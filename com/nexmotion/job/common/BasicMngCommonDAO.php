<?
//CommonDAO extends ErpCommonDAO
//ErpCommonDAO extends BasicMngCommonDAO

include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/CommonDAO.php');

/**
 * @file BasicMngCommonDAO.php
 *
 * @brief 기초관리 공통DAO
 */
class BasicMngCommonDAO extends CommonDAO {

    /**
     * @brief 생성자
     *
     */
    function __construct() {
    }

    /**
     * @brief 상품종이 정보 가져옴
     */
    function selectPaperInfo($conn, $dvs, $param) {

        //커넥션 체크
        if (!$this->connectionCheck($conn)) {
            return false;
        }

        //인젝션 어택 방지
        $param = $this->parameterArrayEscape($conn, $param);

        // 종이대분류
        if ($dvs === "SORT") {
            $query  = "\nSELECT  DISTINCT sort";
        // 종이명
        } else if ($dvs === "NAME") {
            $query  = "\nSELECT  DISTINCT name";
        // 구분
        } else if ($dvs === "DVS") {
            $query  = "\nSELECT  DISTINCT dvs";
        // 색상
        } else if ($dvs === "COLOR") {
            $query  = "\nSELECT  DISTINCT color";
        //평량
        } else if ($dvs === "BASISWEIGHT") {
            $query  = "\nSELECT  DISTINCT ";
            $query .= "CONCAT(basisweight, basisweight_unit) AS basisweight";
        //카운트
        } else if ($dvs === "COUNT") {
            $query  = "\nSELECT  COUNT(*) AS cnt";
        //일반 쿼리
        } else if ($dvs === "SEQ") {
            $query  = "\nSELECT  name ";
            $query .= "\n       ,dvs ";
            $query .= "\n       ,color ";
            $query .= "\n       ,sort ";
            $query .= "\n       ,affil ";
            $query .= "\n       ,size ";
            $query .= "\n       ,crtr_unit ";
            $query .= "\n       ,basisweight ";
            $query .= "\n       ,basisweight_unit ";
            $query .= "\n       ,prdt_paper_seqno ";
        }

        $query .= "\n  FROM  prdt_paper ";

        //검색에 필요한 기본 조건
        $query .= "\n WHERE  1 = 1 ";

        //종이대분류
        if ($this->blankParameterCheck($param ,"sort")) {
            $query .= "\n   AND  sort = $param[sort]";
        }
        //종이명
        if ($this->blankParameterCheck($param ,"name")) {
            $query .= "\n   AND  name = $param[name]";
        }
        //구분
        if ($this->blankParameterCheck($param ,"dvs")) {
            $query .= "\n   AND  dvs = $param[dvs]";
        }
        //색상
        if ($this->blankParameterCheck($param ,"color")) {
            $query .= "\n   AND  color = $param[color]";
        }
        //평량
        if ($this->blankParameterCheck($param ,"basisweight")) {
            $query .= "\n   AND  basisweight = $param[basisweight]";
        }

        //종이 일련번호
        if ($this->blankParameterCheck($param ,"seqno")) {
            $query .= "\n   AND  prdt_paper_seqno = $param[seqno]";
        }

        if ($dvs === "SEQ" || $dvs === "COUNT") {

            if ($this->blankParameterCheck($param ,"search_txt")) {
                $val = substr($param["search_txt"], 1, -1);
                $query .= "\n   AND  name LIKE '%" . $val . "%'";
            }

            $s_num = substr($param["s_num"], 1, -1);
            $list_num = substr($param["list_num"], 1, -1);

            if ($this->blankParameterCheck($param ,"sorting")) {
                $sorting = substr($param["sorting"], 1, -1);
                $query .= "\n ORDER BY " . $sorting;

                if ($this->blankParameterCheck($param ,"sorting_type")) {
                    $sorting_type = substr($param["sorting_type"], 1, -1);
                    $query .= " " . $sorting_type;
                }
            }

            if ($dvs === "SEQ") {
                $query .= "\nLIMIT ". $s_num . ", " . $list_num;
            }
        }

        return $conn->Execute($query);
    }

    /**
     * @brief 출력정보 가져옴
     */
    function selectOutputInfo($conn, $dvs, $param) {

        //커넥션 체크
        if (!$this->connectionCheck($conn)) {
            return false;
        }

        //인젝션 어택 방지
        $param = $this->parameterArrayEscape($conn, $param);

        //출력명
        if ($dvs === "NAME") {
            $query  = "\nSELECT  DISTINCT output_name";
        //출력판구분
        } else if ($dvs === "BOARD") {
            $query  = "\nSELECT  DISTINCT output_board_dvs";
        //사이즈
        } else if ($dvs === "SIZE") {
            $query  = "\nSELECT  DISTINCT size";
        //카운트
        } else if ($dvs === "COUNT") {
            $query  = "\nSELECT  COUNT(*) AS cnt";
        //일반 쿼리
        } else if ($dvs === "SEQ") {
            $query  = "\nSELECT  prdt_output_info_seqno ";
            $query .= "\n       ,output_name ";
            $query .= "\n       ,affil ";
            $query .= "\n       ,output_board_dvs ";
            $query .= "\n       ,size ";
        }

        $query .= "\n  FROM  prdt_output_info ";

        //검색에 필요한 기본 조건
        $query .= "\n WHERE  1 = 1 ";

        //출력명
        if ($this->blankParameterCheck($param ,"name")) {
            $query .= "\n   AND  output_name = $param[name]";
        }
        //출력판 구분
        if ($this->blankParameterCheck($param ,"board_dvs")) {
            $query .= "\n   AND  output_board_dvs = $param[board_dvs]";
        }

        //출력정보 일련번호
        if ($this->blankParameterCheck($param ,"seqno")) {
            $query .= "\n   AND  prdt_output_info_seqno = $param[seqno]";
        }

        if ($dvs === "SEQ" || $dvs === "COUNT") {

            if ($this->blankParameterCheck($param ,"search_txt")) {
                $val = substr($param["search_txt"], 1, -1);
                $query .= "\n   AND  output_name LIKE '%" . $val . "%'";
            }

            $s_num = substr($param["s_num"], 1, -1);
            $list_num = substr($param["list_num"], 1, -1);

            if ($this->blankParameterCheck($param ,"sorting")) {
                $sorting = substr($param["sorting"], 1, -1);
                $query .= "\n ORDER BY " . $sorting;

                if ($this->blankParameterCheck($param ,"sorting_type")) {
                    $sorting_type = substr($param["sorting_type"], 1, -1);
                    $query .= " " . $sorting_type;
                }
            }

            if ($dvs === "SEQ") {
                $query .= "\nLIMIT ". $s_num . ", " . $list_num;
            }
        }

        return $conn->Execute($query);
    }

