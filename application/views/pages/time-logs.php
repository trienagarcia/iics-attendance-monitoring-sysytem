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
						<th>Date</th>
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
						<th>Date</th>
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
	<div class="modal fade" id="dynamicModal" tabindex="-1" role="dialog" aria-labelledby="dynamicModalLabel">
		<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="dynamicModalLabel">
						<!-- Title -->
					</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<!-- Form -->
				</div>
				<div class="modal-footer">
					<!-- button -->
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-info" id="updateLogs">Save</button>
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
		
		// annthonite
		$('#date_picker').datepicker({
			maxDate: '0',
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			onSelect: function(sDate) {
				getFilteredTimeLogs($('#professor').val(), sDate);
			},
		});
		
		$('#home a').removeClass('nav-color');
		$('#home a').addClass('nav-active');
		logs = $("#table-submitted-reports").DataTable({
			ajax: {
				url: "<?=base_url()?>ajax/get-time-logs",
				type: 'GET',
				dataSrc: ''
			},
			responsive:true,
			"order": [[ 0, "desc" ]],
			columns: [
				// logs.attendance_id, person.first_name, person.last_name, course.course_code, sections.section_name, rooms.room_number, logs.time_in, logs.time_out, attendance_name
				{ data: 'log_date', width: '15%' },
				{ data: 'first_name' },
				{ data: 'last_name' },
				{ data: 'course_code' },
				{ data: 'section_name' },
				{ data: 'room_number' },
				{ data: 'time_in' },
				{ data: 'time_out' },
				{ data: 'attendance_name' },
				{ data: 'remarks'},
				{ render: function ( data, type, row, meta ) {
						var sRemarks = row['remarks'] === null ? '' : row['remarks'];
						return `
							<button class='btn btn-success btn-sm btn-success' id='btnUpdateAttendance' attendanceval='` + row['attendance_id'] + `' remarksval='` + sRemarks + `' logsidval='` + row['logs_id'] + `''>Edit Attendance</button>
							<button class='btn btn-info btn-sm btn-info' id='btnUpdateRemarks' remarksval='` + sRemarks + `' logsidval='` + row['logs_id'] + `' style="margin-top:5px">Edit Remarks</button>
						`;
    				}
				}
			]
		});

		setInterval( function () {
			logs.ajax.reload();
		}, 2000 );


		// annthonite
		function getFilteredTimeLogs(iProfessorID, sDate) {
			iProfessorID = iProfessorID !== null ? iProfessorID : "";
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
					// log.attendance_id, person.first_name, person.last_name, course.course_code, sections.section_name, rooms.room_number, logs.time_in, logs.time_out, attendance_name
					{ data: 'log_date', width: '15%' },
					{ data: 'first_name'},
					{ data: 'last_name'},
					{ data: 'course_code' },
					{ data: 'section_name' },
					{ data: 'room_number' },
					{ data: 'time_in' },
					{ data: 'time_out'},
					{ data: 'attendance_name' },
					{ data: 'remarks'},
					{ render: function ( data, type, row, meta ) {
							var sRemarks = row['remarks'] === null ? '' : row['remarks'];
							return `
								<button class='btn btn-success btn-sm btn-success' id='btnUpdateAttendance' attendanceval='` + row['attendance_id'] + `' remarksval='` + sRemarks + `' logsidval='` + row['logs_id'] + `''>Edit Attendance</button>
								<button class='btn btn-info btn-sm btn-info' id='btnUpdateRemarks' remarksval='` + sRemarks + `' logsidval='` + row['logs_id'] + `' style="margin-top:5px">Edit Remarks</button>
							`;
						}
					}
				],
				columnDefs: []
			});
		}

		// annthonite
		$(document).on('click', '#btnUpdateAttendance', function (event) {
			var modal = $('#dynamicModal');
			var sBody = `
			<form id="editAttendanceForm">
				<input name="logsid" id="logsid" value="" hidden />		
				<div class="form-check">
					<input class="form-check-input" type="radio" name="attendance" id="radioPresent" value="1">
					<label class="form-check-label" for="radioPresent">
						Present
					</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="attendance" id="radioAbsent" value="2">
					<label class="form-check-label" for="radioAbsent">
						Absent
					</label>
				</div><br />
				<div class="form-group">
					<label for="textareaRemarks">Remarks</label>
					<textarea class="form-control" id="textareaRemarks" rows="3" maxlength="150" style="resize: none" required></textarea>
					<small id="textareaRemarksCounter" class="text-muted pull-right"></small>
				</div>
			</form>
			`;
			var bPresent = $(this).attr('attendanceval') === `1` ? true : false;
			var bAbsent = $(this).attr('attendanceval') === `2` ? true : false;
			var iLogID = $(this).attr('logsidval');

			modal.find('.modal-title').text('Edit Attendance');
			modal.find('.modal-body').html(sBody);
			modal.modal('show');
			
			$('#radioPresent').attr('checked', bPresent);
			$('#radioAbsent').attr('checked', bAbsent);
			$('#logsid').val(iLogID);
			$('#textareaRemarksCounter').html(($('#textareaRemarks').val()).length + '/150');
		});

		// annthonite
		$(document).on('click', '#btnUpdateRemarks', function (event) {
			var modal = $('#dynamicModal');
			var sBody = `
				<input name="logsid" id="logsid" value="" hidden />		
				<div class="form-group">
					<label for="textareaRemarks">Remarks</label>
					<textarea class="form-control" id="textareaRemarks" rows="3" maxlength="150" style="resize: none"></textarea>
					<small id="textareaRemarksCounter" class="text-muted pull-right"></small>
				</div>
			`;
			var iLogID = $(this).attr('logsidval');

			modal.find('.modal-title').text('Edit Remarks');
			modal.find('.modal-body').html(sBody);
			modal.modal('show');
		
			$('#logsid').val(iLogID);
			$('#textareaRemarksCounter').html(($('#textareaRemarks').val()).length + '/150');
		});

		// annthonite
		$(document).on('keydown keypress keyup', '#textareaRemarks', function () {
			var iCounter = $(this).val().length;
			$('#textareaRemarksCounter').html(iCounter + '/150');
		});

		// annthonite
		$(document).on('click', '#updateLogs', function () {
			if ($('input[name=attendance]').length > 0) {
				var sUrl = '<?=base_url()?>ajax/update-logs';
				var oData = {
					'logs_id'       : $('#logsid').val(),
					'attendance_id' : $('input[name=attendance]:checked').val(),
					'remarks'       : $('#textareaRemarks').val()
				};
			} else {
				var sUrl = '<?=base_url()?>ajax/update-logs-remarks';
				var oData = {
					'logs_id' : $('#logsid').val(),
					'remarks' : $('#textareaRemarks').val()
				};
			}

			var bValidate = validateUpdateLogs(oData);

			if (bValidate === true) {
				// annthonite
				$.ajax({
					url     : sUrl,
					type    : 'POST',
					data    : oData,
					success : function(data) {
						alert('Successfully updated');
					},
					error   : function (data) {
						alert('Error Occured');
					}
				});

				$('#dynamicModal').modal('hide');
			}

			logs.ajax.reload();
		});

		//annthonite
		function validateUpdateLogs (oData) {
			if (oData['remarks'] === "") {
				$('#textareaRemarks').addClass("is-invalid");
				return false;
			}
			$('#textareaRemarks').removeClass('is-invalid');
			return true;
		}
	});

	
</script>