<?php
	require_once ("../include.php");
	//分页
	$sql = "select id,username,email,activeFlag from imooc_user {$where}";
	$totalRows = getResultNum($sql);
	$pageSize=2;
	$totalPage=ceil($totalRows/$pageSize);
	$page=$_REQUEST['page']?(int)$_REQUEST['page']:1;
	if($page<1||$page==null||!is_numeric($page))$page=1;
	if($page>$totalPage)$page=$totalPage;
	$offset = ($page-1)*$pageSize;
	$sql = "select id,username,email,activeFlag from imooc_user {$where} limit {$offset},{$pageSize}";
	$rows = fetchAll($sql);
	//查询出所有用户信息
	//$sql = "select id,username,email,activeFlag from imooc_user";
	//$rows = fetchAll($sql);
	//判断是否有用户存在，若没有则跳转到addUser.php中，并执行exit退出本页面
	if(!$rows){
		alertMes("sorry,没有用户，请添加！","addUser.php");
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
                                <th width="20%">用户名称</th>
								<th width="20%">用户邮箱</th>
								<th width="20%">是否激活</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
							<!-- 循环出管理员列表表格 -->
							<?php foreach($rows as $row): ?>
								<tr>
									<!--这里的id和for里面的c1 需要循环出来-->
									<td><input type="checkbox" id="c1" class="check"><label for="c1" class="label"><?php echo $row['id']; ?></label></td>
									<td><?php echo $row['username']; ?></td>
									<td><?php echo $row['email']; ?></td>
									<td>
										<?php
											echo $row['activeFlag']==0?"未激活":"激活";
										?>
									</td>
									<td align="center"><input type="button" value="修改" class="btn" onClick="editUser(<?php echo $row['id']; ?>)"><input type="button" value="删除" class="btn" onClick="delUser(<?php echo $row['id']; ?>)"></td>
								</tr>
							<?php endforeach; ?>
							<!-- 显示分页列表 -->
						   <?php if($totalRows>=$pageSize): ?>
								<tr>
									<td colspan="7"><?php echo showPage($page,$totalPage,"keywords={$keywords}&order={$order}"); ?>
								</tr>
							<?php endif; ?>
                        </tbody>
                    </table>
                </div>
</body>
<script type="text/javascript">
	function addUser(){
		window.location = "addUser.php";
	}
	function editUser(id){
		window.location = "editUser.php?id="+id;
	}
	function delUser(id){
		if(window.confirm("您确定要删除吗？删除之后不可以恢复哦！！")){
			window.location = "doAdminAction.php?act=delUser&id="+id;
		}
	}
</script>
</html>