<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CMS - Apprehension</title>

	<!-- Webpage Icon -->
	<link rel="icon" href="../images/favicon.ico">

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

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- FOR SEARCHABLE DROP -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>
    <link rel = "stylesheet" href = "./extra-css/bootstrap-chosen.css"/>

</head>

<body>

    <div id="wrapper">

        <?php include 'do-sidebar.php';?>

        <div id="page-wrapper">
            <div class="row">
                <h3 class="page-header">Student Apprehension</h3>

                <div class="col-lg-12">

                  <b>Student ID No.</b><br>
                  <select id="select" class="form-control" style = "width: 150px;">
                      <option value="" disabled selected>Enter ID No.</option>
                      <option>12345678</option>
                      <option>11111111</option>
                      <option>12312415</option>
                  </select>

                  <br><b>Offense</b>

                  <select class = "chosen-select">
                      <option value="" disabled selected>Select Offense</option>
                      <option value = "cheating">Cheating </option>
                      <option>Lost ID</option>
                      <option>Disrespect</option>
                      <option>Dress Code</option>
                      <option>Plagiarism</option>
                      <option>Fraud</option>
                      <option>Fraud</option>
                      <option>Fraud</option>
                      <option value = "other">Other</option>
                  </select>
                  <br><div id = "content"></div>

                  <script type="text/javascript">

                    $('.chosen-select').chosen();
                    $('.chosen-select').change(function() {
                      var offense_id = $(this).val();

                      if (offense_id == "other") {
                        $('#content').append (

                          "<br><b>New Offense</b> <input class='form-control' placeholder='Enter Offense That's Not In List'>"
                        );
                      }

                      else if (offense_id == "cheating") {
                        $('#content').append (
                          "<br><b>Types</b> <select id='select' class='form-control' style = 'width: 300px;'><option value='' disabled selected>Types</option><option>With Kodigo</option><option>Glancing</option><option>Searching</option></select>"
                        );
                      }
                    });

                  </script>

                  <br>

                  <b>Complainant</b><input class="form-control" style = "width: 150px;" placeholder="Enter ID No.">

                  <br>

                  <b>Details</b><textarea class="form-control" rows="3"></textarea>

                  <br><br><br>

                  <button type="button" class="btn btn-primary">Submit</button>

                  <br><br><br>

                </div>

                <div class="col-lg-6">
                </div>
                <!-- /.col-lg-12 -->
            </div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    <script src="../data/morris-data.js"></script>

	<!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>