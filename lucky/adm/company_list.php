<?php
$sql = "select no,tour_id,tour_name,indate,tour_main from tour_company  order by no asc";
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}
?>
<script>
    function del_b(i) {
        wrapWindowByMask();
        if (confirm("정말삭제 하시겠습니다?") == false) {
            closeWindowByMask();
            return false;
        } else {
            $.post("company_process.php",
                {
                    no: $("#no_"+i).val(),
                    case: "delete"
                },
                function (data, status) {
                    alert("사이트를 삭제하셨습니다.");
                    //console.log(data);
                    closeWindowByMask();
                    window.location.reload();
                });
        }

    }
</script>

<div style="margin-top: 20px;">
    <p style="margin-bottom: 10px;"><input id="site_btn" type="button" value="사이트등록"></p>
    <div>
        <table class="tbl">
            <tr>
                <th class="title">차례</th>
                <th class="title">사이트명</th>
                <th class="title">사이트설정</th>
                <th class="title">등록일</th>
                <th class="title">관리</th>
            </tr>
            <?php
            $i=1;
            foreach ($result_list as $data){
              $b_no = $data['no'];
              if($data['tour_main']=="Y"){
                  $main = "메인사이트";
              }else{
                  $main = "서브사이트";
              }
            ?>
            <tr>
                <td class="con"><?=$i?></td>
                <td class="con"><a href="?linkpage=company_mod&no=<?=$b_no?>"><?=$data['tour_name']?></a></td>
                <td class="con"><?=$main?></td>
                <td class="con"><?=$data['indate']?></td>
                <td class="con"><input type="button" value="삭제" onclick="del_b(<?=$i?>)">
                    <input type="hidden" name="no" id="no_<?=$i?>" value="<?=$data[no]?>">
                    <input id="basic_btn" type="button" value="기본설정" onclick="location.href = '?linkpage=basic&no=<?=$b_no?>';">
                </td>
            </tr>

            <?
                $i++;
            }
            ?>
        </table>

    </div>


</div>
<div class="overlay"></div>
<div id="layer_d">
    <div class="layer_d" >
        <form id="tour_frm">
            <table class="tbl_com">
                <tr>
                    <th>사이트명</th>
                    <td><input type="text" name="site_name" id="site_name"></td>
                </tr>
                <tr>
                    <th>사이트아이디</th>
                    <td><input type="text" name="site_id" id="site_id" style="ime-mode:disabled"></td>
                </tr>
            </table>
        </form>
        <p><input id="add_btn" type="button" value="사이트등록"></p>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#site_btn").click(function () {
            $("#layer_d").show();
            $(".overlay").show();

        }) ;
        $(".overlay").click(function () {
            $(".overlay").hide();
            $("#layer_d").hide();
        });

        $("#add_btn").click(function () {

            if($("#site_name").val()==""){
                alert("사이트명를 입력해주세요");
                return false;
            }else if($("#site_id").val()==""){
                alert("사이트아이디를 입력해주세요");
                return false;
            }

            var str = $("#site_id").val();
            var regexp = /^[A-Za-z0-9]{4,20}$/i;

            if(!regexp.test(str))
            {
                alert(" 틀렸어요 영어숫자 4-20자만 사용 가능해요");
                return false;
            }

            $.post("company_process.php",
                {
                    tour_name:$("#site_name").val(),
                    tour_id:$("#site_id").val(),
                    case : "insert"
                },
                function(data,status) {
                    if (data == "NO") {
                        alert("아이디가 중복되었습니다. 다른 아이디로 등록해주세요");
                    } else {
                        console.log(data);
                        alert("사이트를 등록하셨습니다.");
                       $(".overlay").hide();
                       $("#layer_d").hide();
                       window.location.reload();
                    }
                });


        });

    });
</script>