<?php 
global $tpl_args;

//pass the page ID to initData
initData(pageID);

include 'static/components/gameobjectCheck.comp';

?>
<html>
    <head>
        <title><?php echo $tpl_args['title'];?></title>
        <meta name="description" content="<?php echo $tpl_args['summary'];?>"/>
        <meta charset="UTF-8">
        <?php 
            //--------------------SCRIPT INCLUDES ARRAY------------------------------------
            foreach($tpl_args['scriptIncludes'] as $key => $script){
                echo '<script type="text/javascript" src="' . $script . '" name="' . $key . '"></script>';
            }
            //--------------------DEPENDENCY CHECKS----------------------------------------
            if($tpl_args['renderMode'] == 'ASCII'){
                echo '<script type="text/javascript" src="static/js/threejs/effects/AsciiEffect.js" name="ASCII"></script>';
            }
            if($tpl_args['ao_bit'] == 1){
                echo '<script type="text/javascript" src="static/js/threejs/shaders/SSAOShader.js" name="ssaoShader"></script>';
            }
            if($tpl_args['aa_bit'] == 1){
                echo '<script type="text/javascript" src="static/js/threejs/shaders/FXAAShader.js" name="fxaaShader"></script>';
            } 
            if($tpl_args['enablePhysics_bit'] == 1){
                echo '<script type="text/javascript" src="static/js/physi.js"></script>';
            }
            //--------------------PIXEL SHADERS--------------------------------------------
            if($tpl_args['usePixelShaders'] == 1 || $tpl_args['ao_bit'] == 1 || $tpl_args['aa_bit'] ==1){
                echo '
                <script src="static/js/threejs/postprocessing/EffectComposer.js"></script>
                <script src="static/js/threejs/postprocessing/RenderPass.js"></script>
                <script src="static/js/threejs/postprocessing/ShaderPass.js"></script>
                <script src="static/js/threejs/postprocessing/MaskPass.js"></script> 
                <script src="static/js/threejs/postprocessing/BloomPass.js"></script>
                <script src="static/js/threejs/shaders/CopyShader.js"></script>
                ';   
            }
            //--------------------RENDER SHADERS--------------------------------------------
            foreach($tpl_args['shaderIncludes'] as $key => $value){
                    if($value != ''){
                        echo '<script type="text/javascript" src="' . $value . '" name="' . $key . '"></script>';
                    }
            }
            //--------------------CONTROL MODE INCLUDES-------------------------------------
            switch ($tpl_args['controlMode']) {
                case 'OrbitControls':
                    echo '<script type="text/javascript" src="static/js/threejs/controls/OrbitControls.js" name="OrbitControls"></script>';
                break;
                case 'FlyControls':
                    echo '<script type="text/javascript" src="static/js/threejs/controls/FlyControls.js" name="FlyControls"></script>';
                break;
                case 'PointerLockControls':
                    echo '<script type="text/javascript" src="static/js/threejs/controls/PointerLockControls.js" name="PointerLock"></script>';
                    echo '<link rel="stylesheet" type="text/css" href="static/css/PointerLock.css">';
                break;
            }
            //--------------------STATS----------------------------------------
            if($tpl_args['showStats']){
                echo '<script type="text/javascript" src="static/js/threejs/debug/stats.min.js" name="Stats"></script>';
            }
        ?>
    <link rel="stylesheet" type="text/css" href="<?php echo view_path; ?>style.css">
    </head>
    <div id="menu">
    </div>

    <div id="Inits">
    </div>

    <body>
        <div id="content" style="<?php if(count($tpl_args['pageContent']) < 1 ){echo 'visibility:hidden;';} ?>">
            <?php 
            if($tpl_args['pageContent']){echo $tpl_args['pageContent'];}
            ?>
        </div>
    </body>

    <div id="GUI">
    </div>
    <script>
        jQuery( document ).ready(function($) {
            //-------------------------------------INITIALIZATION-------------------------------------
            var controls;
            var d = new THREE.Vector3();
            var scene = <?php
                if($tpl_args['enablePhysics_bit'] == 1){
                    echo 'new Physijs.Scene();';
                    echo "Physijs.scripts.worker = 'static/js/physijs_worker.js';";
                    echo "Physijs.scripts.ammo = 'static/js/ammo.js';";
                    echo 'scene.setGravity(new THREE.Vector3( 0, -10, 0 ));';
                }else{
                    echo 'new THREE.Scene();';
                }
            ?>

            var loader = new THREE.ObjectLoader();
            var clock = new THREE.Clock();
            var delta = 0.2;
            var container = $("<?php echo $tpl_args['canvasTarget'];?>");
            var camera = new THREE.PerspectiveCamera(<?php echo $tpl_args['cameraPerspective'];?>, container.width() / container.height(), <?php echo $tpl_args['camNear'] . ', ' . $tpl_args['camFar'] ?>);
            var WIDTH = container.width();
            var HEIGHT = container.height();
            <?php 
                //custom init
                if($tpl_args['customInits'] != ''){echo $tpl_args['customInits'];}

                //Render mode toggler
                if($tpl_args['renderMode'] == 'WebGL'){
                    echo '
                    var renderer = new THREE.WebGLRenderer({ antialias: true });
                    container.append(renderer.domElement);
                    renderer.setSize(WIDTH,HEIGHT);
                    ';
                }elseif($tpl_args['renderMode'] == 'Canvas'){
                    echo '
                    var renderer = new THREE.CanvasRenderer();
                    container.append(renderer.domElement);
                    renderer.setSize(WIDTH,HEIGHT);
                    ';
                }elseif($tpl_args['renderMode'] == 'ASCII'){
                    echo '
                    var renderer = new THREE.CanvasRenderer();
                    effect = new THREE.AsciiEffect( renderer );
                    container.append( effect.domElement );
                    renderer.setSize(WIDTH,HEIGHT);
                    effect.setSize(WIDTH,HEIGHT);
                    ';
                }

                //scene handling and fallback
                if($tpl_args['sceneFile'] == 'default'){
                    echo 'var sceneFile = "static/scenes/Scene_Default.js";';
                }elseif($tpl_args['sceneFile'] != ''){
                    echo 'var sceneFile = "' . $tpl_args['sceneFile'] . '";';
                }else{
                    echo 'var sceneFile = "none";';
                }

                if($tpl_args['showStats']){
                    echo 'var stats;
                    stats = new Stats();
                    stats.domElement.style.position = "absolute";
                    stats.domElement.style.top = "0px";
                    container.append( stats.domElement );
                    ';
                }

            ?>

            //-------------------------------------WINDOW RESIZE-------------------------------------
            window.addEventListener('resize', function () {
                <?php 
                    if($tpl_args['renderMode'] == 'ASCII'){
                        echo 'effect.setSize( WIDTH, HEIGHT );';
                    }
                ?>
                renderer.setSize(WIDTH, HEIGHT);

                camera.aspect = WIDTH / HEIGHT;
                camera.updateProjectionMatrix();
            });

            //-------------------------------------MATERIALS-------------------------------------
            <?php include 'static/components/materialCheck.comp'; ?>

            //--------------------------------------SCENE LOADER------------------------------------
            if(sceneFile != 'none'){
                loader.load(sceneFile, function (object) {
                    $.each( object, function( key, value ) {
                        if(key == '__objectsAdded'){
                            $.each( value, function( key2, value2 ) {
                                value2.castShadow = true;
                                value2.receiveShadow = true;
                                if(SceneTex){
                                    value2.material = SceneTex;
                                }else{                                    
                                    value2.material = defaultMaterial;
                                }

                            });
                        }
                    });
                    //add all the scene objects to the scene
                    scene.add(object);
                });
            }
            //-------------------------------------CUSTOMIZATION-------------------------------------
            <?php
            include 'static/components/lightCheck.comp';
            include 'static/components/shaderCheck.comp';
            include 'static/components/controlsCheck.comp';
            if($tpl_args['useSkybox'] == 1){include 'static/components/skyboxCheck.comp';}
            if($tpl_args['linearFog_bit'] == 1){echo 'scene.fog = new THREE.Fog( "' . $tpl_args['linearFogColor'] . '", ' . $tpl_args['linearFogNear'] . ', ' . $tpl_args['linearFogFar'] . ' );';}
            if($tpl_args['exponentialFog_bit'] == 1){echo 'scene.fog = new THREE.FogExp2( "' . $tpl_args['linearFogColor'] . '", ' . $tpl_args['exponentialFogDensity'] . ');';}
            if($tpl_args['customBody'] != ''){echo $tpl_args['customBody'];}
            
            //--------------------------------------COMPONENTS----------------------------------------
            if(isset($comp_args)){
                foreach($comp_args as $key => $value){
                    if($value['functions'] != ''){
                        echo $value['functions'];                       
                    }
                }
            }
            if($componentsArray[0] != ' '){
                echo 'var componentIteration = 0;';
                foreach($comp_args as $key => $value){
                    echo 'componentIteration++;';
                    echo $value['init_script'];
                    if($value['mesh'] != ''){
                        echo 'var geometry' . $value['slug'] . ' = "' . $value['mesh'] . '";';
                    }else{
                        echo 'var geometry' . $value['slug'] . ' = new THREE.CubeGeometry( 1, 1, 1 );';
                    }

                    if($value['material'] != ''){
                        echo 'var material' . $value['slug'] . ' = "' . $value['material'] . '";';
                    }else{
                        echo 'var material' . $value['slug'] . ' = defaultMaterial;';
                    }

                    echo 'var ' . $value['slug'] . ' = new THREE.Mesh( geometry' . $value['slug'] . ', material' . $value['slug'] . ' );';
                    echo 'scene.add(' . $value['slug'] . ');';

                    echo $value['slug'] . '.scale.set(' . $value['scale'] . ');';
                    echo $value['slug'] . '.position.set(' . $value['position'] . ');';
                    echo $value['slug'] . '.rotation.set(' . $value['rotation'] . ');';

                    echo $value['main_script'];
                }
            }

            ?>
            //init camera
            camera.position = new THREE.Vector3(<?php echo $tpl_args['cameraPosition'];?>);
            //------------------------------------ANIMATE FUNCTION------------------------------------
            function animate() {
                requestAnimationFrame(animate);
                <?php 
                    //custom component animation scripts
                    if(isset($comp_args)){
                        foreach($comp_args as $key => $value){
                            echo $value['animation_script'];
                        }
                    }
                ?>
            }

            //------------------------------------RENDER FUNCTION------------------------------------
            var render = function () {

                requestAnimationFrame(render);

                <?php 
                    //renderer type checks
                    if($tpl_args['renderMode'] == "ASCII"){
                        echo 'effect.render( scene, camera );';
                    }elseif ($tpl_args['renderMode'] == "WebGL" && $tpl_args['usePixelShaders'] == 1 && $tpl_args['ao_bit'] == 0){
                        if($tpl_args['realtimeShadows_bit'] == 1){
                            echo '
                            renderer.shadowMapEnabled = true;
                            renderer.shadowMapType = THREE.' . $tpl_args['realtimeShadowSmooth'] . ';
                            renderer.render(scene, camera);
                            ';
                        }
                        echo '
                        composer.render(0.1);
                        ';
                    }elseif ($tpl_args['renderMode'] == "WebGL" && $tpl_args['usePixelShaders'] == 1 && $tpl_args['ao_bit'] == 1){
                        echo'
                        renderer.autoClear = false;
                        renderer.autoUpdateObjects = true;
                        renderer.shadowMapEnabled = true;
                        depthPassPlugin.enabled = true;
                        renderer.render( scene, camera, composer.renderTarget2, true );

                        depthPassPlugin.enabled = false;
                        composer.render( 0.1 );
                        ';
                    }elseif($tpl_args['renderMode'] == "WebGL" && $tpl_args['ao_bit'] == 1){
                        echo'
                        renderer.autoClear = false;
                        renderer.autoUpdateObjects = true;
                        renderer.shadowMapEnabled = true;
                        depthPassPlugin.enabled = true;
                        renderer.render( scene, camera, composer.renderTarget2, true );

                        depthPassPlugin.enabled = false;
                        composer.render( 0.1 );
                        ';
                    }else{
                        if($tpl_args['realtimeShadows_bit'] == 1){
                            echo '
                            renderer.shadowMapEnabled = true;
                            renderer.shadowMapType = THREE.' . $tpl_args['realtimeShadowSmooth'] . ';
                            ';
                        }
                        echo '
                        renderer.render(scene, camera);
                        ';
                    }

                    //controls update checks
                    switch ($tpl_args['controlMode']) {
                        case 'OrbitControls':
                            echo 'controls.update();';
                        break;
                        case 'FlyControls':
                            echo 'controls.update(delta);';
                        break;
                        case 'PointerLockControls':
                            echo '
                            ray.ray.origin.copy( controls.getObject().position );
                            ray.ray.origin.y -= 10;
                            controls.update( Date.now() - time );
                            time = Date.now();
                            ';
                        break;
                    }

                    if($tpl_args['showStats']){
                        echo 'stats.update();';
                    }

                    if($tpl_args['enablePhysics_bit'] == 1){
                        echo 'scene.simulate();';
                    }

                    //CUSTOM RENDER JAVASCRIPT
                    if($tpl_args['customRender'] != ''){echo $tpl_args['customRender'];}
                    
                    //custom component render scripts
                    if(isset($comp_args)){
                        foreach($comp_args as $key => $value){
                            echo $value['render_script'];
                        }
                    }

                ?>

            };
            render();
            animate();
        });
    </script>
    </body>
</html>