<div class="page-body" >
	<div class="container">
		<div class="section-title">
			<h3>Time Logs</h3>
		</div>
		<!-- annthonite -->
		<div class="row">
			<div class="col"></div>
			<div class="col"></div>
			<div class="col"></div>
			<div class="col">
				<div class=""></div>
				<div class="label-input">Professors</div>
				<select class="form-control" name="professor" id="professor" data-parsley-required="true">
					<option disabled selected></option>
					<?php
					foreach ($faculty as $f) {
						echo '<option value="'.$f['person_id'].'">'.$f['first_name']. ' ' . $f['last_name'] . '</option>';
					} 
					?>
		        </select>
			</div>
			<div class="col">
				<div class="label-input">Date</div>
				<input class="form-control" id="date_picker" name="date_picker">
			</div>
		<!-- annthonite -->
		</div>
		<br>
		<div class="section-body body-part" >
			<?php 
				if($this->session->flashdata('errors')): 
					echo "<font color='red'>" . $this->session->flashdata('errors') . "</font>";
				endif;

				if($this->session->flashdata('server_errors')):
					echo "alert(" . $this->session->flashdata('server_errors') . ");";
				endif;
			?>
			<table id="table-submitted-reports" class="table table-hover dt-responsive" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Course</th>
						<th>Section</th>
						<th>Room No.</th>
						<th>Time In</th>
						<th>Time Out</th>
						<th>Attendance</th>
						<th>Remarks</th>
						<th>Actions</th>
				</thead>
				<tfoot>
					<tr>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Course</th>
						<th>Section</th>
						<th>Room No.</th>
						<th>Time In</th>
						<th>Time Out</th>
						<th>Attendance</th>
						<th>Remarks</th>
						<th>Actions</th>
					</tr>
				</tfoot>
			</table>

		</div>
	</div>

	<!-- annthonite -->
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dynamicModal" data-whatever="@mdo">Open modal for @mdo</button>
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dynamicModal" data-whatever="@fat">Open modal for @fat</button>

	<div class="modal fade" id="dynamicModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="exampleModalLabel">New message</h4>
				</div>
				<div class="modal-body">
					<form>
						<div class="form-group">
							<label for="recipient-name" class="control-label">Recipient:</label>
							<input type="text" class="form-control" id="recipient-name">
						</div>
						<div class="form-group">
							<label for="message-text" class="control-label">Message:</label>
							<textarea class="form-control" id="message-text"></textarea>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Send message</button>
				</div>
			</div>
		</div>
	</div>
	<!-- annthonite -->

	</div>

