<?php
	//构建上传文件信息
	function buildInfo(){
		$i = 0;
		foreach($_FILES as $v){
			//单文件上传,若数组里的一个字符串，则只有一个文件，
			if(is_string($v['name'])){
				$files[$i]=$v;
				$i++;
			}else{//多文件上传，若里面是一个数组，则肯定是多文件
				foreach($v['name'] as $key => $val){
					$files[$i]['name']=$val;
					$files[$i]['size']=$v['size'][$key];
					$files[$i]['tmp_name']=$v['tmp_name'][$key];
					$files[$i]['error']=$v['error'][$key];
					$files[$i]['type']=$v['type'][$key];
					$i++;
				}
			}
		}
		return $files;
	}
	
	//上传文件函数
	function uploadFile($path="uploads",$allowExt=array("gif","jpeg","jpg","png","wbmp"),$maxSize=10485760,$imgFlag=true){
		//判断并构建目录
		if(!file_exists($path)){
			mkdir($path,0777,true);
		}
		$i=0;
		//获取文件信息
		$files = buildInfo();
		//循环文件信息
		foreach($files as $file){
			//判断是否上传成功
			if($file['error'] == UPLOAD_ERR_OK){
				$ext = getExt($file['name']);
				//检查文件的扩展名
				if(!in_array($ext,$allowExt)){
					exit("非法文件类型");
				}
				//校验是否是真正的图片类型
				if($imaFlag){
					if(getimagesize($file['tmp_name'])){
						exit("不是真正的图片类型");
					}
				}
				//上传文件的大小
				if($file['size']>$maxSize){
					exit("上传文件过大");
				}
				//判断是否通过HTTP POST方式上传上来的
				if(!is_uploaded_file($file['tmp_name'])){
					exit("不是通过HTTP POST方式上传上来的");
				}
				//生成文件唯一的字符串并命名给该文件
				$filename = getUniName().".".$ext;
				//文件详细存储路径
				$destination = $path."/".$filename;
				//移动生成的随机文件名并存储到相应目录下去
				if(move_uploaded_file($file['tmp_name'],$destination)){
					//命名文件名
					$file['name']=$filename;
					//unset()函数丢弃数组内相应的数据
					unset($file['error'],$file['tmp_name'],$file['size'],$file['type']);
					//生成数组名赋值
					$uploadedFiles[$i]=$file;
					$i++;
				}
			}else{
				switch($file['error']){
					case 1:
						$mes = "超过了配置文件上传文件的大小";//upload_max_filesize = 64M
						break;
					case 2:
						$mes = "超过了表单设置上传文件的大小";//post_max_size = 10M
						break;
					case 3:
						$mes = "文件部分被上传";
						break;
					case 4:
						$mes = "没有文件被上传";
						break;
					case 6:
						$mes = "没有找到临时目录";
						break;
					case 7:
						$mes = "文件不可写";
						break;
					case 8:
						$mes = "由于PHP的扩展程序中断了文件上传";
						break;
				}
				echo $mes;
			}
		}
		return $uploadedFiles;
	}
?>﻿