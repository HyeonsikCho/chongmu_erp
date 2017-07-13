<?
/**
 * @file EngineSellPriceFunc.php
 *
 * @brief 판매가격 엑셀 업로드시 작업을 수행하는 클래스
 */

include_once(dirname(__FILE__) . '/common/EngineFuncInterface.php');
include_once(dirname(__FILE__) . '/common/EngineCommon.php');
include_once(dirname(__FILE__) . '/dao/EngineDAO.php');
include_once(dirname(__FILE__) . '/define/common.php');

class EngineSellPriceFunc implements EngineFuncInterface {

    function __construct() {
    }

    /**
     * @brief 파라미터를 받아서 해당하는 생산 항목의 가격을 입력하는 함수
     * 
     * @param $param = 정보 파라미터
     *
     * @return 작업실행 성공여부
     */
    function execute($param) {
        $ret = false;

        $param = explode('!', $param);

        $dvs = $param[0];
		
		switch ($dvs) {
			case "PLY":
				$ret = $this->plyPriceFunc($param);
				break;
			case "PAPER":
				$ret = $this->paperSellPriceFunc($param);
				break;
			case "OUTPUT":
				$ret = $this->outputSellPriceFunc($param);
				break;
			case "PRINT":
				$ret = $this->printSellPriceFunc($param);
				break;
			case "AFTER":
				$ret = $this->afterSellPriceFunc($param);
				break;
			case "OPTION":
				$ret = $this->optSellPriceFunc($param);
				break;
		}

        return $ret;
    }

    /**
     * @brief 업로드한 엑셀이 합판 판매가격일 때 실행하는 함수
     * 
     * @details 엔진으로 넘기는 파라미터로는<br/>
     * 구분!파일저장경로!파일명!판매채널<br/>
     * 이다
     * 
     * @param $param = 정보 파라미터
     * 
     * @return 작업실행 성공여부
     */
    function plyPriceFunc($param) {
        $util = new EngineCommon();

        $base_path = dirname(__FILE__);

        $sell_site = $param[3];

        $excel_path = sprintf("%s/%s", $param[1], $param[2]);

        $engine_path = sprintf("%s/proc_engine/ply/%s.php", $base_path
                                                          , "PlyPriceEngine");

        $command = sprintf("%s %s %s %s > %s &", $engine_path
                                               , $excel_path
                                               , $base_path
                                               , $sell_site
                                               , REDIR_PATH);
        system($command);

        $util->checkProcess("PlyPriceEngine");

        $fp = fopen($base_path . "/log/PlyPrice.log", "r");

        $ret_check = "";

        while (($buffer = fgets($fp, 512)) !== false) {
            $ret_check .= $buffer;
        }

        fclose($fp);

        return $util->checkFail($ret_check);
    }

    /**
     * @brief 업로드한 엑셀이 종이 판매가격일 때 실행하는 함수
     * 
     * @details 엔진으로 넘기는 파라미터로는<br/>
     * 구분!파일저장경로!파일명<br/>
     * 이다
     * 
     * @param $param = 정보 파라미터
     * 
     * @return 작업실행 성공여부
     */
    function paperSellPriceFunc($param) {
        $util = new EngineCommon();

        $base_path = dirname(__FILE__);

        $excel_path = sprintf("%s/%s", $param[1], $param[2]);

        $engine_path = sprintf("%s/proc_engine/paper/%s.php", $base_path
                                                            , "PaperSellPriceEngine");

        $command = sprintf("%s %s %s > %s &", $engine_path
                                            , $excel_path
                                            , $base_path
                                            , REDIR_PATH);
        system($command);

        $util->checkProcess("PaperSellPriceEngine");

        $fp = fopen($base_path . "/log/PaperSellPrice.log", "r");

        $ret_check = "";

        while (($buffer = fgets($fp, 512)) !== false) {
            $ret_check .= $buffer;
        }

        fclose($fp);

        return $util->checkFail($ret_check);
    }

