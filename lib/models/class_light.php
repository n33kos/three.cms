<?php 
class light {
    var $lightMode;
    var $lightIntensity;
    var $lightColor;
    function light() {
        $this->lightMode = 'spot';
        $this->lightIntensity = 2.0;
        $this->lightColor = '0xffffff';
    }
    function setlightMode($lmod){
        $this->lightMode = $lmod;
    }
    function setlightIntensity($lint){
        $this->lightIntensity = $lint;
    }
    function setlightColor($lcol){
        $this->lightColor = $lcol;
    }
}
?>