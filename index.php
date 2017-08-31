<?php
	//index.php
	
	require_once(__DIR__ . "/db.php");
	require_once(__DIR__ . "/functions.php");
	require_once(__DIR__ . "/tokens.php");
	
	$max = 3; //max number of items to recommend
	if(isset($_POST['action']) && $_POST['action'] == 'getRecommendation') {
		
		if( !isset($_POST['token']) || !token_verify($_POST['token']))
			die("<div class='alert alert-danger' >Token expired..<br>Reload to generate new one</div>");
		
		echo token_gen() . "|";
		
		if(!isset($_POST['items']))
			die("<div class='alert alert-danger' >`items` parameter is required</div>");
		else if(!isset($_POST['trans_id']) || strlen($_POST['trans_id']) < 1)
			die("<div class='alert alert-danger' >You must provide transaction id</div>");
		
		$items = explode("," , $_POST['items']);
		
		if(isset($_POST['addrow']) && $_POST['addrow'])
			if(!addRow( $_POST['trans_id'] , $items ))
				echo "<div class='alert alert-danger' >Error While adding new row: " . db_error() . "</div>";
		
		$prefList = findPrefences($items);
		
		$total = 0;
		foreach($prefList as $pref=>$val)
			$total += $val;
		
		if($total == 0) { //No Recommendations Found
			
			$prefs = array();
			$c = count($items);
			for($i=0;$i< $c;$i++) {
				$p = array();
				for($j=0;$j<$c;$j++)
					if($j != $i)
						$p[] = $items[$j];
				$prefs[] = $p;
			}
			
			$prefList = array();
			
			foreach($prefs as $pref)
				$prefList = pref_merge( $prefList , findPrefences($pref) , $items );
			
		}
		
		arsort( $prefList );
		
		$c = count( $prefList );
		$keys = array_keys( $prefList );
		
		if($c < 1)
			die("<div class='alert alert-danger' >No Recommended Items Found</div>");
		
		//echo "<pre>"; print_r( $prefList ) ; echo "</pre>";
		echo "<div class='alert alert-info' >Recommended Items are :<ul>";
		
		for($i=0;$i<$c && $i < $max;$i++)
			echo "<li>{$keys[$i]} - {$prefList[$keys[$i]]} People Bought this Item</li>";
		
		echo "</ul></div>";
		die();
	}
?>
<html>
	<head>
		<title>Items Recommendation</title>
		<link rel='stylesheet' href='css/bootswatch.css' />
		<style>
			[name="item[]"] {
				margin-bottom:5px;
			}
		</style>
	</head>
	<body class='container' >
		
		<h3 align='center' class='alert alert-danger' >Recommend Items based on previous sales record</h3>
		
		<div id='response' ></div>
		<form method='post' id='mainform' >
			
			<label for='transid' >Transaction ID:</label>
			<input type='text' id='transid' class='form-control' placeholder='AXX0012Y' required />
			
			<div id='template' class='hidden' >
				<input type='text' name='item[]' class='form-control' placeholder='Item name' />
			</div>
			
			<div id='row_container' >
				<label>List of Items:</label>
				<input type='text' name='item[]' class='form-control' placeholder='Item name' />
				<input type='text' name='item[]' class='form-control' placeholder='Item name' />
			</div>
			
			<br>
			<input type='button' class='btn btn-info' value='Add More Items' id='addrow' /> <input type='reset' class='btn btn-primary' value='Clear' />
			<br><br>
			<input type='checkbox' id='addtodb' /> <label for='addtodb' >Add Data to Database?</label><br>
			<input type='submit' class='btn btn-danger' value='Find Similar Items' />
			
		</form>
		
	</body>
</html>
<script src='js/jquery.min.js' ></script>
<script>
(function () {
	var token = "<?php echo token_gen(); ?>";
	$("#addrow").click(function () {
		$("#row_container").append( $("#template").html() );
	});
	$("#mainform").submit(function (e) {
		e.preventDefault();
		var data = { action : "getRecommendation" , trans_id : $("#transid").val() , items : [] , token : token , addrow : !!$("#addtodb").prop("checked") };
		
		$("#row_container").find("[name='item[]']").filter(function () {
			if(this.value.trim().length > 0)
				data.items.push( this.value.trim() );
		});
		
		data.items = data.items.join(",");
		
		$("#response").html("<div class='alert alert-info'> Loading..</div>");
		$.post( window.location.href , data , function (r) {
			token = r.match(/^[A-Za-z0-9]+/i);
			
			if(!token)
				return $("#response").html(r);
			
			r = r.replace(token,'').replace("|",'');
			
			token = token[0];
			
			$("#response").html( r );
		}).error(function () {
			$("#response").html("<div class='alert alert-danger' >Check your internet connection / Access Denied</div>");
		});
	});
})();
</script>