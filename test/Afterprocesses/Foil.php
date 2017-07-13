<?php
include_once($_SERVER["DOCUMENT_ROOT"] .'/test/BasicMaterials/Afterprocess.php');

class Foil extends Afterprocess
{
    var $bef_foil_mpcode;
    var $aft_foil_mpcode;

    var $dvs_1;
    var $wid_1;
    var  $vert_1;

    var $dvs_2;
    var $wid_2;
    var $vert_2;

    var $agroup;
    var $pressure2;

    function makeHtml() {
        $html = 'Foil';
    }

    function getName() {
        $html = 'foil';
        return $html;
    }

    function makeAfterHtml($info) {
        $info_count = count($info);

        $dup_chk = array();

        $opt1 = '';
        $opt2 = '';

        for ($i = 0; $i < $info_count; $i++) {
            $temp = $info[$i];
            $depth1 = $temp["depth1"];
            $attr = '';

            if ($i === 0) {
                $attr = "selected";
            }

            if ($dup_chk[$depth1] === null) {
                $dup_chk[$depth1] = true;
                $opt1 .= option($depth1, $depth1, $attr);
                $opt2 .= option($depth1, $depth1);
            }
        }

        $html = <<<html
        <div class="option _foil">
            <dl>
                <dt>박</dt>
                <dd id="foil_price_dd" class="price" style="position: absolute; padding: 0 10px;"></dd>
                <dd>
                    <select id="foil_1" style="width:85px;" onchange="foilAreaInit( this.value, '1');">
                        <option value="">-</option>
                        $opt1
                    </select>
                    <select id="foil_dvs_1" style="min-width:60px;" onchange="changeFoilDvs( this.value);">
                        <option value="">-</option>
                        <option value="전면" selected>전면</option>
                        <option value="양면">양면</option>
                    </select>
                    &nbsp;/&nbsp;
                    <select id="foil_2" style="width:85px;" onchange="foilAreaInit(this.value, '2');">
                        <option value="">-</option>
                        $opt2
                    </select>
                    <select id="foil_dvs_2" style="min-width:60px;" onchange="getAfterPrice.common('foil');">
                        <option value="">-</option>
                        <option value="후면">후면</option>
                    </select>
                    <input type="hidden" id="foil_val_1" name="foil_val" value="" />
                    <input type="hidden" id="foil_val_2" name="foil_val_2" value="" />
                    <input type="hidden" id="foil_info" name="foil_info" value="" />
                    <input type="hidden" id="foil_price" name="foil_price" value="" />
                </dd>
                <dd class="br">
                    <label>가로 <input id="foil_wid_1" type="text" class="mm" onblur="getAfterPrice.common('foil');">mm</label>
                    <label>세로 <input id="foil_vert_1" type="text" class="mm" onblur="getAfterPrice.common('foil');">mm</label>
                    &nbsp;/&nbsp;
                    <label>가로 <input id="foil_wid_2" type="text" class="mm" onblur="getAfterPrice.common('foil');">mm</label>
                    <label>세로 <input id="foil_vert_2" type="text" class="mm" onblur="getAfterPrice.common('foil');">mm</label>
                </dd>
                <dd class="br note">
                    File에 박 부분을 먹1도로 업로드 해주세요.
                </dd>
            </dl>
        </div>
html;

        return $html;
    }

    /**
     * @brief 박일 때 금박유광 이런식으로 넘어오는 이름을 금박만 반환
     *
     * @param $aft = 넘어온 후공정명
     *
     * @return 잘라낸 후공정명
     */
    function getFoilAfterName($aft) {
        if (strpos($aft, "금박") !== false) {
            return "금박";
        } else if (strpos($aft, "녹박") !== false) {
            return "녹박";
        } else if (strpos($aft, "먹박") !== false) {
            return "먹박";
        } else if (strpos($aft, "은박") !== false) {
            return "은박";
        } else if (strpos($aft, "적박") !== false) {
            return "적박";
        } else if (strpos($aft, "청박") !== false) {
            return "청박";
        } else {
            return "금박";
        }
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

    function getJson() {
        return ",\"" . $this->getName() . "\" : \"" . $this->costEach() . "\", \"foil_aft_mpcode\" : \"".$this->aft_foil_mpcode . "\", \"foil_bef_mpcode\" : \"".$this->bef_foil_mpcode . "\"";
    }

    function JC_makeOrderHtml($param) {
        $info1 = $this->mappingAreaInfo1($this->agroup);
        $info2 = $this->mappingAreaInfo2($this->pressure2);

        $html = '<input type="hidden" name="AGroup_1_Sel[]" value="06">';
        $html .= '<input type="hidden" name="AGroup_1[5]" value="06">';
        $html .= '<input type="hidden" name="AGroup_2[5]" value="'.$info1.'">'; // 앞면
        $html .= '<input type="hidden" name="Pressure2" value="'.$info2.'">'; // 뒷면
        $html .= '<input type="hidden" name="after_W06" value="'.$this->wid_1.'">';
        $html .= '<input type="hidden" name="after_H06" value="'.$this->vert_1.'">';
        $html .= '<input type="hidden" name="after_W06_sub" value="'.$this->wid_2.'">';
        $html .= '<input type="hidden" name="after_H06_sub" value="'.$this->vert_2.'">';
        $html .= '<input type="hidden" name="after_price[5]" value="' . $this->costEach() . '">';

        return $html;
    }

    function mappingAreaInfo1($info) {
        $tmp = "";
        if(strpos($info, "금박")  !== false) {
            $tmp .= '0';
        } else if(strpos($info, "은박") !== false) {
            $tmp .= '1';
        } else if(strpos($info, "청박") !== false) {
            $tmp .= '2';
        } else if(strpos($info, "적박") !== false) {
            $tmp .= '3';
        } else if(strpos($info, "녹박") !== false) {
            $tmp .= '4';
        } else if(strpos($info, "먹박") !== false) {
            $tmp .= '5';
        }

        if(strpos($info, "단면") !== false) {
            $tmp .= '1';
        } else if(strpos($info, "양면같음") !== false) {
            $tmp .= '2';
        } else if(strpos($info, "양면다름") !== false) {
            $tmp .= '3';
            echo $tmp;
        }

        return $tmp;
    }

    function mappingAreaInfo2($info) {
        $tmp = '';
        if(strpos($info, "금박") !== false) {
            $tmp .= '76';
        } else if(strpos($info, "은박") !== false) {
            $tmp .= '77';
        } else if(strpos($info, "청박") !== false) {
            $tmp .= '78';
        } else if(strpos($info, "적박") !== false) {
            $tmp .= '79';
        } else if(strpos($info, "녹박") !== false) {
            $tmp .= '81';
        } else if(strpos($info, "먹박") !== false) {
            $tmp .= '82';
        }

        return $tmp;
    }
}

?>