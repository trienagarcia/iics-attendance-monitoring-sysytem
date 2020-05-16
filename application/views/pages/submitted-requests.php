<div class="page-body" >
	<div class="container">
		<div class="section-title">
			<h3>My Make-Up Class Requests</h3>
		</div>
		<div class="section-body body-part" >
			<?php 
			if($this->session->flashdata('errors')): 
				echo "<font color='red'>" . $this->session->flashdata('errors') . "</font>";
			endif;

			if($this->session->flashdata('server_errors')):
				echo "alert(" . $this->session->flashdata('server_errors') . ");";
			endif;
			?>
			<!-- start annthonite -->
			<!-- <div class="row">
				<div class="col-md-4">
					<button type="button" class="btn btn-primary btn-add-chem-waste my-3" id="btn-add-request">+ Add Request</button>
				</div>
				
			</div> -->
			<!-- end annthonite -->

			<style>
				input[type=date]::-webkit-inner-spin-button {
				    -webkit-appearance: none;
				    display: none;
				}
			</style>

			<button type="button" class="btn btn-primary mb-3" id="btn-add-request">Add New Request</button>
			<table id="table-submitted-requests" class="table table-hover dt-responsive" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Date</th>
						<th>Time From</th>
						<th>Time To</th>
						<th>Course</th>
						<th>Section</th>
						<th>Room</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Date</th>
						<th>Time From</th>
						<th>Time To</th>
						<th>Course</th>
						<th>Section</th>
						<th>Room</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</tfoot>
			</table>

		</div>
	</div>
</div>

<div class="modal fade modal-fade-in-scale-up" id="add-request-modal" aria-hidden="true" aria-labelledby="exampleModalTitle"
role="dialog" tabindex="-1">
<div class="modal-dialog modal-simple">
	<div class="modal-content">
		<div class="modal-header bgc-primary">
			<h4 class="modal-title white mt-15">Add New Request</h4>
			<button type="button" class="close white" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		</div>
		<div class="modal-body mt-15">
			<form id="form-addadmin" method="post">
				<font color='red'><span id="error_message"></span></font>
				<div class="form-group">
					<div class="row">
						<div class="col-md-12">
							<div class="label-input">Date <span class="required">*</span></div>
							<input type="date" class="form-control required-input" name="date" id="date" onkeydown="return false">
<!-- 							<input class="form-control" id="date" name="date" readonly> -->
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-6">
							<div class="label-input">Time From <span class="required">*</span></div>
							<select class="form-control required-input" name="time_from" id="time_from" 
							data-parsley-required="true" >
							<option value="7:00" selected="selected">7:00 AM</option>
							<option value="7:30">7:30 AM</option>
							<option value="8:00">8:00 AM</option>
							<option value="8:30">8:30 AM</option>
							<option value="9:00">9:00 AM</option>
							<option value="9:30">9:30 AM</option>
							<option value="10:00">10:00 AM</option>
							<option value="10:30">10:30 AM</option>
							<option value="11:00">11:00 AM</option>
							<option value="11:30">11:30 AM</option>
							<option value="12:00">12:00 NN</option>
							<option value="12:30">12:30 PM</option>
							<option value="13:00">1:00 PM</option>
							<option value="13:30">1:30 PM</option>
							<option value="14:00">2:00 PM</option>
							<option value="14:30">2:30 PM</option>
							<option value="15:00">3:00 PM</option>
							<option value="15:30">3:30 PM</option>
							<option value="16:00">4:00 PM</option>
							<option value="16:30">4:30 PM</option>
							<option value="17:00">5:00 PM</option>
							<option value="17:30">5:30 PM</option>
							<option value="18:00">6:00 PM</option>
							<option value="18:30">6:30 PM</option>
							<option value="19:00">7:00 PM</option>
							<option value="19:30">7:30 PM</option>
							<option value="20:00">8:00 PM</option>
							<option value="20:30">8:30 PM</option>

						</select>
					</div>
					<div class="col-md-6">
						<div class="label-input">Time To <span class="required">*</span></div>
						<select class="form-control required-input" name="time_to" id="time_to" 
						data-parsley-required="true" >
						<option value="7:30" selected="selected">7:30 AM</option>
						<option value="8:00">8:00 AM</option>
						<option value="8:30">8:30 AM</option>
						<option value="9:00">9:00 AM</option>
						<option value="9:30">9:30 AM</option>
						<option value="10:00">10:00 AM</option>
						<option value="10:30">10:30 AM</option>
						<option value="11:00">11:00 AM</option>
						<option value="11:30">11:30 AM</option>
						<option value="12:00">12:00 NN</option>
						<option value="12:30">12:30 PM</option>
						<option value="13:00">1:00 PM</option>
						<option value="13:30">1:30 PM</option>
						<option value="14:00">2:00 PM</option>
						<option value="14:30">2:30 PM</option>
						<option value="15:00">3:00 PM</option>
						<option value="15:30">3:30 PM</option>
						<option value="16:00">4:00 PM</option>
						<option value="16:30">4:30 PM</option>
						<option value="17:00">5:00 PM</option>
						<option value="17:30">5:30 PM</option>
						<option value="18:00">6:00 PM</option>
						<option value="18:30">6:30 PM</option>
						<option value="19:00">7:00 PM</option>
						<option value="19:30">7:30 PM</option>
						<option value="20:00">8:00 PM</option>
						<option value="20:30">8:30 PM</option>
						<option value="21:00">9:00 PM</option>
					</select>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-md-6">
					<div class="label-input">Room <span class="required">*</span></div>
					<select class="form-control required-input" name="room" id="room" 
					data-parsley-required="true" >
					<option value="" selected="selected">Select Room</option>
				</select>
			</div>
			<div class="col-md-6">
				<div class="label-input">Section <span class="required">*</span></div>
				<select class="form-control required-input" name="section" id="section" 
				data-parsley-required="true" >
				<option value="" selected="selected">Select Section</option>
			</select>
		</div>
	</div>
