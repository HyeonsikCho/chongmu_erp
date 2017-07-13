<?php
include_once($_SERVER["DOCUMENT_ROOT"] .'/test/BasicMaterials/Afterprocess.php');

class Press extends Afterprocess
{
    var $wid_1;
    var $vert_1;


    function makeHtml() {
        $html = 'Press';
        return $html;
    }

    function getName() {
        $html = 'press';
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
        <div class="option _press">
            <dl>
                <dt>형압</dt>
                <dd id="press_price_dd" class="price" style="position: absolute; padding: 0 10px;"></dd>
                <dd>
                    <select id="press_1" onchange="loadPressDepth2(this.value);">
                        $depth1_option
                    </select>
                    <select id="press_val" onchange="getAfterPrice.common('press');">
                        $depth2_option
                    </select>
                    <input type="hidden" id="press_info" name="press_info" value="" />
                    <input type="hidden" id="press_price" name="press_price" value="" />
                </dd>
                <dd class="br">
                    <label>가로 <input id="press_wid_1" type="text" class="mm"  onblur="getAfterPrice.common('press');">mm</label>
                    <label>세로 <input id="press_vert_1" type="text" class="mm" onblur="getAfterPrice.common('press');">mm</label>
                </dd>
                <dd class="br note">
                    File에 형압 부분을 먹1도로 업로드 해주세요.
                </dd>
            </dl>
        </div>
html;

        return $html;
    }

    /**
     * @brief 각 너비 가중값 계산
     *
     * @param $val = 너비/높이값
     * @param $amt = 수량
     *
     * @return 계산값
     */
    function calcAreaVal($val, $amt) {
        return (($val / 10) - 2) * 10 * $amt;
    }

    // 형압
    function JC_makeOrderHtml($after_history) {
        $html = '<input type="hidden" name="AGroup_1_Sel[]" value="07">';
        $html .= '<input type="hidden" name="AGroup_1[6]" value="07">';
        $html .= '<input type="hidden" name="AGroup_2[6]" value="01">';
        $html .= '<input type="hidden" name="after_W07" value="'.$this->wid_1.'">';
        $html .= '<input type="hidden" name="after_H07" value="'.$this->vert_1.'">';
        $html .= '<input type="hidden" name="after_price[6]" value="' . $this->costEach() . '">';
        return $html;
    }
}

?>