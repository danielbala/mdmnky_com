<?php

  //db connection details

  

  //make connection
  $server = mysql_connect($host, $user, $password);
  $connection = mysql_select_db($database, $server);


	if ( isset($_REQUEST['says']) ) {
		//insert into db
		//get POST data 
		$the_text = mysql_real_escape_string($_POST["the_text"]); 
		$top = mysql_real_escape_string($_POST["top"]);  
		$left = mysql_real_escape_string($_POST["left"]);  
		$id = mysql_real_escape_string($_POST["id"]); 
		$rel = mysql_real_escape_string($_POST["rel"]);
		$profile_url  = mysql_real_escape_string($_POST["profile_url"]);
		$img_url = mysql_real_escape_string($_POST["img_url"]);
		$time_string  = mysql_real_escape_string($_POST["time_string"]);
		$the_series = mysql_real_escape_string($_POST["the_series"]);
		$the_print = mysql_real_escape_string($_POST["the_print"]);
		
		//add new comment to database  
		mysql_query("INSERT INTO comments (the_text, the_top, the_left, unique_id, the_rel, profile_url, img_url, time_string, the_series, the_print) VALUES ('$the_text','$top','$left','$id','$rel','$profile_url','$img_url','$time_string','$the_series','$the_print')");

		//echo "INSERT INTO comments (the_text, the_top, the_left, unique_id, the_rel, profile_url, img_url, time_string) VALUES ('$the_text','$top','$left','$id','$rel','$profile_url','$img_url','$time_string')";
		
	}elseif ( isset($_REQUEST['remove']) ) {
		//insert into db
		//get POST data 
		$the_id = mysql_real_escape_string($_POST["the_id"]);

		//add new comment to database  
		mysql_query("UPDATE comments set is_active = 0 WHERE unique_id = '$the_id'");
		//echo "UPDATE comments set is_active = 0 WHERE unique_id = '$the_id'";

	}else{
		//query the database
		$the_series = mysql_real_escape_string($_GET["the_series"]);
		$the_print = mysql_real_escape_string($_GET["the_print"]);
		$query = mysql_query("SELECT * FROM comments where is_active = 1 and the_series = '$the_series' and the_print = '$the_print' ORDER BY id ASC");

		//loop through and return results
		for ($x = 0, $numrows = mysql_num_rows($query); $x < $numrows; $x++) {
			$row = mysql_fetch_assoc($query);

			$comments[$x] = array("the_text" => $row["the_text"], "top" => $row["the_top"], "left" => $row["the_left"], "id" => $row["unique_id"], "rel" => $row["the_rel"], "profile_url" => $row["profile_url"], "img_url" => $row["img_url"], "time_string" => $row["time_string"]);
			//echo JSON to page
			
			
		}//FOR
		$response = $_GET["jsoncallback"] . "(" . json_encode($comments) . ");";
		//$response = json_encode($comments);
		echo $response;
	 } 

?>