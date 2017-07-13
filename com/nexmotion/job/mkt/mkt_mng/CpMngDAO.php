<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/MktCommonDAO.php');
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/html/mkt/mkt_mng/CpMngHTML.php");

class CpMngDAO extends MktCommonDAO {

    function __construct() {
    }

    /*
     * 쿠폰 list select 
     * $conn : db connection
     * $param["cpn_seqno"] : 회사 관리 일련번호
     * return : resultset 
     */ 
    function selectCplist($conn, $param) {

        if (!$this->connectioncheck($conn)) return false; 
        $param = $this->parameterarrayescape($conn, $param);

        $query  = "\n    SELECT   A.cp_name";
        $query .= "\n            ,A.val";
        $query .= "\n            ,A.unit";
        $query .= "\n            ,A.max_sale_price";
        $query .= "\n            ,A.min_order_price";
        $query .= "\n            ,A.unit";
        $query .= "\n            ,A.regi_date";
        $query .= "\n            ,A.period_limit_yn";
        $query .= "\n            ,A.public_start_date";
        $query .= "\n            ,A.public_end_date";
        $query .= "\n            ,A.public_extinct_date";
        $query .= "\n            ,A.public_deadline_day";
        $query .= "\n            ,A.hour_limit_yn";
        $query .= "\n            ,A.use_start_hour";
        $query .= "\n            ,A.use_end_hour";
        $query .= "\n            ,A.object_appoint_yn";
        $query .= "\n            ,A.use_yn";
        $query .= "\n            ,A.public_amt";
        $query .= "\n            ,A.cp_seqno";
        $query .= "\n            ,B.sell_site";
        $query .= "\n            ,B.cpn_admin_seqno";
        $query .= "\n            ,C.cate_name";
        $query .= "\n            ,C.sortcode";
        $query .= "\n      FROM   cp A";
        $query .= "\n            ,cpn_admin B";
        $query .= "\n            ,cate C";
        $query .= "\n     WHERE  A.cpn_admin_seqno = B.cpn_admin_seqno";
        $query .= "\n       AND  A.cate_sortcode = C.sortcode";

        //판매사이트가 있을때
        if ($this->blankParameterCheck($param ,"cpn_seqno")) {

            $query .= "\n       AND  B.cpn_admin_seqno =" . $param["cpn_seqno"];
        }

        //쿠폰 일련번호가 있을때
        if ($this->blankParameterCheck($param ,"cp_seqno")) {

            $query .= "\n       AND  A.cp_seqno =" . $param["cp_seqno"];
        }
 
        $result = $conn->Execute($query);

        return $result;

    }

    /*
     * 회원 list select 
     * $conn : db connection
     * $param["cpn_seqno"] : 회사 관리 일련번호
     * return : resultset 
     */ 
    function selectMemberNickList($conn, $param) {

        if (!$this->connectioncheck($conn)) return false; 
        $param = $this->parameterarrayescape($conn, $param);
        $query  = "\n    SELECT   office_nick";
        $query .= "\n            ,member_seqno";
        $query .= "\n      FROM   member A";
        $query .= "\n     WHERE   cpn_admin_seqno=" . $param["cpn_seqno"];
        //그룹 아이디가 없을때
        $query .= "\n       AND   (group_id = ''";
        $query .= "\n        OR    group_id IS NULL)";

        //회원명 검색 있을때
        if ($this->blankParameterCheck($param ,"search")) {

            $search_str = substr($param["search"], 1, -1); 
            $query .= "\n       AND  office_nick like '%" . $search_str . "%' ";
        }

        $query .= "\n  ORDER BY member_seqno";

        $result = $conn->Execute($query);

        return $result;
    }

    /*
     * 회원 정보  list select 
     * $conn : db connection
     * $param["cpn_seqno"] : 회사 관리 일련번호
     * return : resultset 
     */ 
    function selectMemberInfoList($conn, $param) {

        if (!$this->connectioncheck($conn)) return false; 
        $param = $this->parameterarrayescape($conn, $param);
        $query  = "\n    SELECT   office_nick";
        $query .= "\n            ,grade";
        $query .= "\n            ,member_typ";
        $query .= "\n            ,cell_num";
        //$query .= "\n            ,office_member_mng";
        $query .= "\n            ,member_seqno";
        $query .= "\n      FROM   member";
        //그룹 아이디가 없을때
        $query .= "\n     WHERE   (group_id = ''";
        $query .= "\n        OR    group_id IS NULL)";
        $query .= "\n       AND    withdraw_dvs = '1'";

        //판매사이트가 있을때
        if ($this->blankParameterCheck($param ,"cpn_seqno")) {

            $query .= "\n       AND  cpn_admin_seqno =" . $param["cpn_seqno"];
        }

        //회원명 검색 있을때
        if ($this->blankParameterCheck($param ,"member_seqno")) {

            $query .= "\n       AND  member_seqno =" . $param["member_seqno"];
        }

        //팀 구분 검색 있을때
        if ($this->blankParameterCheck($param ,"depar_dvs")) {

            $query .= "\n       AND  ( biz_resp  =" . $param["depar_dvs"];
            $query .= "\n       OR     release_resp  =" . $param["depar_dvs"];
            $query .= "\n       OR     dlvr_resp  =" . $param["depar_dvs"] . ")";

        }

        //등급 검색 있을때
        if ($this->blankParameterCheck($param ,"grade")) {

            $query .= "\n       AND  grade =" . $param["grade"];
        }
 
        //회원 구분 있을때
        if ($this->blankParameterCheck($param ,"member_typ")) {

            $query .= "\n       AND  member_typ =" . $param["member_typ"];

        }
 
        $result = $conn->Execute($query);

        return $result;
 
    }

    /*
     * 쿠폰 발급  list select 
     * $conn : db connection
     * $param["cp_seqno"] : 쿠폰 일련번호
     * return : resultset 
     */ 
    function selectCpIssueList($conn, $param) {

        if (!$this->connectioncheck($conn)) return false; 
        $param = $this->parameterarrayescape($conn, $param);
        $query  = "\n    SELECT   A.office_nick";
        $query .= "\n            ,A.member_seqno";
        $query .= "\n            ,B.cp_num";
        $query .= "\n      FROM   member A";
        $query .= "\n            ,cp_issue B";
        $query .= "\n            ,cp C";
        $query .= "\n     WHERE   A.member_seqno = B.member_seqno";
        $query .= "\n       AND   B.cp_seqno = C.cp_seqno";

        //쿠폰 일련번호가 있을때
        if ($this->blankParameterCheck($param ,"cp_seqno")) {

            $query .= "\n       AND   B.cp_seqno =" . $param["cp_seqno"];
        }

        $result = $conn->Execute($query);

        return $result;
    }





}
 
?>
