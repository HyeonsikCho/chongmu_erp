<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/CommonDAO.php');

class FileDAO extends CommonDAO {
    function __construct() {
    }

    function setOrderImg($conn,$param){

        $param = $this->parameterArrayEscape($conn, $param);
        $sql = "insert into order_img (order_no,prd_detail_no,type,file_path,save_file_name,origin_file_name,regdate)
									values (".$param['order_no'].",
											".$param['prd_detail_no'].",
											".$param['type'].",
											".$param['file_path'].",
											".$param['save_file_name'].",
											".$param['origin_file_name'].",
											now()
											)
									ON DUPLICATE KEY UPDATE file_path=".$param['file_path'].",
															save_file_name=".$param['save_file_name'].",
															origin_file_name=".$param['origin_file_name'].",
															regdate=now()";

        if(!$conn->Execute($sql)){
            return false;
        }

        $getSeqSql = "select last_insert_id() as seq";
        if(!$idx = $conn->Execute($getSeqSql)){
            return false;
        }else{
            $seq = $idx->fields["seq"];
        }
        return $seq;
    }

    function updateOrderImg($conn,$param) {
        $param = $this->parameterArrayEscape($conn, $param);

        $sql = "UPDATE order_img SET save_file_name = %s, file_path = %s WHERE prd_detail_no = %s";
        $sql = sprintf($sql,
                    $param['save_file_name'],
                    $param['file_path'],
                    $param['prd_detail_no']
        );

        return $conn->Execute($sql);
    }

    function selectOrderImgPath($conn,$param) {
        $param = $this->parameterArrayEscape($conn, $param);

        $sql = "SELECT file_path, save_file_name FROM order_img WHERE prd_detail_no = %s";
        $sql = sprintf($sql,
            $param['prd_detail_no']
        );

        return $conn->Execute($sql);
    }

    function deleteOrderImage($conn, $param) {

        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\nDELETE ";
        $query .= "\n   FROM  order_img ";
        $query .= "\n WHERE  order_img_seq = %s ";

        $query = sprintf($query, $param["seqno"]);

        $resultSet = $conn->Execute($query);

        if ($resultSet === FALSE) {
            return false;
        } else {
            return true;
        }
    }
}
?>
