<?php
/*
	该文件内容被复制到新文件内并被引用时，可以正常执行
	但引用此文件时，总是出错，很郁闷，未找到原因
*/
	//产生随机数字验证码
	function buildRandomString($type = 1,$length = 4 ){
		//range()函数列举参数内的所有数，并生成一个数组，如range(0,50,10)，则以10为最小单位，列举0、10、20、30、40、50的一个数组
		//join()函数以某定义参数(默认逗号)为分隔符，罗列数组内的值,如join(".",array(0,5)),则输出以“，”为分割符的0、1、2、3、4、5的一个数组
		if($type == 1){
			$chars = join("",range(0,9));
		}else if($type == 2){
			//array_merge()函数，合并两个或多个数字，若键名一致，则后者覆盖前者
			$chars = join("",array_merge(range("a","z"),range("A","Z")));
		}else if($type == 3){
			$chars = join("",array_merge(range("a","z"),range("A","Z"),range(0,9)));
		}
		//strlen()计算字符串长度，这里判断所需求的长度$length与生成的随机数字对比，哪个长，若所需的长，那数组产生的不够，无法满足需求，则抛出提示
		if($length > strlen($chars)){
			//exit()，输出内容并退出当前脚本
			exit("字符串长度不够");
		}
		//str_shuffle()函数随机的打乱字符串中的所有字符
		$chars = str_shuffle($chars);
		//substr()从字符串中返回指定位数的及长度的字符
		return substr($chars,0,$length);
	}
?>