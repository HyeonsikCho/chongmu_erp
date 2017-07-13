<?php
include_once($_SERVER["DOCUMENT_ROOT"] .'/test/BasicMaterials/Afterprocess.php');

class Background extends Afterprocess
{
    function makeHtml() {
        $html = "background";
        return $html;
    }

    function getName() {
        $html = "background";
        return $html;
    }

    function makeAfterHtml($info) {
        $info_count = count($info);

        $merge_arr = array();

        for ($i = 0; $i < $info_count; $i++) {
            $temp = $info[$i];
            $depth1 = $temp["depth1"];
            $depth2 = $temp["depth2"];
            $mpcode = $temp["mpcode"];

            $merge_arr[$depth1][$depth2] = $mpcode;
        }

        $depth1_option = "";
        $depth2_option = "";

        $flag = true;
        foreach ($merge_arr as $depth1 => $depth2_arr) {
            $attr = "";

            if ($flag === true) {
                $flag = false;

                foreach ($depth2_arr as $depth2 => $mpcode) {
                    $depth2_option .= option($mpcode, $depth2);
                }

                $attr = "selected=\"selected\"";
            }

            $depth1_option .= option($depth1, $depth1, $attr);
        }

        $html = <<<html
        <div class="option _binding">
            <dl>
                <dt>제본</dt>
                <dd id="binding_price_dd" class="price"></dd>
                <dd>
                    <select id="binding" onchange="loadBindingDepth2(this.value);">
                        $depth1_option
                    </select>
                    <select id="binding_val" onchange="getAfterPrice.common('binding');">
                        $depth2_option
                    </select>
                </dd>
                <input type="hidden" id="binding_price" name="binding_price" value="" />
            </dl>
        </div>
html;

        return $html;
    }

    function JC_makeOrderHtml($param) {
        $html = '';
        return $html;
    }
}

?>