<?php
	/**
	  *weight:无向图权重
	  *tree:生成的最小生成树
	  *n:无向图大小
	  *v:起始顶点
	  *inf:无穷大
	  */
	function prim($weight,$v,$n,$inf,&$tree){
		$tree = array();
		$nearest = array();//未加入的顶点的最近顶点 ，默认为v
		$distance = array();//各个顶点到顶点v的距离
		/*初始化顶点的最近顶点为v及最近距离*/
		for($i=0;$i<$n;$i++){
			if($i == $v){
				continue;
			}
			$nearest[$i] = $v;
			$distance[$i] = $weight[$v][$i];
		}
		for($i=0;$i<$n;$i++){
			for($j=0;$j<$n;$j++){
				$tree[$i][$j] = $inf;
			}
		}
		for($k=1;$k<$n;$k++){
			//寻找到顶点集v的最近顶点及距离
			$min = $inf;
			for($i=0;$i<$n;$i++){
				if($i==$v){
					continue;
				}
				if($distance[$i] != -1 && $distance[$i] < $min){
					$min = $distance[$i];
					$vnear = $i;
				}
			}
			$tree[$nearest[$vnear]][$vnear] = $min;
			$tree[$vnear][$nearest[$vnear]] = $min;
			$distance[$vnear] = -1;
			/*更新最近距离及顶点*/
			for($i=0;$i<$n;$i++){
				if($i==$v){
					continue;
				}
				if($weight[$i][$vnear] < $distance[$i]){
					$distance[$i] = $weight[$i][$vnear];
					$nearest[$i] = $vnear;
				}
			}
		}
	}

	function printTree($v,$tree,$inf,$n){
		$seq = array();
		array_push($seq,$v);
		array_push($seq,$inf);
		while(count($seq) > 0){
			$v = array_shift($seq);
			if($v == $inf){
				echo PHP_EOL;
				continue;
			}
			echo "v".$v;
			$flag = 0;
			for($i=0;$i<$n;$i++){
				if($tree[$v][$i] != $inf){
					array_push($seq,$i);
					$tree[$v][$i] = $inf;
					$tree[$i][$v] = $inf;
					$flag = 1;
				}
			}
			if($flag){
				array_push($seq,$inf);
			}
		}
	}

	function run(){
		$inf = 99999;
		$weight =  array();
		$weight[0] = array(0,1,3,$inf,$inf);
		$weight[1] =  array(1,0,3,6,$inf);
		$weight[2] =  array(3,3,0,4,2);
		$weight[3] =  array($inf,6,4,0,5);
		$weight[4] =  array($inf,$inf,2,5,0);
		$v = 1;
		prim($weight,$v,5,$inf,$tree);
		printTree($v,$tree,$inf,5);
	}
	run();
?>
