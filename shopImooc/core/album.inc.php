<?php 
	//插入数据库中
	function addAlbum($arr){
		insert("imooc_album", $arr);
	}

	/**
	 * 根据商品id得到商品图片
	 * @param int $id
	 * @return array
	 */
	function getProImgById($id){
		$sql="select albumPath from imooc_album where pid={$id} limit 1";
		$row=fetchOne($sql);
		return $row;
	}

	/**
	 * 根据商品id得到所有图片
	 * @param int $id
	 * @return array
	 */
	function getProImgsById($id){
		$sql="select albumPath from imooc_album where pid={$id} ";
		$rows=fetchAll($sql);
		return $rows;
	}
	/**
	 * 文字水印的效果
	 * @param int $id
	 * @return string
	 */
	function doWaterText($id){
		$rows=getProImgsById($id);
		foreach($rows as $row){
			//定义要加文字水印的图片路径及文件名,这里给大图文件夹image_800内的图片加水印
			$filename="../image_800/".$row['albumPath'];
			waterText($filename);
		}
		$mes="操作成功！<br/><a href='listProImages.php' target='mainFrame'>查看商品图片列表</a>";
		return $mes;
	}
	
	/**
	 *图片水印
	 * @param int $id
	 * @return string
	 */
	function doWaterPic($id){
		$rows=getProImgsById($id);
		foreach($rows as $row){
			$filename="../image_800/".$row['albumPath'];
			waterPic($filename);
		}
		$mes="操作成功！<br/><a href='listProImages.php' target='mainFrame'>查看商品图片列表</a>";
		return $mes;
	}
?>




