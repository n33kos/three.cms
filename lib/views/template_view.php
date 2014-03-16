<?php 
//lets get thigns started
initSettings();
global $tpl_args;
?>
<html>
<head>
    <title>Title</title>
    <meta name="description" content="this is the description"/>
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
        foreach($tpl_args['shaderIncludes'] as $key => $script){
            echo '<script type="text/javascript" src="' . $script . '" name="' . $key . '"></script>';
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

        if($tpl_args['showStats']){
            echo '<script type="text/javascript" src="static/js/threejs/debug/stats.min.js" name="Stats"></script>';
        }
        

    ?>
</head>
	<body>
		<?php include view_path . '/index.php'; ?>
	</body>
</html>