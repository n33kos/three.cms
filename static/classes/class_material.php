<?php 
class material {
    //Options: 'mat' 'line' 'linedash' 'meshbasic' 'meshdepth' 'meshface' 'meshlambert' 'meshnormal' 'meshphong' 'particle' 'shader' 'sprite' 'spritecanvas'
    var $matType;
    //string
    var $matName;
    var $matColor;
    //0 - 1
    var $matOpacity;
    //bool
    var $matTransparent;
    //'NoBlending' 'NormalBlending' 'AdditiveBlending' 'SubtractiveBlending' 'MultiplyBlending' 'CustomBlending'
    var $matBlending;
    var $matBlendSrc;
    var $matBlendDst;
    var $matBlendEquation;
    //bool
    var $matDepthTest;
    //bool
    var $matDepthWrite;
    //bool
    var $matPolygonOffset;
    var $matPolygonOffsetFactor;
    var $matPolygonOffsetUnits;
    var $matAlphaTest;
    //bool
    var $matOverdraw;
    //bool
    var $matVisible;
    //'THREE.FrontSide', 'THREE.BackSide', 'THREE.DoubleSide'
    var $matSide;
    var $matFog;
    
    var $matNeedsUpdate;
    var $matVertexColors;
    var $matLineWidth;
    var $matShading;
    var $matWireFrame;
    var $matLineCap;
    var $matLineJoin;
    var $matLightMap;
    var $matMap;
    
    var $matSpecularMap;
    var $matReflectivity;
    var $matRefractionRatio;
    var $matSkinning;
    var $matMorphTargets;
    var $matCombine;
    var $matScale;
    var $matDashSize;
    var $matGapSize;
    var $matEnvMap;
    var $matAmbient;
    var $matEmissive;
    var $matShininess;
    var $matUniforms;
    function material() {
    }
    
/*    function setOption($varRoot,$newVal){
        $mat{$varRoot} = $newVal;
        return $mat{$varRoot};
    }*/

}
?>