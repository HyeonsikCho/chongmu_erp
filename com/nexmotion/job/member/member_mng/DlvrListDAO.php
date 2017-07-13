<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/common/MemberCommonDAO.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/html/member/member_mng/DlvrListHTML.php");

/**
 * @file DlvrListDAO.php
 *
 * @brief 회원 - 회원관리 - 배송친구리스트 DAO
 */
class DlvrListDAO extends MemberCommonDAO {

    function __construct() {
    }
 
    /*
     * 주소 구군에 해당하는 읍면동 Select 
     * $conn : DB Connection
     * $param["gugun"] : 구,군
     * $param["doro_yn"] : 도로명 여부
     * return : resultSet 
     */ 
    function selectDoroDong($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);
        $area = substr($param["area"], 1, -1); 
        $doro_yn = substr($param["doro_yn"], 1, -1); 

        $query  = "\n      SELECT  DISTINCT";

        if ($doro_yn == "Y") {

            $query .= "\n                       doro";

        } else {

            $query .= "\n                       eup";
            $query .= "\n                      ,dong";

        }

        $query .= "\n        FROM  " . $area . "_zipcode";
        $query .= "\n       WHERE  gugun= " . $param["gugun"];

        if ($doro_yn == "Y") {

            $query .= "\n     ORDER BY doro";

        } else {

            $query .= "\n     ORDER BY dong, eup";

        }

        $result = $conn->Execute($query);

