<?php
include_once($_SERVER["DOCUMENT_ROOT"] .'/test/BasicMaterials/Afterprocess.php');

class Numbering extends Afterprocess
{
    function makeHtml() {
        $html = 'Numbering';
        return $html;
    }

    function getName() {
        $html = 'numbering';
        return $html;
    }

    function JC_makeOrderHtml($after_history) {
        $numbering = '';
        if($after_history[2] == "1개") {
            $numbering = '01';
        } else if($after_history[2] == "2개") {
            $numbering = '02';
        } else if($after_history[2] == "3개") {
            $numbering = '03';
        }
        $html = '<input type="hidden" name="AGroup_1_Sel[]" value="01">';
        $html .= '<input type="hidden" name="AGroup_1[0]" value="01">';
        $html .= '<input type="hidden" name="AGroup_2[0]" value="' . $numbering . '">';
        $html .= '<input type="hidden" name="after_price[0]" value="' . $this->costEach() . '">';
        return $html;
    }
}

?>