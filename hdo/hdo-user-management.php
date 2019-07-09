<?php include 'hdo.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CMS - User Management</title>

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
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../extra-css/chosen.jquery.min.js"></script>
    <link rel="stylesheet" href ="../extra-css/bootstrap-chosen.css"/>

    <style>
      iframe {
        width: 100%;
        border: 0;
        min-height: 80%;
        height: 600px;
        display: flex;
      }
    </style>

</head>

<body>

    <div id="wrapper">

        <?php include 'hdo-sidebar.php';?>

        <div id="page-wrapper">
          <div class="row">
              <div class="col-lg-8">
                  <h3 class="page-header">User Management</h3>
              </div>
              <!-- /.col-lg-12 -->
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- insert code here -->
              <div class="col-lg-12">
                    <div class="panel panel-default">
                        <!-- <div class="panel-heading">
                            User
                        </div> -->
                        <!-- .panel-heading -->
                        <div class="panel-body">
                            <div class="panel-group" id="accordion">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <!-- change the href to the id when you create a new collapse -->
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Create User</a>
                                        </h4>
                                    </div>
                                    <!-- include 'in' at the end of class to have it collapsed when you load the screen ----  class="panel-collapse collapse in" -->
                                    <!-- change the id when you create a new collapse -->
                                    <div id="collapseOne" class="panel-collapse collapse">
                                        <div class="panel-body">

                                            <div class="form-group" style = "width: 400px;">
                                            <label>ID Number <span style="font-weight:normal; color:red;">*</span> </label>
                                            <input id='CU_idnum' type='text' class="form-control" placeholder="Enter User's ID Number">
                                            </div>

                                            <div class="form-group" style = "width: 400px;">
                                            <label>First Name <span style="font-weight:normal; color:red;">*</span> </label>
                                            <input id='CU_firstname' type='text' class="form-control" placeholder="Enter User's First Name">
                                            </div>

                                            <div class="form-group" style = "width: 400px;">
                                            <label>Last Name <span style="font-weight:normal; color:red;">*</span> </label>
                                            <input id='CU_lastname' type='text' class="form-control" placeholder="Enter User's Last Name">
                                            </div>

                                            <div class="form-group" style = "width: 400px;">
                                            <label>DLSU Email <span style="font-weight:normal; color:red;">*</span> </label>
                                            <input id='CU_email' type='text' class="form-control" placeholder="Enter User's Email">
                                            </div>

                                            <div class="form-group" style = "width: 400px;">
                                            <label>User Type <span style="font-weight:normal; color:red;">*</span> </label>
                                              <?php
                                                $query='SELECT USER_TYPE_ID, DESCRIPTION FROM ref_user_types';
                                                $result=mysqli_query($dbc,$query);
                                                if(!$result){
                                                  echo mysqli_error($dbc);
                                                }
                                              ?>
                                            <select id="CU_usertype" class="chosen-select">
                                              <option value="" disabled selected>Select User Type</option>
                                              <?php
                                                while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
                                                {
                                                  echo "<option value=\"{$row['USER_TYPE_ID']}\">{$row['DESCRIPTION']}</option>";
                                                }
                                              ?>
                                            </select>
                                            </div>

                                            <div class="form-group" style = "width: 400px;">
                                            <label>Phone Number <span style="font-weight:normal; color:red;">*</span> </label>
                                            <input id='CU_number' type='text' class="form-control" placeholder="Enter User's Phone Number">
                                            </div>

                                            <div class="form-group" style = "width: 400px;">
                                            <label>Office <span style="font-weight:normal; color:red;">*</span> </label>
                                              <?php
                                                $query='SELECT OFFICE_ID, DESCRIPTION FROM ref_user_office';
                                                $result=mysqli_query($dbc,$query);
                                                if(!$result){
                                                  echo mysqli_error($dbc);
                                                }
                                              ?>
                                            <select id="CU_office" class="chosen-select">
                                              <option value="" disabled selected>Select Office</option>  
                                              <?php
                                                while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
                                                {
                                                  echo "<option value=\"{$row['OFFICE_ID']}\">{$row['DESCRIPTION']}</option>";
                                                }
                                              ?>
                                            </select>
                                            </div>
                                            
                                            <br>
                                            <button id="createuser" type="submit" class="btn btn-default">Create User</button>
                                            <br>
                                          </div>
                                    </div>
                                </div>
								
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Edit User</a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse">
                                        <div class="panel-body">
											                  
                                          <div class="form-group" style = "width: 400px;">
                                          <label>Select User <span style="font-weight:normal; color:red;">*</span> </label>
                                            <?php
                                              $query='SELECT USER_ID, CONCAT(USER_ID, " - ", FIRST_NAME, " ", LAST_NAME) AS USER_INFO FROM USERS';
                                              $result=mysqli_query($dbc,$query);
                                              if(!$result){
                                                echo mysqli_error($dbc);
                                              }
                                            ?>
                                          <select id='EU_selecteduser' class="chosen-select">
                                            <option value="" disabled selected>Select User</option>
                                            <?php
                                              while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
                                              {
                                                echo "<option value=\"{$row['USER_ID']}\">{$row['USER_INFO']}</option>";
                                              }
                                            ?>
                                          </select>
                                          </div>

                                          <div id="EUdetails" class="form-group" style = "width: 500px;" hidden>
                                            <div class="form-group" style = "width: 400px;">
                                            <label>First Name</label>
                                            <input id='EU_firstname' type='text' class="form-control" placeholder="Enter User's First Name"> 
                                            </div>

                                            <div class="form-group" style = "width: 400px;">
                                            <label>Last Name</label>
                                            <input id='EU_lastname' type='text' class="form-control" placeholder="Enter User's Last Name">
                                            </div>

                                            <div class="form-group" style = "width: 400px;">
                                            <label>DLSU Email</label>
                                            <input id='EU_email' type='text' class="form-control" placeholder="Enter User's Email">
                                            </div>

                                            <div class="form-group" style = "width: 400px;">
                                            <label>User Type</label>
                                              <?php
                                                $query='SELECT USER_TYPE_ID, DESCRIPTION FROM ref_user_types';
                                                $result=mysqli_query($dbc,$query);
                                                if(!$result){
                                                  echo mysqli_error($dbc);
                                                }
                                              ?>
                                            <select id="EU_usertype" class="chosen-select">
                                            <option value="" disabled selected>Select User Type</option>
                                              <?php
                                                while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
                                                {
                                                  echo "<option value=\"{$row['USER_TYPE_ID']}\">{$row['DESCRIPTION']}</option>";
                                                }
                                              ?>
                                            </select>
                                            </div>

                                            <div class="form-group" style = "width: 400px;">
                                            <label>Phone Number</label>
                                            <input id='EU_number' type='text' class="form-control" placeholder="Enter User's Phone Number">
                                            </div>

                                            <div class="form-group" style = "width: 400px;">
                                            <label>Office</label>
                                              <?php
                                                $query='SELECT OFFICE_ID, DESCRIPTION FROM ref_user_office';
                                                $result=mysqli_query($dbc,$query);
                                                if(!$result){
                                                  echo mysqli_error($dbc);
                                                }
                                              ?>
                                            <select id="EU_office" class="chosen-select">
                                            <option value="" disabled selected>Select Office</option>
                                              <?php
                                                while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
                                                {
                                                  echo "<option value=\"{$row['OFFICE_ID']}\">{$row['DESCRIPTION']}</option>";
                                                }
                                              ?>
                                            </select>
                                            </div>
                                            
                                            <br>
                                            <button id="edituser" type="submit" class="btn btn-default">Edit User</button>
                                            <br>
                                          </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Manage User</a>
                                        </h4>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse">
                                        <div class="panel-body">

                                            <div class="form-group" style = "width: 400px;">
                                            <label>Disabled Users</label>
                                              <?php
                                                $query='SELECT USER_ID, CONCAT(USER_ID, " - ", FIRST_NAME, " ", LAST_NAME) AS USER_INFO FROM USERS WHERE IS_ACTIVE = 2';
                                                $result=mysqli_query($dbc,$query);
                                                if(!$result){
                                                  echo mysqli_error($dbc);
                                                }
                                              ?>
                                            <select id='MU_selecteduseractive' class="chosen-select">
                                             <option value="" disabled selected>Select User</option>
                                              <?php
                                                while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
                                                {
                                                  echo "<option value=\"{$row['USER_ID']}\">{$row['USER_INFO']}</option>";
                                                }
                                              ?>
                                            </select>

                                            <br><br>   
                                            <button id="activateuser" type="submit" class="btn btn-default">Activate User</button>
                                            <br><br>

                                            <label>Active Users </label>
                                              <?php
                                                $query='SELECT USER_ID, CONCAT(USER_ID, " - ", FIRST_NAME, " ", LAST_NAME) AS USER_INFO FROM USERS WHERE IS_ACTIVE = 1';
                                                $result=mysqli_query($dbc,$query);
                                                if(!$result){
                                                  echo mysqli_error($dbc);
                                                }
                                              ?>
                                            <select id='MU_selecteduserdisable' class="chosen-select">
                                             <option value="" disabled selected>Select User</option>
                                              <?php
                                                while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
                                                {
                                                  echo "<option value=\"{$row['USER_ID']}\">{$row['USER_INFO']}</option>";
                                                }
                                              ?>
                                            </select>
                                            <br><br>
                                            <button id="disableuser" type="submit" class="btn btn-default">Disable User</button>
                                            <br>
                                          </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">Manage Rules</a>
                                        </h4>
                                    </div> 
                                    <div id="collapseFour" class="panel-collapse collapse">
                                      <div class="panel-body">
                                        <div class="form-group" style = "width: 400px;">
                                          <?php
                                            $query='SELECT NUM_DAYS FROM inactivity_rule WHERE offense_type = "Minor"';
                                            $result=mysqli_query($dbc,$query);
                                            if(!$result){
                                              echo mysqli_error($dbc);
                                            }
                                            else {
                                              $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
                                            }
                                          ?>
                                          <label>Maximum days of inactivity for Minor Cases:</label>
                                          <input id='MR_minor' type='text' class="form-control" value="<?php echo $row['NUM_DAYS']; ?>">

                                          <br>
                                          
                                          <?php
                                            $query='SELECT NUM_DAYS FROM inactivity_rule WHERE offense_type = "Major"';
                                            $result=mysqli_query($dbc,$query);
                                            if(!$result){
                                              echo mysqli_error($dbc);
                                            }
                                            else {
                                              $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
                                            }
                                          ?>
                                          <label>Maximum days of inactivity for Major Cases:</label>
                                          <input id='MR_major' type='text' class="form-control" value="<?php echo $row['NUM_DAYS']; ?>">

                                          <br><br>
                                          <button id="updaterules" type="submit" class="btn btn-default">Update Rules</button>
                                      </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">Manage Details</a>
                                        </h4>
                                    </div> 
                                    <div id="collapseFive" class="panel-collapse collapse">
                                      <div class="panel-body">
                                        <div class="form-group" style = "width: 400px;">
                                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Rendering engine</th>
                                        <th>Browser</th>
                                        <th>Platform(s)</th>
                                        <th>Engine version</th>
                                        <th>CSS grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd gradeX">
                                        <td>Trident</td>
                                        <td>Internet Explorer 4.0</td>
                                        <td>Win 95+</td>
                                        <td class="center">4</td>
                                        <td class="center">X</td>
                                    </tr>
                                </tbody>
                            </table>

                                          <br><br>
                                          <button id="updaterules" type="submit" class="btn btn-default">Manage Details</button>
                                      </div>
                                    </div>
                                </div>
								
                            </div>
                        </div>
                        <!-- .panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            </div>
          </div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <!-- <script src="../vendor/jquery/jquery.min.js"></script> -->

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

	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
  <script>
  //all functinos have to be inside this functions
  //function that runs once the page is loaded

  $(document).ready(function() {
    loadNotif();

    $('.chosen-select').chosen({width: '100%'});

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
          url: '../ajax/hdo-notif-cases.php',
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

    $("#login").hide();
    $("#create").hide();
  });

  // create user submit button
  $('#createuser').click(function() {
    var ids = ['#CU_idnum','#CU_firstname','#CU_lastname','#CU_email','#CU_usertype','#CU_number','#CU_office'];
    var isEmpty = true;

    for(var i = 0; i < ids.length; ++i ){
      if($.trim($(ids[i]).val()).length == 0){
        isEmpty = false;
      }
    }

    if(isEmpty) {
      $.ajax({
          url: '../ajax/hdo-insert-created-user.php',
          type: 'POST',
          data: {
              idnum: $('#CU_idnum').val(),
              firstname: $('#CU_firstname').val(),
              lastname: $('#CU_lastname').val(),
              email: $('#CU_email').val(),
              usertype: $('#CU_usertype').val(),
              number: $('#CU_number').val(),
              office: $('#CU_office').val()
          },
          success: function(response) {
            alert('success create');
            location.reload();
          }
      });
    }

    else {
      alert("Fill out all fields");
      // $("#done").hide();
      // $("#alertModal").modal("show");
    }
  });

  //edit user show details div
  $('#EU_selecteduser').on('change',function() {
    var details=$(this).val();
        if(details != null) {
          $('#EUdetails').show();
        }
        else {
          $('#EUdetails').hide();
        }

        $.ajax({
          url: 'hdo-get-details-edit-user.php',
          type: 'POST',
          data: {
            userid: $('#EU_selecteduser').val()
          },
          success: function(response) {
            // alert(response);
            console.log(response);
            var details = JSON.parse(response);
            $('#EU_firstname').val(details.FIRST_NAME);
            $('#EU_lastname').val(details.LAST_NAME);
            $('#EU_email').val(details.EMAIL);
            $('#EU_usertype').val(details.USER_TYPE_ID).trigger("chosen:updated");
            $('#EU_number').val(details.PHONE);
            $('#EU_office').val(details.OFFICE_ID).trigger("chosen:updated"); 
          }
        });
  });
  

  // update user submit button
  $('#edituser').click(function() {
    
    var ids = ['#EU_firstname','#EU_lastname','#EU_email','#EU_usertype','#EU_number','#EU_office'];
    var isEmpty = true;

    for(var i = 0; i < ids.length; ++i ){
      if($.trim($(ids[i]).val()).length == 0){
        isEmpty = false;
      }
    }

    if(isEmpty) {
      $.ajax({
          url: '../ajax/hdo-edit-user-info.php',
          type: 'POST',
          data: {
              idnum: $('#EU_selecteduser').val(),
              firstname: $('#EU_firstname').val(),
              lastname: $('#EU_lastname').val(),
              email: $('#EU_email').val(),
              usertype: $('#EU_usertype').val(),
              number: $('#EU_number').val(),
              office: $('#EU_office').val()
          },
          success: function(response) {
            alert('success edit');
            location.reload();
          }
      });
    }

    else {
      alert("Fill out all fields");
      // $("#done").hide();
      // $("#alertModal").modal("show");
    }
  });

  // activate user submit button
  $('#activateuser').click(function() {
    var ids = ['#MU_selecteduseractive'];
    var isEmpty = true;

    for(var i = 0; i < ids.length; ++i ){
      if($.trim($(ids[i]).val()).length == 0){
        isEmpty = false;
      }
    }

    if(isEmpty) {
      $.ajax({
          url: '../ajax/hdo-update-user-active.php',
          type: 'POST',
          data: {
              idnum: $('#MU_selecteduseractive').val(),
              checker: '1'
          },
          success: function(response) {
            alert('success manage');
            location.reload();
          }
      });
    }

    else {
      alert("Fill out all fields");
      // $("#done").hide();
      // $("#alertModal").modal("show");
    }
  });

  // disable user submit button
  $('#disableuser').click(function() {
    var ids = ['#MU_selecteduserdisable'];
    var isEmpty = true;

    for(var i = 0; i < ids.length; ++i ){
      if($.trim($(ids[i]).val()).length == 0){
        isEmpty = false;
      }
    }

    if(isEmpty) {
      $.ajax({
          url: '../ajax/hdo-update-user-active.php',
          type: 'POST',
          data: {
              idnum: $('#MU_selecteduserdisable').val(),
              checker: '2'
          },
          success: function(response) {
            alert('success manage');
            location.reload();
          }
      });
    }

    else {
      alert("Fill out all fields");
      // $("#done").hide();
      // $("#alertModal").modal("show");
    }
  });

  $('#updaterules').click(function() {
    var ids = ['#MR_minor','#MR_major'];
    var isEmpty = true;

    for(var i = 0; i < ids.length; ++i ){
      if($.trim($(ids[i]).val()).length == 0){
        isEmpty = false;
      }
    }

    if(isEmpty) {
      $.ajax({
          url: '../ajax/hdo-update-inactivity-rules.php',
          type: 'POST',
          data: {
              minor: $('#MR_minor').val(),
              major: $('#MR_major').val()
          },
          success: function(response) {
            alert('success manage rules');
            location.reload();
          }
      });
    }

    else {
      alert("Fill out all fields");
      // $("#done").hide();
      // $("#alertModal").modal("show");
    }
  });

  </script>

</body>

</html>