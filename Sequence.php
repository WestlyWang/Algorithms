<?php
	function opt($x,$y,$dismatch_cost,$gap_cost,&$newx,&$newy){
		$xarray = str_split($x);//字符串转数组
		$yarray = str_split($y);
		$xlen = count($xarray);
		$ylen = count($yarray);
		$opt = array();//最优对准值数组，数组中行列都默认添加一个 tap - 
		/*计算最优对准数组*/
		for($k=$xlen+$ylen;$k>=0;$k--){ //确定按对角线计算需要的计算次数
			$i = $k > $xlen ? $xlen : $k;//确定行的起始值,下三角从xlen起，上三角从k起
			for(;$i>=0;$i--){
				$j = $k - $i;//计算列值，超出最大列号退出
				if($j>$ylen){
					break;
				}
				if($i==$xlen){
					$opt[$i][$j] = $gap_cost*($ylen - $j);//最下行，值为添加tap的代价*需要添加的个数
				}else if($j==$ylen){
					$opt[$i][$j] = $gap_cost*($xlen - $i);//最右列，值为添加tap的代价*需要添加的个数
				}else{
					//不是边界，取添加tap 和 添加mismatch的最小代价方案
					$opt[$i][$j] = minSequence(
							$opt[$i+1][$j+1] + ($xarray[$i] == $yarray[$j] ? 0 : $dismatch_cost),
							$opt[$i+1][$j] + $gap_cost,
							$opt[$i][$j+1] + $gap_cost
							);
				}

			}
		}
		$i = 0;
		$j = 0;
		while($i != $xlen && $j != $ylen){
			/**
			  *opt[i+1][j+1] ==  取x[i] y[j]
			  *opt[i+1][j] == 取x[i] -
			  *opt[i][j+1] == 取- y[j]
			 */
			$xchar = "-";
			$ychar = "-";
			if($opt[$i][$j] == ($opt[$i+1][$j] + $gap_cost)){
				$xchar = $xarray[$i];
				$i = $i + 1;
			}else if($opt[$i][$j] == ($opt[$i][$j+1] + $gap_cost)){
				$ychar = $yarray[$j];
				$j = $j + 1;
			}else{
				$xchar = $xarray[$i];
				$i = $i + 1;
				$ychar = $yarray[$j];
				$j = $j + 1;
			}
			$newx = $newx.$xchar;
			$newy = $newy.$ychar;
		}
		//若x未遍历完，则x不变，y加tap
		while($i < $xlen){
			$newx = $newx.$xarray[$i];
			$newy = $newy."-";
			$i++;
		}
		//若y未遍历完，y不变，x加tap
		while($j < $ylen){
			$newx = $newx."-";
			$newy = $newy.$yarray[$j];
			$j++;
		}
		return $opt[0][0];
	}
	function minSequence($a,$b,$c){
		if($a<$b && $a<$c){
			return $a;
		}
		if($b<$a && $b<$c){
			return $b;
		}
		return $c;
	}
	echo opt("TAAGGTCA","AACAGTTACC",3,2,$newx,$newy).PHP_EOL;
	echo $newx.PHP_EOL;
	echo $newy.PHP_EOL;
?>
