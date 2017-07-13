<?php

/**
 * Created by PhpStorm.
 * User: Hyeonsik Cho
 * Date: 2016-10-20
 * Time: 오후 4:16
 */
class StickerOrder_S30 implements StickerOrder
{
    function getOrderType($param) {
        $html = "";
        $ca_code = "S30";
        $s_code = "SE1";
        $paper_code = "S1/X/XXX";
        $stype_code = "";
        $standard = "SNF";
        $coating = "0";

        $factory = new DPrintingFactory();
        $product = $factory->create($param['cate_sortcode']);

        $after_history = explode("$", $param['after_history']);
        $after_count = count($after_history);
        $amt = $param['prd_amount'] * $param['prd_count'];
        $JC_after_html = "";

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
        }

        $standard = 'SEL';
        if ((int)$param['cate_stan_mpcode'] >= 154 && (int)$param['cate_stan_mpcode'] <= 157) {
            echo "SE";
            $tmp = (int)$param['cate_stan_mpcode'] - 153;
            $tmp = dechex($tmp);
            $stype_code = "SE";
            $s_code = $stype_code . $tmp;
        } else if ((int)$param['cate_stan_mpcode'] >= 158 && (int)$param['cate_stan_mpcode'] <= 184) {
            $tmp = (int)$param['cate_stan_mpcode'] - 157;
            $tmp = dechex($tmp);
            $stype_code = "SB";
            $s_code = $stype_code . $tmp;
        } else if ((int)$param['cate_stan_mpcode'] >= 185 && (int)$param['cate_stan_mpcode'] <= 211) {
            $tmp = (int)$param['cate_stan_mpcode'] - 184;
            $tmp = dechex($tmp);
            $stype_code = "SA";
            $s_code = $stype_code . $tmp;
        } else if ((int)$param['cate_stan_mpcode'] >= 212 && (int)$param['cate_stan_mpcode'] <= 238) {
            $tmp = (int)$param['cate_stan_mpcode'] - 211;
            $tmp = dechex($tmp);
            $stype_code = "SC";
            $s_code = $stype_code . $tmp;
        } else if ((int)$param['cate_stan_mpcode'] >= 239 && (int)$param['cate_stan_mpcode'] <= 265) {
            $tmp = (int)$param['cate_stan_mpcode'] - 238;
            $tmp = dechex($tmp);
            $stype_code = "SS";
            $s_code = $stype_code . $tmp;
        } else if ((int)$param['cate_stan_mpcode'] >= 266 && (int)$param['cate_stan_mpcode'] <= 277) {
            $tmp = (int)$param['cate_stan_mpcode'] - 265;
            $tmp = dechex($tmp);
            $stype_code = "SR";
            $s_code = $stype_code . $tmp;
        } else if ((int)$param['cate_stan_mpcode'] >= 278 && (int)$param['cate_stan_mpcode'] <= 284) {
            $tmp = (int)$param['cate_stan_mpcode'] - 277;
            $tmp = dechex($tmp);
            $stype_code = "SO";
            $s_code = $stype_code . $tmp;
        } else if ((int)$param['cate_stan_mpcode'] >= 954 && (int)$param['cate_stan_mpcode'] <= 957) {
            $tmp = (int)$param['cate_stan_mpcode'] - 953;
            $tmp = dechex($tmp);
            $stype_code = "SZ";
            $s_code = $stype_code . $tmp;
        } else if ((int)$param['cate_stan_mpcode'] >= 958 && (int)$param['cate_stan_mpcode'] <= 961) {
            $tmp = (int)$param['cate_stan_mpcode'] - 957;
            $tmp = dechex($tmp);
            $stype_code = "SD";
            $s_code = $stype_code . $tmp;
        }

        $pro_code = $ca_code . str_replace("/", "", $paper_code) . $s_code . $param['output_board_amt'] . "S" . $coating;
        $pro_code_basic = $ca_code . str_replace("/", "", $paper_code) . "SB1" . $param['output_board_amt'] . "S" . $coating;

        $html .= '<input type="hidden" name="Paper_Code" value="'.$paper_code.'">';
        $html .= '<input type="hidden" name="Pro_Code" value="' . $pro_code . '">'; //
        $html .= '<input type="hidden" name="Pro_Code_basic" value="' . $pro_code_basic . '">'; //
        $html .= '<input type="hidden" name="S_Code" value="'.$s_code.'">';
        $html .= '<input type="hidden" name="Standard" value="' . $standard . '">';
        $html .= '<input type="hidden" name="After_TPrice" value="' . $product->cost() . '">';
        $html .= '<input type="hidden" name="SType_Code" value="' . $stype_code . '">';
        $html .= $JC_after_html;

        return $html;
    }
}