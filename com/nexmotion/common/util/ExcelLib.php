<?
/**
 * @file ExcelUtil.php
 *
 * @brief 다운로드할 엑셀파일 생성유틸
 */

include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/common/excel/PHPExcel.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/define/excel_define.php');

class ExcelLib {

    // 자리수 두 자리 일 때의 시작 열 인덱스
    const EXCEL_2007_DIGIT_2 = 26;
    // 자리수 세 자리 일 때의 시작 열 인덱스
    const EXCEL_2007_DIGIT_3 = 702; 
    // 엑셀 2007버전의 최대 열 개수
    const EXCEL_2007_MAX_COL = 16384;

    // 열 계산용 알파벳 배열
    const ALPABET = array( 0  => 'A'
                          ,1  => 'B'
                          ,2  => 'C'
                          ,3  => 'D'
                          ,4  => 'E'
                          ,5  => 'F'
                          ,6  => 'G'
                          ,7  => 'H'
                          ,8  => 'I'
                          ,9  => 'J'
                          ,10 => 'K'
                          ,11 => 'L'
                          ,12 => 'M'
                          ,13 => 'N'
                          ,14 => 'O'
                          ,15 => 'P'
                          ,16 => 'Q'
                          ,17 => 'R'
                          ,18 => 'S'
                          ,19 => 'T'
                          ,20 => 'U'
                          ,21 => 'V'
                          ,22 => 'W'
                          ,23 => 'X'
                          ,24 => 'Y'
                          ,25 => 'Z');

    // 스타일 상수
    // 넘버링 포멧
    const NUMBER_FORMAT_CODE = '#,##0';
    // 글자 수평, 수직정렬
    const H_CENTER = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
    const H_RIGHT  = PHPExcel_Style_Alignment::HORIZONTAL_RIGHT;
    const V_CENTER = PHPExcel_Style_Alignment::VERTICAL_CENTER;
    // 셀 테두리
    const BORDER_THIN   = PHPExcel_Style_Border::BORDER_THIN;
    const BORDER_THICK  = PHPExcel_Style_Border::BORDER_THICK;
    const BORDER_DOTTED = PHPExcel_Style_Border::BORDER_DOTTED;
    // 셀 배경색
    const YELLOW = 'FFFF00';
    const GRAY   = 'F2F2F2';
    // 셀 보안
    const CELL_UNLOCK = PHPExcel_Style_Protection::PROTECTION_UNPROTECTED;
    const CELL_LOCK = PHPExcel_Style_Protection::PROTECTION_PROTECTED;

    var $obj_PHPExcel; // 엑셀파일객체
    var $active_sheet; // 현재 워크시트

    var $price_info_row_idx;  // 가격정보 행 끝 위치
    var $price_row_idx;   // 가격 행 시작위치
    var $chunk_col_count; // 정보 한 덩어리가 몇 개의 셀인지 저장하는 값
    var $chunk_col_remainder; // 정보 한 덩어리를 순회할 때 시작위치값(% 연산시 나머지값)

    function __construct() {
    }

    /**
     * @brief 업로드한 엑셀파일을 이동하고
     * 정보 초기화
     *
     * @param $price_info_row_idx  = 항목 정보 행이 끝나는 위치
     * @param $chunk_col_count     = 가격정보 셀의 개수
     * @param $chunk_col_remainder = 가격정보 시작위치용 변수
     */
    function initExcelFileWriteInfo($price_info_row_idx,
                                    $chunk_col_count,
                                    $chunk_col_remainder) {

        $this->obj_PHPExcel = new PHPExcel();

        $this->price_info_row_idx = $price_info_row_idx;
        $this->price_row_idx = $price_info_row_idx + 2;
        $this->chunk_col_count = $chunk_col_count;
        $this->chunk_col_remainder = $chunk_col_remainder;
    }

    /**
     * @brief 사용자가 검색한 조건으로 엑셀시트를 생성한다.
     *
     * @detail $price_info_dvs_arr 같은 경우에는 시작 인덱스가 1부터이기 때문에
     * 1 -> 2 -> 3 -> ... -> 0(마지막) 순으로 값을 넣는다
     *
     * @param $sheet_name         = 엑셀파일 워크시트명
     * @param $info_dvs_arr       = 각 시트 A열에 들어가는 정보 항목명(제조사 등)
     * @param $info_arr           = 정보 배열, 상단부분 만드는데 사용
     * @param $price_info_dvs_arr = 가격 정보 구분 배열(기존금액, 요율 등)
     * @param $price_dvs_arr      = 가격 구분 배열(평량, 판 수 등)
     * @param $price_arr          = 가격 배열
     * @param $flattyp_yn         = 낱장 여부
     */
    function makePriceExcelSheet($sheet_name,
                                 $info_dvs_arr,
                                 $info_arr,
                                 $price_info_dvs_arr,
                                 $price_dvs_arr,
                                 $price_arr,
                                 $flattyp_yn = true) {

        // 정보를 입력할 워크시트 생성
        // 시트명이 숫자일 경우 시트생성이 안되는 경우 존재
        $sheet_name = strval($sheet_name);
        $this->active_sheet = $this->createSheet($sheet_name);

        // 정보부분 생성
        $this->makePriceExcelTitle($info_arr,
                                   $info_dvs_arr,
                                   $price_info_dvs_arr);

        // 가격부분 생성
        $info_arr_count = count($info_arr) * $this->chunk_col_count;
                
        $price_arr = $this->makePriceArr($price_dvs_arr, $price_arr);

        if ($flattyp_yn === true) {
            $this->makePlyPriceExcelBody($price_dvs_arr,
                                         $price_arr,
                                         $info_arr_count);
        } else {
            $this->makeCalcPriceExcelBody($price_dvs_arr,
                                          $price_arr,
                                          $info_arr_count);
        }
    }

