<?php 
	/**
	 * 添加商品
	 * @return string
	 */
	function addPro(){
		//POST来信息存储在$arr数组中
		$arr=$_POST;
		//发布时间，定义为当前时间
		$arr['pubTime']=time();
		//存储路径为uploads
		$path="./uploads";
		//调用上传文件函数
		$uploadFiles=uploadFile($path);
		//判断是否有值
		if(is_array($uploadFiles)&&$uploadFiles){
			//遍历数组产生缩略图并存储进各目录中，这里../image_50代表根目录下的image_50文件夹
			foreach($uploadFiles as $key=>$uploadFile){
				thumb($path."/".$uploadFile['name'],"../image_50/".$uploadFile['name'],50,50);
				thumb($path."/".$uploadFile['name'],"../image_220/".$uploadFile['name'],220,220);
				thumb($path."/".$uploadFile['name'],"../image_350/".$uploadFile['name'],350,350);
				thumb($path."/".$uploadFile['name'],"../image_800/".$uploadFile['name'],800,800);
			}
		}
		//调用插入函数
		$res=insert("imooc_pro",$arr);
		//得到刚刚执行的insert操作产生的ID
		$pid=getInsertId();
		//判断是否insert成功
		if($res&&$pid){
			//循环uploadFiles里的值，获得id、albumPath并插入数据库中
			foreach($uploadFiles as $uploadFile){
				$arr1['pid']=$pid;
				$arr1['albumPath']=$uploadFile['name'];
				//调用album.inc.php里的addAlbum函数
				addAlbum($arr1);
			}
			$mes="<p>添加成功!</p><a href='addPro.php' target='mainFrame'>继续添加</a>|<a href='listPro.php' target='mainFrame'>查看商品列表</a>";
		}else{//若不成功，删除对应文件
			foreach($uploadFiles as $uploadFile){
				if(file_exists("../image_800/".$uploadFile['name'])){
					//若不成功，删除对应文件
					unlink("../image_800/".$uploadFile['name']);
				}
				if(file_exists("../image_50/".$uploadFile['name'])){
					unlink("../image_50/".$uploadFile['name']);
				}
				if(file_exists("../image_220/".$uploadFile['name'])){
					unlink("../image_220/".$uploadFile['name']);
				}
				if(file_exists("../image_350/".$uploadFile['name'])){
					unlink("../image_350/".$uploadFile['name']);
				}
			}
			$mes="<p>添加失败!</p><a href='addPro.php' target='mainFrame'>重新添加</a>";
		}
		return $mes;
	}
	/**
	 *编辑商品
	 * @param int $id
	 * @return string
	 */
	function editPro($id){
		$arr=$_POST;
		$path="./uploads";
		$uploadFiles=uploadFile($path);
		if(is_array($uploadFiles)&&$uploadFiles){
			foreach($uploadFiles as $key=>$uploadFile){
				thumb($path."/".$uploadFile['name'],"../image_50/".$uploadFile['name'],50,50);
				thumb($path."/".$uploadFile['name'],"../image_220/".$uploadFile['name'],220,220);
				thumb($path."/".$uploadFile['name'],"../image_350/".$uploadFile['name'],350,350);
				thumb($path."/".$uploadFile['name'],"../image_800/".$uploadFile['name'],800,800);
			}
		}
		$where="id={$id}";
		$res=update("imooc_pro",$arr,$where);
		$pid=$id;
		if($res&&$pid){
			//判断是否有图片上传
			if($uploadFiles &&is_array($uploadFiles)){
				foreach($uploadFiles as $uploadFile){
					$arr1['pid']=$pid;
					$arr1['albumPath']=$uploadFile['name'];
					addAlbum($arr1);
				}
			}
			$mes="<p>编辑成功!</p><a href='listPro.php' target='mainFrame'>查看商品列表</a>";
		}else{
		if(is_array($uploadFiles)&&$uploadFiles){
			foreach($uploadFiles as $uploadFile){
				if(file_exists("../image_800/".$uploadFile['name'])){
					unlink("../image_800/".$uploadFile['name']);
				}
				if(file_exists("../image_50/".$uploadFile['name'])){
					unlink("../image_50/".$uploadFile['name']);
				}
				if(file_exists("../image_220/".$uploadFile['name'])){
					unlink("../image_220/".$uploadFile['name']);
				}
				if(file_exists("../image_350/".$uploadFile['name'])){
					unlink("../image_350/".$uploadFile['name']);
				}
			}
		}
			$mes="<p>编辑失败!</p><a href='listPro.php' target='mainFrame'>重新编辑</a>";
			
		}
		return $mes;
	}
	
	//根据商品ID删除商品
	function delPro($id){
		$where="id=$id";
		$res=delete("imooc_pro",$where);
		//根据ID获取图片信息
		$proImgs=getAllImgByProId($id);
		//判断是否有图片存在
		if($proImgs&&is_array($proImgs)){
			//遍历循环删除商品图片
			foreach($proImgs as $proImg){
				if(file_exists("uploads/".$proImg['albumPath'])){
					unlink("uploads/".$proImg['albumPath']);
				}
				if(file_exists("../image_50/".$proImg['albumPath'])){
					unlink("../image_50/".$proImg['albumPath']);
				}
				if(file_exists("../image_220/".$proImg['albumPath'])){
					unlink("../image_220/".$proImg['albumPath']);
				}
				if(file_exists("../image_350/".$proImg['albumPath'])){
					unlink("../image_350/".$proImg['albumPath']);
				}
				if(file_exists("../image_800/".$proImg['albumPath'])){
					unlink("../image_800/".$proImg['albumPath']);
				}
			}
		}
		$where1="pid={$id}";
		$res1=delete("imooc_album",$where1);
		if($res&&$res1){
			$mes="删除成功!<br/><a href='listPro.php' target='mainFrame'>查看商品列表</a>";
		}else{
			$mes="删除失败!<br/><a href='listPro.php' target='mainFrame'>重新删除</a>";
		}
		return $mes;
	}


	/**
	 * 得到商品的所有信息
	 * @return array
	 */
	function getAllProByAdmin(){
		//内联查询函数，关联量表查询
		$sql="select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName from imooc_pro as p join imooc_cate c on p.cId=c.id";
		$rows=fetchAll($sql);
		return $rows;
	}

	/**
	 *根据商品id得到商品图片
	 * @param int $id
	 * @return array
	 */
	function getAllImgByProId($id){
		$sql="select a.albumPath from imooc_album a where pid={$id}";
		$rows=fetchAll($sql);
		return $rows;
	}

	/**
	 * 根据id得到商品的详细信息
	 * @param int $id
	 * @return array
	 */
	function getProById($id){
		//根据ID查询商品信息sql语句
		$sql="select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from imooc_pro as p join imooc_cate c on p.cId=c.id where p.id={$id}";
		$row=fetchOne($sql);
		return $row;
	}
	/**
	 * 检查分类下是否有产品
	 * @param int $cid
	 * @return array
	 */
	function checkProExist($cid){
		$sql="select * from imooc_pro where cId={$cid}";
		$rows=fetchAll($sql);
		return $rows;
	}

	/**
	 * 得到所有商品信息
	 * @return array
	 */
	function getAllPros(){
		$sql="select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from imooc_pro as p join imooc_cate c on p.cId=c.id ";
		$rows=fetchAll($sql);
		return $rows;
	}

	/**
	 *根据cid得到4条产品
	 * @param int $cid
	 * @return Array
	 */
	function getProsByCid($cid){
		$sql="select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from imooc_pro as p join imooc_cate c on p.cId=c.id where p.cId={$cid} limit 4";
		$rows=fetchAll($sql);
		return $rows;
	}

	/**
	 * 得到下4条产品
	 * @param int $cid
	 * @return array
	 */
	function getSmallProsByCid($cid){
	/*
	limit是mysql的语法：
	select * from table limit m,n
	其中m是指记录开始的index，从0开始，表示第一条记录
	n是指从第m+1条开始，取n条。
	select * from tablename limit 2,4
	即取出第3条至第6条，4条记录
	*/
	//这里用limit4,4，是因为前台大图片已经能够显示了4条了，下面要显示的为第5条开始，所以是4，后面的4是来限制只取4条
		$sql="select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from imooc_pro as p join imooc_cate c on p.cId=c.id where p.cId={$cid} limit 4,4";
		$rows=fetchAll($sql);
		return $rows;
	}

/**
 *得到商品ID和商品名称
 * @return array
 */
function getProInfo(){
	$sql="select id,pName from imooc_pro order by id asc";
	$rows=fetchAll($sql);
	return $rows;
}
