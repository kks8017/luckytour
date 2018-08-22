function overlays_view (overid,layerid) {
        $("#" + layerid).show();
        $("." + layerid).show();
        $("." + overid).show();

}
function overlays_close (overid,layerid) {
    $("#" + layerid).hide();
    $("." + layerid).hide();
    $("." + overid).hide();
}
//콤마넣기
function set_comma(str) {
    str = String(str);
    return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
}

//콤마풀기
function get_comma(str) {
    str = String(str);
    return str.replace(/[^\d]+/g, '');
}



