
<?php
// include the file of fusion chart and make a proper connection with database
include("fs/fusioncharts/fusioncharts.php");

   $hostdb = "localhost";  // MySQl host
   $userdb = "root";  // MySQL username
   $passdb = "";  // MySQL password
   $namedb = "rcs";  // MySQL database name 
   $dbhandle = new mysqli($hostdb, $userdb, $passdb, $namedb);

   
   if ($dbhandle->connect_error) {
    exit("There was an error with your connection: ".$dbhandle->connect_error);
   }
?>
<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <title>Combination Chart</title>
  <!-- Favicon -->
  <link rel="icon" href="../assets/img/brand/favicon.png" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="../assets/vendor/nucleo/css/nucleo.css" type="text/css">
  <link rel="stylesheet" href="../assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
  <!-- Argon CSS -->
  <link rel="stylesheet" href="../assets/css/argon.css?v=1.2.0" type="text/css">
  <script src="http://code.jquery.com/jquery-latest.js"></script>
  <script src=" https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
      <script src=" https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
      <script type="text/javascript" src="js/fusioncharts.js"></script>
<script type="text/javascript" src="js/themes/fusioncharts.theme.zune.js"></script>
</head>

<body>
<div class="container-fluid mt--6">
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
              <h3 class="mb-0">Combination Chart with dual Y axis</h3>
            </div>
            
      <div class="row">
                    <div >
                  <!------------------------------------------------------>
                  <?php
                               
                       //Fetch data from MYsql,here using join query
                               $strQuery = "SELECT DATE_FORMAT(regularsalesanalysis.DOT,'%d-%m-%Y') as DOT,SkuCode,SkuName,SalesAmt,ClusterSalesAmt from regularsalesanalysis group by DOT";  
                               
                               $result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
                               
                               if ($result) 
                                 {
                                   $arrData = array(
                                   "chart" => array(
                                   "caption"=> "Sales Analysis",   
                                   "xAxisname"=> "DOT",
                                   "xAxisNameFontColor"=> "#1cc88a",
                                   "xAxisNameFontSize"=> "15",
                                   "xAxisNameFontBold"=> "1",
                                   "yAxisName"=> "GrossAmt",
                                   "yAxisNameFontColor"=> "#1cc88a",
                                   "yAxisNameFontSize"=> "15",
                                   "yAxisNameFontBold"=> "1",

                                   "xAxisname"=> "DOT",
                                   "pYAxisName"=>"GrossAmt",
                                   "sYAxisName"=> "SalesAmt",//secountry y axis
                                   "numberPrefix"=> "$",
                                   "sNumberSuffix"=> "%",
                                   "sYAxisMaxValue"=> "50",
                                   "divlineAlpha"=> "100",
                                   "divlineColor"=> "#999999",
                                   "divlineThickness"=> "1",
                                   "divLineIsDashed"=> "1",
                                   "divLineDashLen"=> "1",
                                   "divLineGapLen"=> "1",
                                   "usePlotGradientColor"=> "0",
                                   "anchorRadius"=>"3",

                                   "theme"=> "fusion",
                                   "baseFontColor"=> "#000000",
                                   "plotfillpercent"=> "5",
                                    "rotatevalues"=> "1",
                                   "labelDisplay"=> "rotate",
                                   "animation"=>"1",
                                   "animationDuration"=>"3",
                                   "use3DLighting"=>"1",
                                   
                                   )
                                   );
                           
                                   $categoryArray=array();
                                   $datavalues1=array();
                                   $datavalues2=array();
                                   $datavalues3=array();
                                //    change the colur of graph,data from mysql
                                   while($row = mysqli_fetch_array($result)) 
                                     {
                                       array_push($categoryArray, array(
                                       "label" => $row["DOT"]
                                       )
                                       );
                                       array_push($datavalues1, array(
                                       "value" => $row["SalesAmt"],
                                       "color"=>"#25b37d",//graph color
                                       "anchorbgcolor"=> "#18184a",
                                       "showvalues"=> "1",
                                       )
                                       );
                                       array_push($datavalues2, array(
                                        "value" => $row["ClusterSalesAmt"],
                                        "color"=>"#b3256c",
                                        "anchorbgcolor"=> "#1cc88a",
                                        )
                                        );
                                                      
                                     }
                                   $arrData["categories"]=array(array("category"=>$categoryArray));
                                   //parent axix mentioned below
                                   $arrData["dataset"] = array(array("seriesName"=> "SalesAmt","renderAs"=>"bar","parentYAxis"=>"S", "showvalues"=> "1","data"=>$datavalues1),array("seriesName"=> "ClusterSalesAmt","renderAs"=>"area", "data"=>$datavalues2));
                                  
                  
                                   $jsonEncodedData = json_encode($arrData);
                                //    chart type,width and height
                                   $Chart = new FusionCharts("mscombidy2d", "chart1" , 1000, 600, "chart-1", "json", $jsonEncodedData);
                                   $Chart->render();
                                  
                                 }
                           ?>
                           <div id="chart-1"></div>
                                </div>
                  <!-------------------------------------------------------->
                </div>
     
                                </div>  
        
    <body>
</html>