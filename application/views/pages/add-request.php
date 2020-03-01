<div class="page-body">
	<div class="container">
		<div class="section-title">
			<h3>Add Make Up Request</h3>
		</div>
		<div class="section-body">
			<div class="row align-items-center pb-3">
				<input type="hidden" name="hw_report_id" value=<?php echo $this->session->flashdata('hw_report_id') ? 
				$this->session->flashdata('hw_report_id') : '' ?> />
				<!-- annthonite modified -->
				<div class="col col-2 offset-8">
					<div class="label-input">Date</div>
					<input class="form-control" id="inputDate" name="inputDate" readonly>
				</div>
				<div class="col col-2">
					<div class="label-input">Time</div>
					<select class="form-control" id="inputTime" name="inputTime">
						<option value="" selected disabled></option>
						<option value="1">1 hour</option>
						<option value="1.5">1 hour 30 minutes</option>
						<option value="2">2 hours</option>
						<option value="2.5">2 hours 30 minutes</option>
						<option value="3">3 hours</option>
					</select>
				</div>
				<!-- annthonite end modified -->
			</div>
			<!-- Table -->
			<table id="table-schedule" class="table table-hover dt-responsive" cellspacing="0" width="100%">
				<thead>
					<tr>
						<!-- <th>Date</th> -->
						<th>Start Time</th>
						<th>End Time</th>
						<th>Room No.</th>
				</thead>
				<tfoot>
					<tr>
						<!-- <th>Date</th> -->
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
			// annthonite
			$('#inputDate').datepicker({
				minDate: new Date(),
				dateFormat: 'yy-mm-dd',
				changeMonth: true,
				changeYear: true,
				onSelect: function(sDate) {
					getFilteredSchedules(sDate, $('#inputTime').val());
				},
			});

			//annthonite
			$('#inputTime').change(function(){
				getFilteredSchedules($('#inputDate').val(), $(this).val());
			});
			
			//annthonite modified
			schedule = $("#table-schedule").DataTable({
				ajax: {
					url: "<?=base_url()?>ajax/get-schedules",
					type: 'GET',
					dataSrc: ''
				},
				responsive:true,
				"order": [[ 0, "desc" ]],
				columns: [
					// { data: 'date'},
					{ data: 'start_time' },
					{ data: 'end_time' },
					{ data: 'room' }
				]

			});




			function getFilteredSchedules(sch_date, interval) {
				var sData = "sch_date=" + sch_date + "&interval=" + interval;
				var sUrl = "<?=base_url()?>ajax/get-schedules?" + sData;
				schedule.destroy();
				schedule = $("#table-schedule").DataTable({
					ajax: {
						url     : sUrl,
						type    : 'GET',
						dataSrc : ''
					},
					responsive : true,
					"order"    : [[ 0, "desc" ]],
					columns: [
						// { data: 'date'},
						{ data : 'start_time' },
						{ data : 'end_time' },
						{ data : 'room' }
					]
				});
			}
</script>