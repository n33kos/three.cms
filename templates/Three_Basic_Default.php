<?php 
//include our settings
include 'templates/Three_Basic_Default.conf'; 
?>
<head>
    <title>Title</title>
    <link rel="stylesheet" type="text/css" href="css/Three_Basic_Default.css">
    <meta name="description" content="this is the description"/>
    <?php 
        //--------------------SCRIPT INCLUDES ARRAY--------------------------------
        foreach($scriptIncludes as $key => $script){
            echo '<script type="text/javascript" src="' . $script . '" name="' . $key . '"></script>';
        }

        //--------------------DEPENDENCY CHECKS-------------------------------------
        if($renderMode == 'ASCII'){
            echo '<script type="text/javascript" src="threejs/effects/AsciiEffect.js" name="ASCII"></script>';
        }
        if($ao_bit == true){
            echo '<script type="text/javascript" src="threejs/shaders/SSAOShader.js" name="ssaoShader"></script>';
        }
        //--------------------PIXEL SHADERS-------------------------------------
        if($usePixelShaders == true || $ao_bit == true){
            echo '
            <script src="threejs/postprocessing/EffectComposer.js"></script>
            <script src="threejs/postprocessing/RenderPass.js"></script>
            <script src="threejs/postprocessing/ShaderPass.js"></script>
            <script src="threejs/postprocessing/MaskPass.js"></script> 
            <script src="threejs/postprocessing/BloomPass.js"></script>
            <script src="threejs/shaders/CopyShader.js"></script>
            ';   
        }
        foreach($shaderIncludes as $key => $script){
            echo '<script type="text/javascript" src="' . $script . '" name="' . $key . '"></script>';
        }

        switch ($controlMode) {
            case 'OrbitControls':
                echo '<script type="text/javascript" src="threejs/controls/OrbitControls.js" name="OrbitControls"></script>';
            break;
            case 'FlyControls':
                echo '<script type="text/javascript" src="threejs/controls/FlyControls.js" name="FlyControls"></script>';
            break;
            case 'PointerLockControls':
                echo '<script type="text/javascript" src="threejs/controls/PointerLockControls.js" name="PointerLock"></script>';
                echo '<link rel="stylesheet" type="text/css" href="css/PointerLock.css">';
            break;
            
        }

    ?>
</head>
<div id="menu">
</div>

<div id="Inits">
</div>

<body>
    <div id="content">
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
        var camera = new THREE.PerspectiveCamera(<?php echo $cameraPerspective;?>, window.innerWidth / window.innerHeight, <?php echo $camNear . ', ' . $camFar ?>);
        var clock = new THREE.Clock();
        var delta = 0.2;
        var WIDTH = window.innerWidth;
        var HEIGHT = window.innerHeight;
        var container = $('<?php echo $canvasTarget;?>');
        <?php 
            //Render mode toggler
            if($renderMode == 'WebGL'){
                echo '
                var renderer = new THREE.WebGLRenderer({ antialias: true });
                container.append(renderer.domElement);
                renderer.setSize(WIDTH,HEIGHT);
                ';
            }elseif($renderMode == 'Canvas'){
                echo '
                var renderer = new THREE.CanvasRenderer();
                container.append(renderer.domElement);
                renderer.setSize(WIDTH,HEIGHT);
                ';
            }elseif($renderMode == 'ASCII'){
                echo '
                var renderer = new THREE.CanvasRenderer();
                effect = new THREE.AsciiEffect( renderer );
                container.append( effect.domElement );
                renderer.setSize(WIDTH,HEIGHT);
                effect.setSize(WIDTH,HEIGHT);
                ';
            }

            //scene handling and fallback
            if($sceneFile != ''){
                echo 'var sceneFile = "' . $sceneFile . '";';
            }else{
                echo 'var sceneFile = "scenes/TestScene.js";';
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
        var material = new THREE.MeshLambertMaterial({map: THREE.ImageUtils.loadTexture('<?php echo $sceneTex;?>')});

        //--------------------------------------SCENE LOADER------------------------------------
        loader.load(sceneFile, function (object) {
            $.each( object, function( key, value ) {
                if(key == '__objectsAdded'){
                    $.each( value, function( key2, value2 ) {
                        //console.log(value2);
                        value2.castShadow = true;
                        value2.receiveShadow = true;
                        value2.material = material;
                    });
                }
            });
            //add all the scene objects to the scene
            scene.add(object);
        });
        //-------------------------------------CUSTOMIZATION-------------------------------------
        //load component settings if need be
        <?php
        include 'components/lightCheck.comp';
        include 'components/shaderCheck.comp';
        include 'components/controlsCheck.comp';
		if($useSkybox == true){include 'components/skyboxCheck.comp';}
        if($linearfog_bit == true){echo 'scene.fog = new THREE.Fog( "' . $linearfogColor . '", ' . $linearfogNear . ', ' . $linearfogFar . ' );';}
        if($exponentialfog_bit == true){echo 'scene.fog = new THREE.FogExp2( "' . $linearfogColor . '", ' . $exponentialfogDensity . ');';}
        ?>
        //init camera
        camera.position = new THREE.Vector3(<?php echo $cameraPosition;?>);

        //------------------------------------RENDER FUNCTION------------------------------------
        var render = function () {

            requestAnimationFrame(render);

            <?php 
                //renderer type checks
                if($renderMode == "ASCII"){
                    echo 'effect.render( scene, camera );';
                }elseif ($renderMode == "WebGL" && $usePixelShaders == true && $ao_bit == false){
                    if($realtimeShadows_bit == true){
                        echo '
                        renderer.shadowMapEnabled = true;
                        renderer.shadowMapType = THREE.' . $realtimeShadowSmooth . ';
                        renderer.render(scene, camera);
                        ';
                    }
                    echo '
                    composer.render(0.1);
                    ';
                }elseif ($renderMode == "WebGL" && $usePixelShaders == true && $ao_bit == true){
                    echo'
                    renderer.autoClear = false;
                    renderer.autoUpdateObjects = true;
                    renderer.shadowMapEnabled = true;
                    depthPassPlugin.enabled = true;
                    renderer.render( scene, camera, composer.renderTarget2, true );

                    depthPassPlugin.enabled = false;
                    composer.render( 0.1 );
                    ';
                }elseif($renderMode == "WebGL" && $ao_bit == true){
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
                    if($realtimeShadows_bit == true){
                        echo '
                        renderer.shadowMapEnabled = true;
                        renderer.shadowMapType = THREE.' . $realtimeShadowSmooth . ';
                        ';
                    }
                    echo '
                    renderer.render(scene, camera);
                    ';
                }

                //controls update checks
                switch ($controlMode) {
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
            ?>

        };
        render();
    });
</script>

