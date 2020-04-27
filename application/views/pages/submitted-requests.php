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
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<div class="label-input">Date <span class="required">*</span></div>
									<input type="date" class="form-control required-input" name="date" id="date">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<div class="label-input">Time From <span class="required">*</span></div>
									<input type="time" class="form-control form-input required-input" id="time_from" name="time_from">
								</div>
								<div class="col-md-6">
									<div class="label-input">Time To <span class="required">*</span></div>
									<input type="time" class="form-control form-input required-input" id="time_to" name="time_to">
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
							html += "<button class='btn btn-danger btn-sm btn-cancel cancelRequestBtn' requestID='" + row['request_id'] + "'>Cancel</button>";
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
			$('#date').val(''),
        	$('#time_from').val(''),
        	$('#time_to').val(''),
        	$('#room').val(''),
        	$('#section').val(''),
        	$('#course').val('')
		});

		$(document).on('click', '#btn-submit-add-request', function() {

			$.ajax({
                url: '<?=base_url()?>ajax/add-new-request',
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
                	$('#add-request-modal').modal('hide');
                	alert("Request Successfully Added!");
                	requests.ajax.reload();
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
	});
</script>