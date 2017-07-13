<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/BasicMngCommonDAO.php');
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/html/basic_mng/pur_etprs_mng/AddrListHTML.php");

class PurEtprsRegiDAO extends BasicMngCommonDAO {

    function __construct() {
    }

    /*
     * 지번 주소 Select 
     * $conn : DB Connection
     * $param["val"] : 주소 검색어
     * return : resultSet 
     */ 
    function selectJibunZip($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);
        $area = substr($param["area"], 1, -1); 
        $val = substr($param["val"], 1, -1); 

        $query  = "\n    SELECT  zipcode";
        $query .= "\n           ,sido";
        $query .= "\n           ,gugun";
        $query .= "\n           ,eup";
        $query .= "\n           ,dong";
        $query .= "\n           ,bldg";
        $query .= "\n           ,jibun_bonbun";
        $query .= "\n           ,jibun_bubun";
        $query .= "\n           ,bldg";
        $query .= "\n           ,ri";
        $query .= "\n      FROM  " . $area . "_zipcode";
        $query .= "\n     WHERE  (dong LIKE '%" . $val . "%'";
        $query .= "\n        OR   eup LIKE '%" . $val . "%'";
        $query .= "\n        OR   ri LIKE '%" . $val . "%')";

        $result = $conn->Execute($query);

        return $result;
    }

    /*
     * 도로명 주소 Select 
     * $conn : DB Connection
     * $param["val"] : 도로명 검색어
     * return : resultSet 
     */ 
    function selectDoroZip($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);
        $area = substr($param["area"], 1, -1); 
        $val = substr($param["val"], 1, -1); 

        $query  = "\n    SELECT  zipcode";
        $query .= "\n           ,sido";
        $query .= "\n           ,gugun";
        $query .= "\n           ,doro";
        $query .= "\n           ,bldg";
        $query .= "\n           ,bldg_bonbun";
        $query .= "\n           ,bldg_bubun";
        $query .= "\n      FROM  " . $area . "_zipcode";
        $query .= "\n     WHERE  doro LIKE '%" . $val .  "%'";

        $result = $conn->Execute($query);

        return $result;
    }
}
?>
