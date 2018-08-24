<?php include "../inc/header.php"; ?>
<div class="car-top">
	<table>
		<tr>
			<td style="width: 75%;">
				<span class="menu-text">상품바구니</span>(<span class="menu-num">1</span>)
			</td>
			<td style="width: 25%;">
				<button  class="select-button-cart-del">전체삭제</button>
			</td>
		</tr>
	</table>

</div>
<div class="gap"></div>
<div class="car-item">
	<table>
		<tr>
			<td>
				<span class="bold">[신라호텔]</span>
			</td>
			<td class="count" rowspan="4">
				<select>
					<option value="">1</option>
					<option value="">2</option>
					<option value="">3</option>
					<option value="">4</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				시크릿 특가[본관 스탠다드 신전망] 조식불포함
			</td>
		</tr>
		<tr>
			<td>
				<span class="gray">성인:2 / 소아:0</span>
			</td>
		</tr>
		<tr>
			<td>
				<span class="gray">2018-06-01(금)  /  1박  /  기준인원:2(최대:3)</span>
			</td>
		</tr>
	</table>
	<table>
		<tr>
			<td>
				<span class="bold-gray">
				정상가
				</span>
			</td>
			<td class="price">
				755,000원
			</td>
		</tr>
		<tr>
			<td>
				<span class="bold-gray">
				결제예상금액
				</span>
			</td>
			<td class="price">
				355,000원<span class="num">(50%할인)</span>
			</td>
		</tr>
		<tr>
			<td style="padding: 20px; text-align: right;" colspan="2">
				<button  class="select-button-cart">변경</button>
				<button  class="select-button-cart-del-left">삭제</button>
			</td>
		</tr>
	</table>
</div>
<div class="gap"></div>
<div class="car-item-price">
	<table>
		<tr>
			<td>정상가</td>
			<td>할인금액 </td>
			<td>추가금액</td>
			<td></td>
		</tr>
		<tr>
			<td>755,000원<span class="up"></span></td>
			<td>400,000원<span class="down"></span></td>
			<td>0원</td>
			<td></td>
		</tr>
		<tr>
			<td colspan="4"></td>
		</tr>
		<tr>
			<td colspan="2" style="color : #000000; font-size: 35px">최종결제금액</td>
			<td colspan="2" style="color : #000000; font-size: 35px; text-align: right; padding-right: 20px">
				<p style="font-size: 40px; color :#ff5000; ">200,700원</p>
				<p style="font-size: 25px; color :#888888; ">세금/봉사료 포함</p>
			</td>
		</tr>
		<tr>
			<td colspan="4">
				<button class="button-summit-blue" type="summit" onclick="location.href='../../res/res.php'">예약하기</button>
			</td>
		</tr>
	</table>
</div>
<div class="gap"></div>
<?php include "../inc/footer.php"; ?>