    /**
     * makePriceExcel에서 사용하는 함수로써
     * 종이 정보 부분을 생성한다.
     */
    function makePriceExcelTitle($info_arr,
                                 $info_dvs_arr,
                                 $price_info_dvs_arr) {
        /*
         * A열
         */
        $info_dvs_count = count($info_dvs_arr);

        for ($i = 1; $i <= $info_dvs_count; $i++) {
            $info = $info_dvs_arr[$i];
            $cell_name = "A" . $i;

            $this->active_sheet->setCellValue($cell_name, $info);
            // 글자 설정
            $this->setCellHAlign($cell_name, self::H_CENTER);
            $this->setBold($cell_name);
            $this->setFontSize($cell_name, 10);
            // 테두리 설정
            if ($i === $info_dvs_count) {
                $this->setCellBorderEach($cell_name,
                                         "bottom",
                                         self::BORDER_THIN);
                $this->setCellBorderEach($cell_name,
                                         "left",
                                         self::BORDER_DOTTED);
                $this->setCellBorderEach($cell_name,
                                         "right",
                                         self::BORDER_DOTTED);
            } else {
                $this->setCellBorder($cell_name, self::BORDER_DOTTED);
            }
            // 배경색 설정
            $this->setCellBgColor($cell_name, self::YELLOW);
        }

        $info_arr_count = count($info_arr) * $this->chunk_col_count;

        /*
         * 종이 정보 부분
         */
        for ($row_idx = 1; $row_idx <= $this->price_info_row_idx; $row_idx++) {

            // 병합 시작 셀 구하기용 변수
            $d1 = 1;
            $d2 = 0;
            $d3 = 0;

            // 병합 끝 셀 구하기용 변수
            $d1_last = 0;
            $d2_last = 0;
            $d3_last = 0;

            $k = 0; // $info_arr 인덱스용

            // A열은 이미 사용했으므로 1부터 시작
            for ($col_idx = 1; $col_idx <= $info_arr_count; $col_idx++) {

                $col_name = "";
                $col_name_last = "";

                // 이하 조건문은 현재 위치한 샐의 열 인덱스를 구하기 위한 조건문임
                if ($col_idx < self::EXCEL_2007_DIGIT_2) {
                    // 자리수가 한 자리 일 때

                    $col_name = self::ALPABET[$d1++ % 26];

                    if ($d1 === 26) {
                        $d1 = 0;
                    }

                } else if (self::EXCEL_2007_DIGIT_2 <= $col_idx
                                && $col_idx < self::EXCEL_2007_DIGIT_3) {
                    // 자리수가 두 자리 일 때

                    $col_name = sprintf("%s%s", self::ALPABET[$d2 % 26]
                                              , self::ALPABET[$d1++ % 26]);

                    if ($d1 === 26) {
                        $d1 = 0;
                        $d2++;
                    }

                } else if (self::EXCEL_2007_DIGIT_3 <= $col_idx
                                && $col_idx <= self::EXCEL_2007_MAX_COL) {
                    // 자리수가 세 자리 일 때

                    $col_name = sprintf("%s%s%s", self::ALPABET[$d3 % 26]
                                                , self::ALPABET[$d2 % 26]
                                                , self::ALPABET[$d1++ % 26]);

                    if ($d1 === 26) {
                        $d1 = 0;
                        $d2++;

                        if ($d2 === 26) {
                            $d2 = 0;
                            $d3++;
                        }
                    }
                }

                // 이하 조건문은 현재 병합할 샐의 마지막 열 인덱스를 구하기 위한 조건문임
                /*
                 * 현재 위치를 기준으로 몇 칸을 더 병합해야 하는지에 대한 값
                 *
                 * ex) 종이 가격의 경우 총 7칸을 병합해야 하는데 그렇다는 것은
                 *     현재 셀을 기준으로 6칸($this->chunk_col_count - 1)을
                 *     더 병합해야 하므로 현재 인덱스에서 6칸 증가
                 */
                $temp_col_idx = $col_idx + ($this->chunk_col_count - 1); 
                /*
                 * 병합해야 되는 셀에서 마지막 셀의 첫 번째 열 인덱스를 구함
                 *
                 * ex) 위의 ++연산 때문에 그대로 6을 더할 경우 7칸 째 인덱스를 잡게 됨
                 *     따라서 6을 더하고 1을 뺌, 즉 5를 더해줌
                 */
                $temp_d1 = $d1 + ($this->chunk_col_count - 2); 
                /*
                 * A~Z 중 어느 열인지 구함.
                 * 두자리, 세자리 일 경우에는 첫 번째 자리 열을 구하는 용도
                 */
                $d1_last = ($temp_d1 > 25) ? ($temp_d1 - 26) : $temp_d1;

                if ($temp_col_idx < self::EXCEL_2007_DIGIT_2) {
                    // 자리수가 한 자리 일 때

                    $col_name_last = self::ALPABET[$d1_last];

                } else if (self::EXCEL_2007_DIGIT_2 <= $temp_col_idx
                        && $temp_col_idx < self::EXCEL_2007_DIGIT_3) {
                    // 자리수가 두 자리 일 때

                    $col_name_last = sprintf("%s%s", self::ALPABET[$d2_last]
                                                   , self::ALPABET[$d1_last]);

                    // 첫 번째 자리가 Z이면 두 번째 자리는 다음 자리로 바뀌어야됨
                    if ($d1_last === 25) $d2_last = $d2 + 1;

                } else if (self::EXCEL_2007_DIGIT_3 <= $temp_col_idx
                        && $temp_col_idx <= self::EXCEL_2007_MAX_COL) {
                    // 자리수가 세 자리 일 때

                    $col_name_last = sprintf("%s%s%s", self::ALPABET[$d3_last]
                                                     , self::ALPABET[$d2_last]
                                                     , self::ALPABET[$d1_last]);

                    // 첫 번째  Z이면 두 번째 자리는 다음 자리로 바뀌어야됨
                    if ($d1_last === 25) $d2_last = $d2 + 1;
                    // 두 번째 자리가 Z이면 세 번째 자리는 다음 자리로 바뀌어야됨
                    if ($d2_last === 25) $d3_last = $d3 + 1;
                    // 두 번째 자리가 알파벳 수를 넘었을 경우 초기화
                    if ($d2_last === 26) $d2_last = 0;
                }

                if (($col_idx % $this->chunk_col_count) === $this->chunk_col_remainder) {
                    /*
                     * 정보셀을 병합하고 값을 입력
                     */

                    // 한 덩어리 병함
                    $merge_cells = sprintf("%s%s:%s%s", $col_name, $row_idx
                                                      , $col_name_last, $row_idx);
                    $this->mergeCells($merge_cells);
                    $this->setCellBorderTopBot($merge_cells,
                                               self::BORDER_DOTTED);
                    $this->setCellBorderLeftRight($merge_cells,
                                                  self::BORDER_THICK);
                    $this->setCellHAlign($merge_cells, self::H_CENTER);
                    $this->setCellBgColor($merge_cells, self::GRAY);
                    $this->setFontSize($merge_cells, 10);
                    
                    // 정보
                    $temp_arr = explode('|', $info_arr[$k++]);
                    $cell_value = $temp_arr[$row_idx - 1];
                    $cell_value = ($cell_value === "") ? '-' : $cell_value;

                    $this->active_sheet
                         ->setCellValueByColumnAndRow($col_idx,
                                                      $row_idx,
                                                      $cell_value);
                }
            }
        }

        /*
         * 가격 구분 행
         */

        $d1 = 1;
        $d2 = 0;
        $d3 = 0;

        $row_idx = $this->price_info_row_idx + 1;

        // A열은 이미 사용했으므로 1부터 시작
        for ($col_idx = 1; $col_idx <= $info_arr_count; $col_idx++) { 

            $col_name = "";

            // 이하 조건문은 현재 위치한 샐의 열 인덱스를 구하기 위한 조건문임
            if ($col_idx < self::EXCEL_2007_DIGIT_2) {
                /**
                 * 자리수가 한 자리 일 때
                 */

                $col_name = sprintf("%s", self::ALPABET[$d1++ % 26]);

                if ($d1 === 26) {
                    $d1 = 0;
                }

            } else if (self::EXCEL_2007_DIGIT_2 <= $col_idx
                    && $col_idx < self::EXCEL_2007_DIGIT_3) {
                /**
                 * 자리수가 두 자리 일 때
                 */

                $col_name = sprintf("%s%s", self::ALPABET[$d2 % 26]
                                          , self::ALPABET[$d1++ % 26]);

                if ($d1 === 26) {
                    /**
                     * 첫 번째 자리수의 인덱스가 알파벳 개수를 넘어갔을 때
                     */

                    $d1 = 0;
                    $d2++;
                }

            } else if (self::EXCEL_2007_DIGIT_3 <= $col_idx
                    && $col_idx <= self::EXCEL_2007_MAX_COL) {
                /**
                 * 자리수가 세 자리 일 때
                 */

                $col_name = sprintf("%s%s%s", self::ALPABET[$d3 % 26]
                                            , self::ALPABET[$d2 % 26]
                                            , self::ALPABET[$d1++ % 26]);

                if ($d1 === 26) {
                    /**
                     * 첫 번째 자리수의 인덱스가 알파벳 개수를 넘어갔을 때
                     */

                    $d1 = 0;
                    $d2++;

                    if ($d2 === 26) {
                        /**
                         * 두 번째 자리수의 인덱스가 알파벳 개수를 넘어갔을 때
                         */

                        $d2 = 0;
                        $d3++;
                    }
                }
            }

            // 글자가 다 보이도록 셀 너비 일괄변경
            $this->setCellWidth($col_name, 13);

            // row_idx가 고정
            $col_name .= $row_idx;

            // 셀 디자인 설정
            $i = $col_idx % $this->chunk_col_count; // 가격 구분 인덱스

            $this->setCellBorderEach($col_name,
                                     "bottom",
                                     self::BORDER_THIN);
            if ($i === 0) {
                $this->setCellBorderEach($col_name,
                                         "left",
                                         self::BORDER_DOTTED);
                $this->setCellBorderEach($col_name,
                                         "right",
                                         self::BORDER_THICK);
                $this->setBold($col_name);
            } else if ($i === 1) {
                $this->setCellBorderEach($col_name,
                                         "left",
                                         self::BORDER_THICK);
                $this->setCellBorderEach($col_name,
                                         "right",
                                         self::BORDER_DOTTED);
            } else if ($i === 4) {
                $this->setBold($col_name);
            } else {
                $this->setCellBorderEach($col_name,
                                         "left",
                                         self::BORDER_DOTTED);
                $this->setCellBorderEach($col_name,
                                         "right",
                                         self::BORDER_DOTTED);
            }

            $this->setCellHAlign($col_name, self::H_CENTER);
            $this->setCellBgColor($col_name, self::GRAY);
            $this->setFontSize($col_name, 10);

            // 가격 정보 구분 값 입력
            $this->active_sheet
                 ->setCellValueByColumnAndRow($col_idx,
                                              $row_idx,
                                              $price_info_dvs_arr[$i]);
        }
    }

