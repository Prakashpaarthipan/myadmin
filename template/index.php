<?php
function select_query_json_only_new($str,$brn="Centra",$con="TCS"){

    $WSDL = "http://www.templiveservice.com/service.asmx?Wsdl";
    $soap_stream_context = array(
    'http'=>array(
        'method'=>"POST",
        'header'=> "Content-Type: application/soap+xml; charset=utf-8"
        )
    );
        $soap_options = array(
        'uri' => 'http://www.w3.org/2003/05/soap-envelope',
        'style' => SOAP_RPC,
        'use' => SOAP_ENCODED,
        'soap_version' => SOAP_1_2,
        'cache_wsdl' => WSDL_CACHE_NONE,
        'connection_timeout' => 30,
        'trace' => 1,
        'encoding' => 'UTF-8',
        'exceptions' => true,
        'location' => $WSDL,         
        'stream_context' => $soap_stream_context,

    );
        $params = array (
			"str" => $str,
			"B_Code" => $brn,
			"C_Mode" => $con
		);
		$gResult='';
		$response_xml='';
            //$get_parameter->str = $str;
            //$get_parameter->B_Code = $brn; // 'Centra';
            //$get_parameter->C_Mode = $con; // 'TCS';
            try {
                 $result = new SoapClient($WSDL, $soap_options);
                $functions = $result->__getFunctions ();
               // var_dump($functions);
                //$gResult = $result->__soapCall('GetData_JSON', array($params))->GetData_JsonResult;
                $gResult = $result->__soapCall('GetData_JSON_ONLY', array($params));
				//var_dump($gResult);
				return  $gResult;
            } catch (SoapFault $fault) {
					//echo "<br><br>Fault code:{$fault->faultcode}";
                    //echo "<br>Fault string:{$fault->faultstring}";
					//var_dump($fault);
					//echo PHP_EOL;
					//echo($result->__getLastRequest());
					$Direct_JSON = $result->__getLastResponse();
					if(!empty($Direct_JSON)){
						return htmlentities($Direct_JSON);
						$response_xml = str_replace('&amp;#x1F;', '', $Direct_JSON);
						//Convert all element in xml format like "soap:Envelope" as "soapEnvelope"
						$response_xml = preg_replace("/(]*&gt;)/", "$1$2$3", $response_xml);

						//Interprets xml string into an object
						$response_xml = simplexml_load_string($response_xml);

						//returned objects will be converted into associative arrays.
						$response_xml = json_decode(json_encode($response_xml));
						$soapClient = null;
						//Finally return your response as you expected from normal return without error.
						return $response_xml->soapBody->GetData_JSON_ONLY->GetData_JSON_ONLYResponse ;
					}
					
                    
            }
			
          
}
?><!DOCTYPE html>
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
    <link href="../lib/rickshaw/rickshaw.min.css" rel="stylesheet">
    <link href="../lib/select2/css/select2.min.css" rel="stylesheet">

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="../css/bracket.css">
  </head>

  <body>