</div>
<div class="form-group">
	<div class="row">
		<div class="col-md-12">
			<div class="label-input">Course <span class="required">*</span></div>
			<select class="form-control required-input" name="course" id="course" 
			data-parsley-required="true" >
			<option value="" selected="selected">Select Course</option>
		</select>
	</div>
</div>
</div>
</form>
<div class="message"></div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-dark" data-dismiss="modal">Cancel</button>
	<button type="button" id="btn-submit-add-request" class="btn btn-primary">Submit</button>
</div>
</div>
</div>
</div>

<!-- annthonite -->
<div class="modal fade" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="requestModalLabel">
					Confirmation
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to cancel?</p>
			</div>
			<div class="modal-footer">
				<!-- Modal Footer -->
				<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
				<button type="button" class="btn btn-info" id="cancelRequest">Yes</button>
			</div>
		</div>
	</div>
</div>

<script>

	//$('#date').datepicker({
	//	minDate     : new Date(),
	//	dateFormat  : 'yy-mm-dd',
	//	changeMonth : true,
	//	changeYear  : true,
	//}).datepicker("setDate", new Date());

	function addMinutes(time, minsToAdd) {
		function D(J){ return (J<10? '0':'') + J;};
		var piece = time.split(':');
		var mins = piece[0]*60 + +piece[1] + +minsToAdd;
		return D(mins%(24*60)/60 | 0) + ':' + D(mins%60);  
	}  

	function tConvert (time) {
		// Check correct time format and split into components
		time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

		if (time.length > 1) { // If time format correct
		    time = time.slice (1);  // Remove full string match value
		    time[5] = +time[0] < 12 ? ' AM' : ' PM'; // Set AM/PM
		    time[0] = +time[0] % 12 || 12; // Adjust hours
		}
	  	return time.join (''); // return adjusted time or original string
	}

	$("#date").click(function () {
	    var element = $("select")[0],
	        worked = false;
	    if(document.createEvent) { // chrome and safari
	        var e = document.createEvent("MouseEvents");
	        e.initMouseEvent("mousedown", true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
	        worked = element.dispatchEvent(e);
	    }
	    if(!worked) { // unknown browser / error
	        alert("It didn't worked in your browser.");
	    }
	});

	$(function(){
	    var dtToday = new Date();
	    var tomorrow = new Date();
		tomorrow.setDate(dtToday.getDate()+1);
	    var month = tomorrow.getMonth() + 1;
	    var day = tomorrow.getDate();
	    var year = tomorrow.getFullYear();
	    if(month < 10)
	        month = '0' + month.toString();
	    if(day < 10)
	        day = '0' + day.toString();
	    
	    var maxDate = year + '-' + month + '-' + day;
	    $('#date').attr('min', maxDate);
	});

	var requests;
	$(document).ready(function() {
		$('#my-requests a').removeClass('nav-color');
		$('#my-requests a').addClass('nav-active');

		requests = $("#table-submitted-requests").DataTable({
			ajax: {
				url: "<?=base_url()?>ajax/get-user-submitted-requests",
				type: 'GET',
				dataSrc: ''
			},
			responsive:true,
			"order": [[ 0, "desc" ]],
			columns: [
			{ data: 'request_date' },
			{ data: 'start_time'},
			{ data: 'end_time' },
			{ data: 'course_code'},
			{ data: 'section_name'},
			{ data: 'room_number'},
			{ data: 'status_name'},
			{ data: null}
			],
			columnDefs: [
			{
				"targets": 7,
				"data": 'request_id',
				"render": function ( data, type, row ) {
					var html = "";
							// annthonite
							html += "<button class='btn btn-danger btn-sm btn-cancel cancelRequestBtn' requestID='" + row['request_id'] + "'>Delete</button>";
							return html;
						} 
					}
					]
				});

		$.ajax({
			url: "<?=base_url()?>ajax/get-courses",
			type: 'POST',
			success: function (data) {
				var courses = $('#course');
				$.each(JSON.parse(data), function (val, text) {
					courses.append($('<option></option>').attr("value", val)
						.text(text.course_code + " : " + text.course_name));
				})
			}
		});

		$.ajax({
			url: "<?=base_url()?>ajax/get-sections",
			type: 'POST',
			success: function (data) {
				var section = $('#section');
				$.each(JSON.parse(data), function (val, text) {
					section.append($('<option></option>').attr("value", val)
						.text(text.section_name));
				})
			}
		});

		$.ajax({
			url: "<?=base_url()?>ajax/get-rooms",
			type: 'POST',
			success: function (data) {
				var room = $('#room');
				$.each(JSON.parse(data), function (val, text) {
					room.append($('<option></option>').attr("value", val)
						.text(text.room_number));
				})
			}
		});

		$(document).on('click', '#btn-add-request', function() {
			$('#add-request-modal').modal('show');
			$('#date').val('');
			$('#time_from').val('');
			$('#time_to').val('');
			$('#room').val('');
			$('#section').val('');
			$('#course').val('');
			$('#error_message').text('');
		});

		$(document).on('click', '#btn-submit-add-request', function() {

			if( $('#section').val() === "" || $('#room').val() === "" || $('#course').val() === "" ) {
				$('#error_message').text('Please complete all required fields.');
				return;
			}

			$.ajax({
				url: '<?=base_url()?>submit-request',
				type: 'POST',
				data: {
					date: $('#date').val(),
					time_from : $('#time_from').val(),
					time_to: $('#time_to').val(),
					room : $('#room').val(),
					section: $('#section').val(),
					course:  $('#course').val()
				},
				success:function(data) {
					console.log(data);
					var result = JSON.parse(data);

					if( result.type == 'success' || result.type == 'error' ) {
						alert(result.message);
						$('#add-request-modal').modal('hide');
						requests.ajax.reload();
					}else if( result.type == 'taken' ) {
						$('#error_message').text(result.message);
					}

				}
			});
		});

		// annthonite
		$(document).on('click', '.cancelRequestBtn', function () {
			var oModal = $('#requestModal');
			var sFooter = `
			<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
			<button type="button" class="btn btn-info" id="cancelRequestBtn" requestID="` + $(this).attr('requestID') + `">Yes</button>
			`;
			oModal.find('.modal-footer').html(sFooter);
			oModal.modal('show');
		});

		// annthonite
		$(document).on('click', '#cancelRequestBtn', function () {
			var oData = {
				'request_id' : $(this).attr('requestID')
			};

			$.ajax({
				url     : '<?=base_url()?>ajax/delete-requests',
				type    : 'POST',
				data    : oData,
				success : function (data) {
					$('#requestModal').modal('hide');
					requests.ajax.reload();
				},
				error   : function () {
					alert("Request Successfully Deleted!");
				}
			});
		});


		document.getElementById('time_from').addEventListener('change', function() {
			$('#time_to').empty();
			$('#error_message').text('');
			var start_time = this.value;
			var ctr = 0;
			var end_time = $('#time_to');
			var new_time = start_time;

			while( ctr < 6 ) {
				new_time = addMinutes(new_time, '30');
				end_time.append($('<option></option>')
						.attr("value", new_time)
						.text(tConvert(new_time)));
				if( new_time == '21:00' ) break;
				ctr++;
			}
		});

		document.getElementById('time_to').addEventListener('change', function() {
			$('#error_message').text('');
		});

		document.getElementById('date').addEventListener('change', function() {
			$('#error_message').text('');
		});

		document.getElementById('room').addEventListener('change', function() {
			$('#error_message').text('');
		});


	});
</script>