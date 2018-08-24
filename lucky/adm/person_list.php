<?php
$sql = "select * from ad_member";
$rs  = $db->sql_query($sql);
while($row = $db->fetch_array($rs)) {
    $result_list[] = $row;
}

?>



<div style="margin-top: 20px;">
     <div class="add">

        <form >
        <table class="tbl">
            <tr>
                <th>아이디</th>
                <th>비밀번호</th>
                <th>이름</th>
                <th>휴대폰</th>
                <th>입사일</th>
                <th>권한</th>
                <th>추가</th>
            </tr>
            <tr>
              
                <td class="con"><input type="text" name="id" id="id"></td>
                <td class="con"><input type="password" name="passwd" id="passwd"></td>
                <td class="con"><input type="text" name="name" id="name"></td>
                <td class="con"><input type="text" name="hphone" id="hphone"></td>
                <td class="con"><input type="text" name="incom" id="incom_in"></td>
                <td class="con">
                    <select name="level">
                        <option value="9">관리자</option>
                        <option value="8">사원</option>
                        <option value="7">관련업체</option>
                    </select>
                </td>
                <td class="con"><button type="button" id="add_btn" >추가</button></td>
            </tr>
        </table>
        </form>
    </div>
    <div class="up">
     
        <p style="margin-top: 10px;margin-bottom: 10px;"><input type="button" id="up_btn"  value="선택수정" > <input type="button" id="del_btn"  value="선택삭제" ></p>

        <table class="tbl">
            <tr>
                <th><input type="checkbox" name="allsel" id="allsel"></th>
                <th>아이디</th>
                <th>비밀번호</th>
                <th>이름</th>
                <th>휴대폰</th>
                <th>입사일</th>
                <th>권한</th>
            </tr>
            <form id="up_frm">
                <input type="hidden" name="case" id="case" value="">
            <?php
            $i=0;
            foreach ($result_list as $data){

            ?>

            <tr>
                <td class="con"><input type="checkbox" name="sel[]" id="sel_<?=$i?>" value="<?=$i?>">
                    <input type="hidden" name="no[]	" id="no_<?=$i?>" value="<?=$data['no']?>">

                </td>
                <td class="con"><input type="text" name="ad_id[]" id="ad_id_<?=$i?>" value="<?=$data['ad_id']?>"></td>
                <td class="con"><input type="password" name="ad_passwd[]" id="ad_passwd_<?=$i?>" value="<?=$data['ad_passwd']?>"></td>
                <td class="con"><input type="text" name="ad_name[]" id="ad_name_<?=$i?>" value="<?=$data['ad_name']?>"></td>
                <td class="con"><input type="text" name="ad_hphone[]" id="ad_hphone_<?=$i?>" value="<?=$data['ad_hphone']?>"></td>
                <td class="con"><input type="text" class="incom" name="ad_incom[]" id="ad_incom_<?=$i?>" value="<?=$data['ad_incom']?>"></td>
                <td class="con">
                    <select name="ad_level_<?=$i?>">
                        <option value="9" <?php if($data['ad_level']=="9"){?>selected<?}?>>관리자</option>
                        <option value="8" <?php if($data['ad_level']=="8"){?>selected<?}?>>사원</option>
                        <option value="7" <?php if($data['ad_level']=="7"){?>selected<?}?>>관련업체</option>
                    </select>
                </td>
            </tr>
            <?php
                $i++;
            }?>
            </form>
        </table>

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $("#allsel").click(function(){
            $("input[name='sel[]']").prop("checked",function(){
                return !$(this).prop("checked");
            })
        })



        $("#add_btn").click(function () {
            wrapWindowByMask();
            if($("#id").val()==""){
                alert("아이디를 입력해주세요");
                closeWindowByMask();
                return false;
            }else if($("#passwd").val()==""){
                alert("비밀번호를 입력해주세요");
                closeWindowByMask();
                return false;
            }else if($("#name").val()==""){
                alert("이름를 입력해주세요");
                closeWindowByMask();
                return false;
            }
            $.post("person_process.php",
                {
                   ad_id:$("#id").val(),
                   ad_passwd:$("#passwd").val(),
                   ad_name:$("#name").val(),
                   ad_hphone:$("#hphone").val(),
                   ad_incom:$("#incom_in").val(),
                   ad_level:$("select[name=level]").val(),
                   case : "insert"
                },
                function(data,status){
                    alert("관리자을 등록하셨습니다.");
                    closeWindowByMask();
                });


        });

       $("#up_btn").click(function () {
           $("#case").val("update");
		   var url = "person_process.php"; // the script where you handle the form input.
				$.ajax({
				   type: "POST",
				   url: url,
				   data: $("#up_frm").serialize(), // serializes the form's elements.
				   success: function(data)
				   {
					  // console.log(data); // show response from the php script.
				   },
                   beforeSend : function (){
                       wrapWindowByMask();
                   },
                   complete : function (){
                       closeWindowByMask();
                       window.location.reload();
                    }
				 });
	
	   });

        $("#del_btn").click(function () {
            var url = "person_process.php"; // the script where you handle the form input.
            $("#case").val("delete");
            $.ajax({
                type: "POST",
                url: url,
                data: $("#up_frm").serialize(), // serializes the form's elements.
                success: function(data)
                {
                    // console.log(data); // show response from the php script.
                },
                beforeSend : function (){
                    wrapWindowByMask();
                },
                complete : function (){
                    closeWindowByMask();
                    window.location.reload();
                }
            });

        });


    });
    $( function() {
        $( "#incom_in" ).datepicker({
            dateFormat : "yy-mm-dd",
        });
        $( ".incom" ).datepicker({
            dateFormat : "yy-mm-dd",
        });
    } );
</script>