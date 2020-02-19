<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once('lib/config.php');
include_once('lib/function_connect.php');


 if($_SERVER['REQUEST_METHOD']=="POST" ){
  
    $file_url =array('ftp://ituser:S0ft@369@172.16.0.159/CALL_CENTRE/REQUESTS/31228_20190313082334/IMG_20190312_182037.jpg','ftp://ituser:S0ft@369@172.16.0.159/CALL_CENTRE/REQUESTS/31228_20190313082334/IMG_20190312_182047.jpg', 'ftp://ituser:S0ft@369@172.16.0.159/CALL_CENTRE/REQUESTS/31228_20190313082334/IMG_20190312_182052.jpg');

$opts = array(
  'http'=>array(
    'method'=> "GET",
    'header'=> "Accept:*/*\r\n
        Accept-Encoding:gzip, deflate, sdch\r\n
        Accept-Language:en-US,en;q=0.8,id;q=0.6\r\n
        Cache-Control:no-cache\r\n
        Connection:keep-alive\r\n
        Host:www.ligascore.com
        User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36\r\n"
  )
);

$context = stream_context_create($opts);

// Open the file using the HTTP headers set above
//$file = file_get_contents( $url, false, $context);
//echo $file;
/*
for ($i=0; $i <  count($file_url1); $i++) { 
 
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.$i.'".jpg');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($file_url[$i])); //Absolute URL
ob_clean();
flush();
readfile($file_url[$i]); //Absolute URL
 # code...


}*/
for ($i=0; $i < count($file_url) ; $i++) { 
$file = file_get_contents( $file_url[$i]);
$files[]=$file;
}

  $zipname = 'file.zip';
$zip = new ZipArchive;
$zip->open($zipname, ZipArchive::CREATE);
foreach ($files as $file) {
  $zip->addFile($file);
}
$zip->close();
header('Content-Type: application/zip');
header('Content-disposition: attachment; filename='.$zipname);
header('Content-Length: ' . filesize($zipname));
readfile($zipname);

exit();

 }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Twitter -->
    <meta name="twitter:site" content="@themepixels">
    <meta name="twitter:creator" content="@themepixels">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Bracket Plus">
    <meta name="twitter:description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="twitter:image" content="http://themepixels.me/bracketplus/img/bracketplus-social.png">

    <!-- Facebook -->
    <meta property="og:url" content="http://themepixels.me/bracketplus">
    <meta property="og:title" content="Bracket Plus">
    <meta property="og:description" content="Premium Quality and Responsive UI for Dashboard.">

    <meta property="og:image" content="http://themepixels.me/bracketplus/img/bracketplus-social.png">
    <meta property="og:image:secure_url" content="http://themepixels.me/bracketplus/img/bracketplus-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    <!-- Meta -->
    <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="author" content="ThemePixels">

    <title>Bracket Plus Responsive Bootstrap 4 Admin Template</title>

    <!-- vendor css -->
    <link href="../lib/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="../lib/ionicons/css/ionicons.min.css" rel="stylesheet">

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="../css/bracket.css">
  </head>

  <body style="background-color: #fff;">
<?php
include_once('lib/app-left-panel.php');
include_once('lib/app-header.php');
include_once('lib/app-right-panel.php');
//include_once('lib/main-content.php');
?>


    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
      <div class="br-pageheader ">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="index.html">Bracket</a>
          <span class="breadcrumb-item active">Blank Page</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle "  style="display: none;" >
        <i class="icon icon ion-ios-book-outline"></i>
        <div>
          <h4>Blank Page (Default Layout)</h4>
          <p class="mg-b-0">Introducing Bracket Plus admin template, the most handsome admin template of all time.</p>
        </div>
      </div><!-- d-flex -->

      <div class="br-pagebody" style="margin: 0px;padding: 0px">

        <!-- start you own content here -->
        <div class="card ">
          <div class="card-header bg-transparent pd-x-25 pd-y-15 bd-b-0 d-flex justify-content-between align-items-center">
            <h6 class="card-title tx-uppercase tx-12 mg-b-0">Storage Overview</h6>
            <a href="/" class="tx-gray-500 hover-info lh-0"><i class="icon ion-android-more-horizontal tx-24 lh-0"></i></a>
          </div><!-- card-header -->
         
          <div class="card-body pd-x-25 pd-b-25 pd-t-0">
            <form action="./work.php" method="post" enctype="multi-part" name="frm_sample" id="frm_sample">
                <div class="row no-gutters">

                <button class="btn btn-oblong btn-primary btn-block mg-b-10" type="submit" name="Download" value="Download">Download</button>
               </div><!-- row -->
            </form>
          
          </div><!-- card-body --> 
       
          <div class="card-body pd-x-25 pd-b-25 pd-t-0">
            <?php $branch = select_query_json("select * from branch where rownum < 10","Centra","TCS");
           // print_r($branch);

            $token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VybmFtZSI6MTU3MTY4OCwibmFtZSI6IlBBU1VQQVRISSBTIC0iLCJwYXNzd29yZCI6IkFtbWFAMDAxIiwicm9vdCI6eyJzdWJTZWN0aW9uSWQiOjAsInNlY3Rpb25JZCI6MCwiZmxvb3JJZCI6MiwiYnJhbmNoSWQiOjIwNCwiY29tcGFueUlkIjoiVEoifSwiZW1wSWQiOjE1NzE2LCJ1c2VydHlwZSI6IkFETUlOIiwiY1R5cGUiOjIsImlhdCI6MTU4MjEwNzk5MCwiZXhwIjoxNjEzNjQzOTkwfQ.zJ8boCJCIAq67zPhqKbr7KaNqiqLYFxUKvhI-vZ6REs";
            //setup the request, you can also use CURLOPT_URL
        $ch = curl_init('http://172.16.50.149:1010/stockTally?page_no=0&limit=10&from=2020-01-19T18:30:00.000Z&to=2020-02-19T11:21:49.979Z&rootInfo=company&id=TJ&secName=&userName=');

            // Returns the data/output as a string instead of raw data
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            //Set your auth headers
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
               'Content-Type: application/json',
               'x-web-token: ' . $token
               ));

            // get stringified data/output. See CURLOPT_RETURNTRANSFER
              $data = curl_exec($ch);

            // get info about the request
             $info = curl_getinfo($ch);
            // close curl resource to free up system resources
            curl_close($ch);
            ?>
          </div>
         
        </div>

      </div><!-- br-pagebody -->

    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->

    <script src="../lib/jquery/jquery.min.js"></script>
    <script src="../lib/jquery-ui/ui/widgets/datepicker.js"></script>
    <script src="../lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../lib/moment/min/moment.min.js"></script>
    <script src="../lib/peity/jquery.peity.min.js"></script>

    <script src="../js/bracket.js"></script>
    <script type="text/javascript">
     $("#frm_sample").submit(function(e){ 
      e.preventDefault();
      window.location="ajax/ajax_work.php?action=downloadall";
       
        //alert("welcome");
        /*$.ajax({
          url:"ajax/ajax_work.php?action=downloadall",
          type:"POST",
          data:{
            wel:"test"
          },
          success: function(data){
            //console.log(data);
          }

        });*/
     });

    </script>
  </body>
</html>
