<?php include "../inc/header.sub.php"; ?>
<br>
<br>
<?php
if(!$start_date) {
    $start_date = date("Y-m-d",time());
}

$end_date   =  date("Y-m-d", strtotime($start_date." +1 days"));
?>

<div class="select-table">
    <form id="bus_frm" method="post">
	<table>
		<tr>
			<td class="select-title-span">
				<span class="calendar"></span>
					
			</td>
			<td class="select-title">
				출발일
					
			</td>
			<td class="select-text" style="border-right: 1px solid #848484;">
				<input id="start_date" name="start_date" type="text" value="<?=$start_date?>" >
                <input  id="end_date" name="end_date" type="hidden" value="<?=$end_date?>" >
			</td>
			<td class="select-title-span">
				<span class="time"></span>
					
			</td>
			<td class="select-title">
				
					일정

			</td>
			<td class="select-text">
				<select name="bus_stay">
                    <?php
                        $main->vehicle_option("","일")
                    ?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="select-title-span">
				<span class="calendar"></span>
					
			</td>
			<td class="select-title">
			
					차량대수
			
			</td>
			<td class="select-text" style="border-right: 1px solid #848484;">
				<select name="bus_vehicle">
                    <?php
                        $main->vehicle_option("","대");
                    ?>
				</select>
			</td>
			<td class="select-title-span">
				<span class="car"></span>
					
			</td>
			<td class="select-title">
				선택
			</td>
			<td class="select-text">
				<select name="bus_type">
					<option value="B">버스</option>
					<option value="X">택시</option>
				</select>
			</td>
		</tr>
	</table>
    </form>
    <div class="button-summit-area">
        <button class="button-summit"  type="summit" onclick="bus_list();">버스 검색</button>
    </div>
</div>


<style type="text/css" media="screen">
	.container{
		width:100%;
		margin: 0 auto;
	}

	ul.tabs{
		margin: 0px;
		padding: 0px;
		list-style: none;
	}
	ul.tabs li{
		background: none;
		color: #fff;
		display: inline-block;
		padding: 10px 15px;
		cursor: pointer;
		background: #6b6b6b;
		height:50px;
		width: 200px;
		line-height: 50px;
		font-size: 35px;
		text-align: center;
	}

	ul.tabs li.tab-link{
		background: none;
		color: #fff;
		display: inline-block;
		padding: 10px 15px;
		cursor: pointer;
		background: #6b6b6b;
		height:70px;
		width: 200px;
		line-height: 50px;
		font-size: 35px;
		text-align: center;
	}


	ul.tabs li.current{
		background: #fff;
		color: #222;
		border-top: 1px solid #6b6b6b;
		border-right: 1px solid #6b6b6b;
		height: auto;
	}

	.tab-content{
		display: none;
		background: #fff;
		padding: 15px;
		height: auto;
	}

	.tab-content.current{
		display: inherit;
		background: #e5e5e5;
		border-top: 1px solid #6b6b6b;
	}

	.bus-info {
		width: 100%;
		height: auto;

	}

	.bus-info table {
		width: 100%;
		height: auto;
		background : #e5e5e5;
	}

	.bus-info td {
		width: 100%;
		height: 80px;
		font-size: 20px;
		
	}

/*상세정보*/
	.bus-sub-info {
		width: 100%;
		height: auto;
		background : #ffffff;		
	}

	.bus-sub-info table{
		width: 100%;
		height: auto;		
	}

	.bus-sub-info td{
		height: auto;
	}

	.bus-sub-info td.bus-sub-info-title{
		font-family: NanumGothic;
		font-size: 30px;
		font-weight: 500;
		font-style: normal;
		font-stretch: normal;
		line-height: 30px;
		letter-spacing: normal;
		text-align: left;
		color: #e20181;	
	}

	.bus-sub-info td div.bus-sub-info-text{
		width: 100%;
		height: auto;	
		font-family: NanumGothic;
		font-size: 30px;
		font-weight: 400;
		font-style: normal;
		font-stretch: normal;
		line-height: 50px;
		letter-spacing: normal;
		text-align: left;
		color: #666666;
		word-break: keep-all;	
	}

</style>
<!--탭메뉴 -->	
    	<div class="container">
			<ul class="tabs">
				<li class="tab-link current" data-tab="tab-1">버스선택</li>
				<li class="tab-link" data-tab="tab-2">상세정보</li>			
			</ul>

			<div id="tab-1" class="tab-content current">
				<div class="bus-info">
					<div id="bus_list" class="select-bus-list">

					</div>
				</div>
			</div>
			<div id="tab-2" class="tab-content">
				<div class="bus-sub-info">
					<table>
						<tr>
							<td class="bus-sub-info-title">
								[이용안내]
							</td>
						</tr>
						<tr>
							<td>
								<div class="bus-sub-info-text">
									* 이용기간 : 6/1 ~ 6/30(제외일자 : 6/21 ~ 6/22, 6/26 ~ 6/27)<br>
									* 본 상품은 조식불포함입니다.<br>
									<br>
									 * 특전사항<br>
									1) 해온튜브 1개 제공(투숙기간 중 1회 제공)<br>
									2) 기준인원 사우나 무료 이용<br>
									3) 기준인원 피트니스클럽 무료 이용<br>
									4) 발렛파킹 1회 무료 이용(투숙기간 중 1회 제공)<br>
									5) 2박 시 해온스플래시 세트 1개 제공(투숙기간 중 1회 제공)<br>
									- 메뉴구성 : 양갈비/아사히 생맥주2잔 또는 랍스터테일/한치구이/
									아사이생맥주 2잔
								</div>
							</td>
						</tr>
						<tr>
							<td class="bus-sub-info-title">
								[미팅방법]
							</td>
						</tr>
						<tr>
							<td>
								<div class="bus-sub-info-text">
									에어컨, TV, 냉장고, 쇼파, T테이블, 테라스
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
    </div>
    <!--탭메뉴 끝-->	




<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<!--탭메뉴 제이쿼리 -->
 <script>
	$(document).ready(function(){
		
		$('ul.tabs li').click(function(){
			var tab_id = $(this).attr('data-tab');

			$('ul.tabs li').removeClass('current');
			$('.tab-content').removeClass('current');

			$(this).addClass('current');
			$("#"+tab_id).addClass('current');
		})

	})

	</script>
    <script>
        function bus_list() {
            var url = "../list/list_bus.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#bus_frm").serialize()+"&package_type=B", // serializes the form's elements.
                success: function (data) {
                    $("#bus_list").html(data); // show response from the php script.
                    console.log(data);
                },
                beforeSend: function () {
                    //  wrapWindowByMask();
                },
                complete: function () {
                    //   closeWindowByMask();
                }
            });
        }
        function reservation(bus_no) {

            window.location.href = "../res/res_check.php?"+$("#bus_frm").serialize()+"&start_date="+$("#start_date").val()+"&bus_date="+$("#start_date").val()+"&end_date="+$("#end_date").val()+"&bus_no="+bus_no+"&package_type=B";

        }
        bus_list();
    </script>



<?php include "../inc/footer.php"; ?>

<?php include "../pop_calendar.php"?>