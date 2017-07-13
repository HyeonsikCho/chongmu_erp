/**
 * @brief 주문상태값으로 진행상태값 불러옴
 *
 * @param dvs = 구분값
 * @param val = 주문상태값
 */
var loadStatusProc = {
    "dvs"  : null,
    "exec" : function(dvs, val) {
        this.dvs = dvs;

        var url = "/ajax/business/order_common_mng/load_status_proc.php";
        var data = {
            "val" : val
        };
        var callback = function(result) {
            $("#status_proc_" + loadStatusProc.dvs).html(result);
        };
    
        ajaxCall(url, "html", data, callback);
    }
};

/**
* @brief 웹로그인
*/
var webLogin = function(seqno) {
    var url = "/ajax/business/order_hand_regi/load_admin_hash.php";
    var callback = function(result) {
        window.open("http://dprinting.com/common/login.php?seqno=" + seqno + "&flag=" + result.trim(), "_blank");
    };

    showMask();
    ajaxCall(url, "html", {}, callback);
}