    /**
     * @brief 상품규격 정보 가져옴
     */
    function selectSizeInfo($conn, $dvs, $param) {

        //커넥션 체크
        if (!$this->connectionCheck($conn)) {
            return false;
        }

        //인젝션 어택 방지
        $param = $this->parameterArrayEscape($conn, $param);

        //사이즈 대분류
        if ($dvs === "SORT") {
            $query  = "\nSELECT  DISTINCT sort";
        //사이즈명
        } else if ($dvs === "NAME") {
            $query  = "\nSELECT  DISTINCT name";
        //카운트
        } else if ($dvs === "COUNT") {
            $query  = "\nSELECT  COUNT(*) AS cnt";
        //일반 쿼리
        } else if ($dvs === "SEQ") {
            $query  = "\nSELECT  prdt_stan_seqno ";
            $query .= "\n       ,sort ";
            $query .= "\n       ,name ";
            $query .= "\n       ,typ ";
            $query .= "\n       ,affil ";
            $query .= "\n       ,output_name ";
            $query .= "\n       ,output_board_dvs ";
            $query .= "\n       ,cut_wid_size ";
            $query .= "\n       ,cut_vert_size ";
            $query .= "\n       ,work_wid_size ";
            $query .= "\n       ,work_vert_size ";
            $query .= "\n       ,design_wid_size ";
            $query .= "\n       ,design_vert_size ";
            $query .= "\n       ,tomson_wid_size ";
            $query .= "\n       ,tomson_vert_size ";
        }

        $query .= "\n  FROM  prdt_stan ";

        //검색에 필요한 기본 조건
        $query .= "\n WHERE  1 = 1 ";

        //사이즈 대분류
        if ($this->blankParameterCheck($param ,"sort")) {
            $query .= "\n   AND  sort = $param[sort]";
        }

        //사이즈명
        if ($this->blankParameterCheck($param ,"name")) {
            $query .= "\n   AND  name = $param[name]";
        }

        //사이즈 일련번호
        if ($this->blankParameterCheck($param ,"seqno")) {
            $query .= "\n   AND  prdt_stan_seqno = $param[seqno]";
        }

        if ($dvs === "SEQ" || $dvs === "COUNT") {

            if ($this->blankParameterCheck($param ,"search_txt")) {
                $val = substr($param["search_txt"], 1, -1);
                $query .= "\n   AND  name LIKE '%" . $val . "%'";
            }

            $s_num = substr($param["s_num"], 1, -1);
            $list_num = substr($param["list_num"], 1, -1);

            if ($this->blankParameterCheck($param ,"sorting")) {
                $sorting = substr($param["sorting"], 1, -1);
                $query .= "\n ORDER BY " . $sorting;

                if ($this->blankParameterCheck($param ,"sorting_type")) {
                    $sorting_type = substr($param["sorting_type"], 1, -1);
                    $query .= " " . $sorting_type;
                }
            }

            if ($dvs === "SEQ") {
                $query .= "\nLIMIT ". $s_num . ", " . $list_num;
            }
        }

        return $conn->Execute($query);
    }

    /**
     * @brief 인쇄정보 가져옴
     */
    function selectPrintInfo($conn, $dvs, $param) {

        //커넥션 체크
        if (!$this->connectionCheck($conn)) {
            return false;
        }

        //인젝션 어택 방지
        $param = $this->parameterArrayEscape($conn, $param);

        //인쇄명
        if ($dvs === "NAME") {
            $query  = "\nSELECT  DISTINCT A.print_name";
        //용도구분
        } else if ($dvs === "PURP") {
            $query  = "\nSELECT  DISTINCT A.purp_dvs";
        //카운트
        } else if ($dvs === "COUNT") {
            $query  = "\nSELECT  COUNT(*) AS cnt";
        //일반 쿼리
        } else if ($dvs === "SEQ") {
            $query  = "\nSELECT  A.prdt_print_info_seqno ";
            $query .= "\n       ,A.print_name ";
            $query .= "\n       ,A.purp_dvs ";
            $query .= "\n       ,A.cate_sortcode ";
            $query .= "\n       ,B.cate_name ";
            $query .= "\n       ,A.affil ";
            $query .= "\n       ,A.crtr_unit ";
        }

        $query .= "\n  FROM  prdt_print_info A";
        $query .= "\n       ,cate B";

        //검색에 필요한 기본 조건
        $query .= "\n WHERE  A.cate_sortcode = B.sortcode ";

        //인쇄명
        if ($this->blankParameterCheck($param ,"name")) {
            $query .= "\n   AND  A.print_name = $param[name]";
        }

        //카테고리
        if ($this->blankParameterCheck($param ,"cate_sortcode")) {
            $query .= "\n   AND  A.cate_sortcode = $param[cate_sortcode]";
        }

        //인쇄정보 일련번호
        if ($this->blankParameterCheck($param ,"seqno")) {
            $query .= "\n   AND  A.prdt_print_info_seqno = $param[seqno]";
        }

        if ($dvs === "SEQ" || $dvs === "COUNT") {

            if ($this->blankParameterCheck($param ,"search_txt")) {
                $val = substr($param["search_txt"], 1, -1);
                $query .= "\n   AND  A.print_name LIKE '%" . $val . "%'";
            }

            $s_num = substr($param["s_num"], 1, -1);
            $list_num = substr($param["list_num"], 1, -1);

            if ($this->blankParameterCheck($param ,"sorting")) {
                $sorting = substr($param["sorting"], 1, -1);
                $query .= "\n ORDER BY " . $sorting;

                if ($this->blankParameterCheck($param ,"sorting_type")) {
                    $sorting_type = substr($param["sorting_type"], 1, -1);
                    $query .= " " . $sorting_type;
                }
            }

            if ($dvs === "SEQ") {
                $query .= "\nLIMIT ". $s_num . ", " . $list_num;
            }
        }

        return $conn->Execute($query);
    }

