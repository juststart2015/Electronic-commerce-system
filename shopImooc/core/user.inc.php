<?php 
function reg(){
	$arr=$_POST;
	$arr['password']=md5($_POST['password']);
	$arr['regTime']=time();
	$uploadFile=uploadFile();
	
	//print_r($uploadFile);
	if($uploadFile&&is_array($uploadFile)){
		$arr['face']=$uploadFile[0]['name'];
	}else{
		return "注册失败";
	}
//	print_r($arr);exit;
	if(insert("imooc_user", $arr)){
		$mes="注册成功!<br/>3秒钟后跳转到登陆页面!<meta http-equiv='refresh' content='3;url=login.php'/>";
	}else{
		$filename="uploads/".$uploadFile[0]['name'];
		if(file_exists($filename)){
			unlink($filename);
		}
		$mes="注册失败!<br/><a href='reg.php'>重新注册</a>|<a href='index.php'>查看首页</a>";
	}
	return $mes;
}
function login(){
	$username=$_POST['username'];
	//防sql注入语句
	//第一种方法：addslashes():使用反斜线引用特殊字符
	//$username=addslashes($username);
	//第二种方法：mysql_escape_string():转换一个字符串，用于mysql_query
	$username=mysql_escape_string($username);
	$password=md5($_POST['password']);
	$sql="select * from imooc_user where username='{$username}' and password='{$password}'";
	/*以下语句打印出的sql语句，看出恶意攻击的sql注入
	//如有人在账户名中输入“ ' or 1=1 # ”
	//这段代码，那语句会变成select * from imooc_user where username='‘ or 1 = 1 #' and password='d41d8cd98f00b204e9800998ecf8427e'
	//那等于用户名为空或者1=1的sql语句，这句永远为空，则返回ture，那根据下面语句，就会直接登录
	//echo $sql;exit;
	*/
	//$resNum=getResultNum($sql);
	$row=fetchOne($sql);
	//echo $resNum;
	if($row){
		$_SESSION['loginFlag']=$row['id'];
		$_SESSION['username']=$row['username'];
		$mes="登陆成功！<br/>3秒钟后跳转到首页<meta http-equiv='refresh' content='3;url=index.php'/>";
	}else{
		$mes="登陆失败！<a href='login.php'>重新登陆</a>";
	}
	return $mes;
}

function userOut(){
	$_SESSION=array();
	if(isset($_COOKIE[session_name()])){
		setcookie(session_name(),"",time()-1);
	}

	session_destroy();
	header("location:index.php");
}
