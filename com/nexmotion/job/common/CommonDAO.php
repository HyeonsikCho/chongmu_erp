<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/html/common/MakeCommonHtml.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/doc/common/OrderInfoPopDOC.php');

/*! 공통 DAO Class */
class CommonDAO {

    var $errorMessage = "";

    function __construct() {
    }

    /**
     * @brief 다중 데이터 수정 쿼리 함수 (공통) <br>
     *        param 배열 설명 <br>
     *        $param : <br>
     *        $param["table"] = "테이블명"<br>
     *        $param["col"]["컬럼명"] = "수정데이터" (다중)<br>
     *        $param["prk"] = "primary key colulm"<br>
     *        $param["prkVal"] = "primary data"  ex) 1,2,3,4
     * @param $conn DB Connection
     * @param $param 파라미터 인자 배열
     * @return boolean
     */
    function updateMultiData($conn, $param) {

        if (!$conn) {
            echo "master connection failed\n";
            return false;
        }

        //주문배송, 회원, 주문 공통, 가상계좌, 견적
        if ($param["table"] == "member" || $param["table"] == "order_common" ||
            $param["table"] == "order_dlvr" || $param["table"] == "virt_ba_admin" ||
            $param["table"] == "esti") {
            echo "접근이 허용되지 않는 테이블 입니다.";
            return false;
        }

        $prkArr = str_replace(" ", "", $param["prkVal"]);
        $prkArr = str_replace("'", "", $prkArr);
        $prkArr = explode(",", $prkArr);

        $parkVal = "";

        for ($i = 0; $i < count($prkArr); $i++) {
            $prkVal .= $conn->qstr($prkArr[$i], get_magic_quotes_gpc()) . ",";
        }
        $prkVal = substr($prkVal, 0, -1);

        $query = "\n UPDATE " . $param["table"]  . " set";

        $i = 0;
        $col = "";
        $value = "";

        foreach ($param["col"] as $key => $val) {

            $inchr = $conn->qstr($val,get_magic_quotes_gpc());

            if ($i == 0) {
                $value  .= "\n " . $key . "=" . $inchr;
            } else {
                $value  .= "\n ," . $key . "=" . $inchr;
            }

            $i++;
        }

        $query .= $value;
        $query .= " WHERE " . $param["prk"] . " in(";
        $query .= $prkVal . ")";

        $resultSet = $conn->Execute($query);

        if ($resultSet === FALSE) {
            $errorMessage = "데이터 수정에 실패 하였습니다.";
            return false;
        } else {
            return true;
        }

    }

