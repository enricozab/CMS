<?php
session_start();

if(!isset($_SESSION['access_token_calendar'])) {
	header('Location: google-login.php');
	exit();
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.1.9/jquery.datetimepicker.min.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.1.9/jquery.datetimepicker.min.js"></script>

</head>

<body>

<div id="form-container">
	<input type="text" id="event-title" placeholder="Event Title" autocomplete="off" /><br><br>
	<select id="event-type"  autocomplete="off">
		<option value="FIXED-TIME">Fixed Time Event</option>
		<option value="ALL-DAY">All Day Event</option>
	</select><br><br>
	<input type="text" id="event-start-time" placeholder="Event Start Time" autocomplete="off" /><br><br>
	<input type="text" id="event-end-time" placeholder="Event End Time" autocomplete="off" /><br><br>
	<input type="text" id="event-date" placeholder="Event Date" autocomplete="off" /><br><br>
	<input type="text" id="event-attendees" placeholder="Event Attendees" autocomplete="off" /><br><br>
	<button id="create-event">Create Event</button>
</div>

<script>

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
		$("#event-date").show();
		$("#event-start-time, #event-end-time").hide();
	}
	else {
		$("#event-date").hide();
		$("#event-start-time, #event-end-time").show();
	}
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

	// Event details
	parameters = { 	title: $("#event-title").val(),
					attendees: $("#event-attendees").val(),
					event_time: {
						start_time: $("#event-type").val() == 'FIXED-TIME' ? $("#event-start-time").val().replace(' ', 'T') + ':00' : null,
						end_time: $("#event-type").val() == 'FIXED-TIME' ? $("#event-end-time").val().replace(' ', 'T') + ':00' : null,
						event_date: $("#event-type").val() == 'ALL-DAY' ? $("#event-date").val() : null
					},
					all_day: $("#event-type").val() == 'ALL-DAY' ? 1 : 0,
				};

	$("#create-event").attr('disabled', 'disabled');
	$.ajax({
        type: 'POST',
        url: 'calendar_ajax.php',
        data: { event_details: parameters },
        dataType: 'json',
        success: function(response) {
        	$("#create-event").removeAttr('disabled');
        	alert('Event created with ID : ' + response.event_id);
					replaceURL();
        },
        error: function(response) {
            $("#create-event").removeAttr('disabled');
            alert(response.responseJSON.message);
        }
    });
});

function replaceURL() {
	location.replace('google-login.php')
}

</script>

</body>
</html>