    /**
     * @biref makePriceExcel에서 사용하는 함수로써<br/>
     * 모든 rs를 돌면서 해당하는 평량의 정보를 한 줄로 이어붙임
     *
     * @param $price_dvs_arr = 가격 구분 배열(평량, 수량 etc...)
     * @param $price_arr     = 가격 배열
     *
     * @return 정렬된 가격 배열
     */
    function makePriceArr($price_dvs_arr,
                          $price_arr) {
        $price_dvs_arr_count = count($price_dvs_arr);
        $price_arr_count = count($price_arr);

        $ret_arr = array();

        $blank_price = "||||";

        for ($i = 0; $i < $price_dvs_arr_count; $i++) {
            $price_dvs = $price_dvs_arr[$i];

            $price_val = "";

            for ($j = 0; $j < $price_arr_count; $j++) {
                $price = $price_arr[$j][$price_dvs];

                if ($price === null || $price === "") {
                    $price_val .= $blank_price;
                } else {
                    $price_val .= '|' . $price;
                }

            }

            $ret_arr[$price_dvs] = $price_val;
        }

        return $ret_arr;
    }

    /**
     * @brief makePriceExcel에서 사용하는 함수로써
     * 확정형 가격 부분을 생성한다.
     *
     * @param $price_dvs_arr  = 가격 구분 배열
     * @param $price_arr      = 가격 배열
     * @param $info_arr_count = 항목 열의 총 개수
     */
    function makePlyPriceExcelBody($price_dvs_arr,
                                   $price_arr,
                                   $info_arr_count) {

        $formula_base = "=((%s/100)*%s)+%s+%s"; // 매입, 판매가격 수식 틀

        // 가격 시작 행 row부터 시작하기 때문에 더해줌
        $price_dvs_arr_count = count($price_dvs_arr) + $this->price_row_idx;

        $i = 0; // 가격 구분 배열 인덱스
        for ($row_idx = $this->price_row_idx; $row_idx < $price_dvs_arr_count; $row_idx++) {

            $price_dvs = $price_dvs_arr[$i++];
            $price = $price_arr[$price_dvs];
            $price_arr_temp = null;

            $cell_name = "A" . $row_idx;

            // A열 설정
            $this->setCellBorderEach($cell_name,
                                     "bottom",
                                     self::BORDER_DOTTED);
            $this->setCellBorderEach($cell_name,
                                     "left",
                                     self::BORDER_DOTTED);
            $this->setCellBorderEach($cell_name,
                                     "right",
                                     self::BORDER_DOTTED);

            $this->setBold($cell_name);
            $this->setFontSize($cell_name, 10);
            $this->setCellBgColor($cell_name, self::YELLOW);
            $this->setCellNumberFormatting($cell_name);

            $this->setCellBorderLeftRight($cell_name, self::BORDER_DOTTED);
            $this->active_sheet
                 ->setCellValueByColumnAndRow(0,
                                              $row_idx,
                                              $price_dvs);
            $this->setCellUnlock('A' . $row_idx);

            $j = 0; // 가격 배열에서 가격을 가져올 때 사용하는 인덱스
            $l = 0; // 가격을 실제 열에 넣을때 사용하는 인덱스

            $d1 = 1;
            $d2 = 0;
            $d3 = 0;

            $basic_price_col = "";
            $rate_col = "";
            $aplc_price_col = "";

            for ($col_idx = 1; $col_idx <= $info_arr_count; $col_idx++) {

                $col_name = "";
                $col_name_last = "";

                // 이하 조건문은 현재 위치한 샐의 열 인덱스를 구하기 위한 조건문임
                if ($col_idx < self::EXCEL_2007_DIGIT_2) {
                    /**
                     * 자리수가 한 자리 일 때
                     */

                    $col_name = self::ALPABET[$d1++ % 26];

                    if ($d1 === 26) {
                        $d1 = 0;
                    }

                } else if (self::EXCEL_2007_DIGIT_2 <= $col_idx
                        && $col_idx < self::EXCEL_2007_DIGIT_3) {
                    /**
                     * 자리수가 두 자리 일 때
                     */

                    $col_name = sprintf("%s%s", self::ALPABET[$d2 % 26]
                                              , self::ALPABET[$d1++ % 26]);

                    if ($d1 === 26) {
                        $d1 = 0;
                        $d2++;
                    }

                } else if (self::EXCEL_2007_DIGIT_3 <= $col_idx
                        && $col_idx <= self::EXCEL_2007_MAX_COL) {
                    /**
                     * 자리수가 세 자리 일 때
                     */

                    $col_name = sprintf("%s%s%s", self::ALPABET[$d3 % 26]
                                                , self::ALPABET[$d2 % 26]
                                                , self::ALPABET[$d1++ % 26]);

                    if ($d1 === 26) {
                        $d1 = 0;
                        $d2++;

                        if ($d2 === 26) {
                            $d2 = 0;
                            $d3++;
                        }
                    }
                }

                $col_name .= $row_idx;

                $this->setCellHAlign($col_name, self::H_RIGHT);
                $this->setCellNumberFormatting($col_name);
                $this->setFontSize($col_name, 10);

                // 가격 열 별 정보저장 및 가격 분리를 위한 인덱스
                $price_col_idx = $col_idx % $this->chunk_col_count;

                $price_arr_temp = explode("|", $price);

                if ($price_col_idx === 1) {
                    /*
                     * 가격정보를 입력하기 위한 조건문
                     * 열 이름을 가져오기 위해서 한꺼번에($col_idx, $col_idx+1 ...)
                     * 처리가 불가하므로 덩어리 단위로 정보교체
                     */

                    /*
                     * 기준가격열 저장
                     */

                    $basic_price_col = $col_name;

                    // 셀 스타일
                    if ($row_idx === $this->price_row_idx) {
                        $this->setCellBorderEach($col_name,
                                                 "bottom",
                                                 self::BORDER_DOTTED);
                        $this->setCellBorderEach($col_name,
                                                 "left",
                                                 self::BORDER_THICK);
                        $this->setCellBorderEach($col_name,
                                                 "right",
                                                 self::BORDER_DOTTED);
                    } else {
                        $this->setCellBorderEach($col_name,
                                                 "top",
                                                 self::BORDER_DOTTED);
                        $this->setCellBorderEach($col_name,
                                                 "bottom",
                                                 self::BORDER_DOTTED);
                        $this->setCellBorderEach($col_name,
                                                 "left",
                                                 self::BORDER_THICK);
                        $this->setCellBorderEach($col_name,
                                                 "right",
                                                 self::BORDER_DOTTED);
                    }

                } else if ($price_col_idx === 2) {
                    /*
                     * 매입 요율열 저장
                     */

                    $rate_col = $col_name;

                    // 셀 스타일
                    if ($row_idx === $this->price_row_idx) {
                        $this->setCellBorderEach($col_name,
                                                 "bottom",
                                                 self::BORDER_DOTTED);
                        $this->setCellBorderEach($col_name,
                                                 "left",
                                                 self::BORDER_DOTTED);
                        $this->setCellBorderEach($col_name,
                                                 "right",
                                                 self::BORDER_DOTTED);
                    } else {
                        $this->setCellBorder($col_name,
                                             self::BORDER_DOTTED);
                    }

                } else if ($price_col_idx === 3) {
                    /*
                     * 매입 적용가격열 저장
                     */

                    $aplc_price_col = $col_name;

                    // 셀 스타일
                    if ($row_idx === $this->price_row_idx) {
                        $this->setCellBorderEach($col_name,
                                                 "bottom",
                                                 self::BORDER_DOTTED);
                        $this->setCellBorderEach($col_name,
                                                 "left",
                                                 self::BORDER_DOTTED);
                        $this->setCellBorderEach($col_name,
                                                 "right",
                                                 self::BORDER_DOTTED);
                    } else {
                        $this->setCellBorder($col_name,
                                             self::BORDER_DOTTED);
                    }

                } 

                if ($price_col_idx === 0) {
                    /*
                     * 입력 셀이 판매가격일 경우
                     */

                    $formula = sprintf($formula_base, $rate_col
                                                    , $basic_price_col
                                                    , $basic_price_col
                                                    , $aplc_price_col);

                    $this->active_sheet
                         ->setCellValueByColumnAndRow($col_idx,
                                                      $row_idx,
                                                      $formula);
                    // 셀 스타일
                    $this->setBold($col_name);
                    if ($row_idx === $this->price_row_idx) {
                        $this->setCellBorderEach($col_name,
                                                 "bottom",
                                                 self::BORDER_DOTTED);
                        $this->setCellBorderEach($col_name,
                                                 "left",
                                                 self::BORDER_DOTTED);
                        $this->setCellBorderEach($col_name,
                                                 "right",
                                                 self::BORDER_THICK);
                    } else {
                        $this->setCellBorderEach($col_name,
                                                 "top",
                                                 self::BORDER_DOTTED);
                        $this->setCellBorderEach($col_name,
                                                 "bottom",
                                                 self::BORDER_DOTTED);
                        $this->setCellBorderEach($col_name,
                                                 "left",
                                                 self::BORDER_DOTTED);
                        $this->setCellBorderEach($col_name,
                                                 "right",
                                                 self::BORDER_THICK);
                    }

                } else {
                    // 셀 잠금 해제
                    $this->setCellUnlock($col_name);

                    $this->active_sheet
                         ->setCellValueByColumnAndRow($col_idx,
                                                      $row_idx,
                                                      $price_arr_temp[$col_idx]);
                }
            }
        }
    }

