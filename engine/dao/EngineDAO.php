<?
include_once(dirname(__FILE__) . '/CommonDAO.php');

class EngineDAO extends CommonDAO {
    function __construct() {
    }

    /**
     * 큐에 대기중인 작업 목록 중 가장 오래된 한 개를 가져온다.
     */
    function selectStayWork($conn) {
        if (!$this->connectionCheck($conn)) return false;

        $temp = array();

        $temp["col"]  = " engine_que_seqno";
        $temp["col"] .= ",dvs";
        $temp["col"] .= ",param";

        $temp["table"] = "engine_que";

        $temp["where"]["state"] = "stay";

        $temp["order"] = "engine_que_seqno";

        $temp["limit"]["start"] = "0";
        $temp["limit"]["end"] = "1";

        return $this->selectData($conn, $temp);
    }

    /**
     * 해당 파라미터에 해당하는 작업이 이미 존재하는지 확인
     */
    function selectWork($conn, $param) {
        if (!$this->connectionCheck($conn)) return false;

        $temp = array();
        $temp["col"] = "1";

        $temp["table"] = "engine_que";

        $temp["where"]["dvs"]   = $param["dvs"];
        $temp["where"]["param"] = $param["param"];
        $temp["where"]["state"] = "STAY";

        return $this->selectData($conn, $temp);
    }

