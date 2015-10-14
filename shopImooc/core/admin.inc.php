<?php
	//检查是否有该管理员存在
	function checkAdmin($sql){
		return fetchOne($sql);
	}
	
	//检查是否有管理员登录
	function checkLogined(){
		if($_SESSION['adminId'] == ""&&$_COOKIE['adminId'] == ""){
			alertMes("请先登录","login.php");
		}
	}
	
	//添加管理员函数
	function addAdmin(){
		$arr = $_POST;
		//以下语句用md5加密传进来的密码
		$arr['password'] = md5($_POST['password']);
		if(insert("imooc_admin",$arr)){
			$mes = "添加成功！<br/><a href='addAdmin.php'>继续添加</a>|<a href='listAdmin.php'>查看管理员列表</a>";
		}else{
			$mes = "添加失败！<br/><a href='addAdmin.php'>重新添加</a>";
		}
		return $mes;
	}
	
	//得到所有管理员
	function getAllAdmin(){
		$sql = "select id,username,email from imooc_admin";
		$rows = fetchAll($sql);
		return $rows;
	}
	
	//编辑管理员
	function editAdmin($id){
		$arr = $_POST;
		$arr['password'] = md5($_POST['password']);
		if(update("imooc_admin",$arr,"id={$id}")){
			$mes = "编辑成功！<br/><a href='listAdmin.php'>查看管理员列表</a>";
		}else{
			$mes = "编辑失败！<br/><a href='listAdmin.php'>请重新修改</a>";
		}
		return $mes;
	}
	
	//删除管理员
	function delAdmin($id){
		if(delete("imooc_admin","id={$id}")){
			$mes = "删除成功！<br/><a href ='listAdmin.php'>查看管理员列表</a>";
		}else{
			$mes = "删除失败！<br/><a href ='listAdmin.php'>请重新删除</a>";
		}
		return $mes;
	}
	
	function logout(){
		$_SESSION = array();
		if(isset($_COOKIE[session_name()])){
			setcookie(session_name(),"",time()-1);
		}
		if(isset($_COOKIE['adminId'])){
			setcookie("adminId","",time()-1);
		}
		if(isset($_COOKIE['adminName'])){
			setcookie("adminName","",time()-1);
		}
		session_destroy();
		header("location:login.php");
	}
?>