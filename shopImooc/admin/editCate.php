<?php
	require_once ("../include.php");
	$id = $_REQUEST['id'];
	$row = getCateById($id);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Insert title here</title>
</head>
<body>
	<h3>修改分类</h3>
	<form action="doAdminAction.php?act=editCate&id=<?php echo $id; ?>" method="post">
		<table width="70%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
			<tr>
				<td align="right">分类名称</td>
				<td><input type="text" name="cName" value="<?php echo $row['cName']; ?>" /></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" value="修改分类" /></td>
			</tr>
		</table>
	</form>
</body>
</html>