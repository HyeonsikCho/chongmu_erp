<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/common/util/ConnectionPool.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/common/entity/FormBean.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/basic_mng/prdt_mng/PrdtItemRegiDAO.php');

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$prdtItemRegiDAO = new PrdtItemRegiDAO();
$result = true;

$conn->StartTrans();

//카테고리 분류 코드
$cate_sortcode = $fb->form("cate_sortcode"); 

//상품종이 일련번호
$seqno = explode(',', $fb->form("seqno"));
$select_el = $fb->form("selectEl");

$table = "";

if ($select_el === "size") {
    $table = "cate_stan";
} else if ($select_el === "tmpt") {
    $table = "cate_print";
} else {
    $table = "cate_" . $select_el;
}

$i = 0;
foreach ($seqno as $key=>$value) {

    //종이
    if ($select_el === "paper") {

        $param = array();
        $param["table"] = "prdt_paper";
        $param["col"] = "sort, name, dvs, color, basisweight, basisweight_unit";
        $param["where"]["prdt_paper_seqno"] = $seqno[$i];

        $rs = $prdtItemRegiDAO->selectData($conn, $param); 

        $sort = $rs->fields["sort"];
        $name = $rs->fields["name"];
        $dvs = $rs->fields["dvs"];
        $color = $rs->fields["color"];
        $basisweight = $rs->fields["basisweight"] . $rs->fields["basisweight_unit"];

        $param = array();
        $param["table"] = "cate_paper";
        $param["col"] = "cate_paper_seqno";
        $param["where"]["sort"] = $sort;
        $param["where"]["name"] = $name;
        $param["where"]["dvs"] = $dvs;
        $param["where"]["color"] = $color;
        $param["where"]["basisweight"] = $basisweight;
        $param["where"]["cate_sortcode"] = $cate_sortcode;
        
        $rs = $prdtItemRegiDAO->selectData($conn, $param); 

        $param = array();
        $param["table"] = $table;
        $param["col"] = "MAX(mpcode) AS mpcode";
        $mpcode_rs = $prdtItemRegiDAO->selectData($conn, $param);

        $mpcode = $mpcode_rs->fields["mpcode"] + 1;

        if ($mpcode == "" || $mpcode == NULL) {
            $mpcode = 0;
        }

        if ($mpcode_rs->EOF == 1) {
            $mpcode = 0;
        }

        //중복된 값이 없으면 
        if ($rs->EOF == 1) {
            $param = array();
            $param["table"] = "cate_paper";
            $param["col"]["sort"] = $sort;
            $param["col"]["name"] = $name;
            $param["col"]["dvs"] = $dvs;
            $param["col"]["color"] = $color;
            $param["col"]["basisweight"] = $basisweight;
            $param["col"]["cate_sortcode"] = $cate_sortcode;
            $param["col"]["mpcode"] = $mpcode;

            $result = $prdtItemRegiDAO->insertData($conn, $param);
        }
   
    //사이즈
    } else if ($select_el == "size") {
 
        $param = array();
        $param["table"] = $table;
        $param["col"] = "prdt_stan_seqno";
        $param["where"]["prdt_stan_seqno"] = $seqno[$i];
        $param["where"]["cate_sortcode"] = $cate_sortcode;
        
        $rs = $prdtItemRegiDAO->selectData($conn, $param); 

        $param = array();
        $param["table"] = $table;
        $param["col"] = "MAX(mpcode) AS mpcode";
        $mpcode_rs = $prdtItemRegiDAO->selectData($conn, $param);

        $mpcode = $mpcode_rs->fields["mpcode"] + 1;

        if ($mpcode == "" || $mpcode == NULL) {
            $mpcode = 0;
        }

        if ($mpcode_rs->EOF == 1) {
            $mpcode = 0;
        }

        //중복된 값이 없으면 
        if ($rs->EOF == 1) {
            $param = array();
            $param["table"] = $table;
            $param["col"]["prdt_stan_seqno"] = $seqno[$i];
            $param["col"]["cate_sortcode"] = $cate_sortcode;
            $param["col"]["mpcode"] = $mpcode;

            $result = $prdtItemRegiDAO->insertData($conn, $param);
        }

    //인쇄도수
    } else if ($select_el == "tmpt") {
 
        $param = array();
        $param["table"] = $table;
        $param["col"] = "prdt_print_seqno";
        $param["where"]["prdt_print_seqno"] = $seqno[$i];
        $param["where"]["cate_sortcode"] = $cate_sortcode;
        
        $rs = $prdtItemRegiDAO->selectData($conn, $param); 

        $param = array();
        $param["table"] = $table;
        $param["col"] = "MAX(mpcode) AS mpcode";
        $mpcode_rs = $prdtItemRegiDAO->selectData($conn, $param);

        $mpcode = $mpcode_rs->fields["mpcode"] + 1;

        if ($mpcode == "" || $mpcode == NULL) {
            $mpcode = 0;
        }

        if ($mpcode_rs->EOF == 1) {
            $mpcode = 0;
        }

        //중복된 값이 없으면 
        if ($rs->EOF == 1) {
            $param = array();
            $param["table"] = $table;
            $param["col"]["prdt_print_seqno"] = $seqno[$i];
            $param["col"]["cate_sortcode"] = $cate_sortcode;
            $param["col"]["mpcode"] = $mpcode;

            $result = $prdtItemRegiDAO->insertData($conn, $param);
        }
 
    //후공정, 옵션
    } else if ($select_el == "after" || $select_el == "opt") {
  
        $param = array();
        $param["table"] = $table;
        $param["col"] = "prdt_" . $select_el . "_seqno";
        $param["where"]["prdt_" . $select_el . "_seqno"] = $seqno[$i];
        $param["where"]["cate_sortcode"] = $cate_sortcode;
        $param["where"]["basic_yn"] = $fb->form("basic_yn");
        
        $rs = $prdtItemRegiDAO->selectData($conn, $param); 

        $param = array();
        $param["table"] = $table;
        $param["col"] = "MAX(mpcode) AS mpcode";
        $mpcode_rs = $prdtItemRegiDAO->selectData($conn, $param);

        $mpcode = $mpcode_rs->fields["mpcode"] + 1;

        if ($mpcode == "" || $mpcode == NULL) {
            $mpcode = 0;
        }

        if ($mpcode_rs->EOF == 1) {
            $mpcode = 0;
        }

        //중복된 값이 없으면 
        if ($rs->EOF == 1) {
            $param = array();
            $param["table"] = $table;
            $param["col"]["prdt_" . $select_el . "_seqno"] = $seqno[$i];
            $param["col"]["cate_sortcode"] = $cate_sortcode;
            $param["col"]["mpcode"] = $mpcode;
            $param["col"]["basic_yn"] = $fb->form("basic_yn");

            $result = $prdtItemRegiDAO->insertData($conn, $param);
        }
    }

    $i++;
}

echo $result;
$conn->CompleteTrans();
$conn->close();
?>
