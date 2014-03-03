<?php 
//include our settings
initSettings();
global $scriptIncludes, $controlMode, $ao_bit, $usePixelShaders, $shaderIncludes, $canvasTarget, $renderMode, $cameraPosition, $cameraPerspective, $camNear, $camFar, $lights, $realtimeShadows_bit, $realtimeShadowSmooth, $linearfog_bit, $linearfogColor, $linearfogNear, $linearfogFar, $exponentialfog_bit, $exponentialfogColor, $exponentialfogDensity, $sceneFile, $sceneTex, $useSkybox, $skyboxScale, $skyboxTextures;
?>
<html>
<head>
    <title>Title</title>
    <meta name="description" content="this is the description"/>
    <?php 
        //--------------------SCRIPT INCLUDES ARRAY------------------------------------
        foreach($scriptIncludes as $key => $script){
            echo '<script type="text/javascript" src="' . $script . '" name="' . $key . '"></script>';
        }

        //--------------------DEPENDENCY CHECKS----------------------------------------
        if($renderMode == 'ASCII'){
            echo '<script type="text/javascript" src="static/js/threejs/effects/AsciiEffect.js" name="ASCII"></script>';
        }
        if($ao_bit == true){
            echo '<script type="text/javascript" src="static/js/threejs/shaders/SSAOShader.js" name="ssaoShader"></script>';
        }
        //--------------------PIXEL SHADERS--------------------------------------------
        if($usePixelShaders == true || $ao_bit == true){
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
        foreach($shaderIncludes as $key => $script){
            echo '<script type="text/javascript" src="' . $script . '" name="' . $key . '"></script>';
        }
        //--------------------CONTROL MODE INCLUDES-------------------------------------
        switch ($controlMode) {
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

    ?>
</head>
	<body>
		<?php include view_path . '/index.php'; ?>
	</body>
</html>