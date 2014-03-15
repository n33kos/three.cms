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

    require_once 'static/classes/class_light.php';
    require_once 'static/classes/class_material.php';
    require_once 'static/classes/class_particle.php';


    //FOR NOW WE ARE LOADING ALL OF OUR VARIABLES STRAIGHT THROUGH THIS MODEL FILE
    //LATER ON THIS MODEL FILE WILL INTERACT WITH THE DATA BASE AND ALLOW US TO GET OUR VARIABLES DYNAMICALLY

    //--------------------------GLOBALS----------------------------
    global $tpl_args;
    
    //Canvas Target as jQuery Element
    $tpl_args['canvasTarget'] = 'body';

    //Script Includes Array
    $tpl_args['scriptIncludes'] = array(
        'jQuery'  => 'static/js/jquery-1.11.0.min.js',
        'threemin'  => 'static/js/threejs/three.min.js'
    );

    //Shader Includes Array - These scripts are automatically activated by a foreach, 
    //you can combine more than one shader simultaneously.
    $tpl_args['usePixelShaders'] = false;
    $tpl_args['shaderIncludes'] = array(
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
    
    //show statistics
    $tpl_args['showStats'] = true;

    //$renderMode options: WebGL, Canvas, ASCII
    $tpl_args['renderMode'] = 'WebGL';

    //Ambient Occlusion Bit
    $tpl_args['ao_bit'] = false;

    //Antialias Bit
    $tpl_args['aa_bit'] = false;

    //$controlMode options: OrbitControls, FlyControls, PointerLockControls
    $tpl_args['controlMode'] = 'OrbitControls';

    //Camera Settings
    $tpl_args['cameraPosition'] = '0, 1.75, 0';
    $tpl_args['cameraPerspective'] = '50';
    $tpl_args['camNear'] = '0.25';
    $tpl_args['camFar'] = '1000';

    //$lightmodes: directional, hemisphere, ambient, point, area, spot
    $lights[] = new light;
    $lights[0]->lightMode = 'hemisphere';
    $lights[0]->lightIntensity = 0.1;
    $lights[0]->lightColor = '0x55FF99';
    $lights[] = new light;
    $lights[1]->lightMode = 'spot';
    $lights[1]->lightIntensity = 1.5;
    $lights[1]->lightColor = '0xFFFFFF';
    $tpl_args['lights'] = $lights;

    $materials[] = new material;
    $materials[0]->matName = 'TreeTex';
    //OPTIONS: 'lambert', 'wire'
    $materials[0]->matType = 'lambert';
    $materials[0]->matColor = '0x00FF33';
    $materials[0]->matLineWidth = 0.01;
    $materials[0]->matMap = view_path . 'img/DreamOak.jpg';
    $tpl_args['materials'] = $materials;

    //Realtime-Shadows
    $tpl_args['realtimeShadows_bit'] = false;
    //$realtimeShadowSmooth options: BasicShadowMap, PCFShadowMap, PCFSoftShadowMap
    $tpl_args['realtimeShadowSmooth'] = 'BasicShadowMap';

    //Linear Fog Settings
    $tpl_args['linearfog_bit'] = false;
    $tpl_args['linearfogColor'] = '#000';
    $tpl_args['linearfogNear'] = '0.25';
    $tpl_args['linearfogFar'] = '200';
    //exponential fog settings
    $tpl_args['exponentialfog_bit'] = false;
    $tpl_args['exponentialfogColor'] = '#000';
    $tpl_args['exponentialfogDensity'] = '.005';
    
    //Options: 'Scene file url' or 'default'
    //$sceneFile = 'default';
    $tpl_args['sceneFile'] = view_path . 'scenes/TestScene.js';
    $tpl_args['sceneTex'] = view_path . 'img/DreamOak.jpg';
    
    //skybox
    $tpl_args['useSkybox'] = false;
    $tpl_args['skyboxScale'] = 1000;
    $tpl_args['skyboxTextures'] = array(
        'right' => 'static/skybox/px.jpg',
        'left' => 'static/skybox/nx.jpg',
        'top' => 'static/skybox/py.jpg',
        'bottom' => 'static/skybox/ny.jpg',
        'back' => 'static/skybox/pz.jpg',
        'front' => 'static/skybox/nz.jpg'
    );


    //Custom Inits
    $tpl_args['customInits'] = '
        console.log("CustomInits");
    ';

    //Custom Body
    $tpl_args['customBody'] = '
        console.log("CustomBody");
    ';

    //Custom Render
    $tpl_args['customRender'] = '
        //console.log("CustomRender");
    ';

    //Page Content
    $tpl_args['pageContent'] = "

        <p>Alohamora wand elf parchment, Wingardium Leviosa hippogriff, house dementors betrayal. Holly, Snape centaur portkey ghost Hermione spell bezoar Scabbers. Peruvian-Night-Powder werewolf, Dobby pear-tickle half-moon-glasses, Knight-Bus. Padfoot snargaluff seeker: Hagrid broomstick mischief managed. Snitch Fluffy rock-cake, 9 ¾ dress robes I must not tell lies. Mudbloods yew pumpkin juice phials Ravenclaw’s Diadem 10 galleons Thieves Downfall. Ministry-of-Magic mimubulus mimbletonia Pigwidgeon knut phoenix feather other minister Azkaban. Hedwig Daily Prophet treacle tart full-moon Ollivanders You-Know-Who cursed. Fawkes maze raw-steak Voldemort Goblin Wars snitch Forbidden forest grindylows wool socks.</p>

        <p>Thestral dirigible plums, Viktor Krum hexed memory charm Animagus Invisibility Cloak three-headed Dog. Half-Blood Prince Invisibility Cloak cauldron cakes, hiya Harry! Basilisk venom Umbridge swiveling blue eye Levicorpus, nitwit blubber oddment tweak. Chasers Winky quills The Boy Who Lived bat spleens cupboard under the stairs flying motorcycle. Sirius Black Holyhead Harpies, you’ve got dirt on your nose. Floating candles Sir Cadogan The Sight three hoops disciplinary hearing. Grindlewald pig’s tail Sorcerer's Stone biting teacup. Side-along dragon-scale suits Filch 20 points, Mr. Potter.</p>

        <p>Toad-like smile Flourish and Blotts he knew I’d come back Quidditch World Cup. Fat Lady baubles banana fritters fairy lights Petrificus Totalus. So thirsty, deluminator firs’ years follow me 12 inches of parchment. Head Boy start-of-term banquet Cleansweep Seven roaring lion hat. Unicorn blood crossbow mars is bright tonight, feast Norwegian Ridgeback. Come seek us where our voices sound, we cannot sing above the ground, Ginny Weasley bright red. Fanged frisbees, phoenix tears good clean match.</p>
        
        <p>Alohamora wand elf parchment, Wingardium Leviosa hippogriff, house dementors betrayal. Holly, Snape centaur portkey ghost Hermione spell bezoar Scabbers. Peruvian-Night-Powder werewolf, Dobby pear-tickle half-moon-glasses, Knight-Bus. Padfoot snargaluff seeker: Hagrid broomstick mischief managed. Snitch Fluffy rock-cake, 9 ¾ dress robes I must not tell lies. Mudbloods yew pumpkin juice phials Ravenclaw’s Diadem 10 galleons Thieves Downfall. Ministry-of-Magic mimubulus mimbletonia Pigwidgeon knut phoenix feather other minister Azkaban. Hedwig Daily Prophet treacle tart full-moon Ollivanders You-Know-Who cursed. Fawkes maze raw-steak Voldemort Goblin Wars snitch Forbidden forest grindylows wool socks.</p>

        <p>Thestral dirigible plums, Viktor Krum hexed memory charm Animagus Invisibility Cloak three-headed Dog. Half-Blood Prince Invisibility Cloak cauldron cakes, hiya Harry! Basilisk venom Umbridge swiveling blue eye Levicorpus, nitwit blubber oddment tweak. Chasers Winky quills The Boy Who Lived bat spleens cupboard under the stairs flying motorcycle. Sirius Black Holyhead Harpies, you’ve got dirt on your nose. Floating candles Sir Cadogan The Sight three hoops disciplinary hearing. Grindlewald pig’s tail Sorcerer's Stone biting teacup. Side-along dragon-scale suits Filch 20 points, Mr. Potter.</p>

        <p>Toad-like smile Flourish and Blotts he knew I’d come back Quidditch World Cup. Fat Lady baubles banana fritters fairy lights Petrificus Totalus. So thirsty, deluminator firs’ years follow me 12 inches of parchment. Head Boy start-of-term banquet Cleansweep Seven roaring lion hat. Unicorn blood crossbow mars is bright tonight, feast Norwegian Ridgeback. Come seek us where our voices sound, we cannot sing above the ground, Ginny Weasley bright red. Fanged frisbees, phoenix tears good clean match.</p>

        ";

}

?>