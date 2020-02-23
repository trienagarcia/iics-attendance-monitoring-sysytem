<div class="page-body">
	<div class="container">
		<div class="section-title">
			<h3>Add Make Up Request</h3>
		</div>
		<div class="section-body">
			<!-- Form -->
			
				<div class="row align-items-center pb-3">
					<input type="hidden" name="hw_report_id" value=<?php echo $this->session->flashdata('hw_report_id') ? 
					$this->session->flashdata('hw_report_id') : '' ?> />
					
					<!-- annthonite modified -->
					<div class="col col-md-2 offset-8">
						<div class="label-input">Date</div>
						<input class="form-control" type="date">
					</div>
					<div class="col col-md-2">
						<div class="label-input">Time</div>
						<input class="form-control" type="date">
					</div>
					<!-- annthonite end modified -->

				</div>
			
			<!-- Table -->
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

<!-- SCRIPTS -->
		<script>
			//annthonite modified
			schedule = $("#table-schedule").DataTable({
				ajax: {
					url: "<?=base_url()?>ajax/get-makeup-requests",
					type: 'GET',
					dataSrc: ''
				},
				responsive:true,
				"order": [[ 0, "desc" ]],
				columns: [
					{ data: 'request_date' },
					{ data: 'time_from' },
					{ data: 'time_to' },
					{ data: 'room_number' }
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
		    			//}
						// }
					],
					columnDefs: []
				});
		}
</script>