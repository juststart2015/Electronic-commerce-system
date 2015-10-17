<?php
	require_once ("../include.php");
	$act = $_REQUEST['act'];
	$id = $_REQUEST['id'];
	if($act == "logout"){
		logout();
	}elseif($act == "addAdmin"){
		$mes = addAdmin();
	}elseif($act == "editAdmin"){
		$mes = editAdmin($id);
	}elseif($act == "delAdmin"){
		$mes = delAdmin($id);
	}elseif($act == "addCate"){
		$mes = addCate();
	}elseif($act == "editCate"){
		$where = "id={$id}";
		$mes = editCate($where);
	}elseif($act == "delCate"){
		$mes = delCate($id);
	}elseif($act == "addPro"){
		$mes = addPro();
	}elseif($act == "editPro"){
		$mes = editPro($id);
	}elseif($act == "delPro"){
		$mes = delPro($id);
	}elseif($act == "addUser"){
		$mes = addUser();
	}elseif($act == "delUser"){
		$mes = delUser($id);
	}elseif($act == "editUser"){
		$mes = editUser($id);
	}elseif($act == "waterText"){
		$mes = doWaterText($id);
	}elseif($act == "waterPic"){
		$mes = doWaterPic($id);
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Insert title here</title>
</head>
<body>
<?php
	if($mes){
		echo $mes;
	}
?>
</body>
</html>