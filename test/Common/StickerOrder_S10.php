<?php

/**
 * Created by PhpStorm.
 * User: Hyeonsik Cho
 * Date: 2016-10-20
 * Time: 오후 4:16
 */

// 컬러스티커
class StickerOrder_S10 implements StickerOrder
{
    function getOrderType($param) {
        $html = "";
        $ca_code = "S10";
        $paper_code = "S1/X/XXX";
        $s_code = "SN1";
        $standard = "SNF";

        $factory = new DPrintingFactory();
        $product = $factory->create($param['cate_sortcode']);

        $after_history = explode("$", $param['after_history']);
        $after_count = count($after_history);
        $amt = $param['prd_amount'] * $param['prd_count'];
        $JC_after_html = "";
        $coating = "0";
        $background_html = '<input type="hidden" name="Bg_Mode" value="SN">';

        for($i = 0; $i < $after_count ; $i++) {
            if($after_history[$i] == '') {
                break;
            }
            $after = explode("|", $after_history[$i]);
            $product = $factory->createAfter($product, $after[0]);
            $product->setAfterprocess($param['prd_detail_no'] ,$after[0]);
            $JC_after_html .= $product->JC_makeOrderHtml($after);

            if($after[0] == "코팅") {
                $coating = "1";
            }

            if($after[0] == "빼다") {
                $background_html = '<input type="hidden" name="Bg_Mode" value="ST">';
            }
        }

        if($param['cate_stan_type'] == 'stan') {
            $standard = 'SEL';
            if ($param['cate_stan_mpcode'] == "438") {
                $s_code = "SN1";
            } else if ($param['cate_stan_mpcode'] == "439") {
                $s_code = "SN2";
            } else if ($param['cate_stan_mpcode'] == "440") {
                $s_code = "SN3";
            } else if ($param['cate_stan_mpcode'] == "441") {
                $s_code = "SN4";
            } else if ($param['cate_stan_mpcode'] == "442") {
                $s_code = "SN5";
            } else if ($param['cate_stan_mpcode'] == "443") {
                $s_code = "SN6";
            } else if ($param['cate_stan_mpcode'] == "444") {
                $s_code = "SN7";
            } else if ($param['cate_stan_mpcode'] == "445") {
                $s_code = "SN8";
            } else if ($param['cate_stan_mpcode'] == "446") {
                $s_code = "SN9";
            } else if ($param['cate_stan_mpcode'] == "447") {
                $s_code = "SNA";
            } else if ($param['cate_stan_mpcode'] == "448") {
                $s_code = "SNB";
            } else if ($param['cate_stan_mpcode'] == "449") {
                $s_code = "SNC";
            } else if ($param['cate_stan_mpcode'] == "450") {
                $s_code = "SND";
            } else if ($param['cate_stan_mpcode'] == "451") {
                $s_code = "SNE";
            } else if ($param['cate_stan_mpcode'] == "962") {
                $s_code = "ST1";
            } else if ($param['cate_stan_mpcode'] == "963") {
                $s_code = "ST2";
            } else if ($param['cate_stan_mpcode'] == "964") {
                $s_code = "ST3";
            } else if ($param['cate_stan_mpcode'] == "965") {
                $s_code = "ST4";
            } else if ($param['cate_stan_mpcode'] == "966") {
                $s_code = "ST5";
            } else if ($param['cate_stan_mpcode'] == "967") {
                $s_code = "ST6";
            } else if ($param['cate_stan_mpcode'] == "968") {
                $s_code = "ST7";
            } else if ($param['cate_stan_mpcode'] == "969") {
                $s_code = "ST8";
            } else if ($param['cate_stan_mpcode'] == "970") {
                $s_code = "ST9";
            } else if ($param['cate_stan_mpcode'] == "971") {
                $s_code = "STA";
            } else if ($param['cate_stan_mpcode'] == "972") {
                $s_code = "STB";
            } else if ($param['cate_stan_mpcode'] == "973") {
                $s_code = "STC";
            } else if ($param['cate_stan_mpcode'] == "974") {
                $s_code = "STD";
            } else if ($param['cate_stan_mpcode'] == "975") {
                $s_code = "STE";
            }
            $pro_code = $ca_code . str_replace("/", "", $paper_code) . $s_code . $param['output_board_amt'] . "S" . $coating;
        } else {
            $pro_code = $ca_code . str_replace("/", "", $paper_code) . $standard . $param['output_board_amt'] . "S" . $coating;
        }

        $pro_code_basic = $ca_code . str_replace("/", "", $paper_code) . "SN1" . $param['output_board_amt'] . "S" . $coating;

        $html .= '<input type="hidden" name="Paper_Code" value="'.$paper_code.'">';
        $html .= '<input type="hidden" name="Pro_Code" value="' . $pro_code . '">'; //
        $html .= '<input type="hidden" name="Pro_Code_basic" value="' . $pro_code_basic . '">'; //
        $html .= '<input type="hidden" name="S_Code" value="'.$s_code.'">';
        $html .= '<input type="hidden" name="Standard" value="' . $standard . '">';
        $html .= '<input type="hidden" name="After_TPrice" value="' . $product->cost() . '">';
        $html .= $JC_after_html;
        $html .= $background_html;

        return $html;
    }
}