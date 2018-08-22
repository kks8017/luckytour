<?php include "../inc/header.php"; ?>
<div class="member-join">
	<div class="member-join-form">
		<p style="font-size: 35px; font-weight: bold; text-align: center; margin: 20px;">회원 가입을 축하합니다</p>
		<table>
			<tr>
				<td class="join-title">
					아이디
				</td>
				<td class="join-text-main">
					<input type="text" name="" placeholder="아이디" readonly>
				</td>
			</tr>
			<tr>
				<td class="join-title"> 
					이름
				</td>
				<td colspan="2" class="join-text"> 
					<input type="text" name="" placeholder="이름" readonly>
				</td>
			</tr>
			<tr>
					<td class="join-title">
					휴대폰번호 
					</td>
					<td class="join-text">
						<input type="text" name="" placeholder="(예)01012341234" readonly>
					</td>
					<td class="join-text">
						
					</td>
				</tr>
		</table>
	</div>
	
		<div class="button-summit-area">
			<button class="button-summit-blue" type="summit" onclick="location.href='../index.php'">메인으로</button>
		</div>
	</div>	

</div>


<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript">
var acodian = {

  click: function(target) {
    var _self = this,
      $target = $(target);
    $target.on('click', function() {
      var $this = $(this);
      if ($this.next('dd').css('display') == 'none') {
        $('dd').slideUp();
        _self.onremove($target);

        $this.addClass('on');
        $this.next().slideDown();
      } else {
        $('dd').slideUp();
        _self.onremove($target);

      }
    });
  },
  onremove: function($target) {
    $target.removeClass('on');
  }

};
acodian.click('dt');
</script>

<?php include "../inc/footer.php"; ?>