    /**
     * @brief makePriceExcel에서 사용하는 함수로써
     * 계산형 가격 부분을 생성한다.
     *
     * @param $price_dvs_arr  = 가격 구분 배열
     * @param $price_arr      = 가격 배열
     * @param $info_arr_count = 항목 열의 총 개수
     */
    function makeCalcPriceExcelBody($price_dvs_arr,
                                    $price_arr,
                                    $info_arr_count) {

        $formula_base = "=%s+%s+%s"; // 매입, 판매가격 수식 틀

        // 가격 시작 행 row부터 시작하기 때문에 더해줌
        $price_dvs_arr_count = count($price_dvs_arr) + $this->price_row_idx;

        $i = 0; // 가격 구분 배열 인덱스
        for ($row_idx = $this->price_row_idx; $row_idx < $price_dvs_arr_count; $row_idx++) {

            $price_dvs = $price_dvs_arr[$i++];
            $price = $price_arr[$price_dvs];
            $price_arr_temp = null;

            $cell_name = "A" . $row_idx;

            // A열 설정
            $this->setCellBorderEach($cell_name,
                                     "bottom",
                                     self::BORDER_DOTTED);
            $this->setCellBorderEach($cell_name,
                                     "left",
                                     self::BORDER_DOTTED);
            $this->setCellBorderEach($cell_name,
                                     "right",
                                     self::BORDER_DOTTED);

            $this->setBold($cell_name);
            $this->setFontSize($cell_name, 10);
            $this->setCellBgColor($cell_name, self::YELLOW);
            $this->setCellNumberFormatting($cell_name);

            $this->setCellBorderLeftRight($cell_name, self::BORDER_DOTTED);
            $this->active_sheet
                 ->setCellValueByColumnAndRow(0,
                                              $row_idx,
                                              $price_dvs);
            $this->setCellUnlock('A' . $row_idx);

            $j = 0; // 가격 배열에서 가격을 가져올 때 사용하는 인덱스
            $l = 0; // 가격을 실제 열에 넣을때 사용하는 인덱스

            $d1 = 1;
            $d2 = 0;
            $d3 = 0;

            $paper_price_col  = "";
            $print_price_col  = "";
            $output_price_col = "";

            for ($col_idx = 1; $col_idx <= $info_arr_count; $col_idx++) {

                $col_name = "";
                $col_name_last = "";

                // 이하 조건문은 현재 위치한 샐의 열 인덱스를 구하기 위한 조건문임
                if ($col_idx < self::EXCEL_2007_DIGIT_2) {
                    /**
                     * 자리수가 한 자리 일 때
                     */

                    $col_name = self::ALPABET[$d1++ % 26];

                    if ($d1 === 26) {
                        $d1 = 0;
                    }

                } else if (self::EXCEL_2007_DIGIT_2 <= $col_idx
                        && $col_idx < self::EXCEL_2007_DIGIT_3) {
                    /**
                     * 자리수가 두 자리 일 때
                     */

                    $col_name = sprintf("%s%s", self::ALPABET[$d2 % 26]
                                              , self::ALPABET[$d1++ % 26]);

                    if ($d1 === 26) {
                        $d1 = 0;
                        $d2++;
                    }

                } else if (self::EXCEL_2007_DIGIT_3 <= $col_idx
                        && $col_idx <= self::EXCEL_2007_MAX_COL) {
                    /**
                     * 자리수가 세 자리 일 때
                     */

                    $col_name = sprintf("%s%s%s", self::ALPABET[$d3 % 26]
                                                , self::ALPABET[$d2 % 26]
                                                , self::ALPABET[$d1++ % 26]);

                    if ($d1 === 26) {
                        $d1 = 0;
                        $d2++;

                        if ($d2 === 26) {
                            $d2 = 0;
                            $d3++;
                        }
                    }
                }

                $col_name .= $row_idx;

                $this->setCellHAlign($col_name, self::H_RIGHT);
                $this->setCellNumberFormatting($col_name);
                $this->setFontSize($col_name, 10);

                // 가격 열 별 정보저장 및 가격 분리를 위한 인덱스
                $price_col_idx = $col_idx % $this->chunk_col_count;

                $price_arr_temp = explode("|", $price);

                if ($price_col_idx === 1) {
                    /*
                     * 가격정보를 입력하기 위한 조건문
                     * 열 이름을 가져오기 위해서 한꺼번에($col_idx, $col_idx+1 ...)
                     * 처리가 불가하므로 덩어리 단위로 정보교체
                     */

                    // 종이가격 열 저장
                    $paper_price_col = $col_name;

                    // 셀 스타일
                    if ($row_idx === $this->price_row_idx) {
                        $this->setCellBorderEach($col_name,
                                                 "bottom",
                                                 self::BORDER_DOTTED);
                        $this->setCellBorderEach($col_name,
                                                 "left",
                                                 self::BORDER_THICK);
                        $this->setCellBorderEach($col_name,
                                                 "right",
                                                 self::BORDER_DOTTED);
                    } else {
                        $this->setCellBorderEach($col_name,
                                                 "top",
                                                 self::BORDER_DOTTED);
                        $this->setCellBorderEach($col_name,
                                                 "bottom",
                                                 self::BORDER_DOTTED);
                        $this->setCellBorderEach($col_name,
                                                 "left",
                                                 self::BORDER_THICK);
                        $this->setCellBorderEach($col_name,
                                                 "right",
                                                 self::BORDER_DOTTED);
                    }

                } else if ($price_col_idx === 2) {
                    // 인쇄가격열 저장
                    $print_price_col = $col_name;

                    // 셀 스타일
                    if ($row_idx === $this->price_row_idx) {
                        $this->setCellBorderEach($col_name,
                                                 "bottom",
                                                 self::BORDER_DOTTED);
                        $this->setCellBorderEach($col_name,
                                                 "left",
                                                 self::BORDER_DOTTED);
                        $this->setCellBorderEach($col_name,
                                                 "right",
                                                 self::BORDER_DOTTED);
                    } else {
                        $this->setCellBorder($col_name,
                                             self::BORDER_DOTTED);
                    }

                } else if ($price_col_idx === 3) {
                    // 출력가격열 저장
                    $output_price_col = $col_name;

                    // 셀 스타일
                    if ($row_idx === $this->price_row_idx) {
                        $this->setCellBorderEach($col_name,
                                                 "bottom",
                                                 self::BORDER_DOTTED);
                        $this->setCellBorderEach($col_name,
                                                 "left",
                                                 self::BORDER_DOTTED);
                        $this->setCellBorderEach($col_name,
                                                 "right",
                                                 self::BORDER_DOTTED);
                    } else {
                        $this->setCellBorder($col_name,
                                             self::BORDER_DOTTED);
                    }

                } 

                if ($price_col_idx === 0) {
                    // 판매가격
                    $formula = sprintf($formula_base, $paper_price_col
                                                    , $print_price_col
                                                    , $output_price_col);

                    $this->active_sheet
                         ->setCellValueByColumnAndRow($col_idx,
                                                      $row_idx,
                                                      $formula);
                    // 셀 스타일
                    $this->setBold($col_name);
                    if ($row_idx === $this->price_row_idx) {
                        $this->setCellBorderEach($col_name,
                                                 "bottom",
                                                 self::BORDER_DOTTED);
                        $this->setCellBorderEach($col_name,
                                                 "left",
                                                 self::BORDER_DOTTED);
                        $this->setCellBorderEach($col_name,
                                                 "right",
                                                 self::BORDER_THICK);
                    } else {
                        $this->setCellBorderEach($col_name,
                                                 "top",
                                                 self::BORDER_DOTTED);
                        $this->setCellBorderEach($col_name,
                                                 "bottom",
                                                 self::BORDER_DOTTED);
                        $this->setCellBorderEach($col_name,
                                                 "left",
                                                 self::BORDER_DOTTED);
                        $this->setCellBorderEach($col_name,
                                                 "right",
                                                 self::BORDER_THICK);
                    }

                } else {
                    // 셀 잠금 해제
                    $this->setCellUnlock($col_name);

                    $this->active_sheet
                         ->setCellValueByColumnAndRow($col_idx,
                                                      $row_idx,
                                                      $price_arr_temp[$col_idx]);
                }
            }
        }
    }

