<?php
	
	/*
		functions.php
		Contains various functions to Extract , Add & Analyse data present in Transaction Table
	*/
	
	
	/* addRow( $trans_id , $items[Array(a,b,c)] ) - Adds new transaction to table */
	function addRow($transid , $items) {
		$transid = escapestr($transid);
		
		return db_query("INSERT INTO `" . __DB_TABLE . "` (`trans_id` ,`items`) VALUES ('{$transid}','" . escapestr( implode(",",$items) ) . "')");
		
	}
	
	/* Fetch Row via Transaction id */
	function getRow($transid) {
		$res = db_query("SELECT `items` FROM `" . __DB_TABLE . "` WHERE `trans_id`='" . escapestr($transid) . "'");
		
		$row = $res->fetch_object();
		$items = explode("," , $row->items);
		
		return $items;
	}
	
	
	/* Returns an array containing all possible combination of elements in $ar
		if(input == array(0,1,2))
			output = array(
				array(0,1,2),
				array(0,2,1),
				array(1,0,2),
				array(1,2,0),
				array(2,1,0),
				array(2,0,1)
			);
	*/
	function __combinations( $ar , $cpy = array()) {
		
		$ret = array();
		
		foreach($ar as $key=>$val) {
			$copy = $cpy;
			$copy[$key] = $val;
			$temp = array_diff_key( $ar , $copy );
			
			if(count($temp) == 0)
				$ret[] = $copy;
			else
				$ret = array_merge( $ret , __combinations( $temp , $copy) );
			
		}
		
		return $ret;
		
	}
	
	
	/* Finds what other items were bought when purchasing items provided in $items */
	function findPrefences($items) {
		
		$searches = array();
		
		$combi = __combinations( $items ); //get all possible combinations of items
		
		foreach($combi as $com) {
			
			$searches[] = "`items` REGEXP '^(.+,)?" . preg_replace("/^\^,/" , "^" , escapestr( implode(",(.+,)?" , $com) ) ) . ".*'"; //create regexp statement
			//Preg_replace to remove starting , (comma) which is added due to implode
			
		}
		
		$sql = db_query("SELECT * FROM `" . __DB_TABLE . "` WHERE " . implode(" OR " , $searches) ); //Execute Query 
		
		if($sql->num_rows < 1)
			return array();
		
		$recommendations = array();
		
		while($row = $sql->fetch_object()) {
			$itm = explode(',' , $row->items);
			
			foreach($itm as $i)
				$recommendations[ $i ] = isset($recommendations[$i]) ? $recommendations[$i] + 1 : 1;
		}
		
		
		foreach($recommendations as $itm=>$num) {
			if( in_array($itm,$items) )
				unset($recommendations[$itm]); //if $itm exists in $items then remove it from recommendations
		}
		
		return $recommendations;
	}
	
	function pref_merge($p1,$p2,$items) {
		
		foreach($p2 as $itm=>$val) {
			if(in_array($itm,$items))
				continue;
			
			if(!isset($p1[$itm]))
				$p1[$itm] = 0;
			$p1[$itm] += $val;
		}
		
		return $p1;
	}
	