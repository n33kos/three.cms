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
    //bool
    var $matNeedsUpdate;
    var $matVertexColors;
    var $matFog;
    
    //------------------line Specific---------------------
    var $matLineWidth;
    var $matLineCap;
    var $matLineJoin;

    //------------------linedash Specific---------------------
    var $matLineWidth;
    var $matScale;
    var $matDashSize;
    var $matGapSize

    function material() {
    }
    function setmatName($name){
            $this->$matName = $name;
    }
    function setmatOpacity($opac){
            $this->$matOpacity = $opac;
    }
    function setmatTransparent($trans){
            $this->$matTransparent = $trans;
    }
    function setmatVisible($visible){
            $this->$matVisible = $visible;
    }

}
?>