<script>
	var logs;
	$(document).ready(function() {
		// annthonite

		$('#professor').change(function(sProfessor) {
			getFilteredTimeLogs($('#professor').val(), $('#date_picker').val());
		});
		
		$('#date_picker').datepicker({
			maxDate: '0',
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			onSelect: function(sDate) {
				getFilteredTimeLogs($('#professor').val(), sDate);
			},
		});
		
		$('#submitted-reports a').removeClass('nav-color');
		$('#submitted-reports a').addClass('nav-active');
			logs = $("#table-submitted-reports").DataTable({
				ajax: {
					url: "<?=base_url()?>ajax/get-time-logs",
					type: 'GET',
					dataSrc: ''
				},
				responsive:true,
				"order": [[ 0, "desc" ]],
				columns: [
				// person.first_name, person.last_name, course.course_code, sections.section_name, rooms.room_number, logs.time_in, logs.time_out, attendance_name
				{ data: 'first_name'},
				{ data: 'last_name'},
				{ data: 'course_code' },
				{ data: 'section_name' },
				{ data: 'room_number' },
				{ data: 'time_in' },
				{ data: 'time_out'},
				{ data: 'attendance_name' },
				{ data: 'remarks'},
				{ defaultContent: 
					`
					<button class='btn btn-success btn-sm btn-success' id='btnUpdateAttendance'>Edit Attendance</button><br />
					<button class='btn btn-info btn-sm btn-info' id='btnUpdateRemarks'>Edit Remarks</button>
					`
				},

				// `<div class="dropdown">
				// 	<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				// 			Actions
				// 		</button>
				// 		<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				// 			<a class="dropdown-item" href="#">Edit Attendance</a>
				// 			<a class="dropdown-item" href="#">Edit Remarks</a>
				// 		</div>
				// 	</div>`

				],
				columnDefs: []
		});

			// setInterval( function () {
			// 	logs.ajax.reload();
			// }, 2000 );

			$(document).on('click', '.btn-approve', function(data) {
				var report_id = $(this).attr('data-id');
				var status = "Approved";
				var r = confirm("Are you sure you want to approve this report?");
				if (r == true) {
				  $.ajax({
				  	url: "<?=base_url()?>ajax/update-report-status",
				  	type: "POST",
				  	data: {
				  		report_id: report_id,
				  		status: status
				  	},
				  	success: function(data) {
				  		alert("Report Successfully Approved");
				  		reports.ajax.reload();
				  	}
				  });
				} else {
					return false;
				}
			});

			$(document).on('click', '.btn-reject', function(data) {
				
			});

			$(document).on('click', '.btn-view-report', function(data) {
				var report_id = $(this).attr('data-id');
				window.location.href = "<?=base_url()?>report/"+report_id;
			});

			$(document).on('click', '.btn-edit-report', function(data) {
				var form_id = "#form_" + $(this).attr('data-id');
				$(form_id).submit();
			});

			// annthonite
			function getFilteredTimeLogs(iProfessorID, sDate) {
				var sData = "person_id=" + iProfessorID + "&log_date=" + sDate;
				var sUrl = "<?=base_url()?>ajax/get-filter-time-logs?" + sData;
				logs.destroy();
				logs = $("#table-submitted-reports").DataTable({
					ajax: {
						url: sUrl,
						type: 'GET',
						dataSrc: ''
					},
					responsive:true,
					"order": [[ 0, "desc" ]],
					columns: [
						// person.first_name, person.last_name, course.course_code, sections.section_name, rooms.room_number, logs.time_in, logs.time_out, attendance_name
						{ data: 'first_name'},
						{ data: 'last_name'},
						{ data: 'course_code' },
						{ data: 'section_name' },
						{ data: 'room_number' },
						{ data: 'time_in' },
						{ data: 'time_out'},
						{ data: 'attendance_name' },
						{ data: 'remarks'},
						{ defaultContent: 
							`
							<button class='btn btn-success btn-sm btn-success' id='btnUpdateAttendance'>Edit Attendance</button><br />
							<button class='btn btn-info btn-sm btn-info' id='btnUpdateRemarks'>Edit Remarks</button>
							`
						},
					],
					columnDefs: []
				});
			}

			$(document).on('click', '#btnUpdateAttendance', function() {
				//use this to get id of the logs
				var id = $(this).data('id');

					$('#dynamicModal').modal('show');
			});

			$(document).on('click', '#btnUpdateRemarks', function() {
				//use this to get id of the logs
				var id = $(this).data('id');

					$('#dynamicModal').modal('show');
			});

			// $('.btnEUpdateAttendance').click(function () {
			// 	console.log('Update attendance');
			// 	// $('#dynamicModal').on('show.bs.modal', function (event) {
			// 	// 	var button = $(event.relatedTarget) // Button that triggered the modal
			// 	// 	var recipient = button.data('whatever') // Extract info from data-* attributes
			// 	// 	// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
			// 	// 	// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
			// 	// 	var modal = $(this)
			// 	// 	modal.find('.modal-title').text('New message to ' + recipient)
			// 	// 	modal.find('.modal-body input').val(recipient)
			// 	// })
			// });


			// function modal (sTitle, sBody) {
			// 	`
			// 	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
			// 		${sTitle}
			// 	</button>
			// 	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			// 		<div class="modal-dialog" role="document">
			// 			<div class="modal-content">
			// 			<div class="modal-header">
			// 				<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
			// 				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			// 				<span aria-hidden="true">&times;</span>
			// 				</button>
			// 			</div>
			// 			<div class="modal-body">
			// 				${sBody}
			// 			</div>
			// 			<div class="modal-footer">
			// 				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			// 				<button type="button" class="btn btn-primary">Save changes</button>
			// 			</div>
			// 			</div>
			// 		</div>
			// 	</div>
			// 	`
			// }
	});

	
</script>