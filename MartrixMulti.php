<?php
	/**
	  * 校验传输的矩阵列表是否符合矩阵相乘范式
	  */
	function validate($arr_martrixs,$len){
		for($i=1;$i<$len-1;$i++){
			if($arr_martrixs[$i][1] != $arr_martrixs[$i+1][0]){
				return false;
			}
		}
		return true;
	}

	/**
	  *计算矩阵相乘的最后序列
	  */
	function calc($arr_martrixs,$len){
		if(!validate($arr_martrixs)){
			echo "Error".PHP_EOL;
		}
		$multi_martrixs = array();
		$paths = array();
		for($i=0;$i<$len;$i++){
			for($j=0;$j<$len;$j++){
				$multi_martrixs[$i][$j] = 0;
				$paths[$i][$j] = 0;
			}
		}
		for($j=1;$j<$len;$j++){
			for($i=1;$i<=$len-$j;$i++){
				/**
				  *矩阵相乘只具有结合律
				  *若先计算前1 -- n-1的矩阵乘法，在乘An，则需要的乘法数为T(1--n-1)+M1.row*Mn.row*Mn.col
				  *若先计算前2 -- n的矩阵乘法，在乘A1，则需要的乘法数为T(2--n)+M1.row*M1.col*Mn.col
				  *依次类推,计算Mi*....*Mj
				  *若先计算前i -- j-1的矩阵乘法，在乘Aj，则需要的乘法数为T(i--j-1)+Mi.row*Mj.row*Mj.col
				  *若先计算前i+1 -- j的矩阵乘法，在乘Ai，则需要的乘法数为T(i+1--j)+Mi.row*Mi.col*Mj.col
				  *取最小乘法数，同时记录相乘路径
				  *若先计算i---j-1，则路径为需先经过j-1，后j
				  *若先计算i+1---j，则路径为需先经过i+1，后i
				  */
				$multi_martrixs[$i][$i+$j] = minNum($multi_martrixs[$i][$i+$j-1]+$arr_martrixs[$i][0]*$arr_martrixs[$i+$j][0]*$arr_martrixs[$i+$j][1],
						$multi_martrixs[$i+1][$i+$j]+$arr_martrixs[$i][0]*$arr_martrixs[$i][1]*$arr_martrixs[$i+$j][1],$pathk);
				$paths[$i][$i+$j] = $pathk == 0 ? $i+$j-1 : $i;
			}
		}
		order(1,$len-1,$paths);
		echo PHP_EOL;
	}

	function order($i,$j,$paths){
		if($i==$j){
			echo "M".$i;
		}else{
			$k = $paths[$i][$j];
			echo "(";
			order($i,$k,$paths);
			order($k+1,$j,$paths);
			echo ")";
		}
	}
	
	function minNum($a,$b,&$k){
		$k = $a>$b?1:0;
		return $a>$b?$b:$a;
	}

	function run(){
		$arr_martrixs = array();
		$arr_martrixs[0] = array(0,0);
		$arr_martrixs[1] = array(20,2);
		$arr_martrixs[2] = array(2,30);
		$arr_martrixs[3] = array(30,12);
		$arr_martrixs[4] = array(12,8);
		$len = count($arr_martrixs);
		calc($arr_martrixs,$len);//arr_martrixs 代表矩阵链的行列值，len是矩阵链的长度
	}
	run();
?>
