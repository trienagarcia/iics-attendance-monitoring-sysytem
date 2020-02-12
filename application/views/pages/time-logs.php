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
				<input type="inpute" class="form-control" id="date_picker" name="date_picker">
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
					</tr>
				</tfoot>
			</table>

		</div>
	</div>

	
</div>

<script>
	var logs;
	$(document).ready(function() {
		// annthonite
		$('#date_picker').datepicker({
			maxDate: '0',
			onSelect: function(sDate) {
				getFilteredTimeLogs('', sDate);
			},
		});
		$('#professor').change(function(sProfessor) {
			getFilteredTimeLogs($('#professor').val(), '');
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
				{ data: 'remarks'}
				],
				columnDefs: [
					]
		});

			setInterval( function () {
				logs.ajax.reload();
			}, 2000 );

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

	});

	// annthonite
	function getFilteredTimeLogs(sProfessor, sTime) {
		$.ajax({
				  	url: "<?=base_url()?>ajax/get-filter-time-logs",
				  	type: "POST",
				  	data: {sProfessor: sProfessor, sTime: sTime},
				  	success: function(data) {
				  		
				  	}
				  });
		// $("#table-submitted-reports").DataTable({
		// 		ajax: {
		// 			url: "<?=base_url()?>ajax/get-filter-time-logs",
		// 			data: {sProfessor: sProfessor, sTime: sTime},
		// 			type: 'POST',
		// 			dataSrc: ''
		// 		},
		// 		responsive:true,
		// 		"order": [[ 0, "desc" ]],
		// 		columns: [
		// 		{ data: 'date' },
		// 		{ data: 'name'},
		// 		{ data: 'time_in' },
		// 		{ data: 'time_out'},
		// 		],
		// 		columnDefs: [
		// 			]
		// });
	}
</script>