    /**
     * @brief 인쇄도수 정보 가져옴
     */
    function selectTmptInfo($conn, $dvs, $param) {

        //커넥션 체크
        if (!$this->connectionCheck($conn)) {
            return false;
        }

        //인젝션 어택 방지
        $param = $this->parameterArrayEscape($conn, $param);

        //인쇄도수 대분류
        if ($dvs === "SORT") {
            $query  = "\nSELECT  DISTINCT sort";
        //인쇄도수명
        } else if ($dvs === "NAME") {
            $query  = "\nSELECT  DISTINCT name";
        //카운트
        } else if ($dvs === "COUNT") {
            $query  = "\nSELECT  COUNT(*) AS cnt";
        //일반 쿼리
        } else if ($dvs === "SEQ") {
            $query  = "\nSELECT  prdt_print_seqno ";
            $query .= "\n       ,sort ";
            $query .= "\n       ,name ";
            $query .= "\n       ,print_name ";
            $query .= "\n       ,purp_dvs ";
            $query .= "\n       ,side_dvs ";
            $query .= "\n       ,beforeside_tmpt ";
            $query .= "\n       ,aftside_tmpt ";
            $query .= "\n       ,add_tmpt ";
            $query .= "\n       ,tot_tmpt ";
            $query .= "\n       ,output_board_amt ";
        }

        $query .= "\n  FROM  prdt_print ";

        //검색에 필요한 기본 조건
        $query .= "\n WHERE  1 = 1 ";

        //인쇄도수 대분류
        if ($this->blankParameterCheck($param ,"sort")) {
            $query .= "\n   AND  sort = $param[sort]";
        }

        //인쇄도수명
        if ($this->blankParameterCheck($param ,"name")) {
            $query .= "\n   AND  name = $param[name]";
        }

        //인쇄도수 일련번호
        if ($this->blankParameterCheck($param ,"seqno")) {
            $query .= "\n   AND  prdt_print_seqno = $param[seqno]";
        }

        if ($dvs === "SEQ" || $dvs === "COUNT") {

            if ($this->blankParameterCheck($param ,"search_txt")) {
                $val = substr($param["search_txt"], 1, -1);
                $query .= "\n   AND  name LIKE '%" . $val . "%'";
            }

            $s_num = substr($param["s_num"], 1, -1);
            $list_num = substr($param["list_num"], 1, -1);

            if ($this->blankParameterCheck($param ,"sorting")) {
                $sorting = substr($param["sorting"], 1, -1);
                $query .= "\n ORDER BY " . $sorting;

                if ($this->blankParameterCheck($param ,"sorting_type")) {
                    $sorting_type = substr($param["sorting_type"], 1, -1);
                    $query .= " " . $sorting_type;
                }
            }

            if ($dvs === "SEQ") {
                $query .= "\nLIMIT ". $s_num . ", " . $list_num;
            }
        }

        return $conn->Execute($query);
    }

    /**
     * @brief 후공정 정보 가져옴
     */
    function selectAfterInfo($conn, $dvs, $param) {

        //커넥션 체크
        if (!$this->connectionCheck($conn)) {
            return false;
        }

        //인젝션 어택 방지
        $param = $this->parameterArrayEscape($conn, $param);

        //후공정명
        if ($dvs === "AFTER_NAME") {
            $query  = "\nSELECT  DISTINCT after_name";
        //카운트
        }  if ($dvs === "COUNT") {
            $query  = "\nSELECT  COUNT(*) AS cnt";
        //일반 쿼리
        } else if ($dvs === "SEQ") {
            $query  = "\nSELECT  prdt_after_seqno ";
            $query .= "\n       ,after_name ";
            $query .= "\n       ,depth1 ";
            $query .= "\n       ,depth2 ";
            $query .= "\n       ,depth3 ";
            $query .= "\n       ,crtr_unit ";
        }

        $query .= "\n  FROM  prdt_after ";

        //검색에 필요한 기본 조건
        $query .= "\n WHERE  1 = 1 ";

        //후공명
        if ($this->blankParameterCheck($param ,"name")) {
            $query .= "\n   AND  after_name = $param[name]";
        }

        //후공정 일련번호
        if ($this->blankParameterCheck($param ,"seqno")) {
            $query .= "\n   AND  prdt_after_seqno = $param[seqno]";
        }

        if ($dvs === "SEQ" || $dvs === "COUNT") {

            if ($this->blankParameterCheck($param ,"search_txt")) {
                $val = substr($param["search_txt"], 1, -1);
                $query .= "\n   AND  after_name LIKE '%" . $val . "%'";
            }

            $s_num = substr($param["s_num"], 1, -1);
            $list_num = substr($param["list_num"], 1, -1);

            if ($this->blankParameterCheck($param ,"sorting")) {
                $sorting = substr($param["sorting"], 1, -1);
                $query .= "\n ORDER BY " . $sorting;

                if ($this->blankParameterCheck($param ,"sorting_type")) {
                    $sorting_type = substr($param["sorting_type"], 1, -1);
                    $query .= " " . $sorting_type;
                }
            }

            if ($dvs === "SEQ") {
                $query .= "\nLIMIT ". $s_num . ", " . $list_num;
            }
        }

        return $conn->Execute($query);
    }

