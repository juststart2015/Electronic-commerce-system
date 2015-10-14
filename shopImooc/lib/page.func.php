<?php
	/*分页编写时参考数据
	require_once ("../include.php");
	//查询imooc_admin内的所有记录
	$sql = "select * from imooc_admin";
	//得到所有记录的记录数
	$totalRows = getResultNum($sql);
	//$pageSize记录每页显示几条，
	$pageSize = 2;
	//得到总页码数
	$totalPage = ceil($totalRows/$pageSize);
	//定义默认页码,(int)转换数据为整型
	$page = $_REQUEST['page']?(int)$_REQUEST['page']:1;
	//判断是否小于1，是否为空，或者不是数字，则都为$page都为1
	if($page<1||$page==null||!is_numeric($page)){
		$page = 1;
	}
	//判断传入的页码如果超过总页码数，则值为最大的页码数
	if($page >= $totalPage){
		$page = $totalPage;
	}
	$offset = ($page-1)*$pageSize;
	//$offset定义偏移量，$pageSize定义显示记录数
	$sql = "select * from imooc_admin limit {$offset},{$pageSize}";
	$rows = fetchAll($sql);
	foreach($rows as $row){
		echo "编号：".$row['id']."<br/>";
		echo "管理员的名称：".$row['username']."<hr/>";
	}
	echo showPage($page,$totalPage,"cid=5");
	*/
	//封装分页函数，$page为当前页，$totalPage为总页数，$where用于传入多个参数，如某个类别下的第几页，传入一个page=1&cid=5，$sep为分隔符
	function showPage($page,$totalPage,$where=null,$sep="&nbsp;"){
		$where = ($where==null)?null:"&".$where;
		//调用自身页面地址
		$url = $_SESSION['PHP_SELF'];
		//判断当前页码为第几页，并以此判断首页、尾页、上一页、下一页
		$index = ($page == 1)?"首页":"<a href='{$url}?page=1{$where}'>首页</a>";
		$last = ($page == $totalPage)?"尾页":"<a href='{$url}?page={$totalPage}{$where}'>尾页</a>";
		$prevPage = ($page>=1)?$page-1:1;
		$nextPage = ($page>=$totalPage)?$totalPage:$page+1;
		$prev = ($page == 1)?"上一页":"<a href='{$url}?page={$prevPage}{$where}'>上一页</a>";
		$next = ($page == $totalPage)?"下一页":"<a href='{$url}?page={$nextPage}{$where}'>下一页</a>";
		$str = "总共{$totalPage}页/当前是第{$page}页";
		//循环出页码数
		for($i=1;$i<=$totalPage;$i++){
			//判断当前页数，若与i吻合，则直接显示该页数
			if($page == $i){
				$p.="[{$i}]";
			//若不吻合，则输出一个带连接的页数
			}else{
				//非当前页的页数，都带上超链接，页码数为其本身(也就是$i,$i是不断循环的)
				$p.="<a href='{$url}?page={$i}{$where}'>[{$i}]</a>";
			}
		}
		//按此顺序输出，并返回出去
		$pageStr = $str.$sep.$index.$sep.$prev.$sep.$p.$sep.$next.$sep.$last;
		return $pageStr;
	}
?>