    /**
     * @brief 셀의 경계선 스타일을 상하좌우 위치별로 설정하는 함수
     * 배경색이 넘어올 경우 배경색도 변경한다
     *
     * @param $cells    = 스타일을 적용할 셀 번호(A1. B1. A1:A9 ...)
     * @param $position = 경계선을 적용할 위치(top, bottom, left, right)
     * @param $style    = 경계선 스타일
     */
    function setCellBorderEach($cells, $position, $style) {
        $style_arr = array();
        $style_arr["borders"][$position]["style"] = $style;

        $this->active_sheet
             ->getStyle($cells)
             ->applyFromArray($style_arr);
    }

    /**
     * 셀의 경계선 스타일을 상하만 변경 하는 함수
     *
     * $position : 경계선을 적용할 위치(top, bottom, left, right)
     * $style    : 경계선 스타일
     */
    function setCellBorderTopBot($cells, $style) {
        $style_arr = array();
        $style_arr["borders"]["top"]["style"] = $style;
        $style_arr["borders"]["bottom"]["style"] = $style;

        $this->active_sheet
             ->getStyle($cells)
             ->applyFromArray($style_arr);
    }

    /**
     * 셀의 경계선 스타일을 좌우만 변경 하는 함수
     *
     * $position : 경계선을 적용할 위치(top, bottom, left, right)
     * $style    : 경계선 스타일
     */
    function setCellBorderLeftRight($cells, $style) {
        $style_arr = array();
        $style_arr["borders"]["left"]["style"] = $style;
        $style_arr["borders"]["right"]["style"] = $style;

        $this->active_sheet
             ->getStyle($cells)
             ->applyFromArray($style_arr);
    }

