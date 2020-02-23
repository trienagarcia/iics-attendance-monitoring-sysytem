<div class="page-body">
	<div class="container">
		<div class="section-title">
			<h3>Add Make Up Request</h3>
		</div>
		<div class="section-body">
			<form id="form-addadmin" method="post" action="insert">
				<form id="form-add-waste-report" method="post">
					<div class="form-group">
						<input type="hidden" name="hw_report_id" value=<?php echo $this->session->flashdata('hw_report_id') ? 
						$this->session->flashdata('hw_report_id') : '' ?> />
						<div class="row">
							<div class="col-md-6">
								<div class="label-input">College <span class="required">*</span></div>
								<select class="form-control required-input" name="college" id="college" data-parsley-required="true">

								</select>
							</div>
							<div class="col-md-6" style="margin-bottom: 1em;">
								<div class="label-input">Department <span class="required">*</span></div>
								<select class="form-control required-input" name="department" id="department" data-parsley-required="true">
									<option value="">Select Department</option>

								</select>
							</div>
						</div>

						<div class="row">
							<div class="col-md-9" >
							</div>
							<div class="col-md-3">
								<button type="button" class='btn btn-primary confirm-submit-btn'>Search</button>
							</div>
						</div>
					</div>
					<table id="table-schedule" class="table table-hover dt-responsive" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Date</th>
						<th>Start Time</th>
						<th>End Time</th>
						<th>Room No.</th>
				</thead>
				<tfoot>
					<tr>
						<th>Date</th>
						<th>Start Time</th>
						<th>End Time</th>
						<th>Room No.</th>
					</tr>
				</tfoot>
			</table>

				</div>
			</div>
		</div>



		<script>
			schedule = $("#table-schedule").DataTable({
			ajax: {
				url: "<?=base_url()?>ajax/get-schedules",
				type: 'GET',
				dataSrc: ''
			},
			responsive:true,
			"order": [[ 0, "desc" ]],
			columns: [
				{ data: 'date' },
				{ data: 'start_time' },
				{ data: 'end_time' },
				{ data: 'room_number' }
				// ,
				// { render: function ( data, type, row, meta ) {
				// 		// var sRemarks = row['remarks'] === null ? '' : row['remarks'];
				// 		// return `
				// 		// 	<button class='btn btn-success btn-sm btn-success' id='btnUpdateAttendance' attendanceval='` + row['attendance_id'] + `' remarksval='` + sRemarks + `' logsidval='` + row['logs_id'] + `''>Edit Attendance</button>
				// 		// 	<button class='btn btn-info btn-sm btn-info' id='btnUpdateRemarks' remarksval='` + sRemarks + `' logsidval='` + row['logs_id'] + `' style="margin-top:5px">Edit Remarks</button>
				// 		// `;
    // 				}
				// }
			]
		});

			function getFilteredSchedules(sch_date, interval) {
				var sData = "sch_date=" + sch_date + "&interval=" + interval;
				var sUrl = "<?=base_url()?>ajax/get-schedules?" + sData;
				schedule.destroy();
				schedule = $("#table-submitted-reports").DataTable({
					ajax: {
						url: sUrl,
						type: 'GET',
						dataSrc: ''
					},
					responsive:true,
					"order": [[ 0, "desc" ]],
					columns: [
						{ data: 'date' },
						{ data: 'start_time' },
						{ data: 'end_time' },
						{ data: 'room_number' }
						// ,
						// { render: function ( data, type, row, meta ) {
						// 		// var sRemarks = row['remarks'] === null ? '' : row['remarks'];
						// 		// return `
						// 		// 	<button class='btn btn-success btn-sm btn-success' id='btnUpdateAttendance' attendanceval='` + row['attendance_id'] + `' remarksval='` + sRemarks + `' logsidval='` + row['logs_id'] + `''>Edit Attendance</button>
						// 		// 	<button class='btn btn-info btn-sm btn-info' id='btnUpdateRemarks' remarksval='` + sRemarks + `' logsidval='` + row['logs_id'] + `' style="margin-top:5px">Edit Remarks</button>
						// 		// `;
		    // 				}
						// }
					],
					columnDefs: []
				});
		}
</script>