    /**
     * @brief 옵션 정보 가져옴
     */
    function selectOptInfo($conn, $dvs, $param) {

        //커넥션 체크
        if (!$this->connectionCheck($conn)) {
            return false;
        }

        //인젝션 어택 방지
        $param = $this->parameterArrayEscape($conn, $param);

        //옵션명
        if ($dvs === "OPT_NAME") {
            $query  = "\nSELECT  DISTINCT opt_name";
        //카운트
        } else if ($dvs === "COUNT") {
            $query  = "\nSELECT  COUNT(*) AS cnt";
        //일반 쿼리
        } else if ($dvs === "SEQ") {
            $query  = "\nSELECT  prdt_opt_seqno ";
            $query .= "\n       ,opt_name ";
            $query .= "\n       ,depth1 ";
            $query .= "\n       ,depth2 ";
            $query .= "\n       ,depth3 ";
        }

        $query .= "\n  FROM  prdt_opt ";

        //검색에 필요한 기본 조건
        $query .= "\n WHERE  1 = 1 ";

        //옵션명
        if ($this->blankParameterCheck($param ,"name")) {
            $query .= "\n   AND  opt_name = $param[name]";
        }

        //옵션 일련번호
        if ($this->blankParameterCheck($param ,"seqno")) {
            $query .= "\n   AND  prdt_opt_seqno = $param[seqno]";
        }

        if ($dvs === "SEQ" || $dvs === "COUNT") {

            if ($this->blankParameterCheck($param ,"search_txt")) {
                $val = substr($param["search_txt"], 1, -1);
                $query .= "\n   AND  opt_name LIKE '%" . $val . "%'";
            }

            $s_num = substr($param["s_num"], 1, -1);
            $list_num = substr($param["list_num"], 1, -1);

            if ($this->blankParameterCheck($param ,"sorting")) {
                $sorting = substr($param["sorting"], 1, -1);
                $query .= "\n ORDER BY " . $sorting;

                if ($this->blankParameterCheck($param ,"sorting_type")) {
                    $sorting_type = substr($param["sorting_type"], 1, -1);
                    $query .= " " . $sorting_type;
                }
            }

            if ($dvs === "SEQ") {
                $query .= "\nLIMIT ". $s_num . ", " . $list_num;
            }
        }

        return $conn->Execute($query);
    }

    /**
     * @brief 상품구성아이템 종이 정보 가져옴
     *
     * @param $conn  = connection identifier
     * @param $dvs   = 정보 구분
     * @param $param = 정보검색용 파라미터
     *
     * @return 검색결과
     */
    function selectCatePaperInfo($conn, $dvs, $param) {

        //커넥션 체크
        if (!$this->connectionCheck($conn)) {
            return false;
        }

        //인젝션 어택 방지
        $param = $this->parameterArrayEscape($conn, $param);

        // 종이대분류
        if ($dvs === "SORT") {
            $query  = "\nSELECT  DISTINCT sort";
        // 종이명
        } else if ($dvs === "NAME") {
            $query  = "\nSELECT  DISTINCT name";
        // 구분
        } else if ($dvs === "DVS") {
            $query  = "\nSELECT  DISTINCT dvs";
        // 색상
        } else if ($dvs === "COLOR") {
            $query  = "\nSELECT  DISTINCT color";
        //평량
        } else if ($dvs === "BASISWEIGHT") {
            $query  = "\nSELECT  DISTINCT basisweight";
        //카운트
        } else if ($dvs === "COUNT") {
            $query  = "\nSELECT  COUNT(*) AS cnt";
        //일반 쿼리
        } else if ($dvs === "SEQ") {
            $query  = "\nSELECT  name ";
            $query .= "\n       ,dvs ";
            $query .= "\n       ,color ";
            $query .= "\n       ,sort ";
            $query .= "\n       ,basisweight ";
            $query .= "\n       ,cate_sortcode ";
            $query .= "\n       ,cate_paper_seqno ";
            $query .= "\n       ,mpcode";
        }

        $query .= "\n  FROM  cate_paper ";

        //검색에 필요한 기본 조건
        $query .= "\n WHERE  1 = 1 ";

        //종이대분류
        if ($this->blankParameterCheck($param ,"sort")) {
            $query .= "\n   AND  sort = $param[sort]";
        }

        //종이명
        if ($this->blankParameterCheck($param ,"name")) {
            $query .= "\n   AND  name = $param[name]";
        }

        //종이구분
        if ($this->blankParameterCheck($param ,"dvs")) {
            $query .= "\n   AND  dvs = $param[dvs]";
        }

        //종이색상
        if ($this->blankParameterCheck($param ,"color")) {
            $query .= "\n   AND  color = $param[color]";
        }

        //종이평량
        if ($this->blankParameterCheck($param ,"basisweight")) {
            $query .= "\n   AND  basisweight = $param[basisweight]";
        }

        //카테고리 분류코드
        if ($this->blankParameterCheck($param ,"cate_sortcode")) {
            $query .= "\n   AND  cate_sortcode = $param[cate_sortcode]";
        }

        //카테고리 분류코드 LIKE
        if ($this->blankParameterCheck($param ,"cate_sortcode_like")) {
            $val = substr($param["cate_sortcode_like"], 1, -1);
            $query .= "\n   AND  cate_sortcode LIKE '" . $val. "%'";
        }

        //종이 일련번호
        if ($this->blankParameterCheck($param ,"seqno")) {
            $query .= "\n   AND  cate_paper_seqno = $param[seqno]";
        }

        if ($dvs === "SEQ" || $dvs === "COUNT") {

            if ($this->blankParameterCheck($param ,"search_txt")) {
                $val = substr($param["search_txt"], 1, -1);
                $query .= "\n   AND  name LIKE '%" . $val . "%'";
            }

            if ($this->blankParameterCheck($param ,"sorting")) {
                $sorting = substr($param["sorting"], 1, -1);
                $query .= "\n ORDER BY " . $sorting;

                if ($this->blankParameterCheck($param ,"sorting_type")) {
                    $sorting_type = substr($param["sorting_type"], 1, -1);
                    $query .= " " . $sorting_type;
                }
            }

            if ($this->blankParameterCheck($param ,"s_num")) {
                $s_num = substr($param["s_num"], 1, -1);
            }

            if ($this->blankParameterCheck($param ,"list_num")) {
                $list_num = substr($param["list_num"], 1, -1);
            }

            if ($this->blankParameterCheck($param ,"s_num") &&
                    $this->blankParameterCheck($param ,"list_num") &&
                    $dvs != "COUNT") {
                $query .= "\nLIMIT ". $s_num . ", " . $list_num;
            }
        }

        return $conn->Execute($query);
    }

