<?

include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/business/order_mng/OrderInsertDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();
$fb = new FormBean();

$dao = new OrderInsertDAO();

$cart_prdlist_id = $dao->getCartSequence($conn);



		$param['cart_prdlist_id'] = $cart_prdlist_id;
		$param['user_id'] = $fb->fb['user_id'];
		$param['title'] = $fb->fb['cart_comment'];
		$param['cate_sortcode'] = '004001001';
		$param['cate_print_mpcode'] = '5';
		$param['cate_paper_mpcode'] = '5';
		$param['cate_stan_mpcode'] = '7';
		$param['cate_stan_type'] = 'stan';
		$param['stan_cal'] = '1';
		$param['work_size_wid'] = '0';
		$param['work_size_vert'] ='0';
		$param['cut_size_wid'] ='0';
		$param['cut_size_vert'] ='0';
		$param['tomson_size_wid'] ='0';
		$param['tomson_size_vert'] ='0';
		$param['prd_amount'] = 0;
		$param['prd_count'] = 1;
		$param['cart_d_amnt'] = $fb->fb['amount'];
		$param['cart_amnt']  = $fb->fb['amount'];
		$param['addtax_d_amnt']  = $fb->fb['amount'] + ($fb->fb['amount'] * 0.1);
		$param['addtax_amnt'] = $fb->fb['amount'] + ($fb->fb['amount'] * 0.1);
		$param['c_rate'] = $fb->fb['c_rate'];
		$param['c_user_rate'] = $fb->fb['c_user_rate'];
		$param['cpoint'] = 0;
		$param['direct_flag'] = 'N';
		
		$rs = $dao->setCartPrdlist($conn,$param);
		if($rs){
			$ret['result'] = 'true';
		}else{
			$ret['result'] = 'false';
		}
		echo json_encode($ret);

$conn->Close();
?>
