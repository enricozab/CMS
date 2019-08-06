<?php include 'sdfod.php' ?>
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

        <?php include 'sdfod-sidebar.php';?>

        <div id="page-wrapper">
          <div class="row">
              <div class="col-lg-8">
                  <h3 class="page-header">System Audit Trail</h3>
              </div>
              <!-- /.col-lg-12 -->
          </div>

          <div class="row">
            <div class="col-lg-12">
              <table width="100%" class="table table-striped table-bordered table-hover" id="audit-table">
              </table>
            </div>
          </div>
          <br><br>
          
          <div id="snackbar"><i class="fa fa-info-circle fa-fw" style="font-size: 20px"></i> <span id="alert-message">Some text some message..</span></div>

        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

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

    $("#login").hide();
    $("#create").hide();
  });

  auditTable();

  function auditTable() {
    $.ajax({
      url: '../ajax/sdfod-get-sys-audit.php',
      type: 'POST',
      data: {
      },
      success: function(response) {
        $('#audit-table').html(response);
        $('#audit-table').DataTable({
          "order": [[ 2, 'desc' ]]
        });
      }
    });
  }

  // create user submit button
  $('#createuser').click(function() {
    var ids = ['#CU_idnum','#CU_firstname','#CU_lastname','#CU_email','#CU_usertype','#CU_office'];
    var isEmpty = true;

    for(var i = 0; i < ids.length; ++i ){
      if($.trim($(ids[i]).val()).length == 0){
        isEmpty = false;
      }
    }

    if(isEmpty) {
      $.ajax({
          url: '../ajax/sdfod-insert-created-user.php',
          type: 'POST',
          data: {
              idnum: $('#CU_idnum').val(),
              firstname: $('#CU_firstname').val(),
              lastname: $('#CU_lastname').val(),
              email: $('#CU_email').val(),
              usertype: $('#CU_usertype').val(),
              office: $('#CU_office').val()
          },
          success: function(response) {
            alert('Create User Succsseful'+response);
            $.ajax({
                url: '../ajax/insert_system_audit_trail.php',
                type: 'POST',
                data: {
                    userid: <?php echo $_SESSION['user_id'] ?>,
                    actiondone: 'SDFOD System Management - Created a user.'
                },
                success: function(response) {
                  console.log('Success');
                }
            })
            location.reload();
          }
      });
    }

    else {
      alert("Fill out all fields");
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
          url: 'sdfod-get-details-edit-user.php',
          type: 'POST',
          data: {
            userid: $('#EU_selecteduser').val()
          },
          success: function(response) {
            var details = JSON.parse(response);
            $('#EU_firstname').val(details.FIRST_NAME);
            $('#EU_lastname').val(details.LAST_NAME);
            $('#EU_email').val(details.EMAIL);
            $('#EU_usertype').val(details.USER_TYPE_ID).trigger("chosen:updated");
            $('#EU_office').val(details.OFFICE_ID).trigger("chosen:updated"); 
          }
        });
  });
  

  // update user submit button
  $('#edituser').click(function() {
    
    var ids = ['#EU_firstname','#EU_lastname','#EU_email','#EU_usertype','#EU_office'];
    var isEmpty = true;

    for(var i = 0; i < ids.length; ++i ){
      if($.trim($(ids[i]).val()).length == 0){
        isEmpty = false;
      }
    }

    if(isEmpty) {
      $.ajax({
          url: '../ajax/sdfod-edit-user-info.php',
          type: 'POST',
          data: {
              idnum: $('#EU_selecteduser').val(),
              firstname: $('#EU_firstname').val(),
              lastname: $('#EU_lastname').val(),
              email: $('#EU_email').val(),
              usertype: $('#EU_usertype').val(),
              office: $('#EU_office').val()
          },
          success: function(response) {
            alert('Edit User Successful');
            $.ajax({
                url: '../ajax/insert_system_audit_trail.php',
                type: 'POST',
                data: {
                    userid: <?php echo $_SESSION['user_id'] ?>,
                    actiondone: 'SDFOD System Management - Edited a user.'
                },
                success: function(response) {
                  console.log('Success');
                }
            })
            location.reload();
          }
      });
    }

    else {
      alert("Fill out all fields");
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
          url: '../ajax/sdfod-update-user-active.php',
          type: 'POST',
          data: {
              idnum: $('#MU_selecteduseractive').val(),
              checker: '1'
          },
          success: function(response) {
            alert('Activate User Successful');
            $.ajax({
                url: '../ajax/insert_system_audit_trail.php',
                type: 'POST',
                data: {
                    userid: <?php echo $_SESSION['user_id'] ?>,
                    actiondone: 'SDFOD System Management - Activated a user.'
                },
                success: function(response) {
                  console.log('Success');
                }
            })
            location.reload();
          }
      });
    }

    else {
      alert("Fill out all fields");
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
          url: '../ajax/sdfod-update-user-active.php',
          type: 'POST',
          data: {
              idnum: $('#MU_selecteduserdisable').val(),
              checker: '2'
          },
          success: function(response) {
            alert('Disable User Successful');
            $.ajax({
                url: '../ajax/insert_system_audit_trail.php',
                type: 'POST',
                data: {
                    userid: <?php echo $_SESSION['user_id'] ?>,
                    actiondone: 'SDFOD System Management - Disabled a user.'
                },
                success: function(response) {
                  console.log('Success');
                }
            })
            location.reload();
          }
      });
    }

    else {
      alert("Fill out all fields");
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
          url: '../ajax/sdfod-update-inactivity-rules.php',
          type: 'POST',
          data: {
              minor: $('#MR_minor').val(),
              major: $('#MR_major').val()
          },
          success: function(response) {
            alert('Manage Rules Successful');
            $.ajax({
                url: '../ajax/insert_system_audit_trail.php',
                type: 'POST',
                data: {
                    userid: <?php echo $_SESSION['user_id'] ?>,
                    actiondone: 'SDFOD System Management - Edited rules.'
                },
                success: function(response) {
                  console.log('Success');
                }
            })
            location.reload();
          }
      });
    }

    else {
      alert("Fill out all fields");
    }
  });

  //manage details show details div
  $('#MD_offense').on('change',function() {
    var details=$(this).val();
        if(details != null) {
          $('#MDdetails').show();
        }
        else {
          $('#MDdetails').hide();
        }

        $.ajax({
          url: 'sdfod-get-details-manage-details.php',
          type: 'POST',
          data: {
            offense: $('#MD_offense').val()
          },
          success: function(response) {
            console.log(response);
            var d = JSON.parse(response);
            var dd = d.detailsarray;
            console.log(dd);
            $("#MDtable").find("tr:gt(0)").remove();
            for (var ctr = 0; ctr < dd.length; ctr++){
              console.log(ctr);
              var table = document.getElementById("MDtable");
              var row = table.insertRow(table.size);
              var cell1 = row.insertCell(0);
              cell1.innerHTML = dd[ctr].DETAILS;
            }
          }
        });
  });

  // manage details add details
  $('#MD_add_detail').click(function() {
    var ids = ['#MDadd'];
    var isEmpty = true;

    for(var i = 0; i < ids.length; ++i ){
      if($.trim($(ids[i]).val()).length == 0){
        isEmpty = false;
      }
    }

    if(isEmpty) {
      $.ajax({
          url: '../ajax/sdfod-insert-offense-details.php',
          type: 'POST',
          data: {
              offenseid: $('#MD_offense').val(),
              details: $('#MDadd').val()
          },
          success: function(response) {
            alert('Add Offense Description Successful');
            $.ajax({
                url: '../ajax/insert_system_audit_trail.php',
                type: 'POST',
                data: {
                    userid: <?php echo $_SESSION['user_id'] ?>,
                    actiondone: 'SDFOD System Management - Added offense description.'
                },
                success: function(response) {
                  console.log('Success');
                }
            })
            location.reload();
          }
      });
    }

    else {
      alert("Fill out all fields");
    }
  });


  // sidebar system audit trail
  $('#sidebar_dashboard').click(function() {
    $.ajax({
        url: '../ajax/insert_system_audit_trail.php',
        type: 'POST',
        data: {
            userid: <?php echo $_SESSION['user_id'] ?>,
            actiondone: 'SDFOD System Management - Viewed Dashboard'
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
            actiondone: 'SDFOD System Management - Viewed Cases'
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
            actiondone: 'SDFOD System Management - Viewed Calendar'
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
            actiondone: 'SDFOD System Management - Viewed Files'
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
            actiondone: 'SDFOD System Management - Viewed Inbox'
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
            actiondone: 'SDFOD System Management - Viewed System Management'
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