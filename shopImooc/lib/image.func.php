<?php
	//引入 string.func.php
	require_once("string.func.php");
	//产生验证码函数verifyImage()
	function verifyImage($type =1,$length = 4,$pixel = 0,$line = 0,$sess_name = "verify"){
		session_start();
		//0b_clean()函数丢弃输出缓冲区中的内容
		ob_clean();
		//通过GD库做验证码
		//创建画布宽、高
		$width = 80;
		$height = 28;
		//imagecreatetruecolor()函数新建一个真彩色图像，返回一个图像标示符，代表了一幅大小为X、Y(两个参数)的黑色图像
		$image = imagecreatetruecolor($width,$height);
		//imagecolorallocate()为一副图像分配颜色，语法：imagecolorallocate(resource $image,$red,$green,$blue)
		//填充画布颜色，白色255,255,255,画笔颜色，黑色0,0,0
		$white = imagecolorallocate($image,255,255,255);
		//$black创建画笔颜色
		$black = imagecolorallocate($image,0,0,0);
		//imagefilledrectangle()函数，画一矩形并填充，语法：imagefilledrectangle(resource $image,$x1,$y1,$x2,$y2,int $color)
		//用填充矩形填充画布，把画布变成白色
		imagefilledrectangle($image,1,1,$width-2,$height-2,$white);
		//引用string.func.php文件内的buildRandomString()函数产生随机数
		$chars = buildRandomString($type,$length);
		//把该验证码赋值给$sess_name，以便后面与用户输入的进行验证对比
		$_SESSION['$sess_name'] = $chars;
		//因字体文件太大，上传GitHub及下载时过分耗时，故删减成2个字体文件，其余字体可自行添加
		//$fontfiles = array("MSYH.TTF","MSYHBD.TTF","SIMLI.TTF","SIMSUN.TTC","SIMYOU.TTF","STZHONGS.TTF");
		$fontfiles = array("SIMLI.TTF","SIMYOU.TTF");
		//for循环生成随机验证码
		for($i = 0; $i < $length; $i++){
			//mt_rand()函数，使用Mersenne Twister算法返回随机整数
			//$size变量定义字体大小
			$size = mt_rand(14,18);
			//angle变量定义字体旋转角度
			$angle = mt_rand(-15,15);
			//$x、$y定义了字体在图片内的位置
			$x = 5+ $i*$size;
			$y = mt_rand(20,26);
			$fontfile = "../fonts/".$fontfiles[mt_rand(0,count($fontfiles)-1)];
			$color = imagecolorallocate($image,mt_rand(50,90),mt_rand(80,200),mt_rand(90,180));
			$text = substr($chars,$i,1);
			//imagettftext()函数用TrueType字体向图像写入字体
			//array imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
			//这里图像源为$image包含的已创建的图床，$size、$angle定义了里面字体的大小及旋转的角度，$x、$y定义了字体在图片内的位置，$color定义了填充的颜色，$fontfile定义了字体路径，$text定义了要输入的数字
			imagettftext($image,$size,$angle,$x,$y,$color,$fontfile,$text);
		}
		
		//该函数给图像加上小点做干扰，默认是50个点，封装后放入verifyImage()函数中做参数
		//$pixel = 50;
		if($pixel){
			for($i = 0;$i < $pixel; $i++){
				imagesetpixel($image,mt_rand(0,$width-1),mt_rand(0,$height-1),$black);
			}
		}
		
		//该函数给图像加上直线，默认是10根，封装后放入verifyImage()函数中做参数
		//$line = 10;
		if($line){
			for($i=1;$i<$line;$i++){
				$color = imagecolorallocate($image,mt_rand(50,90),mt_rand(80,200),mt_rand(90,180));
				imageline($image,mt_rand(0,$width-1),mt_rand(0,$height-1),mt_rand(0,$width-1),mt_rand(0,$height-1),$color);
			}
		}
		
		header('Content-Type: image/gif');
		//imagegif把图像以gif文件格式输出到浏览器或文件
		imagegif($image);
		//inagedestroy销毁图像，释放与image关联的内存
		imagedestroy($image);
	}
	
	//生成缩略图函数
	function thumb($filename,$destination=null,$dst_w=null,$dst_h=null,$isReservedSource=false,$scale=0.5){
		//list()函数为里面的元素赋上数组中的值,getimagesize ( string $filename [, array &$imageinfo ] )获取图像的大小，若没有有效信息，返回false
		list($src_w,$src_h,$imagetype)=getimagesize($filename);
		//设置默认缩放比例
		//$scale = 0.5;
		//判断是否设置缩放比
		if(is_null($dst_w)||is_null($dst_h)){
			$dst_w = ceil($src_w*$scale);
			$dst_h = ceil($src_h*$scale);
		}
		//image_type_to_mime_type()函数判断一个imagetype常量的MIME类型
		//MIME 消息能包含文本、图像、音频、视频以及其他应用程序专用的数据。
		//返回值类似：IMAGETYPE_GIF 对应 image/gif;IMAGETYPE_JPEG对应image/jpeg.
		$mime = image_type_to_mime_type($imagetype);
		//echo $mime;这里输出image/jpeg
		//替换mime数据里的/为createfrom
		//创建画布资源，原句为：$src_image = imagecreatefromjpeg,这里因为是jpeg所以写formjpeg,若是gif则为creategif
		//这里函数用替换法来灵活的确定创建什么样子的画布把image/jpeg变成imagecreatejpeg
		$createFun = str_replace("/","createfrom",$mime);
		//创建一个JPEG图像并保存，原句为:imagejpeg()
		//imagejpeg(resource $image[, string $filename [, int $quality ]] )函数以$filename问文件名创建一个JPEG图像，输出图像至浏览器或文件中，若有路径则到文件在
		//这里函数用替换法来灵活确定输出什么样子的图片，把image/jpeg变成imagejpeg
		$outFun = str_replace("/",null,$mime);
		//图片资源赋值给$src_image,即imagecreatejpeg出来的内容赋值给$src_image
		$src_image = $createFun($filename);
		//imagecreatetruecolor()创建一个真彩色图像
		$dst_image = imagecreatetruecolor($dst_w,$dst_h);
		//将一幅图像中的一块正方形区域拷贝到另一个图像中，平滑的插入像素值，因此，尤其是，减小了图像的大小而仍然保持了极大的清晰度。
		//这里将$src_image插入$dst_image中
		imagecopyresampled($dst_image,$src_image,0,0,0,0,$dst_w,$dst_h,$src_w,$src_h);
		//判断存储路径是否存在,dirname() 函数返回路径中的目录部分。
		if($destination&&!file_exists(dirname($destination))){
			mkdir(dirname($destination),0777,true);
		}
		//生成唯一的文件名
		$dstFilename = $destination == null?getUniName().".".getExt($filename):$destination;
		//存储文件至文件夹中
		$outFun($dst_image,$dstFilename);
		imagedestroy($src_image);
		imagedestroy($dst_image);
		//isReservedSource，判断是否保留原目录里的原文件，这里预设了false，所以为删除
		if(!$isReservedSource){
			//unlink() 函数删除文件。
			unlink($filename);
		}
		return $dstFilename;
	}
?>