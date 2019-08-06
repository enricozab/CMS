<?php include 'sdfod.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CMS - Dashboard</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

	  <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src = "https://code.highcharts.com/highcharts.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script>
      function showSnackbar() {
        var x = document.getElementById("snackbar");
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
      }
    </script>

</head>

<body>

  <div id="wrapper">

    <?php include 'sdfod-sidebar.php'; ?>

    <div id="page-wrapper">
      <div class="row">
          <div class="col-lg-8">
              <h3 class="page-header">Dashboard</h3>
          </div>
      </div>

      <?php
      //MAJOR CASES
      require_once('../mysql_connect.php');
      $topOffensesDescriptionMajor = array();
      $topOffensesIDMajor = array();
      $totalOffensesMajor = array();
      $dataMajor = array();

      $sqlQuery = "SELECT DISTINCT RO.DESCRIPTION, C.OFFENSE_ID, COUNT(C.CASE_ID) AS 'NUMCASES'
                    FROM CASES C
                      LEFT JOIN ref_offenses RO ON RO.OFFENSE_ID = C.OFFENSE_ID
                      WHERE RO.TYPE = 'Major'
                      GROUP BY C.OFFENSE_ID
                      ORDER BY COUNT(C.CASE_ID) DESC
                      LIMIT 3";

      $sqlRes = mysqli_query($dbc, $sqlQuery);
      while ($row = $sqlRes->fetch_assoc()){
        $topOffensesDescriptionMajor[] = $row['DESCRIPTION'];
        $topOffensesIDMajor[] = $row['OFFENSE_ID'];
        $totalOffensesMajor[] = $row['NUMCASES'];
        //echo "DESCRIPTION: ", $topOffenses[0], "<br>";
        //echo "NUMCASES: ", $topOffenses[0], "<br>";
      }

      //ERROR-HANDLING
      if (sizeof($topOffensesIDMajor)!=3){
        while (sizeof($topOffensesIDMajor)<=3){
        $topOffensesIDMajor[] = "0";
        $totalOffensesMajor[] = 0;
        }
      }

      $queryNum=0;
      $offenseIndex=0;

      // echo "topOffensesIDMajor Size: " , sizeOf($topOffensesIDMajor), "<br>";
      for($x=0; $x<3; $x++){

        //echo "Offense Index: ", $offenseIndex, "<br";

        for($i=1; $i<=7; $i++){
          //echo "I: " , $i, "<br>";
          $numcasesquery =  "SELECT COUNT(C.CASE_ID) AS 'NUMCASES'
                              FROM CASES C
                              LEFT JOIN USERS U 				    ON	C.REPORTED_STUDENT_ID = U.USER_ID
                              LEFT JOIN REF_USER_OFFICE RUO	ON 	U.OFFICE_ID = RUO.OFFICE_ID
                              WHERE U.OFFICE_ID = " .$i ."
                              && C.OFFENSE_ID = " .$topOffensesIDMajor[$offenseIndex];

          //echo $queryNum, " Query: ", $numcasesquery, "<br><br>";
          $numcasesres = mysqli_query($dbc,$numcasesquery);
          if(!$numcasesres){

            echo mysqli_error($dbc);
          }
          else{
            $casesrow=mysqli_fetch_array($numcasesres,MYSQLI_ASSOC);
            $cases = $casesrow['NUMCASES'];
            $dataMajor[]= $cases;
          }
          //echo 'Data Num #', $z, '<br>';
          $queryNum++;
        }

        $offenseIndex++;
      }

      //MINOR CASES
      $topOffensesDescriptionMinor = array();
      $topOffensesIDMinor = array();
      $totalOffensesMinor = array();
      $dataMinor = array();

      $sqlQuery = "SELECT DISTINCT RO.DESCRIPTION, C.OFFENSE_ID, COUNT(C.CASE_ID) AS 'NUMCASES'
                    FROM CASES C
                      LEFT JOIN ref_offenses RO ON RO.OFFENSE_ID = C.OFFENSE_ID
                      WHERE RO.TYPE = 'Minor'
                      GROUP BY C.OFFENSE_ID
                      ORDER BY COUNT(C.CASE_ID) DESC
                      LIMIT 3";

      $sqlRes = mysqli_query($dbc, $sqlQuery);
      while ($row = $sqlRes->fetch_assoc()){
        $topOffensesDescriptionMinor[] = $row['DESCRIPTION'];
        $topOffensesIDMinor[] = $row['OFFENSE_ID'];
        $totalOffensesMinor[] = $row['NUMCASES'];
      }

      //ERROR HANDLING
      if (sizeof($topOffensesIDMinor)!=3){
        while (sizeof($topOffensesIDMinor)<=3){
          $topOffensesIDMinor[] = "0";
          $totalOffensesMinor[] = 0;
        }
      }

      $queryNum=0;
      $offenseIndex=0;

      for($x=0; $x<3; $x++){

        //echo "Offense Index: ", $offenseIndex, "<br";

        for($i=1; $i<=7; $i++){
          //echo "I: " , $i, "<br>";
          $numcasesquery =  "SELECT COUNT(C.CASE_ID) AS 'NUMCASES'
                              FROM CASES C
                              LEFT JOIN USERS U 				    ON	C.REPORTED_STUDENT_ID = U.USER_ID
                              LEFT JOIN REF_USER_OFFICE RUO	ON 	U.OFFICE_ID = RUO.OFFICE_ID
                              WHERE U.OFFICE_ID = " .$i ."
                              && C.OFFENSE_ID = " .$topOffensesIDMinor[$offenseIndex];

          //echo $queryNum, " Query: ", $numcasesquery, "<br><br>";
          $numcasesres = mysqli_query($dbc,$numcasesquery);
          if(!$numcasesres){

            echo mysqli_error($dbc);
          }
          else{
            $casesrow=mysqli_fetch_array($numcasesres,MYSQLI_ASSOC);
            $cases = $casesrow['NUMCASES'];
            $dataMinor[]= $cases;
          }
          //echo 'Data Num #', $z, '<br>';
          $queryNum++;
        }

        $offenseIndex++;
      }
      ?>

      <?php
      ////////////////////////GET REASONS FOR MAJOR CASES
      $topDetailsMajor = array();
      $totalOffensesMajor = array();

      for($i=0; $i < sizeOf($topOffensesIDMajor); $i++){
        // echo "Offense ID: ", $topOffensesIDMajor[$i], "<br>";
        $sqlQuery = "SELECT COUNT(C.CASE_ID) AS 'COUNT', C.DETAILS
                      FROM CASES C
                      LEFT JOIN	REF_OFFENSES RO	ON	C.OFFENSE_ID = RO.OFFENSE_ID
                        LEFT JOIN	REF_DETAILS	 RD	ON	C.DETAILS = RD.DETAILS
                        WHERE C.OFFENSE_ID = " .$topOffensesIDMajor[$i] ."
                        GROUP BY C.DETAILS
                        ORDER BY 1 DESC
                        LIMIT 3";

        $sqlRes = mysqli_query($dbc, $sqlQuery);
        while ($row = $sqlRes->fetch_assoc()){
          $topDetailsMajor[] = $row['DETAILS'];
        }

        if(mysqli_num_rows($sqlRes)==1){
          $topDetailsMajor[] ='';
          $topDetailsMajor[] ='';
        }
        else if(mysqli_num_rows($sqlRes)==2){
          $topDetailsMajor[] ='';
        }
      }

      ////////////////////////GET REASONS FOR MINOR CASES
      $topDetailsMinor = array();

      for($i=0; $i < sizeOf($topOffensesIDMinor); $i++){
        $sqlQuery = "SELECT COUNT(C.CASE_ID) AS 'COUNT', C.DETAILS
                      FROM CASES C
                      LEFT JOIN	REF_OFFENSES RO	ON	C.OFFENSE_ID = RO.OFFENSE_ID
                        LEFT JOIN	REF_DETAILS	 RD	ON	C.DETAILS = RD.DETAILS
                        WHERE C.OFFENSE_ID = " .$topOffensesIDMinor[$i] ."
                        GROUP BY C.DETAILS
                        ORDER BY 1 DESC
                        LIMIT 3";

        $sqlRes = mysqli_query($dbc, $sqlQuery);
        while ($row = $sqlRes->fetch_assoc()){
          $topDetailsMinor[] = $row['DETAILS'];
        }

        if(mysqli_num_rows($sqlRes)==1){
          $topDetailsMinor[] ='';
          $topDetailsMinor[] ='';
        }
        else if(mysqli_num_rows($sqlRes)==2){
          $topDetailsMinor[] ='';
        }

      }
      ?>

			<!-- CHARTS -->
			<div class="row">
        <div class="col-lg-6">
          <br>
          <div class="btn-group">
            <button type="button" class="tableButton btn btn-primary" id="majorBtn"  onClick="majorBtn()">Major</button>
            <button type="button" class="tableButton btn btn-primary" id="minorBtn"  onClick="minorBtn()">Minor</button>
          </div>
          <style>
              .tableButton {
                width: 100px;
              }
              #majorBtn {border-radius: 3px 0px 0px 3px;}
              #minorBtn {border-radius: 0px 3px 3px 0px;}
          </style>

          <br><br>

          <!--HIGHCHARTS style = "width: 600px; height: 400px; margin: 0 auto"-->
          <div id = "majorCase" class="majorCase" alignment="center" style = "width: 950px; height: 500px; margin: 0 auto"></div>
          <script language = "JavaScript">
             $(document).ready(function() {
                var chart = {
                   type: 'bar'
                };
                var title = {
                   text: 'Top 3 Major Cases in DLSU',
                   style: {
                        fontFamily: 'Arial'
                    }
                };
                var subtitle = {
                   text: ''
                };
                var xAxis = {
                   categories: ['College of Computer Studies',
                                'College of Liberal Arts',
                                'College of Business',
                                'School of Economics',
                                'Gokongwei College of Engineering',
                                'College of Science',
                                'College of Education'],
                   title: {
                      text: null
                   }
                };
                var yAxis = {
                   min: 0,
                   allowDecimals: false,
                   title: {
                      text: 'Total',
                      align: 'high'
                   },
                   labels: {
                      overflow: 'justify'
                   }
                };
                var tooltip = {
                   valueSuffix: ''
                };
                var plotOptions = {
                   bar: {
                      dataLabels: {
                         enabled: true
                      }
                   }
                };
                var legend = {
                  layout: 'vertical',
                  align: 'right',
                  verticalAlign: 'top',
                  x: -90,
                  y: 250,
                  floating: false,
                  borderWidth: 1,
                  backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
                  shadow: true
                };
                var credits = {
                   enabled: false
                };
                var series = [
                   {
                      name: '<?php echo $topOffensesDescriptionMajor[0] ?>',
                      data: [<?php echo $dataMajor[0]?>,
                              <?php echo $dataMajor[1]?>,
                              <?php echo $dataMajor[2]?>,
                              <?php echo $dataMajor[3]?>,
                              <?php echo $dataMajor[4]?>,
                              <?php echo $dataMajor[5]?>,
                              <?php echo $dataMajor[6]?>]
                   },
                   {
                      name: '<?php echo $topOffensesDescriptionMajor[1] ?>',
                      data: [<?php echo $dataMajor[7]?>,
                              <?php echo $dataMajor[8]?>,
                              <?php echo $dataMajor[9]?>,
                              <?php echo $dataMajor[10]?>,
                              <?php echo $dataMajor[11]?>,
                              <?php echo $dataMajor[12]?>,
                              <?php echo $dataMajor[13]?>]
                   },
                   {
                      name: '<?php echo $topOffensesDescriptionMajor[2] ?>',
                      data: [<?php echo $dataMajor[14]?>,
                              <?php echo $dataMajor[15]?>,
                              <?php echo $dataMajor[16]?>,
                              <?php echo $dataMajor[17]?>,
                              <?php echo $dataMajor[18]?>,
                              <?php echo $dataMajor[19]?>,
                              <?php echo $dataMajor[20]?>]
                   }
                ];

                var json = {};
                json.chart = chart;
                json.title = title;
                json.subtitle = subtitle;
                json.tooltip = tooltip;
                json.xAxis = xAxis;
                json.yAxis = yAxis;
                json.series = series;
                json.plotOptions = plotOptions;
                json.legend = legend;
                json.credits = credits;
                $('#majorCase').highcharts(json);
             });
          </script>

          <!--MINOR BAR CHART-->
          <div id = "minorCase" class="minorCase" style = "width: 950px; height: 500px; margin: 0 auto; display: none;" align="center"></div>
          <script language = "JavaScript">
             $(document).ready(function() {

               $('#majorBtn').css("background-color", "#256092");

                var chart = {
                   type: 'bar'
                };
                var title = {
                   text: 'Top 3 Minor Cases in DLSU',
                   style: {
                        fontFamily: 'Arial'
                    }
                };
                var subtitle = {
                   text: ''
                };
                var xAxis = {
                   categories: ['College of Computer Studies',
                                'College of Liberal Arts',
                                'College of Business',
                                'School of Economics',
                                'Gokongwei College of Engineering',
                                'College of Science',
                                'College of Education'],
                   title: {
                      text: null
                   }
                };
                var yAxis = {
                   min: 0,
                   allowDecimals: false,
                   title: {
                      text: 'Total',
                      align: 'high'
                   },
                   labels: {
                      overflow: 'justify'
                   }
                };
                var tooltip = {
                   valueSuffix: ''
                };
                var plotOptions = {
                   bar: {
                      dataLabels: {
                         enabled: true
                      }
                   }
                };
                var legend = {
                  layout: 'vertical',
                  align: 'right',
                  verticalAlign: 'top',
                  x: -90,
                  y: 250,
                  floating: false,
                  borderWidth: 1,
                  backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
                  shadow: true
                };
                var credits = {
                   enabled: false
                };
                var series = [
                   {
                      name: '<?php echo $topOffensesDescriptionMinor[0] ?>',
                      data: [<?php echo $dataMinor[0]?>,
                              <?php echo $dataMinor[1]?>,
                              <?php echo $dataMinor[2]?>,
                              <?php echo $dataMinor[3]?>,
                              <?php echo $dataMinor[4]?>,
                              <?php echo $dataMinor[5]?>,
                              <?php echo $dataMinor[6]?>]
                   },
                   {
                      name: '<?php echo $topOffensesDescriptionMinor[1] ?>',
                      data: [<?php echo $dataMinor[7]?>,
                              <?php echo $dataMinor[8]?>,
                              <?php echo $dataMinor[9]?>,
                              <?php echo $dataMinor[10]?>,
                              <?php echo $dataMinor[11]?>,
                              <?php echo $dataMinor[12]?>,
                              <?php echo $dataMinor[13]?>]
                   },
                   {
                      name: '<?php echo $topOffensesDescriptionMinor[2] ?>',
                      data: [<?php echo $dataMinor[14]?>,
                              <?php echo $dataMinor[15]?>,
                              <?php echo $dataMinor[16]?>,
                              <?php echo $dataMinor[17]?>,
                              <?php echo $dataMinor[18]?>,
                              <?php echo $dataMinor[19]?>,
                              <?php echo $dataMinor[20]?>]
                   }
                ];

                var json = {};
                json.chart = chart;
                json.title = title;
                json.subtitle = subtitle;
                json.tooltip = tooltip;
                json.xAxis = xAxis;
                json.yAxis = yAxis;
                json.series = series;
                json.plotOptions = plotOptions;
                json.legend = legend;
                json.credits = credits;
                $('#minorCase').highcharts(json);
             });
          </script>
          <!--HIGHCHARTS-->
          <br>
        </div>
        <!-- /.col-lg-12 -->

        <div class="col-lg-6" style="position: relative; padding-top: 70px; left: -15%">
          <!-- <label for="majorTable">Common Reasons for committing such violations</label> style="display:none;"-->
          <table id="majorTable" align="center">
          <?php
            if(sizeof($topDetailsMajor)==9){
              echo'<caption style="font-size: 18px; color: black;">Top Ways for Committing Such Offenses</caption>
              <tr>
                <th>Offense</th>
                <th>Reason</th>
              </tr>';

              $descIndex = 0;
              for($x=0; $x<9;$x++){
                if($x==3 || $x==6){
                  $descIndex++;
                }

                if($topDetailsMajor[$x] != ''){
                  echo'<tr>';
                  if($x==0 || $x==3 || $x==6){
                    echo'<td>'. $topOffensesDescriptionMajor[$descIndex] .'</td>';
                    }

                  else{
                    echo '<td></td>';
                  }
                  echo'<td>'. $topDetailsMajor[$x] .'</td>
                        </tr>';
                }
              }
            }

            else{
              echo("<br><h3>No data to display</h3>");
            }

            ?>
          </table>
          <script> var majorTable = document.getElementById("majorTable"); majorTable.style.display = "block"; </script>
        </div>

        <div class="col-lg-6" style="position: relative; padding-top: 0px; left: -15%">
          <table id="minorTable" style="display: none;" align="center">
            <?php
            if(sizeof($topDetailsMajor)==9){
              echo '<caption style="font-size: 18px; color: black;">Top Ways for Commiting Such Offenses</caption>
              <tr>
                <th>Offense</th>
                <th>Reason</th>
              </tr>';

              $descIndex = 0;
              for($x=0; $x<9;$x++){
                if($x==3 || $x==6){
                  $descIndex++;
                }

                if($topDetailsMinor[$x] != ''){
                  echo'<tr>';
                  if($x==0 || $x==3 || $x==6){
                    echo'<td>'. $topOffensesDescriptionMinor[$descIndex] .'</td>';
                    }

                  else{
                    echo '<td></td>';
                  }
                  echo'<td>'. $topDetailsMinor[$x] .'</td>
                        </tr>';
                }
              }
            }
            ?>
          </table>
        </div>
      </div>

      <br><br><br><br><br>

      <div id="snackbar"><i class="fa fa-info-circle fa-fw" style="font-size: 20px"></i> <span id="alert-message">Some text some message..</span></div>

    </div>
    <!-- /#page-wrapper -->
  </div>
  <!-- /#wrapper -->

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
  loadNotif();

  function loadNotif () {
        $.ajax({
          url: '../ajax/hdo-notif-incident-reports.php',
          type: 'POST',
          data: {
          },
          success: function(response) {
            if(response > 0) {
              $('#ir').text(response);
            }
            else {
              $('#ir').text('');
            }
          }
        });

        $.ajax({
          url: '../ajax/sdfod-notif-cases.php',
          type: 'POST',
          data: {
          },
          success: function(response) {
            if(response > 0) {
              $('#cn').text(response);
            }
            else {
              $('#cn').text('');
            }
          }
        });

        setTimeout(loadNotif, 5000);
    };

  function majorBtn(){
    $(document).ready(function() {
      var chart = {
          type: 'bar'
      };
      var title = {
          text: 'Top 3 Major Cases in DLSU',
          style: {
              fontFamily: 'Arial'
          }
      };
      var subtitle = {
          text: ''
      };
      var xAxis = {
          categories: ['College of Computer Studies',
                      'College of Liberal Arts',
                      'College of Business',
                      'School of Economics',
                      'Gokongwei College of Engineering',
                      'College of Science',
                      'College of Education'],
          title: {
            text: null
          }
      };
      var yAxis = {
          min: 0,
          allowDecimals: false,
          title: {
            text: 'Total',
            align: 'high'
          },
          labels: {
            overflow: 'justify'
          }
      };
      var tooltip = {
          valueSuffix: ''
      };
      var plotOptions = {
          bar: {
            dataLabels: {
                enabled: true
            }
          }
      };
      var legend = {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'top',
        x: -90,
        y: 250,
        floating: false,
        borderWidth: 1,
        backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
        shadow: true
      };
      var credits = {
          enabled: false
      };
      var series = [
          {
            name: '<?php echo $topOffensesDescriptionMajor[0] ?>',
            data: [<?php echo $dataMajor[0]?>,
                    <?php echo $dataMajor[1]?>,
                    <?php echo $dataMajor[2]?>,
                    <?php echo $dataMajor[3]?>,
                    <?php echo $dataMajor[4]?>,
                    <?php echo $dataMajor[5]?>,
                    <?php echo $dataMajor[6]?>]
          },
          {
            name: '<?php echo $topOffensesDescriptionMajor[1] ?>',
            data: [<?php echo $dataMajor[7]?>,
                    <?php echo $dataMajor[8]?>,
                    <?php echo $dataMajor[9]?>,
                    <?php echo $dataMajor[10]?>,
                    <?php echo $dataMajor[11]?>,
                    <?php echo $dataMajor[12]?>,
                    <?php echo $dataMajor[13]?>]
          },
          {
            name: '<?php echo $topOffensesDescriptionMajor[2] ?>',
            data: [<?php echo $dataMajor[14]?>,
                    <?php echo $dataMajor[15]?>,
                    <?php echo $dataMajor[16]?>,
                    <?php echo $dataMajor[17]?>,
                    <?php echo $dataMajor[18]?>,
                    <?php echo $dataMajor[19]?>,
                    <?php echo $dataMajor[20]?>]
          }
      ];

      var json = {};
      json.chart = chart;
      json.title = title;
      json.subtitle = subtitle;
      json.tooltip = tooltip;
      json.xAxis = xAxis;
      json.yAxis = yAxis;
      json.series = series;
      json.plotOptions = plotOptions;
      json.legend = legend;
      json.credits = credits;
      $('#majorCase').highcharts(json);
    });

    var minorChart = document.getElementById("minorCase");
    var majorChart = document.getElementById("majorCase");
      majorChart.style.display = "block";
      minorChart.style.display = "none";
    var minorTable = document.getElementById("minorTable");
    var majorTable = document.getElementById("majorTable");
      majorTable.style.display = "block";
      minorTable.style.display = "none";

    $("#majorBtn").css("background-color", "#256092");
    $('#minorBtn').css("background-color", "#337ab7");
  }

  function minorBtn(){
    $(document).ready(function() {
      var chart = {
          type: 'bar'
      };
      var title = {
          text: 'Top 3 Minor Cases in DLSU',
          style: {
              fontFamily: 'Arial'
          }
      };
      var subtitle = {
          text: ''
      };
      var xAxis = {
          categories: ['College of Computer Studies',
                      'College of Liberal Arts',
                      'College of Business',
                      'School of Economics',
                      'Gokongwei College of Engineering',
                      'College of Science',
                      'College of Education'],
          title: {
            text: null
          }
      };
      var yAxis = {
          min: 0,
          allowDecimals: false,
          title: {
            text: 'Total',
            align: 'high'
          },
          labels: {
            overflow: 'justify'
          }
      };
      var tooltip = {
          valueSuffix: ''
      };
      var plotOptions = {
          bar: {
            dataLabels: {
                enabled: true
            }
          }
      };
      var legend = {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'top',
        x: -90,
        y: 250,
        floating: false,
        borderWidth: 1,
        backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
        shadow: true
      };
      var credits = {
          enabled: false
      };
      var series = [
          {
            name: '<?php echo $topOffensesDescriptionMinor[0] ?>',
            data: [<?php echo $dataMinor[0]?>,
                    <?php echo $dataMinor[1]?>,
                    <?php echo $dataMinor[2]?>,
                    <?php echo $dataMinor[3]?>,
                    <?php echo $dataMinor[4]?>,
                    <?php echo $dataMinor[5]?>,
                    <?php echo $dataMinor[6]?>]
          },
          {
            name: '<?php echo $topOffensesDescriptionMinor[1] ?>',
            data: [<?php echo $dataMinor[7]?>,
                    <?php echo $dataMinor[8]?>,
                    <?php echo $dataMinor[9]?>,
                    <?php echo $dataMinor[10]?>,
                    <?php echo $dataMinor[11]?>,
                    <?php echo $dataMinor[12]?>,
                    <?php echo $dataMinor[13]?>]
          },
          {
            name: '<?php echo $topOffensesDescriptionMinor[2] ?>',
            data: [<?php echo $dataMinor[14]?>,
                    <?php echo $dataMinor[15]?>,
                    <?php echo $dataMinor[16]?>,
                    <?php echo $dataMinor[17]?>,
                    <?php echo $dataMinor[18]?>,
                    <?php echo $dataMinor[19]?>,
                    <?php echo $dataMinor[20]?>]
          }
      ];

      var json = {};
      json.chart = chart;
      json.title = title;
      json.subtitle = subtitle;
      json.tooltip = tooltip;
      json.xAxis = xAxis;
      json.yAxis = yAxis;
      json.series = series;
      json.plotOptions = plotOptions;
      json.legend = legend;
      json.credits = credits;
      $('#minorCase').highcharts(json);
    });
    var minorChart = document.getElementById("minorCase");
    var majorChart = document.getElementById("majorCase");
      minorChart.style.display = "block";
      majorChart.style.display = "none";
    var minorTable = document.getElementById("minorTable");
    var majorTable = document.getElementById("majorTable");
      minorTable.style.display = "block";
      majorTable.style.display = "none";

    $('#minorBtn').css("background-color", "#256092");
    $('#majorBtn').css("background-color", "#337ab7");
  }

  // sidebar system audit trail
  $('#sidebar_dashboard').click(function() {
    $.ajax({
        url: '../ajax/insert_system_audit_trail.php',
        type: 'POST',
        data: {
            userid: <?php echo $_SESSION['user_id'] ?>,
            actiondone: 'SDFOD Dashboard - Viewed Dashboard'
        },
        success: function(response) {
          console.log('Success');
        }
    });
  });
  $('#sidebar_cases').click(function() {
    $.ajax({
        url: '../ajax/insert_system_audit_trail.php',
        type: 'POST',
        data: {
            userid: <?php echo $_SESSION['user_id'] ?>,
            actiondone: 'SDFOD Dashboard - Viewed Cases'
        },
        success: function(response) {
          console.log('Success');
        }
    });
  });
  $('#sidebar_calendar').click(function() {
    $.ajax({
        url: '../ajax/insert_system_audit_trail.php',
        type: 'POST',
        data: {
            userid: <?php echo $_SESSION['user_id'] ?>,
            actiondone: 'SDFOD Dashboard - Viewed Calendar'
        },
        success: function(response) {
          console.log('Success');
        }
    });
  });
  $('#sidebar_drive').click(function() {
    $.ajax({
        url: '../ajax/insert_system_audit_trail.php',
        type: 'POST',
        data: {
            userid: <?php echo $_SESSION['user_id'] ?>,
            actiondone: 'SDFOD Dashboard - Viewed Files'
        },
        success: function(response) {
          console.log('Success');
        }
    });
  });
  $('#sidebar_inbox').click(function() {
    $.ajax({
        url: '../ajax/insert_system_audit_trail.php',
        type: 'POST',
        data: {
            userid: <?php echo $_SESSION['user_id'] ?>,
            actiondone: 'SDFOD Dashboard - Viewed Inbox'
        },
        success: function(response) {
          console.log('Success');
        }
    });
  });
  $('#sidebar_sysmanagement').click(function() {
    $.ajax({
        url: '../ajax/insert_system_audit_trail.php',
        type: 'POST',
        data: {
            userid: <?php echo $_SESSION['user_id'] ?>,
            actiondone: 'SDFOD Dashboard - Viewed System Management'
        },
        success: function(response) {
          console.log('Success');
        }
    });
  });
  $('#sidebar_sysaudit').click(function() {
    $.ajax({
        url: '../ajax/insert_system_audit_trail.php',
        type: 'POST',
        data: {
            userid: <?php echo $_SESSION['user_id'] ?>,
            actiondone: 'SDFOD Dashboard - Viewed System Audit'
        },
        success: function(response) {
          console.log('Success');
        }
    });
  });
  $('#sidebar_reports').click(function() {
    $.ajax({
        url: '../ajax/insert_system_audit_trail.php',
        type: 'POST',
        data: {
            userid: <?php echo $_SESSION['user_id'] ?>,
            actiondone: 'SDFOD Dashboard - Viewed Reports'
        },
        success: function(response) {
          console.log('Success');
        }
    });
  });
  $('#sidebar_reports').click(function() {
    $.ajax({
        url: '../ajax/insert_system_audit_trail.php',
        type: 'POST',
        data: {
            userid: <?php echo $_SESSION['user_id'] ?>,
            actiondone: 'SDFOD Dashboard - Viewed Incident Reports'
        },
        success: function(response) {
          console.log('Success');
        }
    });
  });

  var count = 0;
  var prevCount = 0;
  loadCount();

  function loadCount() {
    $.ajax({
      url: '../ajax/user-notifications-count.php',
      type: 'POST',
      data: {
      },
      success: function(response) {
        count = response;
        if(count > 0) {
          $('#notif-badge').text(count);
        }
        else {
          $('#notif-badge').text('');
        }
        if (prevCount != count) {
          loadReminders();
          prevCount = count;
        }
      }
    });

    setTimeout(loadCount, 5000);
  };

  var notifTable;

  function loadReminders() {
    if (count > 0) {
      var notif = " new notification";
      if (count > 1) notif = " new notifications";
      $('#alert-message').text('You have '+count+notif);
      setTimeout(function() { showSnackbar(); }, 1500);
    }
  }

  notifData();

  function notifData() {
    $.ajax({
      url: '../ajax/user-notifications.php',
      type: 'POST',
      data: {
      },
      success: function(response) {
        $('#notifTable').html(response);
      }
    });

    notifTable = setTimeout(notifData, 5000);
  }