<?php
include_once('lib/app-left-panel.php');
include_once('lib/app-header.php');
include_once('lib/app-right-panel.php');
//include_once('lib/main-content.php');
?>
	<div class="br-mainpanel">
		<div class="br-pageheader">
			<nav class="breadcrumb pd-0 mg-0 tx-12">
			  <a class="breadcrumb-item" href="index.html">Home</a>
			  <a class="breadcrumb-item" href="#">Fiddle</a>
			  <span class="breadcrumb-item active">PHP Fiddle</span>
			</nav>
        </div><!-- br-pageheader -->
	  
    <?php /*  <div class="br-pagetitle">
        <i class="icon ion-ios-home-outline"></i>
        <div>
          <h4>Dashboard</h4>
          <p class="mg-b-0">Do bigger things with Bracket plus, the responsive bootstrap 4 admin template.</p>
        </div>
      </div> */
	  ?>

      <div class="br-pagebody">
		<div class="br-section-wrapper"> 
            <form action="" method="post" name="frm_submit">
                <div class="form-layout form-layout-1">
                    <div class="row mg-b-25">
                        <div class="col-lg-12">
                            <div class="form-group">
                              <label class="form-control-label">PHP Code: <span class="tx-danger">*</span></label>
                               <?/*php if($_REQUEST['phpCode'] !="")
                                {
                                    echo  $_REQUEST['phpCode'];
                                }php if(trim($_POST['phpCode']) !="")
                                { echo  $_POST['phpCode']; } 
                                */
                                ?>
                               <textarea rows="20" cols="60" name="phpCode" class="form-control" id="phpCode" placeholder="Your php code.."></textarea> 
                            </div>
                        </div>
                    </div> 
                    <div class="form-layout-footer">
                        <button class="btn btn-success" type="submit" name="run" value="submit" > <i class="fa fa-save"></i> Run</button>
                         <button class="btn btn-danger" type="reset" name="reset" value="reset" > <i class="fa fa-times"></i> Reset</button>
                    </div>
                </div>               
           </form>
		</div>
        <?php
        if($_SERVER['REQUEST_METHOD']=="POST" and $_REQUEST['run'] != '' and trim($_REQUEST['phpCode']) != '' ) {
        ?>
        <div class="br-section-wrapper"> 
             <label class="form-control-label">Result: <span class="tx-danger">*</span></label>
             <div class="form-layout form-layout-1">
                   <?php 
                   echo "<pre>";
                   echo $_REQUEST['phpCode'];
				   
				   
				   ?>
             </div>
        </div>
        <?php }?>
		<div class="br-section-wrapper"> 
		<?php
		//$inner_submenu1 = select_query_json_only_new("select * from srm_menu order by MNUCODE Asc", "Centra", 'TCS');
		//print_r($inner_submenu1);
		?>
		</div>
	</div> <!-- br-pagebody -->
	</div> <!-- br-mainpanel -->


   



    <script src="../lib/jquery/jquery.min.js"></script>
    <script src="../lib/jquery-ui/ui/widgets/datepicker.js"></script>
    <script src="../lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../lib/moment/min/moment.min.js"></script>
    <script src="../lib/peity/jquery.peity.min.js"></script>
    <script src="../lib/rickshaw/vendor/d3.min.js"></script>
    <script src="../lib/rickshaw/vendor/d3.layout.min.js"></script>
    <script src="../lib/rickshaw/rickshaw.min.js"></script>
    <script src="../lib/jquery.flot/jquery.flot.js"></script>
    <script src="../lib/jquery.flot/jquery.flot.resize.js"></script>
    <script src="../lib/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="../lib/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="../lib/echarts/echarts.min.js"></script>
    <script src="../lib/select2/js/select2.full.min.js"></script>
    <!--<script src="http://maps.google.com/maps/api/js?key=AIzaSyAq8o5-8Y5pudbJMJtDFzb8aHiWJufa5fg"></script>
    <script src="../lib/gmaps/gmaps.min.js"></script>-->

    <script src="../js/bracket.js"></script>
    <!--<script src="../js/map.shiftworker.js"></script>-->
    <script src="../js/ResizeSensor.js"></script>
    <script src="../js/dashboard.js"></script>
    <script>
      $(function(){
        'use strict'

        // FOR DEMO ONLY
        // menu collapsed by default during first page load or refresh with screen
        // having a size between 992px and 1299px. This is intended on this page only
        // for better viewing of widgets demo.
        $(window).resize(function(){
          minimizeMenu();
        });

        minimizeMenu();

        function minimizeMenu() {
          if(window.matchMedia('(min-width: 992px)').matches && window.matchMedia('(max-width: 1299px)').matches) {
            // show only the icons and hide left menu label by default
            $('.menu-item-label,.menu-item-arrow').addClass('op-lg-0-force d-lg-none');
            $('body').addClass('collapsed-menu');
            $('.show-sub + .br-menu-sub').slideUp();
          } else if(window.matchMedia('(min-width: 1300px)').matches && !$('body').hasClass('collapsed-menu')) {
            $('.menu-item-label,.menu-item-arrow').removeClass('op-lg-0-force d-lg-none');
            $('body').removeClass('collapsed-menu');
            $('.show-sub + .br-menu-sub').slideDown();
          }
        }
      });
    </script>
  </body>
</html>