        return $result;
    }
 
    /*
     * 주소 구군에 해당하는 읍면동 Select 
     * $conn : DB Connection
     * $param["gugun"] : 구,군
     * $param["eup"] : 읍,면,동
     * $param["doro_yn"] : 도로명 여부
     * return : resultSet 
     */ 
    function selectRi($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);
        $area = substr($param["area"], 1, -1); 
        $doro_yn = substr($param["doro_yn"], 1, -1); 

        $query  = "\n      SELECT  DISTINCT";
        $query .= "\n                       ri";
        $query .= "\n        FROM  " . $area . "_zipcode";
        $query .= "\n       WHERE  gugun= " . $param["gugun"];

        //읍,면
        if ($this->blankParameterCheck($param, "eup")) {

            $query .= "\n         AND  eup = " . $param["eup"];

        }

        $result = $conn->Execute($query);

        return $result;
    }
    

    
    /*
     * 주소에 해당하는 배송친구 Select 
     * $conn : DB Connection
     * $param["search"] : 주소 검색어
     * $param["datail"] : 주소 상세 검색어
     * return : resultSet 
     */ 
    function selectDlvrFriend($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);
        $type = substr($param["type"], 1, -1);

        if ($type == "All" || $type == "Main") {

            $query .= "\n    SELECT  B.office_nick";
            $query .= "\n           ,B.member_name";
            $query .= "\n           ,B.member_seqno";
            $query .= "\n           ,B.dlvr_friend_yn";
            $query .= "\n           ,B.dlvr_friend_main";
            $query .= "\n           ,A.regi_date";
            $query .= "\n           ,C.addr";
            $query .= "\n           ,C.addr_detail";
            $query .= "\n           ,C.tel_num";
            $query .= "\n      FROM dlvr_friend_main A";
            $query .= "\n          ,member B";
            $query .= "\n          ,member_dlvr C";
            $query .= "\n     WHERE A.state = '2'";
            $query .= "\n       AND A.member_seqno = B.member_seqno";
            $query .= "\n       AND B.member_seqno = C.member_seqno";
            $query .= "\n       AND B.dlvr_friend_yn = 'Y'";
            $query .= "\n       AND B.dlvr_friend_main = 'Y'";
            $query .= "\n       AND C.dlvr_dvs = '2'";

            //주소 검색어
            if ($this->blankParameterCheck($param, "search")) {
                $query .= "\n       AND C.addr LIKE '%" . substr($param["search"], 1,-1) . "%'";
            }

        }

        if ($type == "All") {
            
            $query .= "\n   UNION";

        } 

        if ($type == "All" || $type == "Sub") {

            $query .= "\n    SELECT  B.office_nick";
            $query .= "\n           ,B.member_name";
            $query .= "\n           ,B.member_seqno";
            $query .= "\n           ,B.dlvr_friend_yn";
            $query .= "\n           ,B.dlvr_friend_main";
            $query .= "\n           ,A.regi_date";
            $query .= "\n           ,C.addr";
            $query .= "\n           ,C.addr_detail";
            $query .= "\n           ,C.tel_num";
            $query .= "\n      FROM dlvr_friend_sub A";
            $query .= "\n          ,member B";
            $query .= "\n          ,member_dlvr C";
            $query .= "\n     WHERE A.state = '2'";
            $query .= "\n       AND A.member_seqno = B.member_seqno";
            $query .= "\n       AND B.member_seqno = C.member_seqno";
            $query .= "\n       AND B.dlvr_friend_yn = 'Y'";
            $query .= "\n       AND B.dlvr_friend_main = 'N'";
            $query .= "\n       AND C.dlvr_dvs = '2'";

            //주소 검색어
            if ($this->blankParameterCheck($param, "search")) {
                $query .= "\n       AND C.addr LIKE '%" . substr($param["search"], 1,-1) . "%'";
            }

        }

        $result = $conn->Execute($query);

        return $result;
    }
    
    /*
     * 주소에 해당하는 배송친구 요청 Select 
     * $conn : DB Connection
     * $param["search"] : 주소 검색어
     * $param["detail"] : 주소 상세 검색어
     * return : resultSet 
     */ 
    function selectMainReqList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query .= "\n    SELECT  B.office_nick";
        $query .= "\n           ,B.member_name";
        $query .= "\n           ,B.member_seqno";
        $query .= "\n           ,A.regi_date";
        $query .= "\n           ,A.dlvr_friend_main_seqno";
        $query .= "\n           ,C.addr";
        $query .= "\n           ,C.addr_detail";
        $query .= "\n           ,C.tel_num";
        $query .= "\n      FROM dlvr_friend_main A";
        $query .= "\n          ,member B";
        $query .= "\n          ,member_dlvr C";
        $query .= "\n     WHERE A.state = '1'";
        $query .= "\n       AND A.member_seqno = B.member_seqno";
        $query .= "\n       AND B.member_seqno = C.member_seqno";
        $query .= "\n       AND B.dlvr_friend_yn = 'Y'";
        $query .= "\n       AND B.dlvr_friend_main = 'Y'";
        $query .= "\n       AND C.dlvr_dvs = '2'";

        //주소 검색어
        if ($this->blankParameterCheck($param, "search")) {
            $query .= "\n       AND C.addr LIKE '%" . substr($param["search"], 1,-1) . "%'";
        }

        $result = $conn->Execute($query);

        return $result;
    }
     
    /*
     * 주소에 해당하는 배송친구 요청 Select 
     * $conn : DB Connection
     * $param["area"] : 지역 이름
     * $param["gugun"] : 구,군
     * $param["eupdong"] : 읍,면,동
     * return : resultSet 
     */ 
    function selectSubReqList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query .= "\n    SELECT  B.office_nick as sub_nick";
        $query .= "\n           ,B.member_seqno as sub_seqno";
        $query .= "\n           ,A.regi_date as sub_date";
        $query .= "\n           ,A.dlvr_friend_sub_seqno";
        $query .= "\n           ,C.addr as sub_addr";
        $query .= "\n           ,C.addr_detail as sub_detail";
        $query .= "\n           ,C.tel_num as sub_tel";
        $query .= "\n           ,D.member_seqno as main_seqno";
        $query .= "\n           ,D.dlvr_friend_main_seqno";
        $query .= "\n           ,E.office_nick as main_nick";
        $query .= "\n           ,E.member_seqno as main_member_seqno";
        $query .= "\n           ,F.addr as main_addr";
        $query .= "\n           ,F.addr_detail as main_detail";
        $query .= "\n           ,F.tel_num as main_tel";
        $query .= "\n      FROM dlvr_friend_sub A";
        $query .= "\n          ,member B";
        $query .= "\n          ,member_dlvr C";
        $query .= "\n          ,dlvr_friend_main D";
        $query .= "\n          ,member E";
        $query .= "\n          ,member_dlvr F";
        $query .= "\n     WHERE A.state = '1'";
        $query .= "\n       AND A.member_seqno = B.member_seqno";
        $query .= "\n       AND B.member_seqno = C.member_seqno";
        $query .= "\n       AND D.member_seqno = E.member_seqno";
        $query .= "\n       AND E.member_seqno = F.member_seqno";
        $query .= "\n       AND A.dlvr_friend_main_seqno = D.dlvr_friend_main_seqno";
        $query .= "\n       AND B.dlvr_friend_yn = 'Y'";
        $query .= "\n       AND B.dlvr_friend_main = 'N'";
        $query .= "\n       AND F.dlvr_dvs = '2'";

        //주소 검색어
        if ($this->blankParameterCheck($param, "search")) {
            $query .= "\n       AND C.addr LIKE '%" . substr($param["search"], 1,-1) . "%'";
        }

        $result = $conn->Execute($query);

        return $result;
    }


    /*
     * 모든 메인 업체 리스트 보기
     * $conn : DB Connection
     * return : resultSet 
     */ 
    function selectDlvrMainList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n    SELECT  A.addr";
        $query .= "\n           ,A.addr_detail";
        $query .= "\n           ,A.tel_num";
        $query .= "\n           ,B.office_nick";  
        $query .= "\n           ,B.member_seqno";  
        $query .= "\n      FROM  member_dlvr A";
        $query .= "\n           ,member B";
        $query .= "\n           ,dlvr_friend_main C";
        $query .= "\n     WHERE  A.member_seqno = B.member_seqno";
        $query .= "\n       AND  B.member_seqno = C.member_seqno";
        $query .= "\n       AND  A.dlvr_dvs = '2'";
        $query .= "\n       AND  B.dlvr_friend_yn = 'Y'";
        $query .= "\n       AND  B.dlvr_friend_main = 'Y'";
        $query .= "\n       AND  C.state = '2'";

        //사내닉네임 검색어
        if ($this->blankParameterCheck($param, "search_nick")) {

            $query .= "\n       AND B.office_nick LIKE '%" . substr($param["search_nick"], 1,-1) . "%'";

        }

        if ($this->blankParameterCheck($param ,"sort") && $this->blankParameterCheck($param,"sort_type")) {
    
            $param["sort"] = substr($param["sort"], 1, -1);
            $param["sort_type"] = substr($param["sort_type"], 1, -1); 
            
            if ($param["sort"] == "member_name") {

                $query .= "\n  ORDER BY  B.member_name " . $param["sort_type"];

            } else if ($param["sort"] == "addr") {

                $query .= "\n  ORDER BY  A.addr " . $param["sort_type"];

            }
        }

        $result = $conn->Execute($query);

        return $result;
    }
    
    /*
     * 배송친구 요청 Main Select 
     * $conn : DB Connection
     * $param["seqno"] : 배송친구 메인 일련번호
     * return : resultSet 
     */ 
    function selectDlvrMain($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query .= "\n    SELECT  B.office_nick";
        $query .= "\n           ,B.member_seqno";
        $query .= "\n           ,A.regi_date";
        $query .= "\n           ,C.addr";
        $query .= "\n           ,C.addr_detail";
        $query .= "\n           ,C.tel_num";
        $query .= "\n      FROM dlvr_friend_main A";
        $query .= "\n          ,member B";
        $query .= "\n          ,member_dlvr C";
        $query .= "\n     WHERE A.state = '1'";
        $query .= "\n       AND A.member_seqno = B.member_seqno";
        $query .= "\n       AND B.member_seqno = C.member_seqno";
        $query .= "\n       AND B.dlvr_friend_yn = 'Y'";
        $query .= "\n       AND B.dlvr_friend_main = 'Y'";
        $query .= "\n       AND C.dlvr_dvs = '2'";
        $query .= "\n       AND A.dlvr_friend_main_seqno = " . $param["seqno"];
        $result = $conn->Execute($query);

        return $result;
    }
 
    
    /*
     * 회원 일련번호에 해당하는 배송친구 메인 일련번호 Select 
     * $conn : DB Connection
     * $param["member_seqno"] : 회원 일련번호
     * return : resultSet 
     */ 
    function selectMemberMainSeqno($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query .= "\n    SELECT  A.dlvr_friend_main_seqno";
        $query .= "\n      FROM dlvr_friend_main A";
        $query .= "\n          ,member B";
        $query .= "\n          ,member_dlvr C";
        $query .= "\n     WHERE A.state = '2'";
        $query .= "\n       AND A.member_seqno = B.member_seqno";
        $query .= "\n       AND B.member_seqno = C.member_seqno";
        $query .= "\n       AND B.dlvr_friend_yn = 'Y'";
        $query .= "\n       AND B.dlvr_friend_main = 'Y'";
        $query .= "\n       AND C.dlvr_dvs = '2'";

        //회원 일련번호
        if ($this->blankParameterCheck($param, "member_seqno")) {

            $query .= "\n       AND A.member_seqno =" . $param["member_seqno"];
        }

        $result = $conn->Execute($query);

        return $result;
    }
 

 
}
 ?>
