<?php
error_reporting(1);
include_once('config.php');
include_once('general_functions.php');

ini_set('soap.wsdl_cache_enabled',0);
ini_set('soap.wsdl_cache_ttl',0);
extract($_REQUEST);
// $current_year = select_query_json("Select Poryear From Codeinc", "Centra", 'TCS'); // Get the Current Year

try {
	// connect and login to FTP server
	$ftp_conn = ftp_connect(ftpvri_server_apdsk, 5022) or die("Could not connect to ftpvri_server_apdsk");
	$login = ftp_login($ftp_conn, ftpvri_user_name_apdsk, ftpvri_user_pass_apdsk);
}
catch(Exception $e) { //catch exception
  echo 'Error Message: ' .$e->getMessage();
}

// Find User Rights
function find_user_rights($mainmenu, $user)
{
	$inner_mainmenu = select_query_json("select VEWVALU from SRM_MENU mnu, SRM_MENU_ACCESS acc
												where mnu.MNUCODE = acc.MNUCODE and mnu.MAINMENU = '".$mainmenu."' and acc.entsrno = ".$user."
												order by mnu.MNUCODE Asc", "Centra", 'TCS');
	/* $inner_mainmenu = select_query_json("select VEWVALU from SRM_MENU mnu, SRM_MENU_ACCESS acc
												where mnu.MNUCODE = acc.MNUCODE and acc.entsrno = ".$user."
												order by VEWVALU DESC, mnu.MNUCODE Asc", "Centra", 'TCS'); */
	$access = 0;
	for($menu = 0; $menu < count($inner_mainmenu); $menu++)
	{
		if($inner_mainmenu[$menu]['VEWVALU'] == 'Y')
		{
			$access++;
		}
	}
	if($access == 0) { return 0; }
	else { return 1; }
}
// Find User Rights

// Find User Rights
function find_user_rightsAll($user)
{
	$inner_mainmenu = select_query_json("select VEWVALU,MAINMENU from SRM_MENU mnu, SRM_MENU_ACCESS acc
												where mnu.MNUCODE = acc.MNUCODE and acc.entsrno = ".$user."
												order by mnu.MNUCODE Asc", "Centra", 'TCS');
	return $inner_mainmenu;
}
// Find User Rights

// Insert Database Query
function insert_dbquery($field_values, $tbl_names)
{
	try {
		$key_value = array_keys($field_values);
		$org_value = array_values($field_values);
		$key_values = array_keys($field_values);

		for($ii = 0; $ii < count($field_values); $ii++) {
			$expld = explode("~~",$org_value[$ii]);
			if($expld[1] != '')
			{
				$kvl .= $key_values[$ii].", ";
				$kyvl .= "to_date('".$expld[1]."', '".$expld[0]."'), ";
				$kkvl[] = "".$key_values[$ii]."";
			} else {
				$kvl .= $key_values[$ii].", ";
				$kyvl .= "'".$org_value[$ii]."', ";
				$kkvl[] = "".$key_values[$ii]."";
			}
		}
		$kyvl = rtrim($kyvl, ", ");
		$kvl = rtrim($kvl, ", ");

		$sql_insert ="insert into ".$tbl_names." (".$kvl.") values (".$kyvl.")";
		 if($tbl_names=='EMPLOYEE_CONVERT_DETAILS'){
			 $q=date('Y-m-d His').".txt";
			 $a1local_file = "uploads/empconvert/".$q;
			 $fp=fopen($a1local_file,'w');
			 fwrite($fp,$sql_insert);
             fclose($fp);
		} 

		$save_query = save_query_json($sql_insert, "Centra", 'TCS');
		return $save_query;
	}
	catch(Exception $e) {
		echo 'Message: ' .$e->getMessage();
	}
}
// Insert Database Query
function insert_brn_dbquery($field_values, $tbl_names, $brn_connection = 'Centra', $schema_source = 'TCS')
{
	try {
		$key_value = array_keys($field_values);
		$org_value = array_values($field_values);
		$key_values = array_keys($field_values);

		for($ii = 0; $ii < count($field_values); $ii++) {
			$expld = explode("~~",$org_value[$ii]);
			if($expld[1] != '')
			{
				$kvl .= $key_values[$ii].", ";
				$kyvl .= "to_date('".$expld[1]."', '".$expld[0]."'), ";
				$kkvl[] = "".$key_values[$ii]."";
			} else {
				$kvl .= $key_values[$ii].", ";
				$kyvl .= "'".$org_value[$ii]."', ";
				$kkvl[] = "".$key_values[$ii]."";
			}
		}
		$kyvl = rtrim($kyvl, ", ");
		$kvl = rtrim($kvl, ", ");

		$sql_insert ="insert into ".$tbl_names." (".$kvl.") values (".$kyvl.")";
		 if($tbl_names=='EMPLOYEE_CONVERT_DETAILS'){
			 $q=date('Y-m-d His').".txt";
			 $a1local_file = "uploads/empconvert/".$q;
			 $fp=fopen($a1local_file,'w');
			 fwrite($fp,$sql_insert);
             fclose($fp);
		} 

		$save_query = save_query_json($sql_insert, $brn_connection, $schema_source);
		return $save_query;
	}
	catch(Exception $e) {
		echo 'Message: ' .$e->getMessage();
	}
}
function insert1_dbquery($field_values, $tbl_names)
{
	try {
		$key_value = array_keys($field_values);
		$org_value = array_values($field_values);
		$key_values = array_keys($field_values);

		for($ii = 0; $ii < count($field_values); $ii++) {
			$expld = explode("~~",$org_value[$ii]);
			if($expld[1] != '')
			{
				$kvl .= $key_values[$ii].", ";
				$kyvl .= "to_date('".$expld[1]."', '".$expld[0]."'), ";
				$kkvl[] = "".$key_values[$ii]."";
			} else {
				$kvl .= $key_values[$ii].", ";
				$kyvl .= "'".$org_value[$ii]."', ";
				$kkvl[] = "".$key_values[$ii]."";
			}
		}
		$kyvl = rtrim($kyvl, ", ");
		$kvl = rtrim($kvl, ", ");

	echo	$sql_insert ="insert into ".$tbl_names." (".$kvl.") values (".$kyvl.")";
		/* if($tbl_names=='approval_timer'){
			 $q=date('Y-m-d His').".txt";
			 $a1local_file = "uploads/".$q;
			 $fp=fopen($a1local_file,'w');
			 fwrite($fp,$sql_insert);
             fclose($fp);
		} */

		$save_query = save_query_json($sql_insert, "Centra", 'TCS');
		return $save_query;
	}
	catch(Exception $e) {
		echo 'Message: ' .$e->getMessage();
	}
}
// Insert Database Query

// InsertImage Database Query
function insert_testquery_image($field_values, $tbl_names,$files)
{
	// include("config.php");
	// echo $_SESSION['tcstest_username'] ."!=".$_SESSION['tcstest_password'] ."!=".$_SESSION['tcstest_host_db'] ."!=".$_SESSION['dbassign'] ."!=<br>";
	// echo "==@@==";
	include_once("../db_connect/config.php");
	$connect_db = oci_connect($_SESSION['username1'], $_SESSION['password1'], $_SESSION['host_db1'], 'AL32UTF8');
		$key_value = array_keys($field_values);
		$org_value = array_values($field_values);
		$key_values = array_keys($field_values);
		
		//print_r($key_value);
		//echo '</br>';
		for($ii = 0; $ii < count($field_values); $ii++) {
			$expld = explode("~~",$org_value[$ii]);
			$expldImg = explode("~*~",$org_value[$ii]);
			if($expld[1] != '')
			{
				$kvl .= $key_values[$ii].", ";
				$kyvl .= "to_date(:".$key_values[$ii].", '".$expld[0]."'), ";
				$kkvl[] = "".$key_values[$ii]."";
			}else if($expldImg[1]!=''){
				$kvl .= $key_values[$ii].", ";
				$kyvl .= "EMPTY_BLOB(), ";
				$kkvl[] = "EMPTY_BLOB(), ";
			} else {
				$kvl .= $key_values[$ii].", ";
				$kyvl .= ":".$key_values[$ii].", ";
				$kkvl[] = "".$key_values[$ii]."";
			}
			
			
		}
		$kyvl = rtrim($kyvl, ", ");
		$kvl = rtrim($kvl, ", ");

		 $sql_insert ="insert into ".$tbl_names." (".$kvl.") values (".$kyvl.") RETURNING EMPPHOT INTO :LOB_A";
		 
		
		
		//echo '</br>';
		$image = file_get_contents($files['prd_image']['tmp_name']);
		//$image = file_get_contents("../images/back.jpg");
		
		//var_dump($image);;
		//$image = addslashes(file_get_contents($_FILES['prd_image']['tmp_name']));
		//exit;
		
		//var_dump($image);
		$res_insert=oci_parse($connect_db, $sql_insert);
		for($ij = 0; $ij < count($field_values); $ij++) {
			$expld = explode("~~",$org_value[$ij]);
			$expldImg = explode("~*~",$org_value[$ij]);
			if($expld[1] != '')
			{
				oci_bind_by_name($res_insert, $kkvl[$ij], $expld[1]);
			}else if($expldImg[1]!=''){
				$lob_a = oci_new_descriptor($connect_db, OCI_D_LOB);
				oci_bind_by_name($res_insert, ':LOB_A', $lob_a, -1, OCI_B_BLOB);
				
				//var_dump($c);
			} else {
				oci_bind_by_name($res_insert, $kkvl[$ij], $org_value[$ij]);
			}
		}
		$res_execute = oci_execute($res_insert, OCI_DEFAULT);
		if(!$res_execute) {
			  $e = error_get_last();
			  $f = oci_error();
			  echo "Message: ".$e['message']."\n";
			  echo "File: ".$e['file']."\n";
			  echo "Line: ".$e['line']."\n";
			  echo "Oracle Message: ".$f['message'];
			  // exit if you consider this fatal
			  exit(9);
			} else {
			 // save the blob data
			  $abc = $lob_a->save($image);
			  //var_dump($abc);
			  
			  oci_commit($connect_db);
			  
			 // commit the query
			  //oci_commit($con);
			  // free up the blob descriptors
			 
			  $lob_a->free();
			 
			}
		//$res_execute=oci_execute($res_insert);
		// $res_execute = oci_execute($res_insert, OCI_NO_AUTO_COMMIT);
		
		if($res_execute) {
			return '1';
		}
		else {
			$arr_error = oci_error($res_insert);
			return $arr_error['message'];
		}
		
	
	
	
	
}

// Insert Database Query
function insert_req_dbquery($field_values, $tbl_names)
{
	try {
		$key_value = array_keys($field_values);
		$org_value = array_values($field_values);
		$key_values = array_keys($field_values);

		for($ii = 0; $ii < count($field_values); $ii++) {
			$expld = explode("~~",$org_value[$ii]);
			if($expld[1] != '')
			{
				$kvl .= $key_values[$ii].", ";
				$kyvl .= "to_date('".$expld[1]."', '".$expld[0]."'), ";
				$kkvl[] = "".$key_values[$ii]."";
			} else {
				$kvl .= $key_values[$ii].", ";
				$kyvl .= "'".$org_value[$ii]."', ";
				$kkvl[] = "".$key_values[$ii]."";
			}
		}
		$kyvl = rtrim($kyvl, ", ");
		$kvl = rtrim($kvl, ", ");

		 $sql_insert ="insert into ".$tbl_names." (".$kvl.") values (".$kyvl.")";
		/* if($tbl_names=='approval_timer'){
			 $q=date('Y-m-d His').".txt";
			 $a1local_file = "uploads/".$q;
			 $fp=fopen($a1local_file,'w');
			 fwrite($fp,$sql_insert);
             fclose($fp);
		} */

		$save_query = save_query_json($sql_insert, "Req", 'TCS');
		return $save_query;
	}
	catch(Exception $e) {
		echo 'Message: ' .$e->getMessage();
	}
}
// Insert Database Query
// Insert Database Query
function insert_ktmquery($field_values, $tbl_names)
{
	try {
		$key_value = array_keys($field_values);
		$org_value = array_values($field_values);
		$key_values = array_keys($field_values);

		for($ii = 0; $ii < count($field_values); $ii++) {
			$expld = explode("~~",$org_value[$ii]);
			if($expld[1] != '')
			{
				$kvl .= $key_values[$ii].", ";
				$kyvl .= "to_date('".$expld[1]."', '".$expld[0]."'), ";
				$kkvl[] = "".$key_values[$ii]."";
			} else {
				$kvl .= $key_values[$ii].", ";
				$kyvl .= "'".$org_value[$ii]."', ";
				$kkvl[] = "".$key_values[$ii]."";
			}
		}
		$kyvl = rtrim($kyvl, ", ");
		$kvl = rtrim($kvl, ", ");

	   $sql_insert ="insert into ".$tbl_names." (".$kvl.") values (".$kyvl.")";
		/* if($tbl_names=='approval_timer'){
			 $q=date('Y-m-d His').".txt";
			 $a1local_file = "uploads/".$q;
			 $fp=fopen($a1local_file,'w');
			 fwrite($fp,$sql_insert);
             fclose($fp);
		} */

		$save_query = save_query_json($sql_insert, "Centra", 'KTM');
		return $save_query;
	}
	catch(Exception $e) {
		echo 'Message: ' .$e->getMessage();
	}
}

// Insert Database Query
function insert_test_dbquery($field_values, $tbl_names)
{


	try {
		$key_value = array_keys($field_values);
		$org_value = array_values($field_values);
		$key_values = array_keys($field_values);

		for($ii = 0; $ii < count($field_values); $ii++) {
			$expld = explode("~~",$org_value[$ii]);
			// echo "!!"; print_r($expld); echo "!!";
			if($expld[1] != '')
			{
				$kvl .= $key_values[$ii].", ";
				$kyvl .= "to_date('".$expld[1]."', '".$expld[0]."'), ";
				$kkvl[] = "".$key_values[$ii]."";
			} else {
				$kvl .= $key_values[$ii].", ";
				$kyvl .= "'".$org_value[$ii]."', ";
				$kkvl[] = "".$key_values[$ii]."";
			}
		}
		$kyvl = rtrim($kyvl, ", ");
		$kvl = rtrim($kvl, ", ");
		
		

	   echo	 $sql_insert ="insert into ".$tbl_names." (".$kvl.") values (".$kyvl.")"; # DO NOT REMOVE ECHO FOR NEED RETURN USE insert_test1_dbquery function
        $save_query = save_test_query_json($sql_insert, "Centra", 'TEST'); # DO NOT REMOVE ECHO FOR NEED RETURN USE insert_test1_dbquery function
		return $save_query;
	}
	catch(Exception $e) {
		echo 'Message: ' .$e->getMessage();
	}
}

function insert_test1_dbquery($field_values, $tbl_names)
{


	try {
		$key_value = array_keys($field_values);
		$org_value = array_values($field_values);
		$key_values = array_keys($field_values);

		for($ii = 0; $ii < count($field_values); $ii++) {
			$expld = explode("~~",$org_value[$ii]);
			// echo "!!"; print_r($expld); echo "!!";
			if($expld[1] != '')
			{
				$kvl .= $key_values[$ii].", ";
				$kyvl .= "to_date('".$expld[1]."', '".$expld[0]."'), ";
				$kkvl[] = "".$key_values[$ii]."";
			} else {
				$kvl .= $key_values[$ii].", ";
				$kyvl .= "'".$org_value[$ii]."', ";
				$kkvl[] = "".$key_values[$ii]."";
			}
		}
		$kyvl = rtrim($kyvl, ", ");
		$kvl = rtrim($kvl, ", ");

		 echo  "<br>##".$sql_insert ="insert into ".$tbl_names." (".$kvl.") values (".$kyvl.")";
		  echo "<br>**".$save_query = save_test_query_json($sql_insert, "Centra", 'TEST');
		return $save_query;
	}
	catch(Exception $e) {
		echo 'Message: ' .$e->getMessage();
	}
}
function insert_test_save_dbquery($field_values, $tbl_names)
{
	try {
		$key_value = array_keys($field_values);
		$org_value = array_values($field_values);
		$key_values = array_keys($field_values);

		for($ii = 0; $ii < count($field_values); $ii++) {
			$expld = explode("~~",$org_value[$ii]);
			// echo "!!"; print_r($expld); echo "!!";
			if($expld[1] != '')
			{
				$kvl .= $key_values[$ii].", ";
				$kyvl .= "to_date('".$expld[1]."', '".$expld[0]."'), ";
				$kkvl[] = "".$key_values[$ii]."";
			} else {
				$kvl .= $key_values[$ii].", ";
				$kyvl .= "'".$org_value[$ii]."', ";
				$kkvl[] = "".$key_values[$ii]."";
			}
		}
		$kyvl = rtrim($kyvl, ", ");
		$kvl = rtrim($kvl, ", ");

		 $sql_insert ="insert into ".$tbl_names." (".$kvl.") values (".$kyvl.")";
		 $save_query = save_test_query_json($sql_insert, "Centra", 'TEST');
		 
		//do not comment this return query 
		return $save_query;
	}
	catch(Exception $e) {
		echo 'Message: ' .$e->getMessage();
	}
}
// Insert Database Query

// Update Database Query
function update_dbquery($field_values, $tbl_names, $where_condition)
{
	try{
		$key_value = array_keys($field_values);
		$org_value = array_values($field_values);
		$key_values = array_keys($field_values);
		$org_values = array_values($field_values);

		for($ii = 0; $ii < count($field_values); $ii++) {
			$expld = explode("~~",$org_value[$ii]);
			if($expld[1] != '')
			{
				$kyvl .= $key_values[$ii]." = to_date('".$expld[1]."', '".$expld[0]."'), ";
			} else {
				$kyvl .= $key_values[$ii]." = '". $org_values[$ii]."', ";
			}
		}
		$kyvl = rtrim($kyvl, ", ");

		 $sql_update = "UPDATE ".$tbl_names." SET ".$kyvl." WHERE ".$where_condition;
		 $save_query = save_query_json($sql_update, "Centra", 'TCS');
		return $save_query;
	}
	catch(Exception $e) {
		//echo 'Message: ' .$e->getMessage();
	}
}

function update_brn_dbquery($field_values, $tbl_names, $where_condition, $brn_connection = 'Centra', $schema_source = 'TCS')
{
	try{
		$key_value = array_keys($field_values);
		$org_value = array_values($field_values);
		$key_values = array_keys($field_values);
		$org_values = array_values($field_values);

		for($ii = 0; $ii < count($field_values); $ii++) {
			$expld = explode("~~",$org_value[$ii]);
			if($expld[1] != '')
			{
				$kyvl .= $key_values[$ii]." = to_date('".$expld[1]."', '".$expld[0]."'), ";
			} else {
				$kyvl .= $key_values[$ii]." = '". $org_values[$ii]."', ";
			}
		}
		$kyvl = rtrim($kyvl, ", ");

		 $sql_update = "UPDATE ".$tbl_names." SET ".$kyvl." WHERE ".$where_condition;
		 $save_query = save_query_json($sql_update, $brn_connection, $schema_source);
		return $save_query;
	}
	catch(Exception $e) {
		//echo 'Message: ' .$e->getMessage();
	}
}

// Update Database Query
function update_dbquery_zf_local($field_values, $tbl_names, $where_condition)
{
	try{
		$key_value = array_keys($field_values);
		$org_value = array_values($field_values);
		$key_values = array_keys($field_values);
		$org_values = array_values($field_values);

		for($ii = 0; $ii < count($field_values); $ii++) {
			$expld = explode("~~",$org_value[$ii]);
			if($expld[1] != '')
			{
				$kyvl .= $key_values[$ii]." = to_date('".$expld[1]."', '".$expld[0]."'), ";
			} else {
				$kyvl .= $key_values[$ii]." = '". $org_values[$ii]."', ";
			}
		}
		$kyvl = rtrim($kyvl, ", ");

		 $sql_update = "UPDATE ".$tbl_names." SET ".$kyvl." WHERE ".$where_condition;
		 $save_query = save_query_json_zf_local($sql_update, "1", 'TCS');
		return $save_query;
	}
	catch(Exception $e) {
		//echo 'Message: ' .$e->getMessage();
	}
}

function update_req_dbquery($field_values, $tbl_names, $where_condition)
{
	try{
		$key_value = array_keys($field_values);
		$org_value = array_values($field_values);
		$key_values = array_keys($field_values);
		$org_values = array_values($field_values);

		for($ii = 0; $ii < count($field_values); $ii++) {
			$expld = explode("~~",$org_value[$ii]);
			if($expld[1] != '')
			{
				$kyvl .= $key_values[$ii]." = to_date('".$expld[1]."', '".$expld[0]."'), ";
			} else {
				$kyvl .= $key_values[$ii]." = '". $org_values[$ii]."', ";
			}
		}
		$kyvl = rtrim($kyvl, ", ");

		$sql_update = "UPDATE ".$tbl_names." SET ".$kyvl." WHERE ".$where_condition;
		$save_query = save_query_json($sql_update, "Req", 'TCS');
		return $save_query;
	}
	catch(Exception $e) {
		//echo 'Message: ' .$e->getMessage();
	}
}


function update_test_dbquery($field_values, $tbl_names, $where_condition)
{
	try{
		$key_value = array_keys($field_values);
		$org_value = array_values($field_values);
		$key_values = array_keys($field_values);
		$org_values = array_values($field_values);

		for($ii = 0; $ii < count($field_values); $ii++) {
			$expld = explode("~~",$org_value[$ii]);
			if($expld[1] != '')
			{
				$kyvl .= $key_values[$ii]." = to_date('".$expld[1]."', '".$expld[0]."'), ";
			} else {
				$kyvl .= $key_values[$ii]." = '". $org_values[$ii]."', ";
			}
		}
		$kyvl = rtrim($kyvl, ", ");
//DO NOT REMOVE ECHO
	   echo $sql_update = "UPDATE ".$tbl_names." SET ".$kyvl." WHERE ".$where_condition;
	  echo $save_query = save_test_query_json($sql_update, "Centra", 'TEST');
		return $save_query;
	}
	catch(Exception $e) {
		echo 'Message: ' .$e->getMessage();
	}
}

function update_test_save_dbquery($field_values, $tbl_names, $where_condition)
{
	try{
		$key_value = array_keys($field_values);
		$org_value = array_values($field_values);
		$key_values = array_keys($field_values);
		$org_values = array_values($field_values);

		for($ii = 0; $ii < count($field_values); $ii++) {
			$expld = explode("~~",$org_value[$ii]);
			if($expld[1] != '')
			{
				$kyvl .= $key_values[$ii]." = to_date('".$expld[1]."', '".$expld[0]."'), ";
			} else {
				$kyvl .= $key_values[$ii]." = '". $org_values[$ii]."', ";
			}
		}
		$kyvl = rtrim($kyvl, ", ");

		$sql_update = "UPDATE ".$tbl_names." SET ".$kyvl." WHERE ".$where_condition;
	    $save_query = save_test_query_json($sql_update, "Centra", 'TEST');
		return $save_query;
	}
	catch(Exception $e) {
		echo 'Message: ' .$e->getMessage();
	}
}


// Save Query JSON Response

// Delete Database Query
function delete_dbquery($delete_qry)
{
	try {
		// $sql_delete = "UPDATE ".$tbl_names." SET ".$kyvl." WHERE ".$where_condition;
		$sql_delete = $delete_qry;
		$save_query = save_query_json($sql_delete, "Centra", 'TCS');
		return $save_query;
	}
	catch(Exception $e) {
		echo 'Message: ' .$e->getMessage();
	}
}


function delete_req_dbquery($delete_qry)
{
	try {
		// $sql_delete = "UPDATE ".$tbl_names." SET ".$kyvl." WHERE ".$where_condition;
		$sql_delete = $delete_qry;
		$save_query = save_query_json($sql_delete, "Req", 'TCS');
		return $save_query;
	}
	catch(Exception $e) {
		echo 'Message: ' .$e->getMessage();
	}
}


function delete_test_dbquery($delete_qry)
{
	try {
		// echo "<br>##".$sql_delete = "UPDATE ".$tbl_names." SET ".$kyvl." WHERE ".$where_condition;
		 "<br>##".$sql_delete = $delete_qry;
		 "<br>**".$save_query = save_test_query_json($sql_delete, "Centra", 'TEST');
		return $save_query;
	}
	catch(Exception $e) {
		echo 'Message: ' .$e->getMessage();
	}
}

function delete_test_save_dbquery($delete_qry)
{
	try {
		$sql_delete = $delete_qry;
		$save_query = save_test_query_json($sql_delete, "Centra", 'TEST');
		return $save_query;
	}
	catch(Exception $e) {
		echo 'Message: ' .$e->getMessage();
	}
}
// Delete Database Query


// Select Query JSON Response
function select_query_login_check_json($usrlogin, $usrpass, $brn_connection = 'Centra', $schema_source = 'TCS') {
	// $client = new SoapClient("http://templive.thechennaisilks.com:5088/service.asmx?Wsdl", array('exceptions'=>true, 'trace' => true));

	$opts = array(
        'http' => array(
            'user_agent' => 'PHPSoapClient'
        )
    );
    $context = stream_context_create($opts);
    $wsdlUrl = "http://www.templiveservice.com/service.asmx?Wsdl";
    // $wsdlUrl = "http://templive.thechennaisilks.com:5088/service.asmx?Wsdl";
    $soapClientOptions = array(
    	'encoding' => 'UTF-8',
	    'verifypeer' => false,
	    'verifyhost' => false,
        'stream_context' => $context,
        'exceptions'=> 1,
        'trace' => 1,
    	'connection_timeout' => 180,
        'cache_wsdl' => WSDL_CACHE_NONE
    );
    $client = new SoapClient($wsdlUrl, $soapClientOptions);

	$get_parameter->User_Login = $usrlogin;
	$get_parameter->User_Pass = $usrpass;
	$get_parameter->B_Code = $brn_connection; // 'Centra';
	$get_parameter->C_Mode = $schema_source; // 'TCS' / 'TEST';
	// $get_parameter->C_Mode='TEST';
	try{
		$get_result=$client->Php_Login_Check($get_parameter)->Php_Login_CheckResult;
		// print_r($get_result);
	}
	catch(SoapFault $fault){
		/* echo "Fault code:{$fault->faultcode}".NEWLINE;
		echo "Fault string:{$fault->faultstring}".NEWLINE; */
		if ($client != null)
		{
			$client=null;
		}
		// exit();
	}
	$soapClient = null;
	return $get_result;
	// return json_decode($get_result, true);
}

function select_test_query_json($sqlqry_select, $brn_connection = 'Centra', $schema_source = 'TCS') {
	// $client = new SoapClient("http://templive.thechennaisilks.com:5088/service.asmx?Wsdl", array('exceptions'=>true, 'trace' => true));

	$opts = array(
        'http' => array(
            'user_agent' => 'PHPSoapClient'
        )
    );
    $context = stream_context_create($opts);
    $wsdlUrl = "http://www.templiveservice.com/service.asmx?Wsdl";
    // $wsdlUrl = "http://templive.thechennaisilks.com:5088/service.asmx?Wsdl";
    $soapClientOptions = array(
        'stream_context' => $context,
        'exceptions'=> 1,
        'trace' => 1,
        'cache_wsdl' => WSDL_CACHE_NONE
    );
    $client = new SoapClient($wsdlUrl, $soapClientOptions);

	$get_parameter->str = $sqlqry_select;
	$get_parameter->B_Code = $brn_connection; // 'Centra';
	$get_parameter->C_Mode = $schema_source; // 'TCS';
	// $get_parameter->C_Mode='TEST';
	try{
		$get_result=$client->GetData_Json($get_parameter)->GetData_JsonResult;
	}
	catch(SoapFault $fault){
		echo "<br><br>Fault code:{$fault->faultcode}";
		echo "<br>Fault string:{$fault->faultstring}";
		if ($client != null)
		{
			$client=null;
		}
		// exit();
	}
	$soapClient = null;
	return json_decode($get_result,true);
}

function select_query_json($sqlqry_select, $brn_connection = 'Centra', $schema_source = 'TCS') {
	// $client = new SoapClient("http://templive.thechennaisilks.com:5088/service.asmx?Wsdl", array('exceptions'=>true, 'trace' => true));

	/* $opts = array(
        'http' => array(
            'user_agent' => 'PHPSoapClient'
        )
    );
    $context = stream_context_create($opts);
    $wsdlUrl = "http://www.templiveservice.com/service.asmx?Wsdl";
    // $wsdlUrl = "http://templive.thechennaisilks.com:5088/service.asmx?Wsdl";
    $soapClientOptions = array(
        'stream_context' => $context,
        'exceptions'=> 1,
        'trace' => 1,
        'cache_wsdl' => WSDL_CACHE_NONE
    );
    $client = new SoapClient($wsdlUrl, $soapClientOptions);

	$get_parameter->str = $sqlqry_select;
	$get_parameter->B_Code = $brn_connection; // 'Centra';
	$get_parameter->C_Mode = $schema_source; // 'TCS';
	// $get_parameter->C_Mode='TEST';
	try{
		$get_result=$client->GetData_Json($get_parameter)->GetData_JsonResult;
	}
	catch(SoapFault $fault){
		// echo "<br><br>Fault code:{$fault->faultcode}";
		// echo "<br>Fault string:{$fault->faultstring}";
		if ($client != null)
		{
			$client=null;
		}
		// exit();
	}
	$soapClient = null;
	return json_decode($get_result,true); */

	$opts = array(
        'http' => array(
            'user_agent' => 'PHPSoapClient',
            // 'method'=>"POST",
        	'header'=> "Content-Type: application/soap+xml; charset=utf-8"
        )
    );
    $context = stream_context_create($opts);
    $wsdlUrl = "http://www.templiveservice.com/service.asmx?Wsdl";
    $soap_options = array(
		    'uri' => 'http://www.w3.org/2003/05/soap-envelope',
		    'style' => SOAP_RPC,
		    'use' => SOAP_ENCODED,
		    'soap_version' => SOAP_1_2,
		    'cache_wsdl' => WSDL_CACHE_NONE,
		    'connection_timeout' => 30,
		    'trace' => true,
		    'encoding' => 'UTF-8',
		    'stream_context' => $context,
		    'exceptions' => true
	);

    $client = new SoapClient($wsdlUrl, $soap_options);
	$get_parameter->str = $sqlqry_select;
	$get_parameter->B_Code = $brn_connection; // 'Centra';
	$get_parameter->C_Mode = $schema_source; // 'TCS';

	try{
		// echo "!!";
		$get_result = $client->GetData_JSON_ONLY($get_parameter)->GetData_JSON_ONLYResult;
		// echo "@@";
		// var_dump($get_result);
		// echo "##";
		return $get_result;
		// echo "$$";
	}
	catch(SoapFault $fault){
		// echo "%%";
		// echo "<br><br>Fault code:{$fault->faultcode}";
		// echo "<br>Fault string:{$fault->faultstring}";
		// echo "OK";
		$InvalidXML = $client->__getLastResponse();
		// echo "^^";
		// echo "NOT OK";
		if ($client != null)
		{
			$client = null;
		}
		if($InvalidXML == "0") {
			// echo "**".$InvalidXML."**".$sqlqry_select."**<br>";
			$InvalidXML = "";
		} else {
			// echo "==".$InvalidXML."==";
		}
		// exit();
	}
	$soapClient = null;
	// return $InvalidXML;
	return json_decode($InvalidXML, true);
}

function select_query_json_new($sqlqry_select, $brn_connection = 'Centra', $schema_source = 'TCS') {
	// $client = new SoapClient("http://templive.thechennaisilks.com:5088/service.asmx?Wsdl", array('exceptions'=>true, 'trace' => true));

	$opts = array(
        'http' => array(
            'user_agent' => 'PHPSoapClient'
        )
    );
    $context = stream_context_create($opts);
    $wsdlUrl = "http://www.templiveservice.com/service.asmx?Wsdl";
    // $wsdlUrl = "http://templive.thechennaisilks.com:5088/service.asmx?Wsdl";
    $soapClientOptions = array(
        'stream_context' => $context,
        'exceptions'=> 1,
        'trace' => 1,
        'cache_wsdl' => WSDL_CACHE_NONE
    );
    $client = new SoapClient($wsdlUrl, $soapClientOptions);

	$get_parameter->str = $sqlqry_select;
	$get_parameter->B_Code = $brn_connection; // 'Centra';
	$get_parameter->C_Mode = $schema_source; // 'TCS';
	// $get_parameter->C_Mode='TEST';
	try{
		$get_result=$client->GetData_Json($get_parameter)->GetData_JsonResult;
	}
	catch(SoapFault $fault){
		/* echo "<br><br>Fault code:{$fault->faultcode}";
		echo "<br>Fault string:{$fault->faultstring}"; */
		if ($client != null)
		{
			$client=null;
		}
		// exit();
	}
	$soapClient = null;
	return json_decode($get_result,true);
}
function select_query_json_checking() {
	$client = new SoapClient("http://www.dneonline.com/calculator.asmx?Wsdl");
	$get_parameter->intA = 15;
	$get_parameter->intB = 12;
	try{
		$get_result=$client->Add($get_parameter)->AddResult;
	}
	catch(SoapFault $fault){
		echo "<br><br>Fault code:{$fault->faultcode}";
		echo "<br>Fault string:{$fault->faultstring}";
		if ($client != null)
		{
			$client=null;
		}
		// exit();
	}
	$soapClient = null;
	return json_decode($get_result,true);
}

function select_dbquery_json($sqlqry_select, $brn_connection = 'Centra', $schema_source = 'TCS') {
	// $client = new SoapClient("http://templive.thechennaisilks.com:5088/service.asmx?Wsdl", array('exceptions'=>true, 'trace' => true));
	$opts = array(
        'http' => array(
            'user_agent' => 'PHPSoapClient'
        )
    );
    $context = stream_context_create($opts);
    $wsdlUrl = "http://www.templiveservice.com/service.asmx?Wsdl";
    // $wsdlUrl = "http://templive.thechennaisilks.com:5088/service.asmx?Wsdl";
    $soapClientOptions = array(
        'stream_context' => $context,
        'exceptions'=> 1,
        'trace' => 1,
        'cache_wsdl' => WSDL_CACHE_NONE
    );
    $client = new SoapClient($wsdlUrl, $soapClientOptions);

	$get_parameter->str = $sqlqry_select;
	$get_parameter->B_Code = $brn_connection; // 'Centra';
	$get_parameter->C_Mode = $schema_source; // 'TCS';
	// $get_parameter->C_Mode='TEST';
	try{
		$get_result=$client->GetData_Json($get_parameter)->GetData_JsonResult;
	}
	catch(SoapFault $fault){
		echo "Fault code:{$fault->faultcode}".NEWLINE;
		echo "Fault string:{$fault->faultstring}".NEWLINE;
		if ($client != null)
		{
			$client=null;
		}
		// exit();
	}
	$soapClient = null;
	return json_decode($get_result,true);
}
// Select Query JSON Response

// Save Query JSON Response
function save_query_json($sqlqry_select, $brn_connection = 'Centra', $schema_source = 'TCS') {
	// $client = new SoapClient("http://templive.thechennaisilks.com:5088/service.asmx?Wsdl", array('exceptions'=>true, 'trace' => true));
	$opts = array(
        'http' => array(
            'user_agent' => 'PHPSoapClient'
        )
    );
    $context = stream_context_create($opts);
    $wsdlUrl = "http://www.templiveservice.com/service.asmx?Wsdl";
    // $wsdlUrl = "http://templive.thechennaisilks.com:5088/service.asmx?Wsdl";
    $soapClientOptions = array(
        'stream_context' => $context,
        'exceptions'=> 1,
        'trace' => 1,
        'cache_wsdl' => WSDL_CACHE_NONE
    );
    $client = new SoapClient($wsdlUrl, $soapClientOptions);

	$get_parameter->str = $sqlqry_select;
	$get_parameter->B_Code = $brn_connection; // 'Centra';
	$get_parameter->C_Mode = $schema_source; // 'TCS';
	// $get_parameter->C_Mode='TEST';
	try{
		$get_result = $client->Php_Store_Data($get_parameter)->Php_Store_DataResult;
	}
	catch(SoapFault $fault){
		$get_result = 0;
		/* echo "Fault code:{$fault->faultcode}".NEWLINE;
		echo "Fault string:{$fault->faultstring}".NEWLINE; */
		if ($client != null)
		{
			$client=null;
		}
		// exit();
	}
	$soapClient = null;
	return json_decode($get_result,true);
}


function save_query_json_zf_local($sqlqry_select, $brn_connection = '1', $schema_source = 'TCS') {
	// $client = new SoapClient("http://templive.thechennaisilks.com:5088/service.asmx?Wsdl", array('exceptions'=>true, 'trace' => true));
	$opts = array(
        'http' => array(
            'user_agent' => 'PHPSoapClient'
        )
    );
    $context = stream_context_create($opts);
    $wsdlUrl = "http://www.templiveservice.com/service.asmx?Wsdl";
    // $wsdlUrl = "http://templive.thechennaisilks.com:5088/service.asmx?Wsdl";
    $soapClientOptions = array(
        'stream_context' => $context,
        'exceptions'=> 1,
        'trace' => 1,
        'cache_wsdl' => WSDL_CACHE_NONE
    );
    $client = new SoapClient($wsdlUrl, $soapClientOptions);

	$get_parameter->str = $sqlqry_select;
	$get_parameter->B_Code = $brn_connection; // 'Centra';
	$get_parameter->C_Mode = $schema_source; // 'TCS';
	// $get_parameter->C_Mode='TEST';
	try{
		$get_result = $client->Php_Store_Data($get_parameter)->Php_Store_DataResult;
	}
	catch(SoapFault $fault){
		$get_result = 0;
		/* echo "Fault code:{$fault->faultcode}".NEWLINE;
		echo "Fault string:{$fault->faultstring}".NEWLINE; */
		if ($client != null)
		{
			$client=null;
		}
		// exit();
	}
	$soapClient = null;
	return json_decode($get_result,true);
}
//save query json
function Upload_FTPImages($image,$path,$filename) {
	// $client = new SoapClient("http://templive.thechennaisilks.com:5088/service.asmx?Wsdl", array('exceptions'=>true, 'trace' => true));

	$opts = array(
        'http' => array(
            'user_agent' => 'PHPSoapClient'
        )
    );
    $context = stream_context_create($opts);
    //$wsdlUrl = "http://172.16.50.100:8082/cdata.asmx?wsdl";  // test service
    $wsdlUrl = "http://mtcspurcapp.thechennaisilks.com/TCSservice.asmx?wsdl";  // live service
    // $wsdlUrl = "http://templive.thechennaisilks.com:5088/service.asmx?Wsdl";
    $soapClientOptions = array(
        'stream_context' => $context,
        'exceptions'=> 1, 
        'trace' => 1,
        'cache_wsdl' => WSDL_CACHE_NONE
    );
    $client = new SoapClient($wsdlUrl, $soapClientOptions);
    //print_r($client);

	

	$get_parameter->BASE = $image;
	$get_parameter->PATH = $path;
	$get_parameter->FILENAME = $filename;
	$get_parameter->PASSWORD = 'TCS!@#';
	$get_parameter->BRNCODE ='888';  // 888 for ftp://172.16.0.49/
	
	// $get_parameter->B_Code = $brn_connection; // 'Centra';
	// $get_parameter->C_Mode = $schema_source; // 'TCS';
	// $get_parameter->C_Mode='TEST';
	try{
		$get_result = $client->CENT_STIMG($get_parameter)->CENT_STIMGResult;
		//return $get_result;
		 //echo "============++".$get_result."++=================";
		return $get_result;
	}
	catch(SoapFault $fault){
		return $fault;
		$get_result = 0;
		/* echo "Fault code:{$fault->faultcode}".NEWLINE;
		echo "Fault string:{$fault->faultstring}".NEWLINE; */
		if ($client != null)
		{
			$client=null;
		}
		// exit();
		//return $get_result;
	}
	$soapClient = null;
	//return json_decode($get_result,true);
}

function store_procedure_query_json($sqlqry_select, $brn_connection = 'Req', $schema_source = 'TCS') {
	// $client = new SoapClient("http://templive.thechennaisilks.com:5088/service.asmx?Wsdl", array('exceptions'=>true, 'trace' => true));

	$opts = array(
        'http' => array(
            'user_agent' => 'PHPSoapClient'
        )
    );
    $context = stream_context_create($opts);
    $wsdlUrl = "http://www.templiveservice.com/service.asmx?Wsdl";
    // $wsdlUrl = "http://templive.thechennaisilks.com:5088/service.asmx?Wsdl";
    $soapClientOptions = array(
        'stream_context' => $context,
        'exceptions'=> 1,
        'trace' => 1,
        'cache_wsdl' => WSDL_CACHE_NONE
    );
    $client = new SoapClient($wsdlUrl, $soapClientOptions);

	$get_parameter->str = $sqlqry_select;
	$get_parameter->B_Code = $brn_connection; // 'Centra';
	$get_parameter->C_Mode = $schema_source; // 'TCS';
	try{
		$get_result = $client->Store_Procedure($get_parameter)->Store_ProcedureResult;
	}
	catch(SoapFault $fault){
		$get_result = 0;
		if ($client != null)
		{
			$client=null;
		}
	}
	$soapClient = null;
	return json_decode($get_result,true);
}
function store_procedure_query_json_req($sqlqry_select, $brn_connection = 'Req', $schema_source = 'TCS') {
	// $client = new SoapClient("http://templive.thechennaisilks.com:5088/service.asmx?Wsdl", array('exceptions'=>true, 'trace' => true));

	$opts = array(
        'http' => array(
            'user_agent' => 'PHPSoapClient'
        )
    );
    $context = stream_context_create($opts);
    $wsdlUrl = "http://www.templiveservice.com/service.asmx?Wsdl";
    // $wsdlUrl = "http://templive.thechennaisilks.com:5088/service.asmx?Wsdl";
    $soapClientOptions = array(
        'stream_context' => $context,
        'exceptions'=> 1,
        'trace' => 1,
        'cache_wsdl' => WSDL_CACHE_NONE
    );
    $client = new SoapClient($wsdlUrl, $soapClientOptions);

	$get_parameter->str = $sqlqry_select;
	$get_parameter->B_Code = $brn_connection; // 'Centra';
	$get_parameter->C_Mode = $schema_source; // 'TCS';
	try{
		$get_result = $client->Store_Procedure($get_parameter)->Store_ProcedureResult;
	}
	catch(SoapFault $fault){
		print_r($fault);
		$get_result = 0;
		if ($client != null)
		{
			$client=null;
		}
	}
	$soapClient = null;
	return json_decode($get_result,true);
}
function store_procedure_query_json1($sqlqry_select, $brn_connection = 'Centra', $schema_source = 'TCS') {
	// $client = new SoapClient("http://templive.thechennaisilks.com:5088/service.asmx?Wsdl", array('exceptions'=>true, 'trace' => true));

	$opts = array(
        'http' => array(
            'user_agent' => 'PHPSoapClient'
        )
    );
    $context = stream_context_create($opts);
    $wsdlUrl = "http://www.templiveservice.com/service.asmx?Wsdl";
    // $wsdlUrl = "http://templive.thechennaisilks.com:5088/service.asmx?Wsdl";
    $soapClientOptions = array(
        'stream_context' => $context,
        'exceptions'=> 1,
        'trace' => 1,
        'cache_wsdl' => WSDL_CACHE_NONE
    );
    $client = new SoapClient($wsdlUrl, $soapClientOptions);

	$get_parameter->str = $sqlqry_select;
	$get_parameter->B_Code = $brn_connection; // 'Centra';
	$get_parameter->C_Mode = $schema_source; // 'TCS';
	try{
		$get_result = $client->Store_Procedure($get_parameter)->Store_ProcedureResult;
	}
	catch(SoapFault $fault){
		 // print_r($fault);
		$get_result = 0;
		if ($client != null)
		{
			$client=null;
		}
	}
	$soapClient = null;
	return json_decode($get_result,true);
}
function store_procedure_query_json2($sqlqry_select, $brn_connection = 'Centra', $schema_source = 'TCS') {
	// $client = new SoapClient("http://templive.thechennaisilks.com:5088/service.asmx?Wsdl", array('exceptions'=>true, 'trace' => true));

	$opts = array(
        'http' => array(
            'user_agent' => 'PHPSoapClient'
        )
    );
    $context = stream_context_create($opts);
    $wsdlUrl = "http://www.templiveservice.com/service.asmx?Wsdl";
    // $wsdlUrl = "http://templive.thechennaisilks.com:5088/service.asmx?Wsdl";
    $soapClientOptions = array(
        'stream_context' => $context,
        'exceptions'=> 1,
        'trace' => 1,
        'cache_wsdl' => WSDL_CACHE_NONE
    );
    $client = new SoapClient($wsdlUrl, $soapClientOptions);

	$get_parameter->str = $sqlqry_select;
	$get_parameter->B_Code = $brn_connection; // 'Centra';
	$get_parameter->C_Mode = $schema_source; // 'TCS';
	try{
		$get_result = $client->Store_Procedure($get_parameter)->Store_ProcedureResult;
	}
	catch(SoapFault $fault){
		print_r($fault);
		$get_result = 0;
		if ($client != null)
		{
			$client=null;
		}
	}
	$soapClient = null;
	return json_decode($get_result,true);
}
function save_test_query_json($sqlqry_select, $brn_connection = 'Centra', $schema_source = 'TEST') {
	// $client = new SoapClient("http://templive.thechennaisilks.com:5088/service.asmx?Wsdl", array('exceptions'=>true, 'trace' => true));

	$opts = array(
        'http' => array(
            'user_agent' => 'PHPSoapClient'
        )
    );
    $context = stream_context_create($opts);
    $wsdlUrl = "http://www.templiveservice.com/service.asmx?Wsdl";
    // $wsdlUrl = "http://templive.thechennaisilks.com:5088/service.asmx?Wsdl";
    $soapClientOptions = array(
        'stream_context' => $context,
        'exceptions'=> 1,
        'trace' => 1,
        'cache_wsdl' => WSDL_CACHE_NONE
    );
    $client = new SoapClient($wsdlUrl, $soapClientOptions);

	$get_parameter->str = $sqlqry_select;
	$get_parameter->B_Code = $brn_connection; // 'Centra';
	$get_parameter->C_Mode = $schema_source; // 'TCS';
	// $get_parameter->C_Mode='TEST';
	try{
		 $get_result = $client->Php_Store_Data($get_parameter)->Php_Store_DataResult;
		// echo "=================".$get_result."=================";
	}
	catch(SoapFault $fault){
		$get_result = 0;
		/* echo "Fault code:{$fault->faultcode}".NEWLINE;
		echo "Fault string:{$fault->faultstring}".NEWLINE; */
		if ($client != null)
		{
			$client=null;
		}
		// exit();
	}
	$soapClient = null;
	return json_decode($get_result,true);
}
// Save Query JSON Response


function save_test_query_json_gst($sqlqry_select) {
	// $client = new SoapClient("http://templive.thechennaisilks.com:5088/service.asmx?Wsdl", array('exceptions'=>true, 'trace' => true));
//echo $sqlqry_select;
	$opts = array(
        'http' => array(
            'user_agent' => 'PHPSoapClient'
        )
    );
    $context = stream_context_create($opts);
    $wsdlUrl = "http://172.16.50.100:8082/CData.asmx?Wsdl";
    // $wsdlUrl = "http://templive.thechennaisilks.com:5088/service.asmx?Wsdl";
    $soapClientOptions = array(
        'stream_context' => $context,
        'exceptions'=> 1,
        'trace' => 1,
        'cache_wsdl' => WSDL_CACHE_NONE
    );
    $client = new SoapClient($wsdlUrl, $soapClientOptions);

	$get_parameter->chk_sum = $sqlqry_select;
	//$get_parameter->B_Code = $brn_connection; // 'Centra';
	//$get_parameter->C_Mode = $schema_source; // 'TCS';
	// $get_parameter->C_Mode='TEST';
	//print_r($get_parameter);

	try{
		 $get_result = $client->SAVE_GST_HOLD_PAYMENT_ARRAY($get_parameter)->SAVE_GST_HOLD_PAYMENT_ARRAYResult;
		 //echo "=================".$get_result."=================";
	}
	catch(SoapFault $fault){
		//echo $fault;
		$get_result = 0;
		/* echo "Fault code:{$fault->faultcode}".NEWLINE;
		echo "Fault string:{$fault->faultstring}".NEWLINE; */
		if ($client != null)
		{
			$client=null;
		}
		// exit();
	}
	$soapClient = null;
	return json_decode($get_result,true);
}



function select_query_webservice($sqlqry_select) {
	// $service_url = 'http://tcstextile.in/tcs_service/TCSservice.asmx/App_TRN_List?TRN=A';
	$curl = curl_init($sqlqry_select);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$curl_response = curl_exec($curl);
	if ($curl_response === false) {
		$info = curl_getinfo($curl);
		curl_close($curl);
		die('error occured during curl exec. Additioanl info: ' . var_export($info));
	}
	curl_close($curl);

	$respxpl = explode('<string xmlns="http://tempuri.org/">', $curl_response);
	$respxplode = explode('</string>', $respxpl[1]);

	$jsonverify = isJson($respxplode[0]);
	$mainarray = json_decode($respxplode[0], true);

	if(count($mainarray[0]) == 0) { $innerarray[0] = $mainarray; }
	else { $innerarray = $mainarray; }
	return $innerarray;
}

function check_PoImages($path) {	
$opts = array(
        'http' => array(
            'user_agent' => 'PHPSoapClient'
        )
    );
    $context = stream_context_create($opts);   
    $wsdlUrl = "http://mtcspurcapp.thechennaisilks.com/TCSservice.asmx?wsdl";     
    $soapClientOptions = array(
        'stream_context' => $context,
        'exceptions'=> 1, 
        'trace' => 1,
        'cache_wsdl' => WSDL_CACHE_NONE
    );
    $client = new SoapClient($wsdlUrl, $soapClientOptions);    
$get_parameter->PATH = $path;	
$get_parameter->BRNCODE ='888';
$get_parameter->PASSWORD = 'TCS!@#';

try{
$get_result = $client->CENT_CHKFILE($get_parameter)->CENT_CHKFILEResult;	
return $get_result;
}
catch(SoapFault $fault){
return $fault;
$get_result = 0;	
if ($client != null)
{
$client=null;
}	
}
$soapClient = null;	
}
// JSON is available
function isJson($string) {
	json_decode($string);
	return (json_last_error() == JSON_ERROR_NONE);
}
// JSON is available

// *** Find the Browser Type ***
function find_browser () {
	 if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)
	   return 'IE';
	 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE) //For Supporting IE 11
		return 'IE';
	 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE)
	   return 'Firefox';
	 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE)
	   return 'Chrome';
	 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE)
	   return "Opera";
	 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE)
	   return "Opera";
	 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE)
	   return "Safari";
	 else
	   return 'Fail';
}
// *** Find the Browser Type ***

// *** Password Encrypt ***
function encrypt_pwd($password)
{
	$lenpass = strlen($password);
	$ks = 50;
	$txt = '';
	$txt1 = '';
	$txt2 = '';

	for($i = 0; $i < $lenpass; $i++)
	{
		$txt1 = ord(substr($password, $i, 1));
		$txt1 += $ks;
		if($txt1 >= 255)
		{
			$txt1 = $txt1 - 200;
		}
		$txt2 = chr($txt1);
		$txt .= $txt2;
		$ks = $ks + 15;
	}
	//echo $password = $txt;
	return $txt;
	// return md5($txt);
}
// *** Password Encrypt ***

function in_multiarrays($elem, $array, $field)
{
    $top = sizeof($array) - 1;
    $bottom = 0;
    while($bottom <= $top)
    {
        if($array[$bottom][$field] == $elem)
            return true;
        else
            if(is_array($array[$bottom][$field]))
                if(in_multiarray($elem, ($array[$bottom][$field])))
                    return true;
        $bottom++;
    }
    return false;
}
?>
