<?php include_once('./_common.php');
if (!defined('_KSTOUR_')) exit; // 개별 페이지 접근 불가
$main = new main();
$ip = $main->user_ip();
$incom = "PC";
$indate = date("Y-m-d H:i");
$group_name = $_POST['group']."(".$_POST['group_detail'].")";
$time = $_REQUEST['time'];

$start_date = $_REQUEST['start_year']."-".$_REQUEST['start_month']."-".$_REQUEST['start_day'];
$end_date = date("Y-m-d", strtotime($start_date . "+{$_REQUEST['start_stay']} days"));
$SQL = "insert into reservation_user_content(user_id,
                                                      reserv_name,
                                                      reserv_group_name,
                                                      reserv_phone,
                                                      reserv_email,
                                                      reserv_fax,
                                                      reserv_counsel,
                                                      reserv_time,
                                                      reserv_departure_area,                                              
                                                      reserv_tour_start_date,
                                                      reserv_tour_end_date,
                                                      reserv_adult_number,
                                                      reserv_child_number,
                                                      reserv_baby_number,
                                                      reserv_young_number,
                                                      reserv_inquiry,
                                                      reserv_ip,
                                                      reserv_type,
                                                      reserv_state,
                                                      reserv_incom_type,
                                                      reserv_group,
                                                      indate
                                                      ) VALUES 
                                                      (
                                                      '{$_SESSION['user_id']}',
                                                      '{$_POST['name']}',
                                                      '{$group_name}',
                                                      '{$_POST['phone']}',
                                                      '{$_POST['email']}',
                                                      '{$_POST['fax']}',
                                                      '{$_POST['advice']}',
                                                      '{$time}',
                                                      '{$_POST['area']}',
                                                      '{$start_date}',
                                                      '{$end_date}',
                                                      '{$_POST['adult_number']}',
                                                      '{$_POST['child_number']}',
                                                      '{$_POST['baby_number']}',
                                                      '{$_POST['yong_number']}',
                                                      '{$_POST['reserv_inquiry']}',
                                                      '{$ip}',
                                                      '단체',
                                                      'WT',
                                                      '{$incom}',
                                                      'Y',
                                                      '{$indate}'
                                                      )
                                                      ";


$rs = $db->sql_query($SQL);
$reserv_no = $db->insert_id();
$SQL_basic = "insert into reservation_user_content_basic(user_id,
                                                      reserv_user_no,
                                                      reserv_name,
                                                      reserv_group_name,
                                                      reserv_phone,
                                                      reserv_email,
                                                      reserv_fax,
                                                      reserv_counsel,
                                                      reserv_time,
                                                      reserv_departure_area,                                              
                                                      reserv_tour_start_date,
                                                      reserv_tour_end_date,
                                                      reserv_adult_number,
                                                      reserv_child_number,
                                                      reserv_baby_number,
                                                      reserv_young_number,
                                                      reserv_inquiry,
                                                      reserv_ip,
                                                      reserv_type,
                                                      reserv_state,
                                                      reserv_incom_type,
                                                      reserv_group,
                                                      indate
                                                      ) VALUES 
                                                      (
                                                      '{$_SESSION['user_id']}',
                                                      '{$reserv_no}',
                                                      '{$_POST['name']}',
                                                      '{$group_name}',
                                                      '{$_POST['phone']}',
                                                      '{$_POST['email']}',
                                                      '{$_POST['fax']}',
                                                      '{$_POST['advice']}',
                                                      '{$time}',
                                                      '{$_POST['area']}',
                                                      '{$start_date}',
                                                      '{$end_date}',
                                                      '{$_POST['adult_number']}',
                                                      '{$_POST['child_number']}',
                                                      '{$_POST['baby_number']}',
                                                      '{$_POST['yong_number']}',
                                                      '{$_POST['reserv_inquiry']}',
                                                      '{$ip}',
                                                      '단체',
                                                      'WT',
                                                      '{$incom}',
                                                      'Y',
                                                      '{$indate}'
                                                      )
                                                      ";

$db->sql_query($SQL_basic);
$reserv_start_date  = date("Y-m-d",time());
$reserv_end_date  = date("Y-m-d", strtotime(time()." +7 days"));

$sql_amount = "insert into reservation_amount(reserv_user_no,reserv_deposit_price,reserv_deposit_date,reserv_balance_price,reserv_balance_date,reserv_total_price,indate) 
                                        values('{$reserv_no}','{$reserv_price}','{$reserv_start_date}','{$balance_price}','{$reserv_start_date}','{$total_price}','{$indate}')";
$db->sql_query($sql_amount);
$sql_amount_basic = "insert into reservation_amount_basic(reserv_user_no,reserv_deposit_price,reserv_deposit_date,reserv_balance_price,reserv_balance_date,reserv_total_price,indate) 
                                        values('{$reserv_no}','{$reserv_price}','{$reserv_start_date}','{$balance_price}','{$reserv_start_date}','{$total_price}','{$indate}')";
$db->sql_query($sql_amount_basic);
echo "<script>
            alert('단체문의가 접수되었습니다. 감사합니다.')
            window.location.href = '/group/group.php'
       </script>
      ";
?>