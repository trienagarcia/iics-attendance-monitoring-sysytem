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
			<div class="row">
				<div class="col-md-4">
					<button type="button" class="btn btn-primary btn-add-chem-waste my-3" id="btn-add-request">+ Add Request</button>
				</div>
				
			</div>

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

<script>
	var requests;
	$(document).ready(function() {
		$('#submitted-requests a').removeClass('nav-color');
		$('#submitted-requests a').addClass('nav-active');

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
				{ data: 'time_from'},
				{ data: 'time_to' },
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
							html += "<button class='btn btn-primary btn-sm btn-edit-request' data-id='"+data.request_id+"'>&nbsp;&nbsp;Edit&nbsp;&nbsp;</button> ";
							html += "<button class='btn btn-danger btn-sm btn-cancel' data-id='"+data.hw_report_id+"'>Cancel</button>";
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


		


	});
</script>