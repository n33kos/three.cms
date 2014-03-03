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
    function setlightMode($lmin){
        $this->lightMode = $lmin;
    }
}
?>