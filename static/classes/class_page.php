<?php
class page {
    //Canvas Target as jQuery Element
    var $canvasTarget;

    //Script Includes Array
    var $scriptIncludes;

    //Shader Includes Array - These scripts are automatically activated by a foreach, 
    //you can combine more than one shader simultaneously.
    var $usePixelShaders;
    var $shaderIncludes;
    
    //show statistics
    var $showStats;

    //var $renderMode options: WebGL, Canvas, ASCII
    var $renderMode;

    //Ambient Occlusion Bit
    var $ao_bit;

    //Antialias Bit
    var $aa_bit;

    //var $controlMode options: OrbitControls, FlyControls, PointerLockControls
    var $controlMode;

    //Camera Settings
    var $cameraPosition;
    var $cameraPerspective;
    var $camNear;
    var $camFar;

    //var $lightmodes: directional, hemisphere, ambient, point, area, spot
    var $lights;


    var $materials;

    //Realtime-Shadows
    var $realtimeShadows_bit;
    //var $realtimeShadowSmooth options: BasicShadowMap, PCFShadowMap, PCFSoftShadowMap
    var $realtimeShadowSmooth;

    //Linear Fog Settings
    var $linearfog_bit;
    var $linearfogColor;
    var $linearfogNear;
    var $linearfogFar;
    //exponential fog settings
    var $exponentialfog_bit;
    var $exponentialfogColor;
    var $exponentialfogDensity;
    
    //Options: 'Scene file url' or 'default'
    //var $sceneFile = 'default';
    var $sceneFile;
    var $sceneTex;
    
    //skybox
    var $useSkybox;
    var $skyboxScale;
    var $skyboxTextures;


    //Custom Inits
    var $customInits;

    //Custom Body
    var $customBody;

    //Custom Render
    var $customRender;

    //Page Content
    var $pageContent;

    function page(){
    }
}
?>