    /**
     * @brief 상품구성아이템 출력 정보 가져옴
     *
     * @param $conn  = connection identifier
     * @param $dvs   = 정보 구분
     * @param $param = 정보검색용 파라미터
     *
     * @return 검색결과
     */
    function selectCateSizeInfo($conn, $dvs, $param) {

        //커넥션 체크
        if (!$this->connectionCheck($conn)) {
            return false;
        }

        //인젝션 어택 방지
        $param = $this->parameterArrayEscape($conn, $param);

        //사이즈 대분류
        if ($dvs === "SORT") {
            $query  = "\nSELECT  DISTINCT sort";
        //사이즈명
        } else if ($dvs === "NAME") {
            $query  = "\nSELECT  DISTINCT name";
        //카운트
        } else if ($dvs === "COUNT") {
            $query  = "\nSELECT  COUNT(*) AS cnt";
        //일반 쿼리
        } else if ($dvs === "SEQ") {
            $query  = "\nSELECT  B.cate_stan_seqno ";
            $query .= "\n       ,A.sort ";
            $query .= "\n       ,A.name ";
            $query .= "\n       ,A.typ ";
            $query .= "\n       ,A.affil ";
            $query .= "\n       ,A.output_name ";
            $query .= "\n       ,A.output_board_dvs ";
            $query .= "\n       ,A.cut_wid_size ";
            $query .= "\n       ,A.cut_vert_size ";
            $query .= "\n       ,A.work_wid_size ";
            $query .= "\n       ,A.work_vert_size ";
            $query .= "\n       ,A.design_wid_size ";
            $query .= "\n       ,A.design_vert_size ";
            $query .= "\n       ,A.tomson_wid_size ";
            $query .= "\n       ,A.tomson_vert_size ";
            $query .= "\n       ,B.cate_sortcode ";
        }

        $query .= "\n  FROM  prdt_stan AS A ";
        $query .= "\n       ,cate_stan AS B ";

        //검색에 필요한 기본 조건
        $query .= "\n WHERE  A.prdt_stan_seqno  = B.prdt_stan_seqno ";

        //사이즈 대분류
        if ($this->blankParameterCheck($param ,"sort")) {
            $query .= "\n   AND  sort = $param[sort]";
        }

        //사이즈명
        if ($this->blankParameterCheck($param ,"name")) {
            $query .= "\n   AND  name = $param[name]";
        }

        //사이즈 일련번호
        if ($this->blankParameterCheck($param ,"seqno")) {
            $query .= "\n   AND  prdt_stan_seqno = $param[seqno]";
        }

        //카테고리 분류코드
        if ($this->blankParameterCheck($param ,"cate_sortcode")) {
            $query .= "\n   AND cate_sortcode = $param[cate_sortcode]";
        }

        //카테고리 분류코드 LIKE
        if ($this->blankParameterCheck($param ,"cate_sortcode_like")) {
            $val = substr($param["cate_sortcode_like"], 1, -1);
            $query .= "\n   AND  cate_sortcode LIKE '" . $val. "%'";
        }

        if ($dvs === "SEQ" || $dvs === "COUNT") {

            if ($this->blankParameterCheck($param ,"search_txt")) {
                $val = substr($param["search_txt"], 1, -1);
                $query .= "\n   AND  name LIKE '%" . $val . "%'";
            }

            if ($this->blankParameterCheck($param ,"sorting")) {
                $sorting = substr($param["sorting"], 1, -1);
                $query .= "\n ORDER BY " . $sorting;

                if ($this->blankParameterCheck($param ,"sorting_type")) {
                    $sorting_type = substr($param["sorting_type"], 1, -1);
                    $query .= " " . $sorting_type;
                }
            }

            if ($this->blankParameterCheck($param ,"s_num")) {
                $s_num = substr($param["s_num"], 1, -1);
            }

            if ($this->blankParameterCheck($param ,"list_num")) {
                $list_num = substr($param["list_num"], 1, -1);
            }

            if ($this->blankParameterCheck($param ,"s_num") &&
                $this->blankParameterCheck($param ,"list_num") &&
                $dvs != "COUNT") {
                $query .= "\nLIMIT ". $s_num . ", " . $list_num;
            }
        }

        return $conn->Execute($query);
    }

