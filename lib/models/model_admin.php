<?php

class admin extends Model
{
    function __construct()
    {
        parent::__construct(); // This line is very important
    }

}
function initSettings($getID){
    
    global $tpl_settings;
    $tpl_settings = getSettings();
    
}
function initData($getID){
    
    global $tpl_args;
    $tpl_args = getTable($getID);

}
function initComponent($getID){

    global $comp_args;
    $comp_args = getComponent($getID);

}
function getComponents(){
    // Connects to your Database 
    mysql_connect(mysql_server, mysql_username, mysql_password) or die(mysql_error()); 
    mysql_select_db(mysql_database) or die(mysql_error()); 
    $data = mysql_query("SELECT id, slug, component_type FROM components ORDER BY slug DESC LIMIT 20") 
    or die(mysql_error());
    //grab those vars
    global $comp_args;
    while($info = mysql_fetch_assoc($data)){
        $comp_args[] = $info;
    }
    
    return;
}
function deleteComponent($mysqli,$theID){
    /*-------------------------------------------------------------------------------*/
    /*---------------------------Prep Then execute Statement-------------------------*/
    /*-------------------------------------------------------------------------------*/
    $prep_stmt = "DELETE FROM components WHERE id=?";
    $delete_stmt = $mysqli->prepare($prep_stmt);
    $delete_stmt->bind_param( "i", $theID);
    
    // Execute the prepared query.
    if (!$delete_stmt->execute()) {
        header('Location: ?error=1');
        echo "Execute failed: (" . $delete_stmt->errno . ") " . $delete_stmt->error;
        print('ERROR!');
    }else{
        $delete_stmt->close();
        $pageLocation = 'Location: ' . baseURL . '/admin';
        header($pageLocation);
        print('SUCCESS!');
    }
}
function updateComponent($mysqli,$theID){
    /*-------------------------------------------------------------------------------*/
    /*---------------------------Get POST Variables----------------------------------*/
    /*-------------------------------------------------------------------------------*/
    $slug = filter_input(INPUT_POST, 'slug', FILTER_SANITIZE_STRING);
    $component_type = filter_input(INPUT_POST, 'component_type', FILTER_SANITIZE_STRING);
    $position = filter_input(INPUT_POST, 'position', FILTER_SANITIZE_STRING);
    $rotation = filter_input(INPUT_POST, 'rotation', FILTER_SANITIZE_STRING);
    $scale = filter_input(INPUT_POST, 'scale', FILTER_SANITIZE_STRING);
    $mesh = filter_input(INPUT_POST, 'mesh', FILTER_SANITIZE_STRING);
    $material = filter_input(INPUT_POST, 'material', FILTER_SANITIZE_STRING);
    $functions = filter_input(INPUT_POST, 'functions', FILTER_UNSAFE_RAW);
    $init_script = filter_input(INPUT_POST, 'init_script', FILTER_UNSAFE_RAW);
    $main_script = filter_input(INPUT_POST, 'main_script', FILTER_UNSAFE_RAW);
    $render_script = filter_input(INPUT_POST, 'render_script', FILTER_UNSAFE_RAW);
    $animation_script = filter_input(INPUT_POST, 'animation_script', FILTER_UNSAFE_RAW);

    /*-------------------------------------------------------------------------------*/
    /*---------------------------Prep Then execute Statement-------------------------*/
    /*-------------------------------------------------------------------------------*/

    $prep_stmt = "UPDATE components SET slug=?, component_type=?, position=?, rotation=?, scale=?, mesh=?, material=?, functions=?, init_script=?, main_script=?, render_script=?, animation_script=? WHERE id=?";
    $update_stmt = $mysqli->prepare($prep_stmt);
    $update_stmt->bind_param( "ssssssssssssi", $slug, $component_type, $position, $rotation, $scale, $mesh, $material, $functions, $init_script, $main_script, $render_script, $animation_script, $theID);
    
    // Execute the prepared query.
    if (!$update_stmt->execute()) {
        header('Location: ?error=1');
        echo "Execute failed: (" . $update_stmt->errno . ") " . $update_stmt->error;
        print('ERROR!');
    }else{
        $update_stmt->close();
        header('Location: ?success=1');
        print('SUCCESS!');
    }
}
function createComponent($mysqli){
    /*-------------------------------------------------------------------------------*/
    /*---------------------------Get POST Variables----------------------------------*/
    /*-------------------------------------------------------------------------------*/
    $theID = 0;

    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
    $slug = filter_input(INPUT_POST, 'slug', FILTER_SANITIZE_STRING);
    $component_type = filter_input(INPUT_POST, 'component_type', FILTER_SANITIZE_STRING);
    $position = filter_input(INPUT_POST, 'position', FILTER_SANITIZE_STRING);
    $rotation = filter_input(INPUT_POST, 'rotation', FILTER_SANITIZE_STRING);
    $scale = filter_input(INPUT_POST, 'scale', FILTER_SANITIZE_STRING);
    $mesh = filter_input(INPUT_POST, 'mesh', FILTER_SANITIZE_STRING);
    $material = filter_input(INPUT_POST, 'material', FILTER_SANITIZE_STRING);
    $functions = filter_input(INPUT_POST, 'functions', FILTER_SANITIZE_STRING);
    $init_script = filter_input(INPUT_POST, 'init_script', FILTER_SANITIZE_STRING);
    $main_script = filter_input(INPUT_POST, 'main_script', FILTER_SANITIZE_STRING);
    $render_script = filter_input(INPUT_POST, 'render_script', FILTER_SANITIZE_STRING);
    $animation_script = filter_input(INPUT_POST, 'animation_script', FILTER_SANITIZE_STRING);

    /*-------------------------------------------------------------------------------*/
    /*---------------------------Prep Then execute Statement-------------------------*/
    /*-------------------------------------------------------------------------------*/
    $prep_stmt = "INSERT INTO components (id, slug, component_type, position, rotation, scale, mesh, material, functions, init_script, main_script, render_script, animation_script) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $update_stmt = $mysqli->prepare($prep_stmt);
    $update_stmt->bind_param( "issssssssssss", $id, $slug, $component_type, $position, $rotation, $scale, $mesh, $material, $functions, $init_script, $main_script, $render_script, $animation_script);
    
    // Execute the prepared query.
    if (!$update_stmt->execute()) {
        header('Location: ?error=1');
        echo "Execute failed: (" . $update_stmt->errno . ") " . $update_stmt->error;
        print('ERROR!');
    }else{
        $update_stmt->close();
        header('Location: ?success=1');
        print('SUCCESS!');
    }
}
function getComponent($compID){
    // Connects to your Database 
    mysql_connect(mysql_server, mysql_username, mysql_password) or die(mysql_error()); 
    mysql_select_db(mysql_database) or die(mysql_error()); 
    $data = mysql_query("SELECT * FROM components WHERE id = $compID") 
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
function getPages(){
    // Connects to your Database 
    mysql_connect(mysql_server, mysql_username, mysql_password) or die(mysql_error()); 
    mysql_select_db(mysql_database) or die(mysql_error()); 
    $data = mysql_query("SELECT id, title, publicationDate, summary FROM pages ORDER BY publicationDate DESC LIMIT 20") 
    or die(mysql_error());
    //grab those vars
    global $tpl_args;
    while($info = mysql_fetch_assoc($data)){
        $tpl_args[] = $info;
    }
    

    return;
}
//Sometime change this to getPage
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

function createPage($mysqli){
    //id will auto-increment
    $theID = 0;
    /*-------------------------------------------------------------------------------*/
    /*---------------------------Get POST Variables----------------------------------*/
    /*-------------------------------------------------------------------------------*/
    $publicationDate = date('Y-m-d');
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $summary = filter_input(INPUT_POST, 'summary', FILTER_SANITIZE_STRING);
    $pageContent = filter_input(INPUT_POST, 'pageContent', FILTER_UNSAFE_RAW);
    $canvasTarget = filter_input(INPUT_POST, 'canvasTarget', FILTER_SANITIZE_STRING);
    $usePixelShaders = filter_input(INPUT_POST, 'usePixelShaders', FILTER_SANITIZE_STRING);
    
    $scriptSetup = new scriptinclude;
    foreach($_POST as $key => $value){
        if($key == 'jQuery' && $value = 'yes'){$scriptSetup->jQuery = 'static/js/jquery-1.11.0.min.js';}
        if($key == 'threemin' && $value = 'yes'){$scriptSetup->threemin  = 'static/js/threejs/three.min.js';}
    }
    $scriptIncludes = serialize($scriptSetup);

    $shaderSetup = new rendershader;
    foreach($_POST as $key => $value){
        if($key == 'colorifyShader' && $value = 'yes'){$shaderSetup->colorifyShader = 'static/js/threejs/shaders/ColorifyShader.js';}
        if($key == 'filmShader' && $value = 'yes'){$shaderSetup->filmShader = 'static/js/threejs/shaders/FilmShader.js';}
        if($key == 'bleachBypassShader' && $value = 'yes'){$shaderSetup->bleachBypassShader =  'static/js/threejs/shaders/BleachBypassShader.js';}
        if($key == 'colorifyShader' && $value = 'yes'){$shaderSetup->colorifyShader =  'static/js/threejs/shaders/ColorifyShader.js';}
        if($key == 'dotScreenShader' && $value = 'yes'){$shaderSetup->dotScreenShader =  'static/js/threejs/shaders/DotScreenShader.js';}
        if($key == 'brightnessContrastShader' && $value = 'yes'){$shaderSetup->brightnessContrastShader =  'static/js/threejs/shaders/BrightnessContrastShader.js';}
        if($key == 'colorCorrectionShader' && $value = 'yes'){$shaderSetup->colorCorrectionShader =  'static/js/threejs/shaders/ColorCorrectionShader.js';}
        if($key == 'filmShader' && $value = 'yes'){$shaderSetup->filmShader = 'static/js/threejs/shaders/FilmShader.js';}
        if($key == 'focusShader' && $value = 'yes'){$shaderSetup->focusShader =  'static/js/threejs/shaders/FocusShader.js';}
        if($key == 'horizontalBlurShader' && $value = 'yes'){$shaderSetup->horizontalBlurShader =  'static/js/threejs/shaders/HorizontalBlurShader.js';}
        if($key == 'verticalBlurShader' && $value = 'yes'){$shaderSetup->verticalBlurShader =  'static/js/threejs/shaders/VerticalBlurShader.js';}
        if($key == 'verticalTiltShiftShader' && $value = 'yes'){$shaderSetup->verticalTiltShiftShader =  'static/js/threejs/shaders/VerticalTiltShiftShader.js';}
        if($key == 'hueSaturationShader' && $value = 'yes'){$shaderSetup->hueSaturationShader =  'static/js/threejs/shaders/HueSaturationShader.js';}
        if($key == 'kaleidoShader' && $value = 'yes'){$shaderSetup->kaleidoShader =  'static/js/threejs/shaders/KaleidoShader.js';}
        if($key == 'luminosityShader' && $value = 'yes'){$shaderSetup->luminosityShader =  'static/js/threejs/shaders/LuminosityShader.js';}
        if($key == 'mirrorShader' && $value = 'yes'){$shaderSetup->mirrorShader =  'static/js/threejs/shaders/MirrorShader.js';}
        if($key == 'rgbShiftShader' && $value = 'yes'){$shaderSetup->rgbShiftShader =  'static/js/threejs/shaders/RGBShiftShader.js';}
        if($key == 'sepiaShader' && $value = 'yes'){$shaderSetup->sepiaShader =  'static/js/threejs/shaders/SepiaShader.js';}
        if($key == 'vignetteShader' && $value = 'yes'){$shaderSetup->vignetteShader = 'static/js/threejs/shaders/VignetteShader.js';}
        if($key == 'edgeDetectionFreiChenShader' && $value = 'yes'){$shaderSetup->edgeDetectionFreiChenShader =  'static/js/threejs/shaders/EdgeShader.js';}
        if($key == 'edgeDetectionSobelShader' && $value = 'yes'){$shaderSetup->edgeDetectionSobelShader =  'static/js/threejs/shaders/EdgeShader2.js';}
    }
    $shaderIncludes = serialize($shaderSetup);
    
    $showStats =     filter_input(INPUT_POST, 'showStats', FILTER_SANITIZE_STRING);
    $renderMode =     filter_input(INPUT_POST, 'renderMode', FILTER_SANITIZE_STRING);
    $ao_bit =     filter_input(INPUT_POST, 'ao_bit', FILTER_SANITIZE_STRING);
    $aa_bit =     filter_input(INPUT_POST, 'aa_bit', FILTER_SANITIZE_STRING);
    $enablePhysics_bit =     filter_input(INPUT_POST, 'enablePhysics_bit', FILTER_SANITIZE_STRING);
    $controlMode =     filter_input(INPUT_POST, 'controlMode', FILTER_SANITIZE_STRING);
    $cameraPosition =     filter_input(INPUT_POST, 'cameraPosition', FILTER_SANITIZE_STRING);
    $cameraPerspective =     filter_input(INPUT_POST, 'cameraPerspective', FILTER_SANITIZE_STRING);
    $camNear =     filter_input(INPUT_POST, 'camNear', FILTER_SANITIZE_STRING);
    $camFar =     filter_input(INPUT_POST, 'camFar', FILTER_SANITIZE_STRING);

    $lightLoop = 0;
    $lightSetup[] = new light;
    foreach($_POST as $key => $value){
            if($key == 'lightMode' . ($lightLoop+1)){$lightSetup[] = new light;$lightLoop++;}
            if($key == 'lightMode' . $lightLoop && $value != ''){$lightSetup[$lightLoop]->lightMode = $value;}
            if($key == 'lightIntensity' . $lightLoop && $value != ''){$lightSetup[$lightLoop]->lightIntensity = $value;}
            if($key == 'lightColor' . $lightLoop && $value != ''){$lightSetup[$lightLoop]->lightColor = $value;}
    }
    $lights = serialize($lightSetup);

    $matLoop = 0;
    $matSetup[] = new material;
    foreach($_POST as $key => $value){
        if($key == 'matName' . ($matLoop+1)){$matSetup[] = new material;$matLoop++;}
        if($key == 'matType' . $matLoop && $value != ''){$matSetup[$matLoop]->matType = $value;}
        if($key == 'matName' . $matLoop && $value != ''){$matSetup[$matLoop]->matName = $value;}
        if($key == 'matColor' . $matLoop && $value != ''){$matSetup[$matLoop]->matColor = $value;}
        if($key == 'matOpacity' . $matLoop && $value != ''){$matSetup[$matLoop]->matOpacity = $value;}
        if($key == 'matTransparent' . $matLoop && $value != ''){$matSetup[$matLoop]->matTransparent = $value;}
        if($key == 'matBlending' . $matLoop && $value != ''){$matSetup[$matLoop]->matBlending = $value;}
        if($key == 'matBlendSrc' . $matLoop && $value != ''){$matSetup[$matLoop]->matBlendSrc = $value;}
        if($key == 'matBlendDst' . $matLoop && $value != ''){$matSetup[$matLoop]->matBlendDst = $value;}
        if($key == 'matBlendEquation' . $matLoop && $value != ''){$matSetup[$matLoop]->matBlendEquation = $value;}
        if($key == 'matDepthTest' . $matLoop && $value != ''){$matSetup[$matLoop]->matDepthTest = $value;}
        if($key == 'matDepthWrite' . $matLoop && $value != ''){$matSetup[$matLoop]->matDepthWrite = $value;}
        if($key == 'matPolygonOffset' . $matLoop && $value != ''){$matSetup[$matLoop]->matPolygonOffset = $value;}
        if($key == 'matPolygonOffsetFactor' . $matLoop && $value != ''){$matSetup[$matLoop]->matPolygonOffsetFactor = $value;}
        if($key == 'matPolygonOffsetUnits' . $matLoop && $value != ''){$matSetup[$matLoop]->matPolygonOffsetUnits = $value;}
        if($key == 'matAlphaTest' . $matLoop && $value != ''){$matSetup[$matLoop]->matAlphaTest = $value;}
        if($key == 'matOverdraw' . $matLoop && $value != ''){$matSetup[$matLoop]->matOverdraw = $value;}
        if($key == 'matVisible' . $matLoop && $value != ''){$matSetup[$matLoop]->matVisible = $value;}
        if($key == 'matSide' . $matLoop && $value != ''){$matSetup[$matLoop]->matSide = $value;}
        if($key == 'matFog' . $matLoop && $value != ''){$matSetup[$matLoop]->matFog = $value;}
        if($key == 'matNeedsUpdate' . $matLoop && $value != ''){$matSetup[$matLoop]->matNeedsUpdate = $value;}
        if($key == 'matVertexColors' . $matLoop && $value != ''){$matSetup[$matLoop]->matVertexColors = $value;}
        if($key == 'matLineWidth' . $matLoop && $value != ''){$matSetup[$matLoop]->matLineWidth = $value;}
        if($key == 'matShading' . $matLoop && $value != ''){$matSetup[$matLoop]->matShading = $value;}
        if($key == 'matWireFrame' . $matLoop && $value != ''){$matSetup[$matLoop]->matWireFrame = $value;}
        if($key == 'matLineCap' . $matLoop && $value != ''){$matSetup[$matLoop]->matLineCap = $value;}
        if($key == 'matLineJoin' . $matLoop && $value != ''){$matSetup[$matLoop]->matLineJoin = $value;}
        if($key == 'matLightMap' . $matLoop && $value != ''){$matSetup[$matLoop]->matLightMap = $value;}
        if($key == 'matSpecularMap' . $matLoop && $value != ''){$matSetup[$matLoop]->matSpecularMap = $value;}
        if($key == 'matReflectivity' . $matLoop && $value != ''){$matSetup[$matLoop]->matReflectivity = $value;}
        if($key == 'matRefractionRatio' . $matLoop && $value != ''){$matSetup[$matLoop]->matRefractionRatio = $value;}
        if($key == 'matSkinning' . $matLoop && $value != ''){$matSetup[$matLoop]->matSkinning = $value;}
        if($key == 'matMorphTargets' . $matLoop && $value != ''){$matSetup[$matLoop]->matMorphTargets = $value;}
        if($key == 'matCombine' . $matLoop && $value != ''){$matSetup[$matLoop]->matCombine = $value;}
        if($key == 'matScale' . $matLoop && $value != ''){$matSetup[$matLoop]->matScale = $value;}
        if($key == 'matDashSize' . $matLoop && $value != ''){$matSetup[$matLoop]->matDashSize = $value;}
        if($key == 'matGapSize' . $matLoop && $value != ''){$matSetup[$matLoop]->matGapSize = $value;}
        if($key == 'matEnvMap' . $matLoop && $value != ''){$matSetup[$matLoop]->matEnvMap = $value;}
        if($key == 'matAmbient' . $matLoop && $value != ''){$matSetup[$matLoop]->matAmbient = $value;}
        if($key == 'matEmissive' . $matLoop && $value != ''){$matSetup[$matLoop]->matEmissive = $value;}
        if($key == 'matShininess' . $matLoop && $value != ''){$matSetup[$matLoop]->matShininess = $value;}
        if($key == 'matUniforms' . $matLoop && $value != ''){$matSetup[$matLoop]->matUniforms = $value;}
        if($key == 'matMap' . $matLoop && $value != ''){$matSetup[$matLoop]->matMap = $value;}
    }
    $materials = serialize($matSetup);

    $realtimeShadows_bit =     filter_input(INPUT_POST, 'realtimeShadows_bit', FILTER_SANITIZE_STRING);
    $realtimeShadowSmooth =     filter_input(INPUT_POST, 'realtimeShadowSmooth', FILTER_SANITIZE_STRING);
    $linearFog_bit =     filter_input(INPUT_POST, 'linearFog_bit', FILTER_SANITIZE_STRING);
    $linearFogColor =     filter_input(INPUT_POST, 'linearFogColor', FILTER_SANITIZE_STRING);
    $linearFogNear =     filter_input(INPUT_POST, 'linearFogNear', FILTER_SANITIZE_STRING);
    $linearFogFar =     filter_input(INPUT_POST, 'linearFogFar', FILTER_SANITIZE_STRING);
    $exponentialFog_bit =     filter_input(INPUT_POST, 'exponentialFog_bit', FILTER_SANITIZE_STRING);
    $exponentialFogColor =     filter_input(INPUT_POST, 'exponentialFogColor', FILTER_SANITIZE_STRING);
    $exponentialFogDensity =     filter_input(INPUT_POST, 'exponentialFogDensity', FILTER_SANITIZE_STRING);
    $sceneFile =     filter_input(INPUT_POST, 'sceneFile', FILTER_SANITIZE_STRING);
    $sceneTex =     filter_input(INPUT_POST, 'sceneTex', FILTER_SANITIZE_STRING);
    $useSkybox =     filter_input(INPUT_POST, 'useSkybox', FILTER_SANITIZE_STRING);
    $skyboxScale =     filter_input(INPUT_POST, 'skyboxScale', FILTER_SANITIZE_STRING);

    $skyboxSetup = new skybox;
    foreach($_POST as $key => $value){
        if($key == 'right' && $value != ''){$skyboxSetup->right = $value;}
        if($key == 'left' && $value != ''){$skyboxSetup->left = $value;}
        if($key == 'top' && $value != ''){$skyboxSetup->top = $value;}
        if($key == 'bottom' && $value != ''){$skyboxSetup->bottom = $value;}
        if($key == 'back' && $value != ''){$skyboxSetup->back = $value;}
        if($key == 'front' && $value != ''){$skyboxSetup->front = $value;}
    }
    $skyboxTextures = serialize($skyboxSetup);

    $customInits =     filter_input(INPUT_POST, 'customInits', FILTER_UNSAFE_RAW);
    $customBody =     filter_input(INPUT_POST, 'customBody', FILTER_UNSAFE_RAW);
    $customRender =     filter_input(INPUT_POST, 'customRender', FILTER_UNSAFE_RAW);

    $components = filter_input(INPUT_POST, 'components', FILTER_SANITIZE_STRING);

    /*-------------------------------------------------------------------------------*/
    /*---------------------------Prep Then execute Statement-------------------------*/
    /*-------------------------------------------------------------------------------*/
    $prep_stmt = "INSERT INTO pages (id, publicationDate, title, summary, pagecontent, canvastarget, scriptincludes, usepixelshaders, shaderincludes, showstats, rendermode, aobit, aabit, enablePhysics_bit, controlmode, cameraposition, cameraperspective, camnear, camfar, lights, materials, realtimeshadowsbit, realtimeshadowsmooth, linearfogbit, linearfogcolor, linearfognear, linearfogfar, exponentialfogbit, exponentialfogcolor, exponentialfogdensity, scenefile, scenetex, useskybox, skyboxscale, skyboxtextures, custominits, custombody, customrender, components) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $insert_stmt = $mysqli->prepare($prep_stmt);
    $insert_stmt->bind_param( "issssssisisiiisssssssisisssissssissssss", $theID, $publicationDate, $title, $summary, $pageContent, $canvasTarget, $scriptIncludes, $usePixelShaders, $shaderIncludes, $showStats, $renderMode, $ao_bit, $aa_bit, $enablePhysics_bit, $controlMode, $cameraPosition, $cameraPerspective, $camNear, $camFar, $lights, $materials, $realtimeShadows_bit, $realtimeShadowSmooth, $linearFog_bit, $linearFogColor, $linearFogNear, $linearFogFar, $exponentialFog_bit, $exponentialFogColor, $exponentialFogDensity, $sceneFile, $sceneTex, $useSkybox, $skyboxScale, $skyboxTextures, $customInits, $customBody, $customRender, $components);
    
    // Execute the prepared query.
    if (!$insert_stmt->execute()) {
        header('Location: ?error=1');
        echo "Execute failed: (" . $insert_stmt->errno . ") " . $insert_stmt->error;
        print('ERROR!');
    }else{
        $pageLocation = 'Location: ?success=1';
        $insert_stmt->close();
        header($pageLocation);
    }

}

function updatePage($mysqli, $theID){
    /*-------------------------------------------------------------------------------*/
    /*---------------------------Get POST Variables----------------------------------*/
    /*-------------------------------------------------------------------------------*/
    $publicationDate = date('Y-m-d');
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $summary = filter_input(INPUT_POST, 'summary', FILTER_SANITIZE_STRING);
    $pageContent = filter_input(INPUT_POST, 'pageContent', FILTER_UNSAFE_RAW);
    $canvasTarget = filter_input(INPUT_POST, 'canvasTarget', FILTER_SANITIZE_STRING);
    $usePixelShaders = filter_input(INPUT_POST, 'usePixelShaders', FILTER_SANITIZE_STRING);
    
    $scriptSetup = new scriptinclude;
    foreach($_POST as $key => $value){
        if($key == 'jQuery' && $value = 'yes'){$scriptSetup->jQuery = 'static/js/jquery-1.11.0.min.js';}
        if($key == 'threemin' && $value = 'yes'){$scriptSetup->threemin  = 'static/js/threejs/three.min.js';}
    }
    $scriptIncludes = serialize($scriptSetup);

    $shaderSetup = new rendershader;
    foreach($_POST as $key => $value){
        if($key == 'colorifyShader' && $value = 'yes'){$shaderSetup->colorifyShader = 'static/js/threejs/shaders/ColorifyShader.js';}
        if($key == 'filmShader' && $value = 'yes'){$shaderSetup->filmShader = 'static/js/threejs/shaders/FilmShader.js';}
        if($key == 'bleachBypassShader' && $value = 'yes'){$shaderSetup->bleachBypassShader =  'static/js/threejs/shaders/BleachBypassShader.js';}
        if($key == 'colorifyShader' && $value = 'yes'){$shaderSetup->colorifyShader =  'static/js/threejs/shaders/ColorifyShader.js';}
        if($key == 'dotScreenShader' && $value = 'yes'){$shaderSetup->dotScreenShader =  'static/js/threejs/shaders/DotScreenShader.js';}
        if($key == 'brightnessContrastShader' && $value = 'yes'){$shaderSetup->brightnessContrastShader =  'static/js/threejs/shaders/BrightnessContrastShader.js';}
        if($key == 'colorCorrectionShader' && $value = 'yes'){$shaderSetup->colorCorrectionShader =  'static/js/threejs/shaders/ColorCorrectionShader.js';}
        if($key == 'filmShader' && $value = 'yes'){$shaderSetup->filmShader = 'static/js/threejs/shaders/FilmShader.js';}
        if($key == 'focusShader' && $value = 'yes'){$shaderSetup->focusShader =  'static/js/threejs/shaders/FocusShader.js';}
        if($key == 'horizontalBlurShader' && $value = 'yes'){$shaderSetup->horizontalBlurShader =  'static/js/threejs/shaders/HorizontalBlurShader.js';}
        if($key == 'verticalBlurShader' && $value = 'yes'){$shaderSetup->verticalBlurShader =  'static/js/threejs/shaders/VerticalBlurShader.js';}
        if($key == 'verticalTiltShiftShader' && $value = 'yes'){$shaderSetup->verticalTiltShiftShader =  'static/js/threejs/shaders/VerticalTiltShiftShader.js';}
        if($key == 'hueSaturationShader' && $value = 'yes'){$shaderSetup->hueSaturationShader =  'static/js/threejs/shaders/HueSaturationShader.js';}
        if($key == 'kaleidoShader' && $value = 'yes'){$shaderSetup->kaleidoShader =  'static/js/threejs/shaders/KaleidoShader.js';}
        if($key == 'luminosityShader' && $value = 'yes'){$shaderSetup->luminosityShader =  'static/js/threejs/shaders/LuminosityShader.js';}
        if($key == 'mirrorShader' && $value = 'yes'){$shaderSetup->mirrorShader =  'static/js/threejs/shaders/MirrorShader.js';}
        if($key == 'rgbShiftShader' && $value = 'yes'){$shaderSetup->rgbShiftShader =  'static/js/threejs/shaders/RGBShiftShader.js';}
        if($key == 'sepiaShader' && $value = 'yes'){$shaderSetup->sepiaShader =  'static/js/threejs/shaders/SepiaShader.js';}
        if($key == 'vignetteShader' && $value = 'yes'){$shaderSetup->vignetteShader = 'static/js/threejs/shaders/VignetteShader.js';}
        if($key == 'edgeDetectionFreiChenShader' && $value = 'yes'){$shaderSetup->edgeDetectionFreiChenShader =  'static/js/threejs/shaders/EdgeShader.js';}
        if($key == 'edgeDetectionSobelShader' && $value = 'yes'){$shaderSetup->edgeDetectionSobelShader =  'static/js/threejs/shaders/EdgeShader2.js';}
    }
    $shaderIncludes = serialize($shaderSetup);
    
    $showStats =     filter_input(INPUT_POST, 'showStats', FILTER_SANITIZE_STRING);
    $renderMode =     filter_input(INPUT_POST, 'renderMode', FILTER_SANITIZE_STRING);
    $ao_bit =     filter_input(INPUT_POST, 'ao_bit', FILTER_SANITIZE_STRING);
    $aa_bit =     filter_input(INPUT_POST, 'aa_bit', FILTER_SANITIZE_STRING);
    $enablePhysics_bit =     filter_input(INPUT_POST, 'enablePhysics_bit', FILTER_SANITIZE_STRING);
    $controlMode =     filter_input(INPUT_POST, 'controlMode', FILTER_SANITIZE_STRING);
    $cameraPosition =     filter_input(INPUT_POST, 'cameraPosition', FILTER_SANITIZE_STRING);
    $cameraPerspective =     filter_input(INPUT_POST, 'cameraPerspective', FILTER_SANITIZE_STRING);
    $camNear =     filter_input(INPUT_POST, 'camNear', FILTER_SANITIZE_STRING);
    $camFar =     filter_input(INPUT_POST, 'camFar', FILTER_SANITIZE_STRING);

    $lightLoop = 0;
    $lightSetup[] = new light;
    foreach($_POST as $key => $value){
            if($key == 'lightMode' . ($lightLoop+1)){$lightSetup[] = new light;$lightLoop++;}
            if($key == 'lightMode' . $lightLoop && $value != ''){$lightSetup[$lightLoop]->lightMode = $value;}
            if($key == 'lightIntensity' . $lightLoop && $value != ''){$lightSetup[$lightLoop]->lightIntensity = $value;}
            if($key == 'lightColor' . $lightLoop && $value != ''){$lightSetup[$lightLoop]->lightColor = $value;}
    }
    $lights = serialize($lightSetup);

    $matLoop = 0;
    $matSetup[] = new material;
    foreach($_POST as $key => $value){
        if($key == 'matName' . ($matLoop+1)){$matSetup[] = new material;$matLoop++;}
        if($key == 'matType' . $matLoop && $value != ''){$matSetup[$matLoop]->matType = $value;}
        if($key == 'matName' . $matLoop && $value != ''){$matSetup[$matLoop]->matName = $value;}
        if($key == 'matColor' . $matLoop && $value != ''){$matSetup[$matLoop]->matColor = $value;}
        if($key == 'matOpacity' . $matLoop && $value != ''){$matSetup[$matLoop]->matOpacity = $value;}
        if($key == 'matTransparent' . $matLoop && $value != ''){$matSetup[$matLoop]->matTransparent = $value;}
        if($key == 'matBlending' . $matLoop && $value != ''){$matSetup[$matLoop]->matBlending = $value;}
        if($key == 'matBlendSrc' . $matLoop && $value != ''){$matSetup[$matLoop]->matBlendSrc = $value;}
        if($key == 'matBlendDst' . $matLoop && $value != ''){$matSetup[$matLoop]->matBlendDst = $value;}
        if($key == 'matBlendEquation' . $matLoop && $value != ''){$matSetup[$matLoop]->matBlendEquation = $value;}
        if($key == 'matDepthTest' . $matLoop && $value != ''){$matSetup[$matLoop]->matDepthTest = $value;}
        if($key == 'matDepthWrite' . $matLoop && $value != ''){$matSetup[$matLoop]->matDepthWrite = $value;}
        if($key == 'matPolygonOffset' . $matLoop && $value != ''){$matSetup[$matLoop]->matPolygonOffset = $value;}
        if($key == 'matPolygonOffsetFactor' . $matLoop && $value != ''){$matSetup[$matLoop]->matPolygonOffsetFactor = $value;}
        if($key == 'matPolygonOffsetUnits' . $matLoop && $value != ''){$matSetup[$matLoop]->matPolygonOffsetUnits = $value;}
        if($key == 'matAlphaTest' . $matLoop && $value != ''){$matSetup[$matLoop]->matAlphaTest = $value;}
        if($key == 'matOverdraw' . $matLoop && $value != ''){$matSetup[$matLoop]->matOverdraw = $value;}
        if($key == 'matVisible' . $matLoop && $value != ''){$matSetup[$matLoop]->matVisible = $value;}
        if($key == 'matSide' . $matLoop && $value != ''){$matSetup[$matLoop]->matSide = $value;}
        if($key == 'matFog' . $matLoop && $value != ''){$matSetup[$matLoop]->matFog = $value;}
        if($key == 'matNeedsUpdate' . $matLoop && $value != ''){$matSetup[$matLoop]->matNeedsUpdate = $value;}
        if($key == 'matVertexColors' . $matLoop && $value != ''){$matSetup[$matLoop]->matVertexColors = $value;}
        if($key == 'matLineWidth' . $matLoop && $value != ''){$matSetup[$matLoop]->matLineWidth = $value;}
        if($key == 'matShading' . $matLoop && $value != ''){$matSetup[$matLoop]->matShading = $value;}
        if($key == 'matWireFrame' . $matLoop && $value != ''){$matSetup[$matLoop]->matWireFrame = $value;}
        if($key == 'matLineCap' . $matLoop && $value != ''){$matSetup[$matLoop]->matLineCap = $value;}
        if($key == 'matLineJoin' . $matLoop && $value != ''){$matSetup[$matLoop]->matLineJoin = $value;}
        if($key == 'matLightMap' . $matLoop && $value != ''){$matSetup[$matLoop]->matLightMap = $value;}
        if($key == 'matSpecularMap' . $matLoop && $value != ''){$matSetup[$matLoop]->matSpecularMap = $value;}
        if($key == 'matReflectivity' . $matLoop && $value != ''){$matSetup[$matLoop]->matReflectivity = $value;}
        if($key == 'matRefractionRatio' . $matLoop && $value != ''){$matSetup[$matLoop]->matRefractionRatio = $value;}
        if($key == 'matSkinning' . $matLoop && $value != ''){$matSetup[$matLoop]->matSkinning = $value;}
        if($key == 'matMorphTargets' . $matLoop && $value != ''){$matSetup[$matLoop]->matMorphTargets = $value;}
        if($key == 'matCombine' . $matLoop && $value != ''){$matSetup[$matLoop]->matCombine = $value;}
        if($key == 'matScale' . $matLoop && $value != ''){$matSetup[$matLoop]->matScale = $value;}
        if($key == 'matDashSize' . $matLoop && $value != ''){$matSetup[$matLoop]->matDashSize = $value;}
        if($key == 'matGapSize' . $matLoop && $value != ''){$matSetup[$matLoop]->matGapSize = $value;}
        if($key == 'matEnvMap' . $matLoop && $value != ''){$matSetup[$matLoop]->matEnvMap = $value;}
        if($key == 'matAmbient' . $matLoop && $value != ''){$matSetup[$matLoop]->matAmbient = $value;}
        if($key == 'matEmissive' . $matLoop && $value != ''){$matSetup[$matLoop]->matEmissive = $value;}
        if($key == 'matShininess' . $matLoop && $value != ''){$matSetup[$matLoop]->matShininess = $value;}
        if($key == 'matUniforms' . $matLoop && $value != ''){$matSetup[$matLoop]->matUniforms = $value;}
        if($key == 'matMap' . $matLoop && $value != ''){$matSetup[$matLoop]->matMap = $value;}
    }
    $materials = serialize($matSetup);

    $realtimeShadows_bit =     filter_input(INPUT_POST, 'realtimeShadows_bit', FILTER_SANITIZE_STRING);
    $realtimeShadowSmooth =     filter_input(INPUT_POST, 'realtimeShadowSmooth', FILTER_SANITIZE_STRING);
    $linearFog_bit =     filter_input(INPUT_POST, 'linearFog_bit', FILTER_SANITIZE_STRING);
    $linearFogColor =     filter_input(INPUT_POST, 'linearFogColor', FILTER_SANITIZE_STRING);
    $linearFogNear =     filter_input(INPUT_POST, 'linearFogNear', FILTER_SANITIZE_STRING);
    $linearFogFar =     filter_input(INPUT_POST, 'linearFogFar', FILTER_SANITIZE_STRING);
    $exponentialFog_bit =     filter_input(INPUT_POST, 'exponentialFog_bit', FILTER_SANITIZE_STRING);
    $exponentialFogColor =     filter_input(INPUT_POST, 'exponentialFogColor', FILTER_SANITIZE_STRING);
    $exponentialFogDensity =     filter_input(INPUT_POST, 'exponentialFogDensity', FILTER_SANITIZE_STRING);
    $sceneFile =     filter_input(INPUT_POST, 'sceneFile', FILTER_SANITIZE_STRING);
    $sceneTex =     filter_input(INPUT_POST, 'sceneTex', FILTER_SANITIZE_STRING);
    $useSkybox =     filter_input(INPUT_POST, 'useSkybox', FILTER_SANITIZE_STRING);
    $skyboxScale =     filter_input(INPUT_POST, 'skyboxScale', FILTER_SANITIZE_STRING);

    $skyboxSetup = new skybox;
    foreach($_POST as $key => $value){
        if($key == 'right' && $value != ''){$skyboxSetup->right = $value;}
        if($key == 'left' && $value != ''){$skyboxSetup->left = $value;}
        if($key == 'top' && $value != ''){$skyboxSetup->top = $value;}
        if($key == 'bottom' && $value != ''){$skyboxSetup->bottom = $value;}
        if($key == 'back' && $value != ''){$skyboxSetup->back = $value;}
        if($key == 'front' && $value != ''){$skyboxSetup->front = $value;}
    }
    $skyboxTextures = serialize($skyboxSetup);

    $customInits =     filter_input(INPUT_POST, 'customInits', FILTER_UNSAFE_RAW);
    $customBody =     filter_input(INPUT_POST, 'customBody', FILTER_UNSAFE_RAW);
    $customRender =     filter_input(INPUT_POST, 'customRender', FILTER_UNSAFE_RAW);
    
    $components = filter_input(INPUT_POST, 'components', FILTER_SANITIZE_STRING);

    /*-------------------------------------------------------------------------------*/
    /*---------------------------Prep Then execute Statement-------------------------*/
    /*-------------------------------------------------------------------------------*/

    $prep_stmt = "UPDATE pages SET publicationDate=?, title=?, summary=?, pagecontent=?, canvastarget=?, scriptincludes=?, usepixelshaders=?, shaderincludes=?, showstats=?, rendermode=?, aobit=?, aabit=?, enablePhysics_bit=?, controlmode=?, cameraposition=?, cameraperspective=?, camnear=?, camfar=?, lights=?, materials=?, realtimeshadowsbit=?, realtimeshadowsmooth=?, linearfogbit=?, linearfogcolor=?, linearfognear=?, linearfogfar=?, exponentialfogbit=?, exponentialfogcolor=?, exponentialfogdensity=?, scenefile=?, scenetex=?, useskybox=?, skyboxscale=?, skyboxtextures=?, custominits=?, custombody=?, customrender=?, components=? WHERE id=?";
    $update_stmt = $mysqli->prepare($prep_stmt);
    $update_stmt->bind_param( "ssssssisisiiisssssssisisssissssissssssi", $publicationDate, $title, $summary, $pageContent, $canvasTarget, $scriptIncludes, $usePixelShaders, $shaderIncludes, $showStats, $renderMode, $ao_bit, $aa_bit, $enablePhysics_bit, $controlMode, $cameraPosition, $cameraPerspective, $camNear, $camFar, $lights, $materials, $realtimeShadows_bit, $realtimeShadowSmooth, $linearFog_bit, $linearFogColor, $linearFogNear, $linearFogFar, $exponentialFog_bit, $exponentialFogColor, $exponentialFogDensity, $sceneFile, $sceneTex, $useSkybox, $skyboxScale, $skyboxTextures, $customInits, $customBody, $customRender, $components, $theID);
    
    // Execute the prepared query.
    if (!$update_stmt->execute()) {
        header('Location: ?error=1');
        echo "Execute failed: (" . $update_stmt->errno . ") " . $update_stmt->error;
        print('ERROR!');
    }else{
        $update_stmt->close();
        header('Location: ?success=1');
        print('SUCCESS!');
    }
}

function deletePage($mysqli,$theID){
    /*-------------------------------------------------------------------------------*/
    /*---------------------------Prep Then execute Statement-------------------------*/
    /*-------------------------------------------------------------------------------*/
    $prep_stmt = "DELETE FROM pages WHERE id=?";
    $delete_stmt = $mysqli->prepare($prep_stmt);
    $delete_stmt->bind_param( "i", $theID);
    
    // Execute the prepared query.
    if (!$delete_stmt->execute()) {
        header('Location: ?error=1');
        echo "Execute failed: (" . $delete_stmt->errno . ") " . $delete_stmt->error;
        print('ERROR!');
    }else{
        $delete_stmt->close();
        $pageLocation = 'Location: ' . baseURL . '/admin';
        header($pageLocation);
        print('SUCCESS!');
    }

}

function IsChecked($chkname,$value){
    if(!empty($_POST[$chkname]))
    {
        foreach($_POST[$chkname] as $chkval)
        {
            if($chkval == $value)
            {
                return true;
            }
        }
    }
    return false;
}


?>