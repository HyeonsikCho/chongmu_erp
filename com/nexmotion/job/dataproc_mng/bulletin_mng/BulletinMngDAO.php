<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/CommonDAO.php');
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/html/dataproc_mng/bulletin_mng/BulletinMngHTML.php");

class BulletinMngDAO extends CommonDAO {

    /**
     * @brief 생성자
     *
     */
    function __construct() {
    }

    /*
     * 팝업 관리 list Select
     * $conn : DB Connection
     * return : resultSet
     */
    function selectPopupList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false;
        $param = $this->parameterArrayEscape($conn, $param);
        $query  = "\n    SELECT  post_start_date";
        $query .= "\n           ,post_end_date";
        $query .= "\n           ,name";
        $query .= "\n           ,use_yn";
        $query .= "\n           ,file_path";
        $query .= "\n           ,wid_size";
        $query .= "\n           ,vert_size";
        $query .= "\n           ,save_file_name";
        $query .= "\n           ,origin_file_name";
        $query .= "\n           ,start_hour";
        $query .= "\n           ,end_hour";
        $query .= "\n           ,url_addr";
        $query .= "\n           ,target_yn";
        $query .= "\n           ,popup_admin_seqno";
        $query .= "\n      FROM  popup_admin";


        //팝업 관리 일련번호가 있을때
        if ($this->blankParameterCheck($param, "popup_seqno")) {

            $query .= "\n     WHERE popup_admin_seqno = " . $param["popup_seqno"];

        }

        $result = $conn->Execute($query);

        return $result;
    }

    /*
     * 공지 관리 list Select
     * $conn : DB Connection
     * return : resultSet
     */
    function selectNoticeList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false;
        $param = $this->parameterArrayEscape($conn, $param);
        $query  = "\n    SELECT  A.title";
        $query .= "\n           ,A.dvs";
        $query .= "\n           ,A.regi_date";
        $query .= "\n           ,A.hits";
        $query .= "\n           ,A.seq_no";
        $query .= "\n           ,B.name";
        $query .= "\n      FROM  board_notice A";
        $query .= "\n           ,empl B";
        $query .= "\n     WHERE  A.usr_id = B.empl_id";

        //팝업 관리 일련번호가 있을때
        if ($this->blankParameterCheck($param, "notice_seqno")) {

            $query .= "\n       AND seq_no = " . $param["notice_seqno"];

        }

        $query .= "\n  ORDER BY  A.seq_no DESC";

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
     * 공지 관리 list Count
     * $conn : DB Connection
     * return : resultSet
     */
    function countNoticeList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false;
        $param = $this->parameterArrayEscape($conn, $param);
        $query  = "\n    SELECT  count(*) as cnt";
        $query .= "\n      FROM  board_notice A";
        $query .= "\n           ,empl B";
        $query .= "\n     WHERE  A.empl_seqno = B.empl_seqno";

        //팝업 관리 일련번호가 있을때
        if ($this->blankParameterCheck($param, "notice_seqno")) {

            $query .= "\n       AND seq_no = " . $param["notice_seqno"];

        }

        $result = $conn->Execute($query);

        return $result;
    }


}
?>
