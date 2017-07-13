<?php

/**
 * Created by PhpStorm.
 * User: Hyeonsik Cho
 * Date: 2016-10-20
 * Time: 오후 4:16
 */
class StickerOrder_S20 implements StickerOrder
{
    function getOrderType($param) {
        $html = "";
        $ca_code = "S20";
        $s_code = "SN1";
        $standard = "SNF";
        $coating = "1";

        $factory = new DPrintingFactory();
        $product = $factory->create($param['cate_sortcode']);

        $after_history = explode("$", $param['after_history']);
        $after_count = count($after_history);
        $amt = $param['prd_amount'] * $param['prd_count'];
        $JC_after_html = "";
        $background_html = '<input type="hidden" name="Bg_Mode" value="SN">';

        for($i = 0; $i < $after_count ; $i++) {
            if($after_history[$i] == '') {
                break;
            }
            $after = explode("|", $after_history[$i]);
            $product = $factory->createAfter($product, $after[0]);
            $product->setAfterprocess($param['prd_detail_no'] ,$after[0]);
            $JC_after_html .= $product->JC_makeOrderHtml($after);

            if($after[0] == "빼다") {
                $background_html = '<input type="hidden" name="Bg_Mode" value="ST">';
            }
        }

        $paper_code = "";
        if($param['cate_paper_mpcode'] == "42") {
            $paper_code = "S3/X/XXX";
        } else if($param['cate_paper_mpcode'] == "585") {
            $paper_code = "S4/X/XXX";
        } else if($param['cate_paper_mpcode'] == "584") {
            $paper_code = "S5/X/XXX";
        }

        if($param['cate_stan_type'] == 'stan') {
            $standard = 'SEL';
            if ($param['cate_stan_mpcode'] == "150") {
                $s_code = "SN1";
            } else if ($param['cate_stan_mpcode'] == "151") {
                $s_code = "SN2";
            } else if ($param['cate_stan_mpcode'] == "467") {
                $s_code = "SN4";
            } else if ($param['cate_stan_mpcode'] == "468") {
                $s_code = "SN5";
            } else if ($param['cate_stan_mpcode'] == "469") {
                $s_code = "SN6";
            } else if ($param['cate_stan_mpcode'] == "470") {
                $s_code = "SN7";
            } else if ($param['cate_stan_mpcode'] == "471") {
                $s_code = "SN8";
            } else if ($param['cate_stan_mpcode'] == "472") {
                $s_code = "SN9";
            } else if ($param['cate_stan_mpcode'] == "473") {
                $s_code = "SNA";
            } else if ($param['cate_stan_mpcode'] == "474") {
                $s_code = "SNB";
            } else if ($param['cate_stan_mpcode'] == "475") {
                $s_code = "SNC";
            } else if ($param['cate_stan_mpcode'] == "476") {
                $s_code = "SND";
            } else if ($param['cate_stan_mpcode'] == "477") {
                $s_code = "SNE";
            } else if ($param['cate_stan_mpcode'] == "976") {
                $s_code = "ST1";
            } else if ($param['cate_stan_mpcode'] == "977") {
                $s_code = "ST2";
            } else if ($param['cate_stan_mpcode'] == "978") {
                $s_code = "ST3";
            } else if ($param['cate_stan_mpcode'] == "979") {
                $s_code = "ST4";
            } else if ($param['cate_stan_mpcode'] == "980") {
                $s_code = "ST5";
            } else if ($param['cate_stan_mpcode'] == "981") {
                $s_code = "ST6";
            } else if ($param['cate_stan_mpcode'] == "982") {
                $s_code = "ST7";
            } else if ($param['cate_stan_mpcode'] == "983") {
                $s_code = "ST8";
            } else if ($param['cate_stan_mpcode'] == "984") {
                $s_code = "ST9";
            } else if ($param['cate_stan_mpcode'] == "985") {
                $s_code = "STA";
            } else if ($param['cate_stan_mpcode'] == "986") {
                $s_code = "STB";
            } else if ($param['cate_stan_mpcode'] == "987") {
                $s_code = "STC";
            } else if ($param['cate_stan_mpcode'] == "988") {
                $s_code = "STD";
            } else if ($param['cate_stan_mpcode'] == "989") {
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