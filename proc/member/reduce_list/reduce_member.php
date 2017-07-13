<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/member/member_mng/ReduceListDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$reduceListDAO = new ReduceListDAO();

$check = 1;

$conn->StartTrans();

$seqno = explode(',', $fb->form("seqno"));

//관심_상품 관련 테이블
$inter_table = array();
$inter_table[] = "interest_prdt_ply";
$inter_table[] = "interest_prdt_mono";
$inter_table[] = "interest_prdt_ply_paper";
$inter_table[] = "interest_prdt_opt";
$inter_table[] = "interest_prdt_after";
$inter_table[] = "interest_prdt_mono_paper";

//회원정보 테이블 
$table = array();
$table[] = "member_dlvr";            //회원_배송
$table[] = "member_point_history";   //회원_포인트_내역
$table[] = "member_cp";              //회원_쿠폰
$table[] = "cp_use_history";         //쿠폰_사용_내역
$table[] = "member_office_grade";    //회원_사내_등급
$table[] = "admin_licenseeregi";     //관리_사업자등록
$table[] = "accting_mng";            //회계_담당자
$table[] = "member_event";           //회원_이벤트
$table[] = "member_sales_price";     //회원_매출_금액
$table[] = "member_withdraw";        //회원_탈퇴
$table[] = "member_oa";              //회원_미수금
$table[] = "licensee_info";          //사업자_정보
$table[] = "evid_issue_history";     //증빙_발급_내역
$table[] = "member_grade";           //회원_등급
$table[] = "grade_req";              //등급_요청
$table[] = "member_order";           //회원_주문
$table[] = "member_detail_info";     //회원_상세_정보
$table[] = "member_pay_history";     //회원_결재_내역
$table[] = "dlvr_friend_main";       //배송_친구_메인
$table[] = "dlvr_friend_sub";        //배송_친구_부
$table[] = "member_certi";           //회원_인증
$table[] = "excpt_member";           //예외_회원
$table[] = "member_interest_design"; //회원_관심_디자인
$table[] = "member_interest_needs";  //회원_관심_요구사항
$table[] = "member_interest_event";  //회원_관심_이벤트
$table[] = "member_interest_prdt";   //회원_관심_상품
$table[] = "interest_prdt";          //관심_상품

$j = 0;
foreach ($seqno as $key=>$value) {

    $param = array();
    $param["table"] = "interest_prdt";
    $param["col"] = "interest_prdt_seqno";
    $param["where"]["member_seqno"] = $seqno[$j];

    $sel_rs = $reduceListDAO->selectData($conn, $param);

    //관심상품이 있을 경우
    if (!$sel_rs->EOF == 1) {
        //관심상품 관련 테이블 삭제
        for ($i = 0; $i < count($inter_table); $i++) {

            $param = array();
            $param["table"] = $inter_table[$i];
            $param["prk"] = "interest_prdt_seqno";
            $param["prkVal"] = $sel_rs->fields["interest_prdt_seqno"];

            $rs = $reduceListDAO->deleteData($conn, $param);

            if (!$rs) {
                $check = 0;
                $conn->CompleteTrans();
                $conn->close();
                echo $check;
                exit;
            }
        }
    }

    //회원정보 관련 테이블 삭제
    for ($i = 0; $i < count($table); $i++) {

        $param = array();
        $param["table"] = $table[$i];
        $param["prk"] = "member_seqno";
        $param["prkVal"] = $seqno[$j];

        $rs = $reduceListDAO->deleteData($conn, $param);

        if (!$rs) {
            $check = 0;
            $conn->CompleteTrans();
            $conn->close();
            echo $check;
            exit;
        }
    }

    //기업 개인 
    $param = array();
    $param["member_seqno"] = $seqno[$j];

    $group_rs = $reduceListDAO->selectMemberDetailInfo($conn, $param);

    //개인정보 삭제
    $param = array();
    $param["member_seqno"] = $seqno[$j];
    $rs = $reduceListDAO->updateMemberInfoDelete($conn, $param);

    if (!$rs) {
        $check = 0;
    }

    //기업 개인 일 경우
    if ($group_rs->fields["group_id"]) {

        $param = array();
        $param["group_id"] = $group_rs->fields["group_id"];
        $gr_rs = $reduceListDAO->selectGroupIdInfo($conn, $param);

        while ($gr_rs && !$gr_rs->EOF) {
            $member_seqno = $sel_rs->fields["member_seqno"];

            $param = array();
            $param["table"] = "interest_prdt";
            $param["col"] = "interest_prdt_seqno";
            $param["where"]["member_seqno"] = $seqno[$j];

            $sel_rs = $reduceListDAO->selectData($conn, $param);

            if (!$sel_rs->EOF == 1) {
                //관심상품 관련 테이블 삭제
                for ($i = 0; $i < count($inter_table); $i++) {

                    $param = array();
                    $param["table"] = $inter_table[$i];
                    $param["prk"] = "interest_prdt_seqno";
                    $param["prkVal"] = $sel_rs->fields["interest_prdt_seqno"];

                    $rs = $reduceListDAO->deleteData($conn, $param);

                    if (!$rs) {
                        $check = 0;
                        $conn->CompleteTrans();
                        $conn->close();
                        echo $check;
                        exit;
                    }
                }
            }

            //회원정보 관련 테이블 삭제
            for ($i = 0; $i < count($table); $i++) {

                $param = array();
                $param["table"] = $table[$i];
                $param["prk"] = "member_seqno";
                $param["prkVal"] = $seqno[$j];

                $rs = $reduceListDAO->deleteData($conn, $param);

                if (!$rs) {
                    $check = 0;
                    $conn->CompleteTrans();
                    $conn->close();
                    echo $check;
                    exit;
                }
            }

            //개인정보 삭제
            $rs = $reduceListDAO->updateMemberInfoDelete($conn, $param);

            if (!$rs) {
                $check = 0;
                $conn->CompleteTrans();
                $conn->close();
                echo $check;
                exit;
            }

            $gr_rs->moveNext();
        }
    }
    $j++;
}

$conn->CompleteTrans();
$conn->close();
echo $check;
?>
