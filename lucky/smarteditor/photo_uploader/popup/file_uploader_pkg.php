<?php
echo $_REQUEST["htImageInfo"];

// default redirection
$url = $_REQUEST["callback"].'?callback_func='.$_REQUEST["callback_func"];
$bSuccessUpload = is_uploaded_file($_FILES['Filedata']['tmp_name']);

// SUCCESSFUL
if(bSuccessUpload) {




$abs_dir = $_SERVER[DOCUMENT_ROOT]."/buspkg/images";        //�������� ������
$web_dir = "/board/upload_img";                  //�����

    $filename = date("YmdHis").$m.eregi_replace("(.+)(\.[gif|jpg|png])","\\2",$_FILES['Filedata']['name']);
    $u = "{$web_dir}/{$filename}";
    $result=move_uploaded_file($_FILES['Filedata']['tmp_name'], "{$abs_dir}/{$filename}");

	
	$url .= "&bNewLine=true";
	$url .= "&sFileName=".urlencode(urlencode($filename));
	$url .= "&sFileURL=/buspkg/images/".urlencode(urlencode($filename));
}
// FAILED
else {
	$url .= '&errstr=error';
}

header('Location: '. $url);
?>


