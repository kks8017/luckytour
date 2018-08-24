<?php include "../inc/header.php"; ?>

<div class="select-table">
	<table>
		<tr>
			<td class="select-title-span">
				<span class="calendar"></span>
					
			</td>
			<td class="select-title">
				출발일
					
			</td>
			<td class="select-text" style="border-right: 1px solid #848484;">
				<input id="pop_cal_bt" type="text" >
			</td>
			<td class="select-title-span">
				<span class="time"></span>
					
			</td>
			<td class="select-title">
				
					일정

			</td>
			<td class="select-text">
				<select>
					<option value="">1일</option>
					<option value="">2일</option>
					<option value="">3일</option>
					<option value="">4일</option>
					<option value="">5일</option>
					<option value="">6일</option>			
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
				<select>
					<option value="">1대</option>
					<option value="">2대</option>
					<option value="">3대</option>
					<option value="">4대</option>
					<option value="">5대</option>
					<option value="">6대</option>			
				</select>
			</td>
			<td class="select-title-span">
				<span class="car"></span>
					
			</td>
			<td class="select-title">
				선택
			</td>
			<td class="select-text">
				<select>
					<option value="">버스</option>
					<option value="">택시</option>		
				</select>
			</td>
		</tr>
	</table>

</div>


<div class="select-texi-list">
	<table>
		<tr>
			<td class="texi-img-area" rowspan="4"></td>
			<td class="texi-name">택시</td>
		</tr>
		<tr>
			<td class="texi-info">기사봉사료 포함</td>
		</tr>
		<tr>
			<td class="texi-price">20,700원<span class="texi-time">3</span><span class="texi-time-text">일</span></td>
		</tr>
		<tr>
			<td>
				<button  class="select-button-left" onclick="location.href='../res/res.php'">선택</button> 
			</td>
		</tr>
	</table>	

</div>

<div class="texi-sub-info">
	<table>
		<tr>
			<td class="texi-sub-info-title">
				[이용안내]
			</td>
		</tr>
		<tr>
			<td>
				<div class="texi-sub-info-text">
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
			<td class="texi-sub-info-title">
				[미팅방법]
			</td>
		</tr>
		<tr>
			<td>
				<div class="texi-sub-info-text">
					에어컨, TV, 냉장고, 쇼파, T테이블, 테라스
				</div>
			</td>
		</tr>
	</table>
</div>




<?php include "../inc/footer.php"; ?>

<?php include "../pop_calendar.php"?>