    /**
     * @brief 카테고리 후공정 정보 검색
     *
     * @param $conn  = connection identifier
     * @param $dvs   = 정보 구분
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function selectCateTmptInfo($conn, $dvs, $param) {

        //커넥션 체크
        if (!$this->connectionCheck($conn)) {
            return false;
        }

        //인젝션 어택 방지
        $param = $this->parameterArrayEscape($conn, $param);

        //인쇄도수 대분류
        if ($dvs === "SORT") {
            $query  = "\nSELECT  DISTINCT sort";
        //인쇄도수명
        } else if ($dvs === "NAME") {
            $query  = "\nSELECT  DISTINCT name";
        //카운트
        } else if ($dvs === "COUNT") {
            $query  = "\nSELECT  COUNT(*) AS cnt";
        //일반 쿼리
        } else if ($dvs === "SEQ") {
            $query  = "\nSELECT  B.cate_print_seqno ";
            $query .= "\n       ,A.sort ";
            $query .= "\n       ,A.name ";
            $query .= "\n       ,A.print_name ";
            $query .= "\n       ,A.purp_dvs ";
            $query .= "\n       ,A.side_dvs ";
            $query .= "\n       ,A.beforeside_tmpt ";
            $query .= "\n       ,A.aftside_tmpt ";
            $query .= "\n       ,A.add_tmpt ";
            $query .= "\n       ,A.tot_tmpt ";
        }

        $query .= "\n  FROM  prdt_print AS A ";
        $query .= "\n       ,cate_print AS B";

        //검색에 필요한 기본 조건
        $query .= "\n WHERE  A.prdt_print_seqno = B.prdt_print_seqno ";

        //인쇄도수 대분류
        if ($this->blankParameterCheck($param ,"sort")) {
            $query .= "\n   AND  sort = $param[sort]";
        }

        //인쇄도수명
        if ($this->blankParameterCheck($param ,"name")) {
            $query .= "\n   AND  name = $param[name]";
        }

        //인쇄도수 일련번호
        if ($this->blankParameterCheck($param ,"seqno")) {
            $query .= "\n   AND  prdt_print_seqno = $param[seqno]";
        }

        //카테고리 분류코드
        if ($this->blankParameterCheck($param ,"cate_sortcode")) {
            $query .= "\n   AND cate_sortcode = $param[cate_sortcode]";
        }

        //카테고리 분류코드 LIKE
        if ($this->blankParameterCheck($param ,"cate_sortcode_like")) {
            $val = substr($param["cate_sortcode_like"], 1, -1);
            $query .= "\n   AND  cate_sortcode LIKE '" . $val. "%'";
        }

        if ($dvs === "SEQ" || $dvs === "COUNT") {

            if ($this->blankParameterCheck($param ,"search_txt")) {
                $val = substr($param["search_txt"], 1, -1);
                $query .= "\n   AND  name LIKE '%" . $val . "%'";
            }

            if ($this->blankParameterCheck($param ,"sorting")) {
                $sorting = substr($param["sorting"], 1, -1);
                $query .= "\n ORDER BY " . $sorting;

                if ($this->blankParameterCheck($param ,"sorting_type")) {
                    $sorting_type = substr($param["sorting_type"], 1, -1);
                    $query .= " " . $sorting_type;
                }
            }

            if ($this->blankParameterCheck($param ,"s_num")) {
                $s_num = substr($param["s_num"], 1, -1);
            }

            if ($this->blankParameterCheck($param ,"list_num")) {
                $list_num = substr($param["list_num"], 1, -1);
            }

            if ($this->blankParameterCheck($param ,"s_num") &&
                $this->blankParameterCheck($param ,"list_num") &&
                $dvs != "COUNT") {
                $query .= "\nLIMIT ". $s_num . ", " . $list_num;
            }
        }

        return $conn->Execute($query);
    }

    /**
     * @brief 카테고리 후공정 정보 검색
     *
     * @param $conn  = connection identifier
     * @param $dvs   = 정보 구분
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function selectCateAftInfo($conn, $dvs, $param) {

        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);

        if ($dvs === "AFTER_NAME") {
            $query  = "\n SELECT  DISTINCT after_name";
        } else if ($dvs === "DEPTH1") {
            $query  = "\n SELECT  DISTINCT depth1";
        } else if ($dvs === "DEPTH2") {
            $query  = "\n SELECT  DISTINCT depth2";
        } else if ($dvs === "DEPTH3") {
        $query  = "\n SELECT  DISTINCT depth3";
        //카운트
        } else if ($dvs === "COUNT") {
            $query  = "\nSELECT  COUNT(*) AS cnt";
        } else if ($dvs === "SEQ") {
            $query  = "\n SELECT  A.after_name";
            $query .= "\n        ,A.depth1";
            $query .= "\n        ,A.depth2";
            $query .= "\n        ,A.depth3";
            $query .= "\n        ,A.crtr_unit";
            $query .= "\n        ,B.mpcode";
            $query .= "\n        ,B.basic_yn";
            $query .= "\n        ,B.cate_after_seqno";
            $query .= "\n        ,A.crtr_unit";
        }

        $query .= "\n   FROM  prdt_after AS A";
        $query .= "\n        ,cate_after AS B";

        $query .= "\n  WHERE  A.prdt_after_seqno = B.prdt_after_seqno";

        if ($this->blankParameterCheck($param, "cate_sortcode")) {
            $query .= "\n    AND  B.cate_sortcode = ";
            $query .= $param["cate_sortcode"];
        }
        //카테고리 분류코드 LIKE
        if ($this->blankParameterCheck($param ,"cate_sortcode_like")) {
            $val = substr($param["cate_sortcode_like"], 1, -1);
            $query .= "\n   AND  cate_sortcode LIKE '" . $val. "%'";
        }
        if ($this->blankParameterCheck($param, "basic_yn")) {
            $query .= "\n    AND  B.basic_yn = ";
            $query .= $param["basic_yn"];
        }
        if ($this->blankParameterCheck($param, "after_name")) {
            $query .= "\n    AND  A.after_name = ";
            $query .= $param["after_name"];
        }
        if ($this->blankParameterCheck($param, "depth1")) {
            $query .= "\n    AND  A.depth1 = ";
            $query .= $param["depth1"];
        }
        if ($this->blankParameterCheck($param, "depth2")) {
            $query .= "\n    AND  A.depth2 = ";
            $query .= $param["depth2"];
        }
        if ($this->blankParameterCheck($param, "depth3")) {
            $query .= "\n    AND  A.depth3 = ";
            $query .= $param["depth3"];
        }
        if ($this->blankParameterCheck($param ,"seqno")) {
            $query .= "\n   AND  cate_after_seqno = $param[seqno]";
        }

        if ($dvs === "SEQ" || $dvs === "COUNT") {

            if ($this->blankParameterCheck($param ,"search_txt")) {
                $val = substr($param["search_txt"], 1, -1);
                $query .= "\n   AND  after_name LIKE '%" . $val . "%'";
            }

            if ($this->blankParameterCheck($param ,"sorting")) {
                $sorting = substr($param["sorting"], 1, -1);
                $query .= "\n ORDER BY " . $sorting;

                if ($this->blankParameterCheck($param ,"sorting_type")) {
                    $sorting_type = substr($param["sorting_type"], 1, -1);
                    $query .= " " . $sorting_type;
                }
            }

            if ($this->blankParameterCheck($param ,"s_num")) {
                $s_num = substr($param["s_num"], 1, -1);
            }

            if ($this->blankParameterCheck($param ,"list_num")) {
                $list_num = substr($param["list_num"], 1, -1);
            }

            if ($this->blankParameterCheck($param ,"s_num") &&
                $this->blankParameterCheck($param ,"list_num") &&
                $dvs != "COUNT") {
                $query .= "\nLIMIT ". $s_num . ", " . $list_num;
            }
        }

        return $conn->Execute($query);
    }

    /**
     * @brief 카테고리 옵션 정보 검색
     *
     * @param $conn  = connection identifier
     * @param $dvs   = 정보 구분
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function selectCateOptInfo($conn, $dvs, $param) {

        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);

        if ($dvs === "OPT_NAME") {
            $query  = "\n SELECT  DISTINCT opt_name";
        } else if ($dvs === "DEPTH1") {
            $query  = "\n SELECT  DISTINCT depth1";
        } else if ($dvs === "DEPTH2") {
            $query  = "\n SELECT  DISTINCT depth2";
        } else if ($dvs === "DEPTH3") {
			$query  = "\n SELECT  DISTINCT depth3";
        //카운트
        } else if ($dvs === "COUNT") {
            $query  = "\nSELECT  COUNT(*) AS cnt";
        } else if ($dvs === "SEQ") {
            $query  = "\n SELECT  A.opt_name";
            $query .= "\n        ,A.depth1";
            $query .= "\n        ,A.depth2";
            $query .= "\n        ,A.depth3";
            $query .= "\n        ,B.mpcode";
            $query .= "\n        ,B.basic_yn";
            $query .= "\n        ,B.cate_opt_seqno";
        }

        $query .= "\n   FROM  prdt_opt AS A";
        $query .= "\n        ,cate_opt AS B";

        $query .= "\n  WHERE  A.prdt_opt_seqno = B.prdt_opt_seqno";

        if ($this->blankParameterCheck($param, "cate_sortcode")) {
            $query .= "\n    AND  B.cate_sortcode = ";
            $query .= $param["cate_sortcode"];
        }
        //카테고리 분류코드 LIKE
        if ($this->blankParameterCheck($param ,"cate_sortcode_like")) {
            $val = substr($param["cate_sortcode_like"], 1, -1);
            $query .= "\n   AND  cate_sortcode LIKE '" . $val. "%'";
        }
        if ($this->blankParameterCheck($param, "basic_yn")) {
            $query .= "\n    AND  B.basic_yn = ";
            $query .= $param["basic_yn"];
        }
        if ($this->blankParameterCheck($param, "opt_name")) {
            $query .= "\n    AND  A.opt_name = ";
            $query .= $param["opt_name"];
        }
        if ($this->blankParameterCheck($param, "depth1")) {
            $query .= "\n    AND  A.depth1 = ";
            $query .= $param["depth1"];
        }
        if ($this->blankParameterCheck($param, "depth2")) {
            $query .= "\n    AND  A.depth2 = ";
            $query .= $param["depth2"];
        }
        if ($this->blankParameterCheck($param, "depth3")) {
            $query .= "\n    AND  A.depth3 = ";
            $query .= $param["depth3"];
        }

        //옵션 일련번호
        if ($this->blankParameterCheck($param ,"seqno")) {
            $query .= "\n   AND  cate_opt_seqno = $param[seqno]";
        }

        if ($dvs === "SEQ" || $dvs === "COUNT") {

            if ($this->blankParameterCheck($param ,"search_txt")) {
                $val = substr($param["search_txt"], 1, -1);
                $query .= "\n   AND  opt_name LIKE '%" . $val . "%'";
            }

            if ($this->blankParameterCheck($param ,"sorting")) {
                $sorting = substr($param["sorting"], 1, -1);
                $query .= "\n ORDER BY " . $sorting;

                if ($this->blankParameterCheck($param ,"sorting_type")) {
                    $sorting_type = substr($param["sorting_type"], 1, -1);
                    $query .= " " . $sorting_type;
                }
            }

            if ($this->blankParameterCheck($param ,"s_num")) {
                $s_num = substr($param["s_num"], 1, -1);
            }

            if ($this->blankParameterCheck($param ,"list_num")) {
                $list_num = substr($param["list_num"], 1, -1);
            }

            if ($this->blankParameterCheck($param ,"s_num") &&
                $this->blankParameterCheck($param ,"list_num") &&
                $dvs != "COUNT") {
                $query .= "\nLIMIT ". $s_num . ", " . $list_num;
            }
        }

        return $conn->Execute($query);
    }

    /*
     * 생산 제조사 Select
     * $conn : DB Connection
     * $param : $param["pur_prdt"] = "매입제품"
     * $param : $param["search_str"] = "검색어"
     * return : resultSet
     */
    function selectPrdcManu($conn, $param) {

        if (!$this->connectionCheck($conn)) return false;
        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n    SELECT  extnl_etprs_seqno";
        $query .= "\n           ,manu_name";
        $query .= "\n      FROM  extnl_etprs";
        $query .= "\n     WHERE  pur_prdt =" . $param["pur_prdt"];

        if ($this->blankParameterCheck($param ,"search")) {

            $search_str = substr($param["search"], 1, -1);

            $query .= "\n       AND  manu_name like '%" . $search_str . "%' ";

        }

        $query .= "\n  ORDER BY extnl_etprs_seqno";

        $result = $conn->Execute($query);
        return $result;
    }

