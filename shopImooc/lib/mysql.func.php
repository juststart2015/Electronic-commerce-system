<?php
	//该语句屏蔽了php的notice警告，如undefined variable等
	ini_set("error_reporting","E_ALL & ~E_NOTICE");
	//连接数据库
	function connect(){
		$link = mysql_connect(DB_HOST,DB_USER,DB_PWD)or die("数据库连接失败Error：".mysql_errno().":".mysql_error());
		mysql_set_charset(DB_CHARSET);
		mysql_select_db(DB_DBNAME) or die ("指定数据库打开失败");
		return $link;
	}
	
	//插入数据库操作
	function insert($table,$array){
		$keys = join(",",array_keys($array));
		$vals = "'".join("','",array_values($array))."'";
		$sql = "insert {$table}($keys) values({$vals})";
		mysql_query($sql);
		return mysql_insert_id();
	}
	
	//更新数据库操作
	//这里的$str用于接受循环结果的值，$sep接受间隔符，最终形成一个sql段存入$str中并被$sql调用
	function update($table,$array,$where=null){
		foreach($array as $key => $val){
			if($str == null){
				$sep = "";
			}else{
				$sep = ",";
			}
			$str.=$sep.$key."='".$val."'";
		}
		$sql = "update {$table} set {$str}".($where == null?null:" where ".$where);
		$result = mysql_query($sql);
		//这里添加判断，执行结果是否为真，即是否执行成功
		if($result){
			return mysql_affected_rows();
		}else{
			return false;
		}
	}
	
	//删除数据库记录
	function delete($table,$where=null){
		$where = $where == null?null:" where ".$where;
		$sql = "delete from {$table} {$where}";
		mysql_query($sql);
		return mysql_affected_rows();
	}
	
	//查询一条记录
	function fetchOne($sql,$result_type=MYSQL_ASSOC){
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result,$result_type);
		return $row;
	}
	
	//插叙所有记录
	function fetchAll($sql,$result_type=MYSQL_ASSOC){
		$result = mysql_query($sql);
		while(@$row=mysql_fetch_array($result,$result_type)){
			$rows[]=$row;
		}
		return $rows;
	}
	
	//查询记录条数
	function getResultNum($sql){
		$result = mysql_query($sql);
		return mysql_num_rows($result);
	}
?>