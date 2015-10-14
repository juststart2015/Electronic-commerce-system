<?php
	require_once ("../include.php");
	$rows = getAllAdmin();
	//判断是否有管理员存在，若没有则跳转到addAdmin.php中，并执行exit退出本页面
	if(!$rows){
		alertMes("sorry,没有管理员，请添加！","addAdmin.php");
		exit;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
<link rel="stylesheet" href="styles/backstage.css">
</head>
<body>
<div class="details">
                    <div class="details_operation clearfix">
                        <div class="bui_select">
                            <input type="button" value="添&nbsp;&nbsp;加" class="add"  onclick="addAdmin()">
                        </div>
                            
                    </div>
                    <!--表格-->
                    <table class="table" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th width="15%">编号</th>
                                <th width="25%">管理员名称</th>
								<th width="30%">管理员邮箱</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
							<?php $i = 1; foreach($rows as $row): ?>
								<tr>
									<!--这里的id和for里面的c1 需要循环出来-->
									<td><input type="checkbox" id="c1" class="check"><label for="c1" class="label"><?php echo $i; ?></label></td>
									<td><?php echo $row['username']; ?></td>
									<td><?php echo $row['email']; ?></td>
									<td align="center"><input type="button" value="修改" class="btn" onClick="editAdmin(<?php echo $row['id']; ?>)"><input type="button" value="删除" class="btn" onClick="delAdmin(<?php echo $row['id']; ?>)"></td>
								</tr>
							<?php $i++; endforeach; ?>
                        </tbody>
                    </table>
                </div>
</body>
<script type="text/javascript">
	function addAdmin(){
		window.location = "addAdmin.php";
	}
	function editAdmin(id){
		window.location = "editAdmin.php?id="+id;
	}
	function delAdmin(id){
		if(window.confirm("您确定要删除吗？删除之后不可以恢复哦！！")){
			window.location = "doAdminAction.php?act=delAdmin&id="+id;
		}
	}
</script>
</html>