    /**
     * 셀의 경계선 스타일을 상하좌우 전체 변경 하는 함수
     *
     * $position : 경계선을 적용할 위치(top, bottom, left, right)
     * $style    : 경계선 스타일
     */
    function setCellBorder($cells, $style) {
        $style_arr = array();
        $style_arr["borders"]["top"]["style"] = $style;
        $style_arr["borders"]["bottom"]["style"] = $style;
        $style_arr["borders"]["left"]["style"] = $style;
        $style_arr["borders"]["right"]["style"] = $style;

        $this->active_sheet
             ->getStyle($cells)
             ->applyFromArray($style_arr);
    }

    /**
     * 셀의 배경색을 채우는 함수
     *
     * FFFF00 - 노란색
     * F2F2F2 - 회색
     */
    function setCellBgColor($cells, $bg_color) {
        $style_arr = array();
        $style_arr['type'] = PHPExcel_Style_Fill::FILL_SOLID;
        $style_arr['startcolor'] = array('rgb' => $bg_color);

        $this->active_sheet
             ->getStyle($cells)
             ->getFill()
             ->applyFromArray($style_arr);
    }

    /**
     * 셀의 문자서식을 숫자형으로 변경하는 함수(1,111,111...)
     */
    function setCellNumberFormatting($cells) {
        $this->active_sheet
             ->getStyle($cells)
             ->getNumberFormat()
             ->setFormatCode(self::NUMBER_FORMAT_CODE);
    }

