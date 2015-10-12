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
		$fontfiles = array("MSYH.TTF","MSYHBD.TTF","SIMLI.TTF","SIMSUN.TTC","SIMYOU.TTF","STZHONGS.TTF");
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
?>