    /**
     * 엔진 큐에 작업 추가
     */
    function insertWork($conn, $param) {
        if (!$this->connectionCheck($conn)) return false;

        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n INSERT INTO engine_que( dvs";
        $query .= "\n                        ,param";
        $query .= "\n                        ,state";
        $query .= "\n                        ,startday";
        $query .= "\n ) VALUES ( %s";
        $query .= "\n           ,%s";
        $query .= "\n           ,%s";
        $query .= "\n           ,now()";
        $query .= "\n )";
        $query  = sprintf($query, $param["dvs"]
                                , $param["param"]
                                , $param["state"]);

        $conn->StartTrans();

        $ret = $conn->Execute($query);

        $conn->CompleteTrans();

        if (!$ret) {
            return "데이터 입력에 실패 하였습니다.";
        } else {
            return TRUE;
        }
    }

    /**
     * 해당 작업 상태 업데이트
     */
    function updateState($conn, $seqno, $state) {
        if (!$this->connectionCheck($conn)) return false;

        $temp = array();
        $temp["table"] = "engine_que";
        $temp["col"]["state"] = $state;
        $temp["prk"] = "engine_que_seqno";
        $temp["prkVal"] = $seqno;

        $conn->StartTrans();

        $ret = $this->updateData($conn, $temp);

        $conn->CompleteTrans();

        if (!$ret) {
            return "데이터 입력에 실패 하였습니다.";
        } else {
            return TRUE;
        }
    }

    /**
     * @brief 회원 포인트 조회
     *
     * @detail
     *
     * @param $conn  = 디비 커넥션
     * @param $param = 검색조건 파라미터
     *
     * @return
     */

    function selectMemberPoint($conn, $param) {

        if (!$conn) {
            echo "master connection failed\n";
            return false;
        }

        $query  = "\n  SELECT  A.regi_date";
        $query .= "\n         ,A.point";
        $query .= "\n         ,A.dvs";
        $query .= "\n         ,A.member_grade";
        $query .= "\n         ,B.cpn_admin_seqno";
        $query .= "\n    FROM  member_point_history A";
        $query .= "\n         ,member B";
        $query .= "\n   WHERE  A.member_seqno = B.member_seqno";
        $query .= "\n     AND  A.dvs = '" . $param["dvs"] . "'";

        //Query Cache
        if ($param["cache"] == 1) {
            $rs = $conn->CacheExecute(1800, $query);
        } else {
            $rs = $conn->Execute($query);
        }

        return $rs;

    }

    /**
     * @brief 회원 포인트 내역 조회
     *
     * @detail
     *
     * @param $conn  = 디비 커넥션
     * @param $param = 검색조건 파라미터
     *
     * @return
     */

    function selectPointHistory($conn, $param) {

        if (!$conn) {
            echo "master connection failed\n";
            return false;
        }

        $query  = "\n  SELECT  A.regi_date";
        $query .= "\n         ,A.point_name";
        $query .= "\n         ,A.point";
        $query .= "\n         ,A.dvs";
        $query .= "\n         ,B.cpn_admin_seqno";
        $query .= "\n    FROM  member_point_history A";
        $query .= "\n         ,member B";
        $query .= "\n   WHERE  A.member_seqno = B.member_seqno";

        //Query Cache
        if ($param["cache"] == 1) {
            $rs = $conn->CacheExecute(1800, $query);
        } else {
            $rs = $conn->Execute($query);
        }

        return $rs;

    }

    /**
     * @brief 쿠폰 조회
     *
     * @detail
     *
     * @param $conn  = 디비 커넥션
     *
     * @return

    function selectCp($conn) {

        if (!$conn) {
            echo "master connection failed\n";
            return false;
        }

        $query  = "\nSELECT cp_name";
        $query .= "\n      ,cate_sortcode";
        $query .= "\n      ,cp_seqno";
        $query .= "\n      ,val";
        $query .= "\n      ,unit";
        $query .= "\n      ,cpn_admin_seqno";
        $query .= "\n  FROM cp";
        $query .= "\n WHERE use_yn = 'Y'";

        //Query Cache
        if ($param["cache"] == 1) {
            $rs = $conn->CacheExecute(1800, $query);
        } else {
            $rs = $conn->Execute($query);
        }

        return $rs;
    }

    /**
     * @brief 회원 쿠폰 발행건수
     *
     * @detail
     *
     * @param $conn  = 디비 커넥션
     * @param $param = 검색조건 파라미터
     *
     * @return

    function selectCpIssueCount($conn, $param) {

        if (!$conn) {
            echo "master connection failed\n";
            return false;
        }

        //Query Cache
        if ($param["cache"] == 1) {
            $rs = $conn->CacheExecute(1800, $query);
        } else {
            $rs = $conn->Execute($query);
        }

        return $rs;
    }

    /**
     * @brief 회원 쿠폰 사용건수
     *
     * @detail
     *
     * @param $conn  = 디비 커넥션
     * @param $param = 검색조건 파라미터
     *
     * @return

    function selectCpUseCount($conn, $param) {

        if (!$conn) {
            echo "master connection failed\n";
            return false;
        }

        //Query Cache
        if ($param["cache"] == 1) {
            $rs = $conn->CacheExecute(1800, $query);
        } else {
            $rs = $conn->Execute($query);
        }

        return $rs;
    }
     */

    /*
     * Data Delete (delete only one)
     * $conn : DB Connection
     * $param["prk"] = "primary key colulm"
     * $param["prkVal"] = "primary data"
     *
     * return : boolean
     */
    function deleteGradePointStats($conn, $param) {

        if (!$conn) {
            echo "master connection failed\n";
            return false;
        }

        $query  = "\n DELETE ";
        $query .= "\n   FROM   mon_member_grade_point_stats";
        $query .= "\n  WHERE   year = '" . $param["year"] . "'";
        $query .= "\n    AND   mon = '" . $param["mon"] . "'";
        $query .= "\n    AND   dvs = '" . $param["dvs"] . "'";

        return $conn->Execute($query);
    }

    /*
     * Data Delete (delete only one)
     * $conn : DB Connection
     * $param["prk"] = "primary key colulm"
     * $param["prkVal"] = "primary data"
     *
     * return : boolean
     */
    function deletePointStats($conn, $param) {

        if (!$conn) {
            echo "master connection failed\n";
            return false;
        }

        $query  = "\n DELETE ";
        $query .= "\n   FROM   mon_point_stats";
        $query .= "\n  WHERE   year = '" . $param["year"] . "'";
        $query .= "\n    AND   mon = '" . $param["mon"] . "'";

        return $conn->Execute($query);
    }
}
?>