    /**
     * @brief 업로드한 엑셀이 출력 판매가격일 때 실행하는 함수
     * 
     * @details 엔진으로 넘기는 파라미터로는<br/>
     * 구분!파일저장경로!파일명<br/>
     * 이다
     * 
     * @param $param = 정보 파라미터
     * 
     * @return 작업실행 성공여부
     */
    function outputSellPriceFunc($param) {
        $util = new EngineCommon();

        $base_path = dirname(__FILE__);

        $excel_path = sprintf("%s/%s", $param[1], $param[2]);

        $engine_path = sprintf("%s/proc_engine/output/%s.php", $base_path
                                                             , "OutputSellPriceEngine");

        $command = sprintf("%s %s %s > %s &", $engine_path
                                            , $excel_path
                                            , $base_path
                                            , REDIR_PATH);
        system($command);

        $util->checkProcess("OutputSellPriceEngine");

        $fp = fopen($base_path . "/log/OutputSellPrice.log", "r");

        $ret_check = "";

        while (($buffer = fgets($fp, 512)) !== false) {
            $ret_check .= $buffer;
        }

        fclose($fp);

        return $util->checkFail($ret_check);
    }

    /**
     * @brief 업로드한 엑셀이 인쇄 판매가격일 때 실행하는 함수
     * 
     * @details 엔진으로 넘기는 파라미터로는<br/>
     * 구분!파일저장경로!파일명<br/>
     * 이다
     * 
     * @param $param = 정보 파라미터
     * 
     * @return 작업실행 성공여부
     */
    function printSellPriceFunc($param) {
        $util = new EngineCommon();

        $base_path = dirname(__FILE__);

        $excel_path = sprintf("%s/%s", $param[1], $param[2]);

        $engine_path = sprintf("%s/proc_engine/print/%s.php", $base_path
                                                            , "PrintSellPriceEngine");

        $command = sprintf("%s %s %s > %s &", $engine_path
                                            , $excel_path
                                            , $base_path
                                            , REDIR_PATH);
        system($command);

        $util->checkProcess("PrintSellPriceEngine");

        $fp = fopen($base_path . "/log/PrintSellPrice.log", "r");

        $ret_check = "";

        while (($buffer = fgets($fp, 512)) !== false) {
            $ret_check .= $buffer;
        }

        fclose($fp);

        return $util->checkFail($ret_check);
    }

    /**
     * @brief 업로드한 엑셀이 후공정 판매가격일 때 실행하는 함수
     * 
     * @details 엔진으로 넘기는 파라미터로는<br/>
     * 구분!파일저장경로!파일명<br/>
     * 이다
     * 
     * @param $param = 정보 파라미터
     * 
     * @return 작업실행 성공여부
     */
    function afterSellPriceFunc($param) {
        $util = new EngineCommon();

        $base_path = dirname(__FILE__);

        $excel_path = sprintf("%s/%s", $param[1], $param[2]);

        $engine_path = sprintf("%s/proc_engine/after/%s.php", $base_path
                                                            , "AfterSellPriceEngine");

        $command = sprintf("%s %s %s > %s &", $engine_path
                                            , $excel_path
                                            , $base_path
                                            , REDIR_PATH);
        system($command);

        $util->checkProcess("AfterSellPriceEngine");

        $fp = fopen($base_path . "/log/AfterSellPrice.log", "r");

        $ret_check = "";

        while (($buffer = fgets($fp, 512)) !== false) {
            $ret_check .= $buffer;
        }

        fclose($fp);

        return $util->checkFail($ret_check);
    }

    /**
     * @brief 업로드한 엑셀이 옵션 판매가격일 때 실행하는 함수
     * 
     * @details 엔진으로 넘기는 파라미터로는<br/>
     * 구분!파일저장경로!파일명<br/>
     * 이다
     * 
     * @param $param = 정보 파라미터
     * 
     * @return 작업실행 성공여부
     */
    function optSellPriceFunc($param) {
        $util = new EngineCommon();

        $base_path = dirname(__FILE__);

        $excel_path = sprintf("%s/%s", $param[1], $param[2]);

        $engine_path = sprintf("%s/proc_engine/option/%s.php", $base_path
                                                             , "OptSellPriceEngine");

        $command = sprintf("%s %s %s > %s &", $engine_path
                                            , $excel_path
                                            , $base_path
                                            , REDIR_PATH);
        system($command);

        $util->checkProcess("OptSellPriceEngine");

        $fp = fopen($base_path . "/log/OptSellPrice.log", "r");

        $ret_check = "";

        while (($buffer = fgets($fp, 512)) !== false) {
            $ret_check .= $buffer;
        }

        fclose($fp);

        return $util->checkFail($ret_check);
    }
}
?>
