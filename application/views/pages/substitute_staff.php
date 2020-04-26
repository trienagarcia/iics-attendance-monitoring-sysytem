<div class="page-body" >
	<div class="container">
		<div class="section-title">
			<h3>View Schedule</h3>
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
						<th>Start Time</th>
						<th>End Time</th>
						<th>Scheduled Date</th>
				</thead>
				<tfoot>
					<tr>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Course</th>
						<th>Section</th>
						<th>Room No.</th>
						<th>Start Time</th>
						<th>End Time</th>
						<th>Scheduled Date</th>
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
					<h6 class="modal-title" id="dynamicModalLabel">
						<!-- Title -->
					</h6>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<!-- Form -->
				</div>
				<div class="modal-footer">
					<!-- button -->
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-info" id="saveSubstituteBtn">Save</button>
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
			getFilteredTimeLogs($('#professor').val());
		});
		
		$('#submitted-reports a').removeClass('nav-color');
		$('#submitted-reports a').addClass('nav-active');

		logs = $("#table-submitted-reports").DataTable({
			ajax: {
				url: "<?=base_url()?>ajax/get-all-schedule",
				type: 'GET',
				dataSrc: ''
			},
			responsive:true,
			"order": [[ 0, "desc" ]],
			columns: [
				// logs.attendance_id, person.first_name, person.last_name, course.course_code, sections.section_name, rooms.room_number, logs.time_in, logs.time_out, attendance_name
				{ data: 'first_name' },
				{ data: 'last_name' },
				{ data: 'course_code' },
				{ data: 'section_name' },
				{ data: 'room_number' },
				{ data: 'start_time' },
				{ data: 'end_time' },
				{ data: 'request_date' },
			]
		});

		// setInterval( function () {
		// 	logs.ajax.reload();
		// }, 2000 );

		// annthonite
		function getFilteredTimeLogs(iProfessorID) {
			var sData = "person_id=" + iProfessorID;
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
					{ data: 'first_name' },
					{ data: 'last_name' },
					{ data: 'course_code' },
					{ data: 'section_name' },
					{ data: 'room_number' },
					{ data: 'start_time' },
					{ data: 'end_time' },
					{ data: 'request_date' },
					{ render: function ( data, type, row, meta ) {
							var sRemarks = row['remarks'] === null ? '' : row['remarks'];
							return `
								<button class='btn btn-info btn-sm btn-info' id='btnUpdateSubstitute' scheduleID='` + row['schedule_id'] + `' personID='` + row['person_id'] + `' style="margin-top:5px">Substitute</button>
							`;
						}
					}
				],
				columnDefs: []
			});
		}
	});

	
</script>