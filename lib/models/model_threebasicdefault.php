<?php

class Model_threebasicdefault extends Model
{
    function __construct()
    {
        parent::__construct(); // This line is very important
        //$this->comments_table_name = mysql_table_prefix . 'guestbook';
    }
}


function initData($getID){
    
    global $tpl_args;
    $tpl_args = getTable($getID);

}
function getComponentBySlug($compSlug){
    // Connects to your Database 
    mysql_connect(mysql_server, mysql_username, mysql_password) or die(mysql_error()); 
    mysql_select_db(mysql_database) or die(mysql_error()); 
    $data = mysql_query("SELECT * FROM components WHERE slug = '$compSlug'")
    or die(mysql_error());
    //grab those vars
    $info = mysql_fetch_array($data);

    $comp_args['id'] = $info['id'];
    $comp_args['slug'] = $info['slug'];
    $comp_args['component_type'] = $info['component_type'];
    $comp_args['position'] = $info['position'];
    $comp_args['rotation'] = $info['rotation'];
    $comp_args['scale'] = $info['scale'];
    $comp_args['mesh'] = $info['mesh'];
    $comp_args['material'] = $info['material'];
    $comp_args['functions'] = $info['functions'];
    $comp_args['init_script'] = $info['init_script'];
    $comp_args['main_script'] = $info['main_script'];
    $comp_args['render_script'] = $info['render_script'];
    $comp_args['animation_script'] = $info['animation_script'];

    return $comp_args;
}
function getTable($pageID){
    require_once 'static/classes/class_light.php';
    require_once 'static/classes/class_material.php';
    require_once 'static/classes/class_particle.php';
    require_once 'static/classes/class_page.php';
    require_once 'static/classes/class_rendershader.php';
    require_once 'static/classes/class_scriptinclude.php';
    require_once 'static/classes/class_skybox.php';

    // Connects to your Database 
    mysql_connect(mysql_server, mysql_username, mysql_password) or die(mysql_error()); 
    mysql_select_db(mysql_database) or die(mysql_error()); 
    $data = mysql_query("SELECT * FROM pages WHERE id = $pageID") 
    or die(mysql_error());

    //grab those vars
    $info = mysql_fetch_array($data);
    //assign them
    $tpl_args['id'] = $info['id'];
    $tpl_args['publicationDate'] = $info['publicationDate'];
    $tpl_args['title'] = $info['title'];
    $tpl_args['summary'] = $info['summary'];
    $tpl_args['canvasTarget'] = $info['canvastarget'];

    /*
    $tpl_args['scriptIncludes'] = array(
        'jQuery'  => 'static/js/jquery-1.11.0.min.js',
        'threemin'  => 'static/js/threejs/three.min.js'
    );
    */
    $tpl_args['scriptIncludes'] = unserialize($info['scriptincludes']);
    

    $tpl_args['usePixelShaders'] = $info['usepixelshaders'];
    /*
    $rendershaders[] = new rendershader;
    //$rendershaders[0]->colorifyShader = 'static/js/threejs/shaders/ColorifyShader.js';
    //$rendershaders[0]->filmShader = 'static/js/threejs/shaders/FilmShader.js';
    //$rendershaders[0]->bleachBypassShader =  'static/js/threejs/shaders/BleachBypassShader.js';
    //$rendershaders[0]->colorifyShader =  'static/js/threejs/shaders/ColorifyShader.js';
    //$rendershaders[0]->dotScreenShader =  'static/js/threejs/shaders/DotScreenShader.js';
    //$rendershaders[0]->brightnessContrastShader =  'static/js/threejs/shaders/BrightnessContrastShader.js';
    //$rendershaders[0]->colorCorrectionShader =  'static/js/threejs/shaders/ColorCorrectionShader.js';
    $rendershaders[0]->filmShader = 'static/js/threejs/shaders/FilmShader.js';
    //$rendershaders[0]->focusShader =  'static/js/threejs/shaders/FocusShader.js';
    //$rendershaders[0]->horizontalBlurShader =  'static/js/threejs/shaders/HorizontalBlurShader.js';
    //$rendershaders[0]->verticalBlurShader =  'static/js/threejs/shaders/VerticalBlurShader.js';
    //$rendershaders[0]->verticalTiltShiftShader =  'static/js/threejs/shaders/VerticalTiltShiftShader.js';
    //$rendershaders[0]->hueSaturationShader =  'static/js/threejs/shaders/HueSaturationShader.js';
    //$rendershaders[0]->kaleidoShader =  'static/js/threejs/shaders/KaleidoShader.js';
    //$rendershaders[0]->luminosityShader =  'static/js/threejs/shaders/LuminosityShader.js';
    //$rendershaders[0]->mirrorShader =  'static/js/threejs/shaders/MirrorShader.js';
    //$rendershaders[0]->rgbShiftShader =  'static/js/threejs/shaders/RGBShiftShader.js';
    //$rendershaders[0]->sepiaShader =  'static/js/threejs/shaders/SepiaShader.js';
    $rendershaders[0]->vignetteShader = 'static/js/threejs/shaders/VignetteShader.js';
    //$rendershaders[0]->edgeDetectionFreiChenShader =  'static/js/threejs/shaders/EdgeShader.js';
    //$rendershaders[0]->edgeDetectionSobelShader =  'static/js/threejs/shaders/EdgeShader2.js';
    */
    $tpl_args['shaderIncludes'] = unserialize($info['shaderincludes']);


    $tpl_args['showStats'] = $info['showstats'];
    $tpl_args['renderMode'] = $info['rendermode'];
    $tpl_args['ao_bit'] = $info['aobit'];
    $tpl_args['aa_bit'] = $info['aabit'];
    $tpl_args['enablePhysics_bit'] = $info['enablePhysics_bit'];
    $tpl_args['controlMode'] = $info['controlmode'];
    $tpl_args['cameraPosition'] = $info['cameraposition'];
    $tpl_args['cameraPerspective'] = $info['cameraperspective'];
    $tpl_args['camNear'] = $info['camnear'];
    $tpl_args['camFar'] = $info['camfar'];
   
   /*
    $lights[] = new light;
    $lights[0]->lightMode = 'hemisphere';
    $lights[0]->lightIntensity = 0.1;
    $lights[0]->lightColor = '0x55FF99';
    $lights[] = new light;
    $lights[1]->lightMode = 'spot';
    $lights[1]->lightIntensity = 1.5;
    $lights[1]->lightColor = '0xFFFFFF';
    */
    $tpl_args['lights'] = unserialize($info['lights']);

    /*
    $materials[] = new material;
    $materials[0]->matName = 'TreeTex';
    //OPTIONS: 'lambert', 'wire'
    $materials[0]->matType = 'lambert';
    $materials[0]->matColor = '0x00FF33';
    $materials[0]->matMap = view_path . 'img/DreamOak.jpg';
    */
    $tpl_args['materials'] = unserialize($info['materials']);

    $tpl_args['realtimeShadows_bit'] = $info['realtimeshadowsbit'];
    $tpl_args['realtimeShadowSmooth'] = $info['realtimeshadowsmooth'];
    $tpl_args['linearFog_bit'] = $info['linearfogbit'];
    $tpl_args['linearFogColor'] = $info['linearfogcolor'];
    $tpl_args['linearFogNear'] = $info['linearfognear'];
    $tpl_args['linearFogFar'] = $info['linearfogfar'];
    $tpl_args['exponentialFog_bit'] = $info['exponentialfogbit'];
    $tpl_args['exponentialFogColor'] = $info['exponentialfogcolor'];
    $tpl_args['exponentialFogDensity'] = $info['exponentialfogdensity'];
    $tpl_args['sceneFile'] = $info['scenefile'];
    $tpl_args['sceneTex'] = $info['scenetex'];
    $tpl_args['useSkybox'] = $info['useskybox'];
    $tpl_args['skyboxScale'] = $info['skyboxscale'];

    /*
    $tpl_args['skyboxTextures'] = array(
        'right' => 'static/skybox/px.jpg',
        'left' => 'static/skybox/nx.jpg',
        'top' => 'static/skybox/py.jpg',
        'bottom' => 'static/skybox/ny.jpg',
        'back' => 'static/skybox/pz.jpg',
        'front' => 'static/skybox/nz.jpg'
    );
    */
    $tpl_args['skyboxTextures'] = unserialize($info['skyboxtextures']);

    $tpl_args['customInits'] = $info['custominits'];
    $tpl_args['customBody'] = $info['custombody'];
    $tpl_args['customRender'] = $info['customrender'];
    $tpl_args['pageContent'] = $info['pagecontent'];
    $tpl_args['components'] = $info['components'];
    return $tpl_args;
}

?>