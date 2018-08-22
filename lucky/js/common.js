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
function pack_type (package) {

    if (package == "AT") {

        $("#air_tab").removeClass("select").addClass("select");
        $("#rent_tab").removeClass("select");
        $("#air").css("display", "");
        $("#rent").css("display", "none");
        $("#lod").css("display", "");
        $("#air_tab").css("display", "");
        $("#rent_tab").css("display", "none");
        $("#lod_tab").css("display", "");
        $("#air_content").css("display", "");
        $("#rent_content").css("display", "none");
        $("#tel_content").css("display", "");
        $("#bus_content").css("display", "none");
        $("#golf_content").css("display", "none");
        $(".package_tabmenu ul li .air").css({backgroundColor: "#4474cc", color: "#fff"});
        $(".package_tabmenu ul li .rent").css({backgroundColor: "#fff", color: "#000"});
        $(".package_tabmenu ul li .lodge").css({backgroundColor: "#fff", color: "#000"});
        $(".air_area").show();
        $(".rent_area").hide();
        $(".bus_area").hide();
        $(".lodge_area").hide();
        schedule(1, 'time');

    } else if (package == "CT") {

        $("#lod_tab").removeClass("select").addClass("select");
        $("#rent_tab").removeClass("select");
        $(".package_tabmenu ul li .rent").css({backgroundColor: "#fff", color: "#000"});
        $(".package_tabmenu ul li .air").css({backgroundColor: "#fff", color: "#000"});
        $(".package_tabmenu ul li .lodge").css({backgroundColor: "#4474cc", color: "#fff"});
        $("#air").css("display", "none");
        $("#rent").css("display", "");
        $("#lod").css("display", "");
        $("#air_tab").css("display", "none");
        $("#rent_tab").css("display", "");
        $("#lod_tab").css("display", "");
        $("#air_content").css("display", "none");
        $("#rent_content").css("display", "");
        $("#tel_content").css("display", "");
        $("#bus_content").css("display", "none");
        $("#golf_content").css("display", "none");

        $(".air_area").hide();
        $(".rent_area").hide();
        $(".bus_area").hide();
        $(".lodge_area").show();
        tel_list();

    } else if (package == "AC") {
        $("#air_tab").removeClass("select").addClass("select");
        $("#rent_tab").removeClass("select");
        $("#air").css("display", "");
        $("#rent").css("display", "");
        $("#lod").css("display", "none");
        $("#air_tab").css("display", "");
        $("#rent_tab").css("display", "");
        $("#lod_tab").css("display", "none");
        $("#air_content").css("display", "");
        $("#rent_content").css("display", "");
        $("#tel_content").css("display", "none");
        $("#bus_content").css("display", "none");
        $("#golf_content").css("display", "none");

        $(".package_tabmenu ul li .air").css({backgroundColor: "#4474cc", color: "#fff"});
        $(".package_tabmenu ul li .rent").css({backgroundColor: "#fff", color: "#000"});
        $(".package_tabmenu ul li .lodge").css({backgroundColor: "#fff", color: "#000"});
        schedule(1, 'time');
    } else if (package == "ABT") {
        $("#air_tab").removeClass("select").addClass("select");
        $("#bus_tab").removeClass("select");
        $("#lod_tab").removeClass("select");
        $(".package_tabmenu ul li .air").css({backgroundColor: "#4474cc", color: "#fff"});
        $(".package_tabmenu ul li .lodge").css({backgroundColor: "#fff", color: "#000"});
        $(".package_tabmenu ul li .bus").css({backgroundColor: "#fff", color: "#000"});
        $("#air").css("display", "");
        $("#bus").css("display", "");
        $("#lod").css("display", "");
        $("#air_tab").css("display", "");
        $("#bus_tab").css("display", "");
        $("#lod_tab").css("display", "");
        $("#air_content").css("display", "");
        $("#rent_content").css("display", "none");
        $("#tel_content").css("display", "");
        $("#bus_content").css("display", "");
        $("#golf_content").css("display", "none");
        $(".air_area").show();
        $(".rent_area").hide();
        $(".bus_area").hide();
        $(".lodge_area").hide();
        schedule(1, 'time');
    } else if (package == "AB") {
        $("#air_tab").removeClass("select").addClass("select");
        $("#bus_tab").removeClass("select");
        $(".package_tabmenu ul li .air").css({backgroundColor: "#4474cc", color: "#fff"});
        $(".package_tabmenu ul li .bus").css({backgroundColor: "#fff", color: "#000"});
        $("#air").css("display", "");
        $("#bus").css("display", "");
        $("#lod").css("display", "none");
        $("#air_tab").css("display", "");
        $("#bus_tab").css("display", "");
        $("#lod_tab").css("display", "none");
        $("#air_content").css("display", "");
        $("#rent_content").css("display", "none");
        $("#tel_content").css("display", "none");
        $("#bus_content").css("display", "");
        $("#golf_content").css("display", "none");
        $(".air_area").show();
        $(".rent_area").hide();
        $(".bus_area").hide();
        $(".lodge_area").hide();
        schedule(1, 'time');
    } else if (package == "BT") {
         $("#lodge_tab").removeClass("select").addClass("select");
        $("#bus_tab").removeClass("select");
        $(".package_tabmenu ul li .lodge").css({backgroundColor: "#4474cc", color: "#fff"});
        $(".package_tabmenu ul li .bus").css({backgroundColor: "#fff", color: "#000"});
        $("#air").css("display", "none");
        $("#bus").css("display", "");
        $("#lod").css("display", "");
        $("#air_tab").css("display", "none");
        $("#bus_tab").css("display", "");
        $("#lod_tab").css("display", "");
        $("#lod_tab").css("display", "");
        $("#air_content").css("display", "none");
        $("#rent_content").css("display", "none");
        $("#tel_content").css("display", "");
        $("#bus_content").css("display", "");
        $("#golf_content").css("display", "none");
        $(".air_area").hide();
        $(".rent_area").hide();
        $(".bus_area").hide();
        $(".lodge_area").show();
        tel_list();
    } else if (package == "B") {

        $("#bus_tab").removeClass("select").addClass("select");
        $(".package_tabmenu ul li .lodge").css({backgroundColor: "#fff", color: "#000"});
        $(".package_tabmenu ul li .bus").css({backgroundColor: "#4474cc", color: "#fff"});
        $("#air").css("display", "none");
        $("#bus").css("display", "");
        $("#lod").css("display", "none");
        $("#air_tab").css("display", "none");
        $("#bus_tab").css("display", "");
        $("#lod_tab").css("display", "none");
        $("#air_content").css("display", "none");
        $("#rent_content").css("display", "none");
        $("#tel_content").css("display", "none");
        $("#bus_content").css("display", "");
        $("#golf_content").css("display", "none");
        $(".air_area").hide();
        $(".rent_area").hide();
        $(".bus_area").show();
        $(".lodge_area").hide();
        bus_list();
    } else if (package == "ACTG") {

        $("#air_tab").removeClass("select").addClass("select");
        $("#rent_tab").removeClass("select");
        $("#lodge_tab").removeClass("select");
        $("#golf_tab").removeClass("select");
        $(".package_tabmenu ul li .air").css({backgroundColor: "#4474cc", color: "#fff"});
        $(".package_tabmenu ul li .rent").css({backgroundColor: "#fff", color: "#000"});
        $(".package_tabmenu ul li .lodge").css({backgroundColor: "#fff", color: "#000"});
        $(".package_tabmenu ul li .golf").css({backgroundColor: "#fff", color: "#000"});
        $("#air").css("display", "");
        $("#rent").css("display", "");
        $("#lod").css("display", "");
        $("#golf").css("display", "");
        $("#air_tab").css("display", "");
        $("#rent_tab").css("display", "");
        $("#lod_tab").css("display", "");
        $("#golf_tab").css("display", "");
        $("#air_content").css("display", "");
        $("#rent_content").css("display", "");
        $("#tel_content").css("display", "");
        $("#bus_content").css("display", "none");
        $("#golf_content").css("display", "");
        $(".air_area").show();
        $(".rent_area").hide();
        $(".bus_area").hide();
        $(".lodge_area").hide();
        $(".golf_area").hide();
        schedule(1, 'time');
    } else if (package == "ACG") {
        $("#air_tab").removeClass("select").addClass("select");
        $("#rent_tab").removeClass("select");
        $("#lodge_tab").removeClass("select");
        $("#golf_tab").removeClass("select");
        $(".package_tabmenu ul li .air").css({backgroundColor: "#4474cc", color: "#fff"});
        $(".package_tabmenu ul li .rent").css({backgroundColor: "#fff", color: "#000"});
        $(".package_tabmenu ul li .lodge").css({backgroundColor: "#fff", color: "#000"});
        $(".package_tabmenu ul li .golf").css({backgroundColor: "#fff", color: "#000"});
        $("#air").css("display", "");
        $("#rent").css("display", "");
        $("#lod").css("display", "none");
        $("#golf").css("display", "");
        $("#air_tab").css("display", "");
        $("#rent_tab").css("display", "");
        $("#lod_tab").css("display", "none");
        $("#golf_tab").css("display", "");
        $("#air_content").css("display", "");
        $("#rent_content").css("display", "");
        $("#tel_content").css("display", "none");
        $("#bus_content").css("display", "none");
        $("#golf_content").css("display", "");
        $(".air_area").show();
        $(".rent_area").hide();
        $(".bus_area").hide();
        $(".lodge_area").hide();
        $(".golf_area").hide();
        schedule(1, 'time');
    } else if (package == "ATG") {
        $("#air_tab").removeClass("select").addClass("select");
        $("#rent_tab").removeClass("select");
        $("#lodge_tab").removeClass("select");
        $("#golf_tab").removeClass("select");
        $(".package_tabmenu ul li .air").css({backgroundColor: "#4474cc", color: "#fff"});
        $(".package_tabmenu ul li .rent").css({backgroundColor: "#fff", color: "#000"});
        $(".package_tabmenu ul li .lodge").css({backgroundColor: "#fff", color: "#000"});
        $(".package_tabmenu ul li .golf").css({backgroundColor: "#fff", color: "#000"});
        $("#air").css("display", "");
        $("#rent").css("display", "none");
        $("#lod").css("display", "");
        $("#golf").css("display", "");
        $("#air_tab").css("display", "");
        $("#rent_tab").css("display", "none");
        $("#lod_tab").css("display", "");
        $("#golf_tab").css("display", "");
        $("#air_content").css("display", "");
        $("#rent_content").css("display", "none");
        $("#tel_content").css("display", "");
        $("#bus_content").css("display", "none");
        $("#golf_content").css("display", "");
        $(".air_area").show();
        $(".rent_area").hide();
        $(".bus_area").hide();
        $(".lodge_area").hide();
        $(".golf_area").hide();
        schedule(1, 'time');
    } else if (package == "CTG") {

        $("#rent_tab").removeClass("select");
        $("#lodge_tab").removeClass("select");
        $("#golf_tab").removeClass("select").addClass("select");
        $(".package_tabmenu ul li .golf").css({backgroundColor: "#4474cc", color: "#fff"});
        $(".package_tabmenu ul li .rent").css({backgroundColor: "#fff", color: "#000"});
        $(".package_tabmenu ul li .lodge").css({backgroundColor: "#fff", color: "#000"});
        $("#air").css("display", "none");
        $("#rent").css("display", "");
        $("#lod").css("display", "");
        $("#golf").css("display", "");
        $("#air_tab").css("display", "none");
        $("#rent_tab").css("display", "");
        $("#lod_tab").css("display", "");
        $("#golf_tab").css("display", "");
        $("#air_content").css("display", "none");
        $("#rent_content").css("display", "");
        $("#tel_content").css("display", "");
        $("#bus_content").css("display", "none");
        $("#golf_content").css("display", "");
        $(".air_area").hide();
        $(".rent_area").hide();
        $(".bus_area").hide();
        $(".lodge_area").hide();
        $(".golf_area").show();
        g_stay_list();
    } else if (package == "AG") {
        $("#air_tab").removeClass("select").addClass("select");
        $("#golf_tab").removeClass("select");
        $(".package_tabmenu ul li .air").css({backgroundColor: "#4474cc", color: "#fff"});
        $(".package_tabmenu ul li .golf").css({backgroundColor: "#fff", color: "#000"});
        $("#air").css("display", "");
        $("#rent").css("display", "none");
        $("#lod").css("display", "none");
        $("#golf").css("display", "");
        $("#air_tab").css("display", "");
        $("#rent_tab").css("display", "none");
        $("#lod_tab").css("display", "none");
        $("#golf_tab").css("display", "");
        $("#air_content").css("display", "");
        $("#rent_content").css("display", "none");
        $("#tel_content").css("display", "none");
        $("#bus_content").css("display", "none");
        $("#golf_content").css("display", "");
        $(".air_area").show();
        $(".rent_area").hide();
        $(".bus_area").hide();
        $(".lodge_area").hide();
        $(".golf_area").hide();
        schedule(1, 'time');
    } else if (package == "CG") {

        $("#rent_tab").removeClass("select");
        $("#golf_tab").removeClass("select").addClass("select");
        $(".package_tabmenu ul li .golf").css({backgroundColor: "#4474cc", color: "#fff"});
        $(".package_tabmenu ul li .rent").css({backgroundColor: "#fff", color: "#000"});
        $("#air").css("display", "none");
        $("#rent").css("display", "");
        $("#lod").css("display", "none");
        $("#golf").css("display", "");
        $("#air_tab").css("display", "none");
        $("#rent_tab").css("display", "");
        $("#lod_tab").css("display", "none");
        $("#golf_tab").css("display", "");
        $("#air_content").css("display", "none");
        $("#rent_content").css("display", "");
        $("#tel_content").css("display", "none");
        $("#bus_content").css("display", "none");
        $("#golf_content").css("display", "");
        $(".air_area").hide();
        $(".rent_area").hide();
        $(".bus_area").hide();
        $(".lodge_area").hide();
        $(".golf_area").show();
        g_stay_list();
    } else if (package == "TG") {


        $("#lodge_tab").removeClass("select");
        $("#golf_tab").removeClass("select").addClass("select");
        $(".package_tabmenu ul li .golf").css({backgroundColor: "#4474cc", color: "#fff"});
        $(".package_tabmenu ul li .rent").css({backgroundColor: "#fff", color: "#000"});
        $(".package_tabmenu ul li .lodge").css({backgroundColor: "#fff", color: "#000"});
        $("#air").css("display", "none");
        $("#rent").css("display", "none");
        $("#lod").css("display", "");
        $("#golf").css("display", "");
        $("#air_tab").css("display", "none");
        $("#rent_tab").css("display", "none");
        $("#lod_tab").css("display", "");
        $("#golf_tab").css("display", "none");
        $("#air_content").css("display", "none");
        $("#rent_content").css("display", "");
        $("#tel_content").css("display", "none");
        $("#bus_content").css("display", "none");
        $("#golf_content").css("display", "");
        $(".air_area").hide();
        $(".rent_area").hide();
        $(".bus_area").hide();
        $(".lodge_area").hide();
        $(".golf_area").show();
        g_stay_list();
    } else if (package == "G") {

        $("#golf_tab").removeClass("select").addClass("select");
        $(".package_tabmenu ul li .golf").css({backgroundColor: "#4474cc", color: "#fff"});

        $("#air").css("display", "none");
        $("#rent").css("display", "none");
        $("#lod").css("display", "none");
        $("#golf").css("display", "");
        $("#air_tab").css("display", "none");
        $("#rent_tab").css("display", "none");
        $("#lod_tab").css("display", "none");
        $("#golf_tab").css("display", "");
        $("#air_content").css("display", "none");
        $("#rent_content").css("display", "none");
        $("#tel_content").css("display", "none");
        $("#bus_content").css("display", "none");
        $("#golf_content").css("display", "");
        $(".air_area").hide();
        $(".rent_area").hide();
        $(".bus_area").hide();
        $(".lodge_area").hide();
        $(".golf_area").show();
        g_stay_list();

    } else {
        $("#air").css("display", "");
        $("#rent").css("display", "");
        $("#lod").css("display", "");
        $("#air_tab").css("display", "");
        $("#rent_tab").css("display", "");
        $("#lod_tab").css("display", "");
        $("#air_content").css("display", "");
        $("#rent_content").css("display", "");
        $("#tel_content").css("display", "");
        $("#bus_content").css("display", "none");
        $("#golf_content").css("display", "none");
        $(".package_tabmenu ul li .air").css({backgroundColor: "#4474cc", color: "#fff"});
        $(".package_tabmenu ul li .rent").css({backgroundColor: "#fff", color: "#000"});
        $(".package_tabmenu ul li .lodge").css({backgroundColor: "#fff", color: "#000"});
        $(".air_area").show();
        $(".rent_area").hide();
        $(".bus_area").hide();
        $(".lodge_area").hide();
        schedule(1, 'time');

    }
}
function reserv_chk(pack) {

    var s_date = new Date($("#start_date").val());
    var e_date = new Date($("#end_date").val());
    var stay = e_date - s_date;
    stay =  (stay/(24 * 3600 * 1000));

    var hole="";
    for(var i =0;i < Number(stay)+1;i++){
        if($("#hole_no_"+i).val() == undefined){
            hole += "";
        }else{
            if(i==0) {
                hole += $("#hole_no_"+i).val();
            }else{
                hole += ","+$("#hole_no_"+i).val();
            }
        }
    }

    if(pack=="ACT") {
        if ($("#air_no").val() == undefined) {
            alert("항공을 선택해주세요.");
            return false;
        } else if ($("#car_no").val() == undefined) {
            alert("렌트카을 선택해주세요.");
            return false;
        } else if ($("#room_no").val() == undefined) {
            alert("숙소을 선택해주세요.");
            return false;
        }else {
            $("#package_frm").submit();
            return true;
        }
    }else if(pack=="AT"){
        if ($("#air_no").val() == undefined) {
            alert("항공을 선택해주세요.");
            return false;
        } else if ($("#room_no").val() == undefined) {
            alert("숙소을 선택해주세요.");
            return false;
        }else {
            $("#package_frm").submit();
            return true;
        }
    }else if(pack=="AC"){
        if ($("#air_no").val() == undefined) {
            alert("항공을 선택해주세요.");
            return false;
        } else if ($("#car_no").val() == undefined) {
            alert("렌트카을 선택해주세요.");
            return false;
        }else {
            $("#package_frm").submit();
            return true;
        }
    }else if(pack=="CT"){
        if ($("#car_no").val() == undefined) {
            alert("렌트카을 선택해주세요.");
            return false;
        } else if ($("#room_no").val() == undefined) {
            alert("숙소을 선택해주세요.");
            return false;
        }else {
            $("#package_frm").submit();
            return true;
        }
    }else if(pack=="ABT"){
        if ($("#air_no").val() == undefined) {
            alert("항공을 선택해주세요.");
            return false;
        } else if ($("#room_no").val() == undefined) {
            alert("숙소을 선택해주세요.");
            return false;
        } else if ($("#bus_no").val() == undefined) {
            alert("버스을 선택해주세요.");
            return false;

        }else {
            $("#package_frm").submit();
            return true;
        }
    }else if(pack=="AB"){
        if ($("#air_no").val() == undefined) {
            alert("항공을 선택해주세요.");
            return false;
        } else if ($("#bus_no").val() == undefined) {
            alert("버스을 선택해주세요.");
            return false;
        }else {
            $("#package_frm").submit();
            return true;
        }
    }else if(pack=="BT"){
        if ($("#bus_no").val() == undefined) {
            alert("버스을 선택해주세요.");
            return false;
        } else if ($("#room_no").val() == undefined) {
            alert("숙소을 선택해주세요.");
            return false;
        }else {
            $("#package_frm").submit();
            return true;
        }

    }else if(pack=="ACTG"){
        if ($("#air_no").val() == undefined) {
            alert("항공을 선택해주세요.");
            return false;
        } else if ($("#car_no").val() == undefined) {
            alert("렌트카을 선택해주세요.");
            return false;
        } else if ($("#room_no").val() == undefined) {
            alert("숙소을 선택해주세요.");
            return false;
        } else if (hole == "") {
            alert("골프장을 하나라도 선택해주세요.");
            return false;
        }else {
            $("#package_frm").submit();
            return true;
        }
    }else if(pack=="ACG"){
        if ($("#air_no").val() == undefined) {
            alert("항공을 선택해주세요.");
            return false;
        } else if ($("#car_no").val() == undefined) {
            alert("렌트카을 선택해주세요.");
            return false;
        } else if (hole == "") {
            alert("골프장을 하나라도 선택해주세요.");
            return false;
        }else {
            $("#package_frm").submit();
            return true;
        }
    }else if(pack=="ATG"){
        if ($("#air_no").val() == undefined) {
            alert("항공을 선택해주세요.");
            return false;
        } else if ($("#room_no").val() == undefined) {
            alert("숙소을 선택해주세요.");
            return false;
        } else if (hole == "") {
            alert("골프장을 하나라도 선택해주세요.");
            return false;
        }else {
            $("#package_frm").submit();
            return true;
        }
    }else if(pack=="CTG"){
        if ($("#car_no").val() == undefined) {
            alert("렌트카을 선택해주세요.");
            return false;
        } else if ($("#room_no").val() == undefined) {
            alert("숙소을 선택해주세요.");
            return false;
        } else if (hole == "") {
            alert("골프장을 하나라도 선택해주세요.");
            return false;
        }else {
            $("#package_frm").submit();
            return true;
        }
    }else if(pack=="AG"){
        if ($("#air_no").val() == undefined) {
            alert("항공을 선택해주세요.");
            return false;
        } else if (hole == "") {
            alert("골프장을 하나라도 선택해주세요.");
            return false;
        }else {
            $("#package_frm").submit();
            return true;
        }
    }else if(pack=="CG"){
        if ($("#car_no").val() == undefined) {
            alert("렌트카을 선택해주세요.");
            return false;
        } else if (hole == "") {
            alert("골프장을 하나라도 선택해주세요.");
            return false;
        }else {
            $("#package_frm").submit();
            return true;
        }
    }else if(pack=="TG"){
        if ($("#room_no").val() == undefined) {
            alert("숙소을 선택해주세요.");
            return false;
        } else if (hole == "") {
            alert("골프장을 하나라도 선택해주세요.");
            return false;
        }else {
            $("#package_frm").submit();
            return true;
        }

    }else{
        $("#package_frm").submit();
        return true;
    }



}




