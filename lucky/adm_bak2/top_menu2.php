<div id="navi_width">
<ul class="one">
    <li >
        <a class="main" href="#">예약관리</a>
        <ul >
            <li><a class="sub" href="?linkpage=reservation&subpage=res_list">예약현황</a></li>
            <li><a class="sub" href="javascript:adm_ledger();">장부만들기</a></li>
        </ul>
    </li>
    <li >
        <a class="main" href="#">예약상품현황</a>
        <ul >
            <li><a class="sub" href="?linkpage=report&subpage=all">전체상품현황</a></li>
            <li><a class="sub" href="?linkpage=report&subpage=air">항공</a></li>
            <li><a class="sub" href="?linkpage=report&subpage=rent">렌트</a></li>
            <li><a class="sub" href="?linkpage=report&subpage=lod">숙박</a></li>
            <li><a class="sub" href="?linkpage=report&subpage=bus">버스/택시</a></li>
            <li><a class="sub" href="?linkpage=report&subpage=bustour">버스투어</a></li>
            <li><a class="sub" href="?linkpage=report&subpage=golf">골프</a></li>
        </ul>
    </li>
    <li >
        <a class="main" href="#">판매현황</a>
        <ul >
            <li><a class="sub" href="?linkpage=report_sell&subpage=sell">전체판매현황</a></li>
            <li><a class="sub" href="?linkpage=report_sell&subpage=air">항공</a></li>
            <li><a class="sub" href="?linkpage=report_sell&subpage=rent">렌트</a></li>
            <li><a class="sub" href="?linkpage=report_sell&subpage=lod">숙박</a></li>
            <li><a class="sub" href="?linkpage=report_sell&subpage=bus">버스</a></li>
            <li><a class="sub" href="?linkpage=report_sell&subpage=bustour">버스투어</a></li>
            <li><a class="sub" href="?linkpage=report_sell&subpage=golf">골프</a></li>
            
        </ul>
    </li>
    <li >
        <a class="main" href="#">정산관리</a>
        <ul >
            <li><a class="sub" href="?linkpage=report_remit">송금현황</a></li>
            <li><a class="sub" href="?linkpage=report_collect">수금현황</a></li>
            <li><a class="sub" href="?linkpage=report_card">카드현황</a></li>
            <li><a class="sub" href="?linkpage=report_tax&subpage=tax">세금계산서현황</a></li>
            <li><a class="sub" href="?linkpage=report_refund&subpage=refund">환불현황</a></li>
        </ul>
    </li>
    <li >
        <a class="main" href="#">상품관리</a>
        <ul >
            <li><a class="sub" href="?linkpage=air">항공</a></li>
            <li><a class="sub" href="?linkpage=rent">렌트카</a></li>
            <li><a class="sub" href="?linkpage=tel">숙소</a></li>
            <li><a class="sub" href="?linkpage=bus">버스/택시</a></li>
            <li><a class="sub" href="?linkpage=bustour">버스투어</a></li>
            <li><a class="sub" href="?linkpage=golf">골프</a></li>
            <li><a class="sub" href="?linkpage=golf">관광지</a></li>
            <li><a class="sub" href="?linkpage=golf">식당</a></li>
            <li><a class="sub" href="?linkpage=equip">편의장비</a></li>
        </ul>
    </li>
    <li >
        <a class="main" href="#">게시판관리</a>
        <ul >
            <li><a class="sub" href="?linkpage=board">게시판관리</a></li>
            <?php
            $sql_list = "select * from board_list";
            $rs_list  = $db->sql_query($sql_list);
            while ($row_list = $db->fetch_array($rs_list)){
            ?>
                <li><a class="sub" href="?linkpage=board_list&bd_no=<?=$row_list['no']?>&board_table=<?=$row_list['bd_id']?>"><?=$row_list['bd_name']?></a></li>
            <?php
            }
            ?>
        </ul>
    </li>
    <li >
        <a class="main" href="#">사이트관리</a>
        <ul >

            <li><a class="sub" href="?linkpage=person_list">관리자관리</a></li>
            <li><a class="sub" href="?linkpage=company">사이트관리</a></li>
        </ul>
    </li>
    <li >
        <a class="main" href="#">회원관리</a>
        <ul >

            <li><a class="sub" href="?linkpage=person_list">관리자관리</a></li>
            <li><a class="sub" href="?linkpage=company">사이트관리</a></li>
        </ul>
    </li>

</ul>
</div>
<script>
    function adm_ledger() {
        window.open("reservation/reservation_ledger.php?ledger=adm","ledger_pop","width=1450,height=785");
    }
</script>