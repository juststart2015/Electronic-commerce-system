<?php
	//检查是否有该管理员存在
	function checkAdmin($sql){
		return fetchOne($sql);
	}
	
	//检查是否有管理员登录
	function checkLogined(){
		if($_SESSION['adminId'] == ""){
			alertMes("请先登录","login.php");
		}
	}
	
	function logout(){
		$_SESSION = array();
		if(isset($_COOKIE[session_name()])){
			setcookie(session_name(),"",time()-1);
		}
		session_destroy();
		header("location:login.php");
	}
?>