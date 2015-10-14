<?php
	header("content-type:text/html;charset=utf-8");
	session_start();
	//dirname(__FILE__)返回当前文件的路径名；单纯的__FILE__是PHP常定量，返回文件所在的路径及文件名
	//define(a,b,c)，a为常量名，b为常量值，c确定是否对大小写敏感(可选)，返回常量a的值b；
	define("ROOT",dirname(__FILE__));
	//string set_include_path ( string $new_include_path )为当前脚本设置include_path运行时的配置选项new_include_path为新值，
	//string get_include_path ( void )获取当前include_path配置选项的值
	set_include_path(".".PATH_SEPARATOR.ROOT."/lib".PATH_SEPARATOR.ROOT."/core".PATH_SEPARATOR.ROOT."/configs".PATH_SEPARATOR.get_include_path());
	require_once ("common.func.php");
	require_once ("image.func.php");
	require_once ("mysql.func.php");
	require_once ("page.func.php");
	require_once ("string.func.php");
	require_once ("upload.func.php");
	require_once ("configs.php");
	require_once ("admin.inc.php");
	require_once ("cate.inc.php");
	connect();
?>