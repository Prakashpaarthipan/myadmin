<?php

include_once('../lib/config.php');
include_once('../lib/function_connect.php');
extract($_REQUEST);
$ftp_conn_159 = ftp_connect($ftp_server_159)  or die("Could not connect to $ftp_server");
$login_159 = ftp_login($ftp_conn_159, $ftp_user_name_159, $ftp_user_pass_159);
if($_GET['action']=="downloadall"){
	/*
	// mentioned Option Not Woking
	/*$zip = new ZipArchive();
		$zip_name = time().".zip"; // Zip name
		$zip->open($zip_name,  ZipArchive::CREATE);
		foreach ($files as $file) {
		  $path = '../uploads/'.$file;
		  if(file_exists($path)){
		  $zip->addFromString(basename($path),  file_get_contents($path));  
		  }
		  else{
		   //echo"file does not exist";
		  }
		}
		$zip->close();*/
	
	//echo "print";
	//print_r($_REQUEST);
		// Code from TCS
	
		$request = select_query_json("select SRE.*,to_char(SRE.REQDATE,'dd/MM/yyyy HH:mi:ss AM') REQDATE1 from service_request SRE where reqnumb='2019031300002' and reqsrno='1'", "Centra", "TCS");
		//print_r($request);
		  if($request[0]['REQPATH'] != '' and $request[0]['REQPATH'] != '-')
            {
            	//echo "re";
              $filepath=explode('ftp://172.16.0.159/', $request[0]['REQPATH']);
              if($filepath[1]=='')
              {
                $filepath=explode('ftp://ftp1.thechennaisilks.com/', $request[0]['REQPATH']);
              }
              $file_list = ftp_nlist($ftp_conn_159, $filepath[1]);
            // var_dump( $file_list);
             	$dir= '2019031300023';
               $my_save_dir = '../uploads/'.$dir;
               if(is_dir($my_save_dir)){
               	//echo "fg";
               			$handle = opendir($my_save_dir.'/');
							//do whatever you need
							closedir($handle);							
               			rmdir($my_save_dir.'/');
               			mkdir($my_save_dir, 0777, true);
               }else{
               	//echo "sdfsdf";
              mkdir($my_save_dir, 0777, true);
               }
              if(count($file_list) > 0) {
              
              	if(is_dir($my_save_dir)){
              		 
	              		 for($ij = 0; $ij < count($file_list); $ij++)
	                {
	                    $filename = $file_list[$ij];				
						$url_to_image = "ftp://".$ftp_user_name_159.":".$ftp_user_pass_159."@".$ftp_server_159."/".$filename;
					  
					   $filename = basename($url_to_image);
					   $complete_save_loc = $my_save_dir.'/'.$filename;
					   $upload= file_put_contents($complete_save_loc,file_get_contents($url_to_image));
					   
					}		
              	}
              	
               
			}
		}
		
	//$path    = '../uploads';
//$files = scandir($path);
	 $path    = $my_save_dir.'/';
$files = array_values(array_diff(scandir($path), array('.', '..')));
//echo "1";
//print_r($files);
//exit;
	/* create a compressed zip file */
function createZipArchive($files = array(), $destination = '', $overwrite = false, $path) {
	//print_r($files);

   if(file_exists($destination) && !$overwrite) { return false; }

   $validFiles = array();
   if(is_array($files)) {
   	
      foreach($files as $file) {
      	$filepath = $path.$file;
         if(file_exists($filepath )) {
            $validFiles[] = $filepath;    	
         }else{
         	//echo $path;
         }
      }
   }  
   if(count($validFiles)) {
      $zip = new ZipArchive();
      if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) == true) {
         foreach($validFiles as $file) {
            $zip->addFile($file,$file);
         }
         $zip->close();
         return file_exists($destination);
      }else{
          return false;
      }
   }else{
      return false;
   }
}
$fileName = '../myzipfile'.time().'.zip';

$result = createZipArchive($files, $fileName,false, $path);
$handle = opendir($my_save_dir.'/');
							//do whatever you need
							closedir($handle);							
               			rmdir($my_save_dir.'/');
header('Content-Description: File Transfer');
header('Content-Type: application/zip');
header("Content-Disposition: attachment; filename=\"".$fileName."\"");
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header("Content-Length: ".filesize($fileName));
ob_clean();
flush();
readfile($fileName);
@unlink($fileName);
//rmdir($my_save_dir);

exit();
}
?>