        <div class="rcon">
            <p>예약확인</p><p>고객님이 예약하신 내역을 확인하실 수 있습니다.</p>

            <form action="board.php?board=reserv_list" method="post">
                <div class="tbl_wrap">
                    <table>
                        <tr>
                            <th>
                                예약자성함
                            </th>
                            <td>
                                <input type="text" name="name"/>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                예약자연락처
                            </th>
                            <td class="last">
                                <input type="text" name="phone" id="phone"/>
                            </td>

                        </tr>
                    </table>
                </div>
                <p class="btn"><input type="image" src="../sub_img/res_confirm.png" /></p>
            </form>
        </div>
        <script>
            function phone_chk(str){
                str = str.replace(/[^0-9]/g, '');
                var tmp = '';
                if( str.length < 4){
                    return str;
                }else if(str.length < 7){
                    tmp += str.substr(0, 3);
                    tmp += '-';
                    tmp += str.substr(3);
                    return tmp;
                }else if(str.length < 11){
                    tmp += str.substr(0, 3);
                    tmp += '-';
                    tmp += str.substr(3, 3);
                    tmp += '-';
                    tmp += str.substr(6);
                    return tmp;
                }else{
                    tmp += str.substr(0, 3);
                    tmp += '-';
                    tmp += str.substr(3, 4);
                    tmp += '-';
                    tmp += str.substr(7);
                    return tmp;
                }
                return str;
            }

            var phone = document.getElementById('phone');
            phone.onkeyup = function(event){
                event = event || window.event;
                var _val = this.value.trim();
                this.value = phone_chk(_val) ;
            }


        </script>