    /**
     * 셀의 수평정렬을 설정하는 함수
     *
     * PHPExcel_Style_Alignment::HORIZONTAL_CENTER : 가운데 정렬
     * PHPExcel_Style_Alignment::HORIZONTAL_RIGHT  : 오른쪽 정렬
     */
    function setCellHAlign($cells, $style) {
        $this->active_sheet
             ->getStyle($cells)
             ->getAlignment()
             ->setHorizontal($style);
    }

    /**
     * 셀의 수직정렬을 설정하는 함수
     *
     * PHPExcel_Style_Alignment::VERTICAL_TOP    : 상단 정렬
     * PHPExcel_Style_Alignment::VERTICAL_BOTTOM : 하단 정렬
     * PHPExcel_Style_Alignment::VERTICAL_CENTER : 가운데 정렬
     */
    function setCellVAlign($cells, $style) {
        $this->active_sheet
             ->getStyle($cells)
             ->getAlignment()
             ->setVertical($style);
    }

    /**
     * 글자를 bold 처리하는 함수
     */
    function setBold($cells) {
        $this->active_sheet
             ->getStyle($cells)
             ->getFont()
             ->setBold(TRUE);
    }

    /**
     * 셀의 글자크기를 설정하는 함수
     */
    function setFontSize($cells, $size) {
        $this->active_sheet
             ->getStyle($cells)
             ->getFont()
             ->setSize($size);
    }