    /**
     * @brief 데이터 수정 쿼리 함수 (공통)<br>
     *        param 배열 설명<br>
     *        $param : $param["table"] = "테이블명"<br>
     *        $param["col"]["컬럼명"] = "수정데이터" (다중)<br>
     *        $param["prk"] = "primary key colulm"<br>
     *        $param["prkVal"] = "primary data" <br>
     * @param $conn DB Connection
     * @param $param 파라미터 인자 배열
     * @return boolean
     */
    function updateData($conn, $param) {

        if (!$conn) {
            echo "master connection failed\n";
            return false;
        }

        //주문배송, 회원, 주문 공통, 가상계좌, 견적
        if ($param["table"] == "member" || $param["table"] == "order_common" ||
            $param["table"] == "order_dlvr" || $param["table"] == "virt_ba_admin" ||
            $param["table"] == "esti") {
            echo "접근이 허용되지 않는 테이블 입니다.";
            return false;
        }

        $query = "\n UPDATE " . $param["table"]  . " set";

        $i = 0;
        $col = "";
        $value = "";

        foreach ($param["col"] as $key => $val) {

         //   $inchr = $val;
            $inchr = $conn->qstr($val,get_magic_quotes_gpc());

            if ($i == 0) {
                $value  .= "\n " . $key . "=" . $inchr;
            } else {
                $value  .= "\n ," . $key . "=" . $inchr;
            }

            $i++;
        }

        $query .= $value;
        $query .= " WHERE " . $param["prk"] . "=" . $conn->qstr($param["prkVal"], get_magic_quotes_gpc());

        $resultSet = $conn->Execute($query);

        if ($resultSet === FALSE) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @brief 데이터 삽입 쿼리 함수 (공통)<br>
     *        param 배열 설명<br>
     *        $param : $param["table"] = "테이블명"<br>
     *        $param["col"]["컬럼명"] = "데이터" (다중)<br>
     * @param $conn DB Connection
     * @param $param 파라미터 인자 배열
     * @return boolean
     */
    function insertData($conn, $param) {

        if (!$conn) {
            echo "master connection failed\n";
            return false;
        }

        //주문배송, 회원, 주문 공통, 가상계좌, 견적
        if ($param["table"] == "member" || $param["table"] == "order_common" ||
            $param["table"] == "order_dlvr" || $param["table"] == "virt_ba_admin" ||
            $param["table"] == "esti") {
            echo "접근이 허용되지 않는 테이블 입니다.";
            return false;
        }

        $query = "\n INSERT INTO " . $param["table"] . "(";

        $i = 0;
        $col = "";
        $value = "";

        foreach ($param["col"] as $key => $val) {

            $inchr = $conn->qstr($val,get_magic_quotes_gpc());

            if ($i == 0) {
                $col  .= "\n " . $key;
                $value  .= "\n " . $inchr;
            } else {
                $col  .= "\n ," . $key;
                $value  .= "\n ," . $inchr;
            }

            $i++;
        }

        $query .= $col;
        $query .= "\n ) VALUES (";
        $query .= $value;
        $query .= "\n )";

        $resultSet = $conn->Execute($query);

        if ($resultSet === FALSE) {
            $errorMessage = "데이터 입력에 실패 하였습니다.";
            return false;
        } else {
            return true;
        }
    }

    /**
     * @brief 데이터 삽입/수정 쿼리 함수 (공통)<br>
     *        param 배열 설명<br>
     *        $param : $param["table"] = "테이블명"<br>
     *        $param["col"]["컬럼명"] = "데이터" (다중)<br>
     * @param $conn DB Connection
     * @param $param 파라미터 인자 배열
     * @return boolean
     */
    function replaceData($conn, $param) {

        if (!$conn) {
            echo "master connection failed\n";
            return false;
        }

        //주문배송, 회원, 주문 공통, 가상계좌, 견적
        if ($param["table"] == "member" || $param["table"] == "order_common" ||
            $param["table"] == "order_dlvr" || $param["table"] == "virt_ba_admin" ||
            $param["table"] == "esti") {
            echo "접근이 허용되지 않는 테이블 입니다.";
            return false;
        }

        $query = "\n INSERT INTO " . $param["table"] . "(";

        $i = 0;
        $col = "";
        $value = "";

        foreach ($param["col"] as $key => $val) {

            $inchr = $conn->qstr($val,get_magic_quotes_gpc());
            if ($i == 0) {
                $col  .= "\n " . $key;
                $value  .= "\n " . $inchr;
            } else {
                $col  .= "\n ," . $key;
                $value  .= "\n ," . $inchr;
            }

            $i++;
        }

        $query .= $col;
        $query .= "\n ) VALUES (";
        $query .= $value;
        $query .= "\n )";
        $query .= "\n ON DUPLICATE KEY UPDATE";

        $i = 0;
        $col = "";
        $value = "";

        reset($param["col"]);

        foreach ($param["col"] as $key => $val) {

            $inchr = $conn->qstr($val,get_magic_quotes_gpc());

            if ($i == 0) {
                $value  .= "\n " . $key . "=" . $inchr;
            } else {
                $value  .= "\n ," . $key . "=" . $inchr;
            }

            $i++;
        }
        $query .= $value;

        $resultSet = $conn->Execute($query);

        if ($resultSet === FALSE) {
            $errorMessage = "데이터 입력에 실패 하였습니다.";
            return false;
        } else {
            return true;
        }
    }

    /**
     * @brief 다중 데이터 삭제 쿼리 함수 (공통)<br>
     *        param 배열 설명<br>
     *        $param : $param["table"] = "테이블명"<br>
     *        $param["prk"] = "primary key colulm" <br>
     *        $param["prkVal"] = "primary data"  ex) 1,2,3,4 <br>
     *        $param["not"] = "제외 검색"  ex) Y<br>
     * @param $conn DB Connection
     * @param $param 파라미터 인자 배열
     * @return boolean
     */
    function deleteMultiData($conn, $param) {

        if (!$conn) {
            echo "master connection failed\n";
            return false;
        }

        //주문배송, 회원, 주문 공통, 가상계좌, 견적
        if ($param["table"] == "member" || $param["table"] == "order_common" ||
            $param["table"] == "order_dlvr" || $param["table"] == "virt_ba_admin" ||
            $param["table"] == "esti") {
            echo "접근이 허용되지 않는 테이블 입니다.";
            return false;
        }

        $query  = "\n DELETE ";
        $query .= "\n   FROM " . $param["table"];
        $query .= "\n  WHERE " . $param["prk"];
        $query .= "\n     IN (";

        $prkValCount = count($param["prkVal"]);
        for ($i = 0; $i < $prkValCount; $i++) {
            $val = $conn->qstr($param["prkVal"][$i], get_magic_quotes_gpc());
            $query .= $val;

            if ($i !== $prkValCount - 1) {
                $query .= ",";
            }
        }
        $query .= ")";

        $resultSet = $conn->Execute($query);

        if ($resultSet === FALSE) {
            $errorMessage = "데이터 삭제에 실패 하였습니다.";
            return false;
        } else {
            return true;
        }
    }

    /**
     * @brief 데이터 삭제 쿼리 함수 (공통)<br>
     *        param 배열 설명<br>
     *        $param : $param["table"] = "테이블명"<br>
     *        $param["prk"] = "primary key column"<br>
     *        $param["prkVal"] = "primary data" <br>
     * @param $conn DB Connection
     * @param $param 파라미터 인자 배열
     * @return boolean
     */
    function deleteData($conn, $param) {

        if (!$conn) {
            echo "master connection failed\n";
            return false;
        }

        //주문배송, 회원, 주문 공통, 가상계좌, 견적
        if ($param["table"] == "member" || $param["table"] == "order_common" ||
            $param["table"] == "order_dlvr" || $param["table"] == "virt_ba_admin" ||
            $param["table"] == "esti") {
            echo "접근이 허용되지 않는 테이블 입니다.";
            return false;
        }

        $query  = "\n DELETE ";
        $query .= "\n   FROM " . $param["table"];
        $query .= "\n  WHERE " . $param["prk"];
        $query .= "\n       =" . $conn->qstr($param["prkVal"], get_magic_quotes_gpc());

        $resultSet = $conn->Execute($query);

        if ($resultSet === FALSE) {
            $errorMessage = "데이터 삭제에 실패 하였습니다.";
            return false;
        } else {
            return true;
        }
    }

    /**
     * @brief 전체 데이터 삭제 쿼리 함수 (공통)<br>
     *        param 배열 설명<br>
     *        $param : $param["table"] = "테이블명"<br>
     *        $param["prk"] = "primary key colulm"<br>
     * @param $conn DB Connection
     * @param $param 파라미터 인자 배열
     * @return boolean
     */
    function deleteAllData($conn, $param) {

        if (!$conn) {
            echo "master connection failed\n";
            return false;
        }

        //주문배송, 회원, 주문 공통, 가상계좌, 견적
        if ($param["table"] == "member" || $param["table"] == "order_common" ||
            $param["table"] == "order_dlvr" || $param["table"] == "virt_ba_admin" ||
            $param["table"] == "esti") {
            echo "접근이 허용되지 않는 테이블 입니다.";
            return false;
        }

        $query  = "\n DELETE ";
        $query .= "\n   FROM " . $param["table"];
        $query .= "\n  WHERE " . $param["prk"] . " >= 0";

        $resultSet = $conn->Execute($query);

        if ($resultSet === FALSE) {
            $errorMessage = "데이터 삭제에 실패 하였습니다.";
            return false;
        } else {
            return true;
        }
    }

    /**
     * @brief DISTINCT 데이터 검색 쿼리 함수 (공통)<br>
     *        param 배열 설명<br>
     *        $param : $param["table"] = "테이블명"<br>
     *        $param["col"] = "컬럼명"<br>
     *        $param["where"]["컬럼명"] = "조건" (다중)<br>
     * @param $conn DB Connection
     * @param $param 파라미터 인자 배열
     * @return boolean
     */
    function distinctData($conn, $param) {

        if (!$conn) {
            echo "master connection failed\n";
            return false;
        }

        //주문배송, 회원, 주문 공통, 가상계좌, 견적
        if ($param["table"] == "member" || $param["table"] == "order_common" ||
            $param["table"] == "order_dlvr" || $param["table"] == "virt_ba_admin" ||
            $param["table"] == "esti") {
            echo "접근이 허용되지 않는 테이블 입니다.";
            return false;
        }

        $query = "\n SELECT DISTINCT " . $param["col"] . " FROM " . $param["table"];
        $i = 0;
        $value = "";

        if ($param["where"]) {

            foreach ($param["where"] as $key => $val) {

                $inchr = $conn->qstr($val, get_magic_quotes_gpc());

                if ($i == 0) {
                        $value  .= "\n WHERE " . $key . "=" . $inchr;
                 } else {
                        $value  .= "\n   AND " . $key . "=" . $inchr;
                 }
                $i++;
            }
        }

        $query .= $value;

        //Query Cache
        if ($param["cache"] == 1) {
            $rs = $conn->CacheExecute(1800, $query);
        } else {
            $rs = $conn->Execute($query);
        }

        return $rs;
    }

    /**
     * @brief 데이터 검색 쿼리 함수 (공통)<br>
     *        param 배열 설명<br>
     *        $param : $param["table"] = "테이블명"<br>
     *        $param["col"] = "컬럼명"<br>
     *        $param["where"]["컬럼명"] = "조건" (다중)<br>
     *        $param["not"]["컬럼명"] = "조건" (다중)<br>
     *        $param["order"] = "order by 조건"<br>
     *        $param["group"] = "group by 조건"<br>
     *        $param["cache"] = "1" 캐쉬 생성<br>
     *        $param["limit"]["start"] = 리미트 시작값<br>
     *        $param["limit"]["end"] =  리미트 종료값<br>
     * @param $conn DB Connection
     * @param $param 파라미터 인자 배열
     * @return boolean
     */
    function selectData($conn, $param) {

        if (!$conn) {
            echo "master connection failed\n";
            return false;
        }

        //주문배송, 회원, 주문 공통, 가상계좌, 견적
        if ($param["table"] == "member" || $param["table"] == "order_common" ||
            $param["table"] == "order_dlvr" || $param["table"] == "virt_ba_admin" ||
            $param["table"] == "esti") {
            echo "접근이 허용되지 않는 테이블 입니다.";
            return false;
        }

        $query = "\n SELECT " . $param["col"] . " FROM " . $param["table"];

        $i = 0;
        $col = "";
        $value = "";

        if ($param["where"]) {

            foreach ($param["where"] as $key => $val) {

                $inchr = $conn->qstr($val,get_magic_quotes_gpc());

                if ($i == 0) {
                        $value  .= "\n WHERE " . $key . "=" . $inchr;
                 } else {
                        $value  .= "\n   AND " . $key . "=" . $inchr;
                 }
                $i++;
            }
        }

        //임시로 만듬
        if ($param["not"]) {
            foreach ($param["not"] as $key => $val) {

                $inchr = $conn->qstr($val,get_magic_quotes_gpc());
                $value  .= "\n AND NOT " . $key . "=" . $inchr;
                $i++;
            }
        }

        //like search
        if ($param["like"]) {
            foreach ($param["like"] as $key => $val) {

                $inchr = substr($conn->qstr($val,get_magic_quotes_gpc()),1, -1);

                if ($i == 0) {
                        $value  .= "\n WHERE " . $key . " LIKE '%" . $inchr . "%'";
                 } else {
                        $value  .= "\n   AND " . $key . " LIKE '%" . $inchr . "%'";
                 }
                $i++;
            }
        }

        $query .= $value;

        if ($param["group"]) {
            $query .= "\n GROUP BY " . $param["group"];
        }

        if ($param["order"]) {
            $query .= "\n ORDER BY " . $param["order"];
        }

        if ($param["limit"]) {

            $query .= "\n LIMIT " . $param["limit"]["start"] . ",";
            $query .= $param["limit"]["end"];
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
     * @brief COUNT 데이터 검색 쿼리 함수 (공통)<br>
     *        param 배열 설명<br>
     *        $param : $param["table"] = "테이블명"<br>
     *        $param["where"]["컬럼명"] = "조건" (다중)<br>
     *        $param["cache"] = "1" 캐쉬 생성<br>
     *        $param["limit"]["start"] = 리미트 시작값<br>
     *        $param["limit"]["end"] =  리미트 종료값<br>
     * @param $conn DB Connection
     * @param $param 파라미터 인자 배열
     * @return boolean
     */
    function countData($conn, $param) {

        if (!$conn) {
            echo "master connection failed\n";
            return false;
        }

        $query = "\n SELECT count(*) cnt  FROM " . $param["table"];

        $i = 0;
        $col = "";
        $value = "";

        if ($param["where"]) {

            foreach ($param["where"] as $key => $val) {

                $inchr = $conn->qstr($val,get_magic_quotes_gpc());

                if ($i == 0) {
                        $value  .= "\n WHERE " . $key . "=" . $inchr;
                 } else {
                        $value  .= "\n   AND " . $key . "=" . $inchr;
                 }
                $i++;
            }
        }

        if ($param["like"]) {

            foreach ($param["like"] as $key => $val) {

                $inchr = $conn->qstr($val,get_magic_quotes_gpc());

                if ($i == 0) {
                        $value  .= "\n WHERE " . $key . " LIKE " . $inchr;
                 } else {
                        $value  .= "\n   AND " . $key . " LIKE " . $inchr;
                 }
                $i++;
            }
        }

        if ($param["group"]) {
            $query .= "\n GROUP BY " . $param["group"];
        }

       if ($param["limit"]) {

            $query .= "\n LIMIT " . $param["limit"]["start"] . ",";
            $query .= $param["limit"]["end"];
        }

        $query .= $value;

        $rs = $conn->Execute($query);
        return $rs;

    }

    /**
     * @brief 직원별 페이지 권한 검사
     * @param $conn DB Connection
     * @param $seqno 직원 일련번호
     * @param $path 페이지 경로
     * @return boolean
     */
    function checkAuth($conn, $seqno, $path) {

        if (!$conn) {
            echo "connection failed\n";
            return false;
        }

        $query  = "\n SELECT auth_yn FROM auth_admin_page";
        $query .= "\n  WHERE page_url='" . $path . "'";
        $query .= "\n    AND empl_seqno='" . $seqno . "'";

        $rs = $conn->Execute($query);

        if ($rs->fields["auth_yn"] == "N") {
            echo "<script>";
            echo "    alert('접근 권한이 없습니다.');";
            echo "    history.go(-1);";
            echo "</script>";

        //이것도 'N'일때로 추가해야함
        } else if (!$rs->fields["auth_yn"]) {

        }
    }

    /**
     * @brief 커넥션 검사
     * @param $conn DB Connection
     * @return boolean
     */
    function connectionCheck($conn) {
        if (!$conn) {
            echo "master connection failed\n";
            return false;
        }

        return true;
    }

    /**
     * @brief SQL 인젝션 방지용
     *
     * @param $conn  = DB Connection
     * @param $param = 검색조건
     *
     * @return 변환 된 인자
     */
    function parameterEscape($conn, $param) {
        $ret = $conn->qstr($param, get_magic_quotes_gpc());
        return $ret;
    }

    /**
     * @brief SQL 인젝션 방지용, 배열
     *
     * @detail $except_arr 배열은 $except["제외할 필드명"] = true
     * 형식으로 입력받는다.
     *
     * @param $conn       = DB Connection
     * @param $param      = 검색조건 배열
     * @param $except_arr = 이스케이프 제외할 필드명
     *
     * @return 변환 된 배열
     */
    function parameterArrayEscape($conn, $param, $except_arr = null) {
        if (!is_array($param)) return false;

        $arrSize = count($param);

        foreach ($param as $key => $val) {
            if ($except_arr[$key] === true) {
                continue;
            }

            if (is_array($val)) {
                $val = $this->parameterArrayEscape($conn, $val, $except_arr);
            } else {
                $val = $this->parameterEscape($conn, $val);
            }

            $param[$key] = $val;
        }

        return $param;
    }

   /**
     * @brief NULL 이거나 공백값('')이 아닌 파라미터만 체크
     * @param $param 임의의 배열 인자
     * @param $key 임의의 배열 인자의 키
     * @return boolean
     */
    function blankParameterCheck($param, $key) {
        // 파라미터가 빈 값이 아닐경우
        if ($param !== ""
                && empty($param[$key]) !== true
                && $param[$key] !== "''"
                && $param[$key] !== "NULL"
                && $param[$key] !== "null") {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @brief CUD 실패시 입력된 에러메시지 반환
     * @return 에러메시지
     */
    function getErrorMessage() {
        return $errorMessage;
    }

    /**
     * @brief 캐쉬를 삭제하는 함수
     * @param $conn DB Connection
     */
    function cacheFlush($conn) {
        $conn->CacheFlush();
    }

    /**
     * @brief 직원 권한 페이지 추가 기본 함수
     * @param $conn DB Connection
     * @param $auth_page 권한 페이지
     * @param $seqno 직원 일련번호
     */
    function addAuthDefault($conn, $auth_page, $seqno) {

        $page_url = "";
        $auth_info = "";

        $high_check = 1;
        $high_cnt = 1;
        $tmp_high_name = "";

        $most_check = 0;
        $most_cnt = 1;
        $tmp_most_name = "";

        foreach ($auth_page as $key => $val) {
            $page_url = $key;
            $auth_info = $val;

            $auth_list = explode("|", $auth_info);
            $most_page_name = $auth_list[0];
            $high_page_name = $auth_list[1];
            $page_name = $auth_list[2];

            if ($tmp_high_name == $high_page_name) {
                $high_check ++;

                //임시 이름과 상위 페이지 이름이 다를 경우
            } else {
                $tmp_high_name = $high_page_name;
                $high_check = 1;
            }

            //임시 이름와 최상위 페이지 이름이 같을 경우
            if ($tmp_most_name == $most_page_name) {

                //임시 이름와 최상위 페이지 이름이 다를 경우
            } else {
                $tmp_most_name = $most_page_name;
                $most_check ++;
            }

            $param["table"] = "auth_admin_page";
            $param["col"]["empl_seqno"] = $seqno;
            $param["col"]["page_url"] = $page_url;
            $param["col"]["most_page_name"] = $most_page_name;
            $param["col"]["high_page_name"] = $high_page_name;
            $param["col"]["page_name"] = $page_name;
            $param["col"]["auth_yn"] = "N";
            $param["col"]["array_num"] = $most_check;
            $param["col"]["detail_array_num"] = $high_check;

            $result = $this->insertData($conn,$param);
        }
    }

    /**
     * @brief 카테고리 검색
     *
     * @param $conn = connection identifier
     * @param $sortcode = connection identifier
     *
     * @return 검색결과
     */
    function selectCateList($conn, $sortcode = null) {
        $param = array();
        $param["col"]   = "sortcode, cate_name";
        $param["table"] = "cate";
        if ($sortcode === null) {
            $param["where"]["cate_level"] = "1";
        } else {
            $param["where"]["high_sortcode"] = $sortcode;
        }

        $rs = $this->selectData($conn, $param);

        $basic_option = "대분류(전체)";

        if (strlen($sortcode) === 3) {
            $basic_option = "중분류(전체)";
        } else if (strlen($sortcode) === 6) {
            $basic_option = "소분류(전체)";
        }

        return makeOptionHtml($rs, "sortcode", "cate_name", $basic_option);
    }

    /**
     * @brief 상품 카테고리 검색
     *
     * @param $conn = connection identifier
     * @param $sortcode = connection identifier
     * @param $catecd = 기본카테고리 코드
     * @return 검색결과
     */
    function ChongSelectCateList($conn, $sortcode = null,$catecd) {
        $param = array();
        $param["col"]   = "sortcode, cate_name";
        $param["table"] = "cate";
        if ($sortcode === null) {
            $param["where"]["cate_level"] = "1";
        } else {
            $param["where"]["high_sortcode"] = $sortcode;
        }

        $rs = $this->selectData($conn, $param);
        return ChongMakeOptionHtml($rs, "sortcode", "cate_name",null,null, $catecd);
    }
    /**
     * @brief 상품별 종이검색
     *
     * @param $conn = connection identifier
     * @param $sortcode = 카테고리 코드
     * @param $opt = 가져올 분류 (종이/인쇄도수/사이즈 중 택1)
     * @return 검색결과
     */
    function ChongSelectOptList($conn, $sortcode, $opt,$papercode = null,$printcode=null,$stancode=null) {
        $param = array();
		$param["where"]["a.cate_sortcode"] = $sortcode;
		if($opt == 'paper'){
			$param["col"]   = "distinct concat(name,' ',basisweight) as name,mpcode as value";
			$param["table"] = "ply_price_gp a inner join cate_paper b on (a.cate_paper_mpcode = b.mpcode)";


		}else if($opt == 'print'){
			$param["col"]   = "distinct c.name as name,mpcode as value";
			$param["table"] = "ply_price_gp a
							   inner join cate_print b on (a.cate_print_mpcode = b.mpcode and a.cate_sortcode = b.cate_sortcode)
							   inner join prdt_print c on (b.prdt_print_seqno = c.prdt_print_seqno)";

		}else if($opt == 'stan'){
			$param["col"]   = "distinct c.name as name,mpcode as value";
			$param["table"] = "ply_price_gp a
							   inner join cate_stan b on (a.cate_stan_mpcode = b.mpcode and a.cate_sortcode = b.cate_sortcode)
							   inner join prdt_stan c on (b.prdt_stan_seqno = c.prdt_stan_seqno)";
		}else{
			if(is_null($papercode)) $papercode=1;
			if(is_null($printcode)) $printcode=1;
			if(is_null($stancode)) $stancode=1;
			$param["col"]   = "amt as name,amt as value";
			$param["table"] = "ply_price_gp as a";
			$param["where"]["a.cate_paper_mpcode"] = $papercode;
			$param["where"]["a.cate_print_mpcode"] = $printcode;
			$param["where"]["a.cate_stan_mpcode"] = $stancode;
		}


        $rs = $this->selectData($conn, $param);
        return ChongMakeOptionHtml($rs, "value", "name",null,null,null);
    }


    /**
     * @brief 판매채널 검색
     *
     * @param $conn  = connection identifier
     *
     * @return option html
     */
    function selectSellSite($conn) {
        $temp = array();
        $temp["col"]   = "cpn_admin_seqno, sell_site";
        $temp["table"] = "cpn_admin";

        $rs = $this->selectData($conn, $temp);

        return makeOptionHtml($rs, "cpn_admin_seqno", "sell_site", "", "N");
    }

    /*
     * @brief 지번 주소 Select
     * @param $conn : DB Connection
     * @param $param["val"] : 지번 검색어

     * @param $param["area"] : 지역
     * @return : resultSet
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
     * @brief 도로명 주소 Select
     * @param $conn : DB Connection
     * @param $param["val"] : 지번 검색어
     * @param $param["area"] : 지역
     * @return : resultSet
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

    /**
     * @brief 직원 부서(팀)
     *
     * @param $conn  = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function selectDeparInfo($conn, $param) {

        //커넥션 체크
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        //인젝션 어택 방지
        $param = $this->parameterArrayEscape($conn, $param);

        $val = substr($param["depar_code"], 1, -1);

        $query  = "\nSELECT  A.depar_name ";
        $query .= "\n       ,A.depar_code ";
        $query .= "\n  FROM  depar_admin AS A ";
        $query .= "\n WHERE  depar_code LIKE '$val%' ";
        $query .= "\n   AND  depar_level = 2";

        //카테고리 분류코드 빈값 체크
        if ($this->blankParameterCheck($param ,"sell_site")) {
            $query .= "\n   AND  A.cpn_admin_seqno = $param[sell_site] ";
        }

        return $conn->Execute($query);
    }

    /**
     * @brief 주문 일련번호로 주문 내용 팝업 html 생성
     *
     * @param $conn  = connection identifier
     * @param $seqno = 주문 일련번호
     *
     * @return 주문정보팝업 html
     */
    function selectOrderInfoHtml($conn, $seqno) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $seqno = $this->parameterEscape($conn, $seqno);

        $query = "\n    select * from order_master as a";
        $query .= "\n   inner join order_prdlist as b";
        $query .= "\n   on a.order_no = b.order_no";
        $query .= "\n   where b.order_prdlist_seq = %s";

        $query  = sprintf($query, $seqno);

        $rs = $conn->Execute($query);

        return makeOrderInfoHtml($conn,$seqno, $rs->fields);
    }

    function selectProductInfoHtml($conn, $seqno) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $seqno = $this->parameterEscape($conn, $seqno);

        $query ="select max(a.order_no) as order_no,
         a.title AS title,
         a.stan_cal AS stan_cal,
         a.cate_sortcode AS cate_sortcode,
         a.cate_stan_type AS cate_stan_type,
         a.cate_stan_mpcode AS cate_stan_mpcode,
         a.cate_paper_mpcode AS cate_paper_mpcode,
         MAX(b.addtax_d_amnt) AS addtax_after_amnt,
         b.detail AS after_depth,
         g.side_dvs as side_dvs,
         i.pay_amnt AS pay_amnt,
		 max(a.order_prdlist_seq) as order_prdlist_seq,
		 max(a.prd_detail_no) as prd_detail_no,
		 max(e.cate_name) as cate_name,
		 max(concat(h.name,' ',h.color,' ',h.basisweight)) as paper_name,
		 max(a.work_size_wid) as work_size_wid,
		 max(a.work_size_vert) as work_size_vert,
		 max(a.cut_size_wid) as cut_size_wid,
		 max(a.cut_size_vert) as cut_size_vert,
		 max(a.prd_amount) as prd_amount,
		 max(a.prd_count) as prd_count,
		 max(a.comment) as comment,
		 max(a.prd_status) as prd_status,
         max(a.addtax_amnt) as addtax_order_amnt,
         max(a.detail) as detail,
		 max(concat(g.name)) as print_name,
		 max(d.origin_file_name) as origin_file_name,
		 max(d.order_img_seq) as order_img_seq,
		 max(d.origin_file_name) as origin_file_name,
		 g.side_dvs as side_dvs,
         g.output_board_amt as output_board_amt,
		 group_concat(distinct concat(after_name,'|',b.depth1,'|',b.depth2,'|',b.depth3,'|',b.detail)  order by order_after_history_seq asc SEPARATOR '$') as after_history,
		 group_concat(distinct concat(opt_name,'|',c.depth1,'|',c.depth2,'|',c.depth3)  order by order_opt_history_seq asc SEPARATOR '$') as opt_history,
		 group_concat(distinct concat(d.dvs,'&',d.type,'&',d.file_path,'&',d.save_file_name,'&',origin_file_name )order by d.dvs asc SEPARATOR '$') as img_list
		  from order_prdlist as a
			left join order_after_history as b on (a.order_no = b.order_no and a.prd_detail_no = b.prd_detail_no)
			left join order_opt_history as c on (a.order_no = c.order_no and a.prd_detail_no = c.prd_detail_no)
			left join order_img as d on (a.order_no = d.order_no and a.prd_detail_no = d.prd_detail_no)
			left join cate as e                on a.cate_sortcode = e.sortcode
			left join cate_print as f          on a.cate_print_mpcode = f.mpcode
			left join prdt_print as g          on f.prdt_print_seqno= g.prdt_print_seqno
			left join cate_paper as h          on a.cate_paper_mpcode = h.mpcode
			left join order_master as i		on a.order_no = i.order_no
			where a.order_prdlist_seq=%s";

        $query  = sprintf($query, $seqno);
        $rs = $conn->Execute($query);
        return makeProductInfoHtml($conn,$seqno, $rs->fields);
    }

    /*
    function makeImgInfoHtml($conn,$seqno){
        $query  = "\n select c.cate_name,  b.cate_paper_mpcode as paper,  concat(b.work_size_wid,'*',b.work_size_vert) as size,";
        $query .= "\n        concat(b.prd_amount,c.amt_unit) as amount,  concat(e.purp_dvs,e.name) as print,  b.prd_count as cnt,";
        $query .= "\n        b.prd_d_amnt as price,  b.addtax_d_amnt - b.prd_d_amnt as tax,  b.prd_amnt as pureprice,";
        $query .= "\n        b.addtax_amnt - b.prd_amnt as puretax,  b.addtax_amnt as totprice";
        $query .= "\n from   ";
        $query .= "\n        order_master as a ";
        $query .= "\n        inner join order_prdlist as b      on a.order_no = b.order_no";
        $query .= "\n        inner join cate as c                 on b.cate_sortcode = c.sortcode";
        $query .= "\n        inner join cate_print as d          on b.cate_paper_mpcode = d.mpcode";
        $query .= "\n        inner join prdt_print as e          on d.prdt_print_seqno= e.prdt_print_seqno";
        $query .= "\n where b.order_prdlist_seq = %s";

        $query  = sprintf($query, $seqno);

        $rs = $conn->Execute($query);

        return  makeProductInfoHtml($rs->fiels);
    }
    */

    /**
     * @brief 입력받은 값으로 사내 닉네임 검색
     *
     * @param $conn = connection identifier
     * @param $param = 검색조건 파라미터
     */
    function selectOfficeName($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n SELECT  user_nm as office_nick";
        $query .= "\n        ,CONCAT(user_nm, '(', mysec_id, ')') AS full_name";
        $query .= "\n   FROM  cmember";
        $query .= "\n  WHERE  cpn_admin_seqno = %s";
        if ($this->blankParameterCheck($param, "office_nick")) {
            $query .= "\n    AND  user_nm LIKE '";
            $query .= substr($param["office_nick"], 1, -1);
            $query .= "%%'";
        }

        $query  = sprintf($query, $param["sell_site"]);

        return $conn->Execute($query);
    }

    /**
     * @brief 사내 닉네임 list Select
     *
     * @param $conn  = connection identifier
     * @param $param = 검색 조건 파라미터
     *
     * @return : resultSet
     */
    function selectOfficeNickList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false;
        $param = $this->parameterArrayEscape($conn, $param);
        $query  = "\n    SELECT  office_nick";
        $query .= "\n           ,member_seqno";
        $query .= "\n      FROM  member";
        $query .= "\n     WHERE  cpn_admin_seqno = " . $param["sell_site"];

        //주소 검색어
        if ($this->blankParameterCheck($param, "search")) {
            $query .= "\n       AND office_nick LIKE '%";
            $query .= substr($param["search"], 1,-1) . "%'";
        }

        $result = $conn->Execute($query);

        return $result;
    }

    /**
     * @brief 입력받은 값으로 회원 아이디 검색
     *
     * @param $conn = connection identifier
     * @param $param = 검색조건 파라미터
     */
    function selectMemberId($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n SELECT  member_id";
        $query .= "\n   FROM  member";
        $query .= "\n  WHERE  cpn_admin_seqno = %s";
        if ($this->blankParameterCheck($param, "member_id")) {
            $query .= "\n    AND  member_id LIKE '";
            $query .= substr($param["member_id"], 1, -1);
            $query .= "%%'";
        }

        $query  = sprintf($query, $param["sell_site"]);

        return $conn->Execute($query);
    }

     /**
     * @brief 아이디와 비밀번호로 직원 정보 검색
     *
     * @param $conn = connection identifier
     * @param $id   = 직원 id
     */
    function selectEmpl($conn, $id) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $id = $this->parameterEscape($conn, $id);

        $query  = "\nSELECT name ";        /* 직원이름 */
        $query .= "\n      ,enter_date ";  /* 로그인 시각 */
        $query .= "\n      ,passwd ";      /* 비밀번호 */
        $query .= "\n      ,empl_seqno ";  /* 일련번호 */
        $query .= "\n      ,cpn_admin_seqno ";  /* 판매채널 일련번호 */
        $query .= "\n  FROM empl ";
        $query .= "\n WHERE empl_id = %s ";

        $query  = sprintf($query, $id);

        return $conn->Execute($query);
    }
}
?>