</script>

<style>
  /* .majorCase{
    position: absolute;
  }

  .minorCase{
    position: absolute;
  } */

  table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 40%;
  position: relative;
  left:32%;
  }

  td, th {
    border: 1px solid #9C9C9C;
    text-align: left;
    padding: 8px;
  }

  th {
    background-color: #dddddd;
  }

  /* tr:nth-child(even) {
    background-color: #dddddd;
  } */

</style>

</body>

</html>

<style>
#snackbar {
  visibility: hidden;
  min-width: 300px;
  background-color: #337ab7;
  color: #fff;
  text-align: center;
  border-radius: 2px;
  padding: 15px;
  position: fixed;
  z-index: 10;
  right: 40px;
  bottom: 40px;
  font-size: 18px;
  border-radius: 5px;
}

#snackbar.show {
  visibility: visible;
  -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
  animation: fadein 0.5s, fadeout 0.5s 2.5s;
}

@-webkit-keyframes fadein {
  from {bottom: 0; opacity: 0;} 
  to {bottom: 40px; opacity: 1;}
}

@keyframes fadein {
  from {bottom: 0; opacity: 0;}
  to {bottom: 40px; opacity: 1;}
}

@-webkit-keyframes fadeout {
  from {bottom: 40px; opacity: 1;} 
  to {bottom: 0; opacity: 0;}
}

@keyframes fadeout {
  from {bottom: 40px; opacity: 1;}
  to {bottom: 0; opacity: 0;}
}
</style>