    /**
     * 넘어온 셀 영역을 병합하는 함수
     */
    function mergeCells($cells) {
        $this->active_sheet->mergeCells($cells);
    }

    /**
     * 셀의 너비를 설정하는 함수
     */
    function setCellWidth($cells, $width) {
        $this->active_sheet
             ->getColumnDimension($cells)
             ->setWidth($width);
    }

    /**
     * 셀의 잠금을 푸는 함수
     */
    function setCellUnlock($cells) {
        $this->active_sheet->getStyle($cells)
                           ->getProtection()
                           ->setLocked(self::CELL_UNLOCK);
    }

    /**
     * 가격 구분 배열(평량, 수량 ...)을
     * 오름차순으로 정렬하는 함수
     */
    function sortPriceDvsArr($price_dvs_arr) {
        $temp_arr = array();

        foreach ($price_dvs_arr as $key => $val) {
            if (is_numeric($key)) {
                $temp_arr[$key] = $val;
            } else {
                $key = intval($key);
                $temp_arr[$key] = $val;
            }
        }

        ksort($temp_arr);

        return $temp_arr;
    }

    /**
     * @brief 워크시트를 생성하고 생성된 워크시트의 기본 글꼴을 변경한 후<br/>
     * 엑셀 객체에 시트를 추가한 뒤 워크시트 객체를 반환하는 함수
     *
     * @param $sheet_name = 워크시트명
     */
    function createSheet($sheet_name) {
        $sheet = new PHPExcel_Worksheet($this->obj_PHPExcel, $sheet_name);

        $this->obj_PHPExcel->addSheet($sheet);

        $sheet->getDefaultStyle()->getFont()->setName("맑은 고딕");

        // 보안정책 설정
        $sheet->getProtection()->setPassword('dprinting');
        $sheet->getProtection()->setSheet(true); // 필수
        $sheet->getProtection()->setSort(true);
        //$sheet->getProtection()->setInsertRows(false);

        return $sheet;
    }

    /**
     * @brief 실제 엑셀 결과파일을 생성하고<br/>
     * 첫 번째 시트(아무 내용도 없음)를 삭제한 후<br/>
     * 모든 연결을 끊어버리는 함수<br/>
     *
     * @param $file_name = 생성할 파일이름
     *
     * @return 엑셀파일 경로
     */
    function createExcelFile($file_name) {
        $file_path = DOWNLOAD_PATH . '/' . $file_name . ".xlsx";

        $sheet_index = $this->obj_PHPExcel
                            ->getIndex($this->obj_PHPExcel
                                            ->getSheetByName('Worksheet'));
        $this->obj_PHPExcel->removeSheetByIndex($sheet_index);

        $obj_writer = PHPExcel_IOFactory::createWriter($this->obj_PHPExcel,
                                                       'Excel2007');
        $obj_writer->save($file_path);

        $this->obj_PHPExcel->disconnectWorksheets();
        unset($this->obj_PHPExcel);

        return $file_path;
    }
}
?>
