<head>
<link rel="stylesheet" type="text/css" href="<?php echo view_path; ?>style.css">
</head>
<div id="menu">
</div>

<div id="Inits">
</div>

<body>
    <div id="content" <?php if(!$tpl_args['pageContent']){echo 'style="visibility:hidden;"';}?>>
        <?php if($tpl_args['pageContent']){echo $tpl_args['pageContent'];}?>
    </div>
</body>

<div id="GUI">
</div>
<script>
    jQuery( document ).ready(function($) {
        //-------------------------------------INITIALIZATION-------------------------------------
        var controls;
        var d = new THREE.Vector3();
        var scene = new THREE.Scene();
        var loader = new THREE.ObjectLoader();
        var camera = new THREE.PerspectiveCamera(<?php echo $tpl_args['cameraPerspective'];?>, window.innerWidth / window.innerHeight, <?php echo $tpl_args['camNear'] . ', ' . $tpl_args['camFar'] ?>);
        var clock = new THREE.Clock();
        var delta = 0.2;
        var WIDTH = window.innerWidth;
        var HEIGHT = window.innerHeight;
        var container = $("<?php echo $tpl_args['canvasTarget'];?>");
        <?php 
            //custom init javascript
            if($tpl_args['customInits']){echo $tpl_args['customInits'];}
            
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
                echo 'var sceneFile = "static/scenes/Scene_Default.js"';
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
            effect.setSize( WIDTH, HEIGHT );
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
                            value2.material = TreeTex;
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
        if($tpl_args['useSkybox'] == true){include 'static/components/skyboxCheck.comp';}
        if($tpl_args['linearfog_bit'] == true){echo 'scene.fog = new THREE.Fog( "' . $tpl_args['linearfogColor'] . '", ' . $tpl_args['linearfogNear'] . ', ' . $tpl_args['linearfogFar'] . ' );';}
        if($tpl_args['exponentialfog_bit'] == true){echo 'scene.fog = new THREE.FogExp2( "' . $tpl_args['linearfogColor'] . '", ' . $tpl_args['exponentialfogDensity'] . ');';}
        if($tpl_args['customBody']){echo $tpl_args['customBody'];}
        ?>
        //init camera
        camera.position = new THREE.Vector3(<?php echo $tpl_args['cameraPosition'];?>);
        //------------------------------------ANIMATE FUNCTION------------------------------------
        function animate() {
            requestAnimationFrame(animate);
        }

        //------------------------------------RENDER FUNCTION------------------------------------
        var render = function () {

            requestAnimationFrame(render);

            <?php 
                //renderer type checks
                if($tpl_args['renderMode'] == "ASCII"){
                    echo 'effect.render( scene, camera );';
                }elseif ($tpl_args['renderMode'] == "WebGL" && $tpl_args['usePixelShaders'] == true && $tpl_args['ao_bit'] == false){
                    if($tpl_args['realtimeShadows_bit'] == true){
                        echo '
                        renderer.shadowMapEnabled = true;
                        renderer.shadowMapType = THREE.' . $tpl_args['realtimeShadowSmooth'] . ';
                        renderer.render(scene, camera);
                        ';
                    }
                    echo '
                    composer.render(0.1);
                    ';
                }elseif ($tpl_args['renderMode'] == "WebGL" && $tpl_args['usePixelShaders'] == true && $tpl_args['ao_bit'] == true){
                    echo'
                    renderer.autoClear = false;
                    renderer.autoUpdateObjects = true;
                    renderer.shadowMapEnabled = true;
                    depthPassPlugin.enabled = true;
                    renderer.render( scene, camera, composer.renderTarget2, true );

                    depthPassPlugin.enabled = false;
                    composer.render( 0.1 );
                    ';
                }elseif($tpl_args['renderMode'] == "WebGL" && $tpl_args['ao_bit'] == true){
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
                    if($tpl_args['realtimeShadows_bit'] == true){
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

                //CUSTOM RENDER JAVASCRIPT
                if($tpl_args['customRender']){echo $tpl_args['customRender'];}

            ?>

        };
        render();
    });
</script>