    /*
     * 생산 브랜드 Select
     * $conn : DB Connection
     * $param : $param["manu_name"] = "매입제품"
     * return : resultSet
     */
    function selectPrdcBrand($conn, $param) {

        if (!$this->connectionCheck($conn)) return false;
        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n    SELECT  A.name";
        $query .= "\n           ,A.extnl_brand_seqno";
        $query .= "\n      FROM  extnl_brand A";
        $query .= "\n           ,extnl_etprs B";
        $query .= "\n     WHERE  A.extnl_etprs_seqno = B.extnl_etprs_seqno";

        if ($this->blankParameterCheck($param ,"manu_seqno")) {

            $query .= "\n       AND  B.extnl_etprs_seqno =" . $param["manu_seqno"];

        }

        if ($this->blankParameterCheck($param ,"search")) {

            $search_str = substr($param["search"], 1, -1);

            $query .= "\n       AND  A.name like '%" . $search_str . "%' ";

        }

        $result = $conn->Execute($query);
        return $result;
    }

    /*
     * 후공정, 옵션 depth명 Select
     * $conn : DB Connection
     * $param : $param["name"] = "후공정명or depth1명 or depth2명"
     * $param : $param["depth"] = "depth 레벨"
     * $param : $param["table"] = "테이블명"
     * return : resultSet
     */
    function selectPrdcDepthName($conn, $param) {

        if (!$this->connectionCheck($conn)) return false;
        $param = $this->parameterArrayEscape($conn, $param);

        $depth = substr($param["depth"], 1, -1);
        $table = substr($param["table"], 1, -1);

        $query  = "\n    SELECT  DISTINCT " . $depth;
        $query .= "\n      FROM  " . $table;

        if ($this->blankParameterCheck($param ,"name")) {

            //depth1
            if ($depth == "depth1") {

                $query .= "\n   WHERE  name =" . $param["name"];
            //depth2
            } else if ($depth == "depth2") {

                $query .= "\n   WHERE  depth1 =" . $param["name"];
            //depth3
            } else {

                $query .= "\n   WHERE  depth2 =" . $param["name"];
            }

        }

        $result = $conn->Execute($query);
        return $result;
    }

    /**
     * @brief 넘어온 카테고리 분류코드에 해당하는
     * 카테고리명 반환
     *
     * @detail 후공정, 인쇄 판매가격에서 사용함
     *
     * @param $conn
     * @param $cate_sortcode = 카테고리 분류코드
     *
     * @return 카테고리명
     */
    function selectCateName($conn, $cate_sortcode) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $cate_sortcode = $this->parameterEscape($conn, $cate_sortcode);

        $query  = "\n SELECT cate_name";
        $query .= "\n   FROM cate";
        $query .= "\n  WHERE sortcode = %s";

        $query  = sprintf($query, $cate_sortcode);

        $rs = $conn->Execute($query);

        return $rs->fields["cate_name"];
    }

    /**
     * @brief 판매채널명 검색
     *
     * @param $conn  = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 판매채널명
     */
    function selectSellSiteName($conn, $param = array()) {
        $temp = array();
        $temp["col"]   = "sell_site";
        $temp["table"] = "cpn_admin";
        if ($this->blankParameterCheck($param, "seqno")) {
            $temp["where"]["cpn_admin_seqno"] = $param["seqno"];
        }

        $rs = $this->selectData($conn, $temp);

        return $rs->fields["sell_site"];
    }
}

