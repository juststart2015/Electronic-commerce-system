<?php
	require_once("../include.php");
	$username = $_POST['username'];
	$password = md5($_POST['password']);
	//POST过来的verify
	$verify = $_POST['verify'];
	//session中的verify
	$verify1 = $_SESSION['$sess_name'];
	if($verify == $verify1){
		$sql = "select * from imooc_admin where username = '{$username}' and password = '{$password}'";
		$row = checkAdmin($sql);
		if($row){
			$_SESSION['adminName'] = $row['username'];
			$_SESSION['adminId'] = $row['id'];
			alertMes("登录成功","index.php");
			//header("location:index.php");
		}else{
			alertMes("登录失败，重新登录","login.php");
		}
	}else{
		alertMes("验证码错误","login.php");
		/*封装了跳转函数，在common.func.php中
		echo "<script>alert('验证码错误');</script>";
		echo "<script>window.location='login.php'</script>";
		*/
	}
?>