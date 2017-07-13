<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ErpCommonUtil.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/test/Common/DAO/ProductDAO.php');
include_once($_SERVER["DOCUMENT_ROOT"] .'/test/Common/CondimentDecorator.php');

abstract class Afterprocess extends CondimentDecorator {
	var $sortcode;
	var $product;
	var $name;
	var $price;
	var $depth1;
	var $depth2;
	var $depth3;
	var $jc_orderhtml;


	var $dao;
	var $connectionPool;
	var $util;
	var $conn;


	function __construct($product) {
		$this->product = $product;
		$this->sortcode = $product->sortcode;
		$this->dao = new ProductDAO();
		$connectionPool = new ConnectionPool();
		$this->conn = $connectionPool->getPooledConnection();
	}

	function getDescription() {
		return $this->product->getDescription() . "후공정 : " . $this->name . "(" .$this->price . ")</br>";
	}

	function setAfterprocess($prd_detail_no, $after_name) {
		$param = array();
		$param['prd_detail_no'] = $prd_detail_no;
		$param['after_name'] = $after_name;

		$rs = $this->dao->selectAfterProcess($this->conn, $param);

		$this->name = $after_name;
		$this->price = $rs->fields["addtax_amnt"];
	}

	function getAfterMpcode($param) {
		$rs = $this->dao->selectCateAftInfo($this->conn, 'SEQ' ,$param);
		return $rs->fields['mpcode'];
	}

	function getPrice($rs_price) {
		return $rs_price->fields['sell_price'];
	}

	function cost() {
		return $this->price + $this->product->cost();
	}

	function costEach() {
		return $this->price;
	}

	abstract function JC_makeOrderHtml($param);
}

?>
