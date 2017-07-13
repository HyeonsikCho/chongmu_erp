<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/BusinessCommonDAO.php');


/**
 * @file MemberCommonListDAO.php
 *
 * @brief 영업 - 주문관리 - 주문수기등록 DAO
 */
class OrderInsertDAO extends BusinessCommonDAO {
    
    function __construct() {
    }
 	function getCartSequence($conn){
		$seqSql = "insert into cart_sequence values (null)";
		if(!$conn->Execute($seqSql)){
			return false;
		}
		$getSeqSql = "select last_insert_id() as seq";
		if(!$idx = $conn->Execute($getSeqSql)){
			return false;
		}else{
			$seq = $idx->fields["seq"];
		}
		return $seq;
	 }
	function setCartPrdlist($conn,$param){
		$param = $this->parameterArrayEscape($conn, $param);
		$Sql = "insert into cart_prdlist (cart_prdlist_id,
											user_id,
											title,
											cate_sortcode,
											cate_print_mpcode,
											cate_paper_mpcode,
											cate_stan_mpcode,
											cate_stan_type,
											stan_cal,
											work_size_wid,
											work_size_vert,
											cut_size_wid,
											cut_size_vert,
											tomson_size_wid,
											tomson_size_vert,
											prd_amount,
											prd_count,
											cart_d_amnt,
											cart_amnt,
											addtax_d_amnt,
											addtax_amnt,
											c_rate,
											c_user_rate,
											cpoint,
											direct_flag,
											regdate) value (
											%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,now())";
		$Sql = sprintf($Sql,    $param['cart_prdlist_id'],
							    $param['user_id'],
								$param['title'],
								$param['cate_sortcode'],
								$param['cate_print_mpcode'],
								$param['cate_paper_mpcode'],
								$param['cate_stan_mpcode'],
								$param['cate_stan_type'],
								$param['stan_cal'],
								$param['work_size_wid'],
								$param['work_size_vert'],
								$param['cut_size_wid'],
								$param['cut_size_vert'],
								$param['tomson_size_wid'],
								$param['tomson_size_vert'],
								$param['prd_amount'],
								$param['prd_count'],
								$param['cart_d_amnt'],
								$param['cart_amnt'],
								$param['addtax_d_amnt'],
								$param['addtax_amnt'],
								$param['c_rate'],
								$param['c_user_rate'],
								$param['cpoint'],
								$param['direct_flag']);
		$rs = $conn->Execute($Sql);
		return $rs;
	}
}
?>
