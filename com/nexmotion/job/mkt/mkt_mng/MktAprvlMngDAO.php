<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/MktCommonDAO.php');
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/html/mkt/mkt_mng/MktAprvlMngHTML.php");

class MktAprvlMngDAO extends MktCommonDAO {

    function __construct() {
    }

    /*
     * 회원 list select 
     * $conn : db connection
     * $param["cpn_seqno"] : 회사 관리 일련번호
     * $param["search"] : 검색어
     * return : resultset 
     */ 
    function selectOfficeNickList($conn, $param) {

        if (!$this->connectioncheck($conn)) return false; 
        $param = $this->parameterarrayescape($conn, $param);
        $query  = "\n    SELECT   office_nick";
        $query .= "\n            ,member_seqno";
        $query .= "\n      FROM   member";
        $query .= "\n     WHERE   cpn_admin_seqno =" . $param["cpn_seqno"];

        //회원명 검색 있을때
        if ($this->blankParameterCheck($param ,"search")) {

            $search_str = substr($param["search"], 1, -1); 
            $query .= "\n       AND  office_nick like '%";
            $query .= $search_str . "%' ";
        }

        $result = $conn->Execute($query);

        return $result;
    }

    /*
     * 등급 승인 list Select 
     * $conn : DB Connection
     * $param : $param["cpn_seqno"] = "판매채널 일련번호"
     * $param : $param["office_nick"] = "사내 닉네임"
     * $param : $param["date_from"] = "시작일자"
     * $param : $param["date_to"] = "종료일자"
     * $param : $param["date_dvs"] = "일자별 검색 조건 구분"
     * $param : $param["aprvl_type"] = "승인 종류"
     * return : resultSet 
     */ 
    function selectGradeAprvlList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);
        $query  = "\n    SELECT  A.exist_grade";
        $query .= "\n           ,A.new_grade";
        $query .= "\n           ,A.req_empl_name";
        $query .= "\n           ,A.reason";
        $query .= "\n           ,A.state";
        $query .= "\n           ,A.regi_date";
        $query .= "\n           ,A.member_seqno";
        $query .= "\n           ,A.grade_req_seqno";
        $query .= "\n           ,B.office_nick";
        $query .= "\n      FROM  grade_req A";
        $query .= "\n           ,member B";
        $query .= "\n     WHERE  A.member_seqno = B.member_seqno";

        //판매채널 일련번호
        if ($this->blankParameterCheck($param ,"cpn_seqno")) {

            $query .= "\n        AND B.cpn_admin_seqno =" . $param["cpn_seqno"];
        }

        //회원 일련번호
        if ($this->blankParameterCheck($param ,"member_seqno")) {

            $query .= "\n        AND B.member_seqno =" . $param["member_seqno"];
        }
        
        //신청 일자별 검색 일때
        $date_dvs = substr($param["date_dvs"], 1, -1); 
        if ($date_dvs == "regi") {

            //신청 일자 시작
            if ($this->blankParameterCheck($param ,"date_from")) {

                $query .= "\n        AND A.regi_date >=" . $param["date_from"];
            }
        
            //신청 일자 종료
            if ($this->blankParameterCheck($param ,"date_to")) {

                $query .= "\n        AND A.regi_date <=" . $param["date_to"];
            }

        }
        
        //승인 종류
        if ($this->blankParameterCheck($param ,"aprvl_type")) {

            $query .= "\n        AND A.state =" . $param["aprvl_type"];
        }

        $query .= "\n  ORDER BY  A.grade_req_seqno";

        //limit 조건
        if ($this->blankParameterCheck($param ,"start") && $this->blankParameterCheck($param ,"end")) {
 
            $param["start"] = substr($param["start"], 1, -1);
            $param["end"] = substr($param["end"], 1, -1); 

            $query .= "\n LIMIT " . $param["start"] . ",";
            $query .= $param["end"]; 
        }
    
        $result = $conn->Execute($query);

        return $result;

    }

    /*
     * 등급 승인 list Count
     * $conn : DB Connection
     * $param : $param["cpn_seqno"] = "판매채널 일련번호"
     * $param : $param["office_nick"] = "사내 닉네임"
     * $param : $param["date_from"] = "시작일자"
     * $param : $param["date_to"] = "종료일자"
     * $param : $param["date_dvs"] = "일자별 검색 조건 구분"
     * $param : $param["aprvl_type"] = "승인 종류"
     * return : resultSet
     */ 
    function countGradeAprvlList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);
        $query  = "\n    SELECT  count(*) cnt";
        $query .= "\n      FROM  grade_req A";
        $query .= "\n           ,member B";
        $query .= "\n     WHERE  A.member_seqno = B.member_seqno";

        //판매채널 일련번호
        if ($this->blankParameterCheck($param ,"cpn_seqno")) {

            $query .= "\n        AND B.cpn_admin_seqno =" . $param["cpn_seqno"];
        }

        //회원 일련번호
        if ($this->blankParameterCheck($param ,"member_seqno")) {

            $query .= "\n        AND B.member_seqno =" . $param["member_seqno"];
        }
       
        //신청 일자별 검색 일때
        $date_dvs = substr($param["date_dvs"], 1, -1); 
        if ($date_dvs == "regi") {

            //신청 일자 시작
            if ($this->blankParameterCheck($param ,"date_from")) {

                $query .= "\n        AND A.regi_date =" . $param["date_from"];
            }
        
            //신청 일자 종료
            if ($this->blankParameterCheck($param ,"date_to")) {

                $query .= "\n        AND A.regi_date =" . $param["date_to"];
            }

        }
        
        //승인 종류
        if ($this->blankParameterCheck($param ,"aprvl_type")) {

            $query .= "\n        AND A.state =" . $param["aprvl_type"];
        }

        $result = $conn->Execute($query);

        return $result;

    }

    /*
     * 회원 등급 update
     * $conn : db connection
     * $param["new_grade"] : 새로운 등급
     * $param["member_seqno"] : 회원 일련번호
     */ 
    function updateMemberGrade($conn, $param) {

        if (!$this->connectioncheck($conn)) return false; 
        $param = $this->parameterarrayescape($conn, $param);

        $query  = "\n    UPDATE   member";
        $query .= "\n       SET   grade = " . $param["new_grade"];
        $query .= "\n     WHERE   member_seqno =" . $param["member_seqno"];

        $result = $conn->Execute($query);

        return $result;
    }

    /*
     * 포인트 승인 list Select 
     * $conn : DB Connection
     * $param : $param["cpn_seqno"] = "판매채널 일련번호"
     * $param : $param["office_nick"] = "사내 닉네임"
     * $param : $param["date_from"] = "시작일자"
     * $param : $param["date_to"] = "종료일자"
     * $param : $param["date_dvs"] = "일자별 검색 조건 구분"
     * $param : $param["aprvl_type"] = "승인 종류"
     * return : resultSet 
     */ 
    function selectPointAprvlList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);
        $query  = "\n    SELECT  A.point_name";
        $query .= "\n           ,A.point";
        $query .= "\n           ,A.req_empl_name";
        $query .= "\n           ,A.reason";
        $query .= "\n           ,A.state";
        $query .= "\n           ,A.regi_date";
        $query .= "\n           ,A.member_seqno";
        $query .= "\n           ,A.member_point_req_seqno";
        $query .= "\n           ,B.office_nick";
        $query .= "\n      FROM  member_point_req A";
        $query .= "\n           ,member B";
        $query .= "\n     WHERE  A.member_seqno = B.member_seqno";

        //판매채널 일련번호
        if ($this->blankParameterCheck($param ,"cpn_seqno")) {

            $query .= "\n        AND B.cpn_admin_seqno =" . $param["cpn_seqno"];
        }

        //사내 닉네임
        if ($this->blankParameterCheck($param ,"office_nick")) {

            $query .= "\n        AND B.office_nick =" . $param["office_nick"];
        }
        
        //신청 일자별 검색 일때
        $date_dvs = substr($param["date_dvs"], 1, -1); 
        if ($date_dvs == "regi") {

            //신청 일자 시작
            if ($this->blankParameterCheck($param ,"date_from")) {

                $query .= "\n        AND A.regi_date >=" . $param["date_from"];
            }
        
            //신청 일자 종료
            if ($this->blankParameterCheck($param ,"date_to")) {

                $query .= "\n        AND A.regi_date <=" . $param["date_to"];
            }

        }
        
        //승인 종류
        if ($this->blankParameterCheck($param ,"aprvl_type")) {

            $query .= "\n        AND A.state =" . $param["aprvl_type"];
        }

        $query .= "\n  ORDER BY  A.member_point_req_seqno";

        //limit 조건
        if ($this->blankParameterCheck($param ,"start") && $this->blankParameterCheck($param ,"end")) {
 
            $param["start"] = substr($param["start"], 1, -1);
            $param["end"] = substr($param["end"], 1, -1); 

            $query .= "\n LIMIT " . $param["start"] . ",";
            $query .= $param["end"]; 
        }
    
        $result = $conn->Execute($query);

        return $result;

    }

    /*
     * 포인트 승인 list Count
     * $conn : DB Connection
     * $param : $param["cpn_seqno"] = "판매채널 일련번호"
     * $param : $param["office_nick"] = "사내 닉네임"
     * $param : $param["date_from"] = "시작일자"
     * $param : $param["date_to"] = "종료일자"
     * $param : $param["date_dvs"] = "일자별 검색 조건 구분"
     * $param : $param["aprvl_type"] = "승인 종류"
     * return : resultSet
     */ 
    function countPointAprvlList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);
        $query  = "\n    SELECT  count(*) cnt";
        $query .= "\n      FROM  member_point_req A";
        $query .= "\n           ,member B";
        $query .= "\n     WHERE  A.member_seqno = B.member_seqno";

        //판매채널 일련번호
        if ($this->blankParameterCheck($param ,"cpn_seqno")) {

            $query .= "\n        AND B.cpn_admin_seqno =" . $param["cpn_seqno"];
        }

        //사내 닉네임
        if ($this->blankParameterCheck($param ,"office_nick")) {

            $query .= "\n        AND B.office_nick =" . $param["office_nick"];
        }
        
        //신청 일자별 검색 일때
        $date_dvs = substr($param["date_dvs"], 1, -1); 
        if ($date_dvs == "regi") {

            //신청 일자 시작
            if ($this->blankParameterCheck($param ,"date_from")) {

                $query .= "\n        AND A.regi_date >=" . $param["date_from"];
            }
        
            //신청 일자 종료
            if ($this->blankParameterCheck($param ,"date_to")) {

                $query .= "\n        AND A.regi_date <=" . $param["date_to"];
            }

        }
        
        //승인 종류
        if ($this->blankParameterCheck($param ,"aprvl_type")) {

            $query .= "\n        AND A.state =" . $param["aprvl_type"];
        }

        $result = $conn->Execute($query);

        return $result;

    }

    /*
     * 회원 보유포인트 Select 
     * $conn : DB Connection
     * $param : $param["member_seqno"] = "회원 일련번호"
     * return : resultSet 
     */ 
    function selectMemberPoint($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);
        $query  = "\n    SELECT  own_point";
        $query .= "\n      FROM  member";
        $query .= "\n     WHERE  member_seqno = " . $param["member_seqno"];

        $result = $conn->Execute($query);

        return $result;
    }


    /*
     * 회원 보유 포인트 update
     * $conn : db connection
     * $param["own_point"] : 보유 포인트
     * $param["member_seqno"] : 회원 일련번호
     */ 
    function updateMemberPoint($conn, $param) {

        if (!$this->connectioncheck($conn)) return false; 
        $param = $this->parameterarrayescape($conn, $param);

        $query  = "\n    UPDATE  member";
        $query .= "\n       SET  own_point = " . $param["point"];
        $query .= "\n     WHERE  member_seqno =" . $param["member_seqno"];

        $result = $conn->Execute($query);

        return $result;
    }
}

?>

