<?php

class Model_threebasicdefault extends Model
{
    function __construct()
    {
        parent::__construct(); // This line is very important
        //$this->comments_table_name = mysql_table_prefix . 'guestbook';
    }
}

function initSettings(){

    require_once 'class_light.php';

    //--------------------------GLOBALS----------------------------
    global $scriptIncludes, $controlMode, $ao_bit, $aa_bit, $usePixelShaders, $shaderIncludes, $canvasTarget, $renderMode, $cameraPosition, $cameraPerspective, $camNear, $camFar, $lights, $realtimeShadows_bit, $realtimeShadowSmooth, $linearfog_bit, $linearfogColor, $linearfogNear, $linearfogFar, $exponentialfog_bit, $exponentialfogColor, $exponentialfogDensity, $sceneFile, $sceneTex, $useSkybox, $skyboxScale, $skyboxTextures;
    
    //Canvas Target as jQuery Element
    $canvasTarget = 'body';

    //Script Includes Array
    $scriptIncludes = array(
        'jQuery'  => 'static/js/jquery-1.11.0.min.js'
,       'threemin'  => 'static/js/threejs/three.min.js'
    );

    //Shader Includes Array - These scripts are automatically activated by a foreach, 
    //you can combine more than one shader simultaneously.
    $usePixelShaders = true;
    $shaderIncludes = array(
        //'bleachBypassShader' => 'static/js/threejs/shaders/BleachBypassShader.js',
        //'colorifyShader' => 'static/js/threejs/shaders/ColorifyShader.js',
        //'dotScreenShader' => 'static/js/threejs/shaders/DotScreenShader.js',
        //'brightnessContrastShader' => 'static/js/threejs/shaders/BrightnessContrastShader.js',
        //'colorCorrectionShader' => 'static/js/threejs/shaders/ColorCorrectionShader.js',
        //'filmShader' => 'static/js/threejs/shaders/FilmShader.js',
        //'focusShader' => 'static/js/threejs/shaders/FocusShader.js',
        //'horizontalBlurShader' => 'static/js/threejs/shaders/HorizontalBlurShader.js',
        //'verticalBlurShader' => 'static/js/threejs/shaders/VerticalBlurShader.js',
        //'verticalTiltShiftShader' => 'static/js/threejs/shaders/VerticalTiltShiftShader.js'
        //'hueSaturationShader' => 'static/js/threejs/shaders/HueSaturationShader.js',
        //'kaleidoShader' => 'static/js/threejs/shaders/KaleidoShader.js',
        //'luminosityShader' => 'static/js/threejs/shaders/LuminosityShader.js',
        //'mirrorShader' => 'static/js/threejs/shaders/MirrorShader.js',
        //'rgbShiftShader' => 'static/js/threejs/shaders/RGBShiftShader.js',
        //'sepiaShader' => 'static/js/threejs/shaders/SepiaShader.js',
        //'vignetteShader' => 'static/js/threejs/shaders/VignetteShader.js'
        //'edgeDetectionFreiChenShader' => 'static/js/threejs/shaders/EdgeShader.js'
        //'edgeDetectionSobelShader' => 'static/js/threejs/shaders/EdgeShader2.js'
    );

    //$renderMode options: WebGL, Canvas, ASCII
    $renderMode = 'WebGL';

    //Ambient Occlusion Bit
    $ao_bit = true;

    //Antialias Bit
    $aa_bit = true;

    //$controlMode options: OrbitControls, FlyControls, PointerLockControls
    $controlMode = 'PointerLockControls';

    //Camera Settings
    $cameraPosition = '0, 1.75, 0';
    $cameraPerspective = '50';
    $camNear='0.25';
    $camFar='1000';

    //$lightmodes: directional, hemisphere, ambient, point, area, spot
    $lights[] = new light;
    $lights[0]->setlightMode('ambient');
    $lights[0]->setlightIntensity(0.5);
    $lights[0]->setlightColor('0x113344');

    $lights[] = new light;
    $lights[1]->setlightMode('spot');
    $lights[1]->setlightIntensity(1.5);
    $lights[1]->setlightColor('0xffffff');

    //Realtime-Shadows
    $realtimeShadows_bit = true;
    //$realtimeShadowSmooth options: BasicShadowMap, PCFShadowMap, PCFSoftShadowMap
    $realtimeShadowSmooth = 'PCFSoftShadowMap';

    //Linear Fog Settings
    $linearfog_bit = false;
    $linearfogColor = '#000';
    $linearfogNear = '0.25';
    $linearfogFar = '200';
    //exponential fog settings
    $exponentialfog_bit = false;
    $exponentialfogColor = '#000';
    $exponentialfogDensity = '.005';
    
    //later on the following two should be replaced with an array for multi-scenes and textures
    $sceneFile = view_path . 'scenes/TestScene.js';
    $sceneTex = view_path . 'img/DreamOak.jpg';
    
    //---------------------SKYBOX STUFF-------------------------
    $useSkybox = true;
    $skyboxScale = 1000;
    $skyboxTextures = array(
        'right' => 'static/skybox/px.jpg',
        'left' => 'static/skybox/nx.jpg',
        'top' => 'static/skybox/py.jpg',
        'bottom' => 'static/skybox/ny.jpg',
        'back' => 'static/skybox/pz.jpg',
        'front' => 'static/skybox/nz.jpg'
    );
}


?>