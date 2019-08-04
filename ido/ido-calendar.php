<?php include 'ido.php' ?>
<?php include "../calendar/access_token.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CMS - Calendar</title>

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

</head>

<body>

    <div id="wrapper">

        <?php include 'ido-sidebar.php';?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-8">
                    <h3 class="page-header">Calendar</h3>
                </div>
            </div>
            <?php include '../calendar/button_and_calendar.php' ?>
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

    <!-- scripts from calendar api  -->
    <link rel="stylesheet" href="../extra-css/jquery.datetimepicker.min.css" />
    <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> -->
    <script src="../extra-css/jquery.datetimepicker.min.js"></script>

    <!-- new  -->
    <script src="../extra-css/chosen.jquery.min.js"></script>
    <link rel="stylesheet" href ="../extra-css/bootstrap-chosen.css"/>

	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
  <script>
  $(document).ready(function() {
    loadNotif();

    function loadNotif () {
        $.ajax({
          url: '../ajax/ido-notif-cases.php',
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

    //logs user in through gmail
    $('#login').click(function() {
      <?php $login_url = 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode('https://www.googleapis.com/auth/calendar') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online'; ?>
    	location.href= '<?php echo $login_url; ?>';
    });


    <?php
    //checks if the user is logged in an hides the login button and shoes the create event button
    if (isset($_SESSION['access_token_calendar'])) { ?>
      $("#create").show();
      $("#login").hide();

      //functions of the calendar api
      // Selected time should not be less than current time
      function AdjustMinTime(ct) {
      	var dtob = new Date(),
        		current_date = dtob.getDate(),
        		current_month = dtob.getMonth() + 1,
        		current_year = dtob.getFullYear();

      	var full_date = current_year + '-' +
      					( current_month < 10 ? '0' + current_month : current_month ) + '-' +
      		  			( current_date < 10 ? '0' + current_date : current_date );

      	if(ct.dateFormat('Y-m-d') == full_date)
      		this.setOptions({ minTime: 0 });
      	else
      		this.setOptions({ minTime: false });
      }

      // DateTimePicker plugin : http://xdsoft.net/jqplugins/datetimepicker/
      $("#event-start-time, #event-end-time").datetimepicker({ format: 'Y-m-d H:i', minDate: 0, minTime: 0, step: 5, onShow: AdjustMinTime, onSelectDate: AdjustMinTime });
      $("#event-date").datetimepicker({ format: 'Y-m-d', timepicker: false, minDate: 0 });

      $("#event-type").on('change', function(e) {
      	if($(this).val() == 'ALL-DAY') {
      		$("#datearea").show();
      		$("#timearea").hide();
      	}
      	else {
      		$("#datearea").hide();
      		$("#timearea").show();
      	}
      });

      //new
      $('.chosen-select').chosen({width: '100%'});
      $("#event-title").on('change', function(e) {
        var usertype_id=$(this).val();

        $.ajax({
          url: '../ajax/calendar-get-emails.php',
          type: 'POST',
          data: {
            usertype: usertype_id
          },
          success: function(response) {
            $('#attendee').show();
            $("#event-attendees").html(response);
            $("#event-attendees").trigger("chosen:updated");
          }
        });
      });

      // Send an ajax request to create event
      $("#create-event").on('click', function(e) {
      	if($("#create-event").attr('data-in-progress') == 1)
      		return;

      	var blank_reg_exp = /^([\s]{0,}[^\s]{1,}[\s]{0,}){1,}$/,
      		error = 0,
      		parameters;

      	$(".input-error").removeClass('input-error');

      	if(!blank_reg_exp.test($("#event-title").val())) {
      		$("#event-title").addClass('input-error');
      		error = 1;
      	}

      	// added
      	if(!blank_reg_exp.test($("#event-attendees").val())) {
      		$("#event-attendees").addClass('input-error');
      		error = 1;
      	}

      	if($("#event-type").val() == 'FIXED-TIME') {
      		if(!blank_reg_exp.test($("#event-start-time").val())) {
      			$("#event-start-time").addClass('input-error');
      			error = 1;
      		}

      		if(!blank_reg_exp.test($("#event-end-time").val())) {
      			$("#event-end-time").addClass('input-error');
      			error = 1;
      		}
      	}
      	else if($("#event-type").val() == 'ALL-DAY') {
      		if(!blank_reg_exp.test($("#event-date").val())) {
      			$("#event-date").addClass('input-error');
      			error = 1;
      		}
      	}

      	if(error == 1)
      		return false;

      	if($("#event-type").val() == 'FIXED-TIME') {
      		// If end time is earlier than start time, then interchange them
      		if($("#event-end-time").datetimepicker('getValue') < $("#event-start-time").datetimepicker('getValue')) {
      			var temp = $("#event-end-time").val();
      			$("#event-end-time").val($("#event-start-time").val());
      			$("#event-start-time").val(temp);
      		}
      	}

        //new
        var title = '';
        if ( $("#event-title").val() == '1')
        {
          title = 'Student Interview'
        }
        else if ( $("#event-title").val() == '2'){
          title = 'Formal Hearing'
        }
        else if ( $("#event-title").val() == '3'){
          title = 'Summary Proceeding'
        }
        else if ( $("#event-title").val() == '4'){
          title = 'University Panel for Case Invitation'
        }

      	// Event details that are pased in ajax
      	parameters =
        {
          //new
          title: title,
          attendees: $("#event-attendees").val(), // ['aaicragsolrac@gmail.com','carlos_martin_garcia@dlsu.edu.ph'],
          event_time:
          {
            start_time: $("#event-type").val() == 'FIXED-TIME' ? $("#event-start-time").val().replace(' ', 'T') + ':00' : null,
            end_time: $("#event-type").val() == 'FIXED-TIME' ? $("#event-end-time").val().replace(' ', 'T') + ':00' : null,
            event_date: $("#event-type").val() == 'ALL-DAY' ? $("#event-date").val() : null
          },
          all_day: $("#event-type").val() == 'ALL-DAY' ? 1 : 0,
          access_token: '<?php echo $_SESSION['access_token_calendar']; ?>'
        };

      	$("#create-event").attr('disabled', 'disabled');
        //../ajax/calendar-create-event.php
      	  $.ajax({
              type: 'POST',
              url: '../ajax/calendar-create-event.php',
              data: {
                event_details: parameters,
                <?php
                  if(isset($_SESSION['caseID'])) { ?>
                    caseID: <?php echo $_SESSION['caseID']; ?>
                <?php }
                ?>
              },
              dataType: 'json',
              success: function(response) {
                // audit trail
                $.ajax({
                          url: '../ajax/insert_system_audit_trail.php',
                          type: 'POST',
                          data: {
                              userid: <?php echo $_SESSION['user_id'] ?>,
                              actiondone: 'HDO Calendar - Created Event'
                          },
                          success: function(response) {
                            console.log('Success');
                          }
                      })

              	//$("#create-event").removeAttr('disabled');
                $("#message").text("An event has been created successfully!");
                $("#alertModal").modal("show");
                $("#eventModal").modal("show");
              },
              error: function(response) {
                  //$("#create-event").removeAttr('disabled');
                  console.log(response);
              }
          });
      });

      $("#modalOK").on("click", function() {
        replaceURL();
      });

      function replaceURL() {
        //change
      	location.replace('ido-calendar.php')
        <?php //unset($_SESSION['access_token_calendar']); ?>
      }
    <?php
    }

    //if user is not logged in hide the create event button
    else{ ?>
        $("#create").hide();
        <?php
      } ?>

    //show modal if you click create event button
    $('#create').click(function() {
      $("#eventModal").modal("show");
    });

    $('.modal').attr('data-backdrop', "static");
    $('.modal').attr('data-keyboard', false);

    // sidebar system audit trail
    $('#sidebar_cases').click(function() {
            $.ajax({
                url: '../ajax/insert_system_audit_trail.php',
                type: 'POST',
                data: {
                    userid: <?php echo $_SESSION['user_id'] ?>,
                    actiondone: 'IDO Calendar - Viewed Cases'
                },
                success: function(response) {
                  console.log('Success');
                }
            });
          });
          $('#sidebar_apprehend').click(function() {
            $.ajax({
                url: '../ajax/insert_system_audit_trail.php',
                type: 'POST',
                data: {
                    userid: <?php echo $_SESSION['user_id'] ?>,
                    actiondone: 'IDO Calendar - Viewed Apprehend'
                },
                success: function(response) {
                  console.log('Success');
                }
            });
          });
          $('#sidebar_files').click(function() {
            $.ajax({
                url: '../ajax/insert_system_audit_trail.php',
                type: 'POST',
                data: {
                    userid: <?php echo $_SESSION['user_id'] ?>,
                    actiondone: 'IDO Calendar - Viewed Files'
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
                    actiondone: 'IDO Calendar - Viewed Calendar'
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
                    actiondone: 'IDO Calendar - Viewed Inbox'
                },
                success: function(response) {
                  console.log('Success');
                }
            });
          });

  });
  </script>

  <?php include '../calendar/modal.php' ?>

</body>

</html>
