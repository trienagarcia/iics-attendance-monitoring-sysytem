<div class="page-body">
	<div class="container">
		<div class="section-title">
			<h3>Add Make Up Request</h3>
		</div>
		<div class="section-body">
			<div class="row align-items-center pb-3">
<!-- 				<input type="hidden" name="hw_report_id" value=<?php// echo $this->session->flashdata('hw_report_id') ? 
			//	$this->session->flashdata('hw_report_id') : '' ?> /> -->
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
						<th>Action</th>
				</thead>
				<tfoot>
					<tr>
						<!-- <th>Date</th> -->
						<th>Start Time</th>
						<th>End Time</th>
						<th>Room No.</th>
						<th>Action</th>
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
					{ data: 'room' },
					{ data: null }
				],
				columnDefs: [
					{
						"targets": 3,
						"data": 'schedule_id',
						"render": function ( data, type, row ) {
							var html = "";
							html += `<div class='modal fade' id='modalContactForm` + data.schedule_id + `' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
		                        <form method='post' name='reject_form' action='reject-reason'>
		                           <div class='modal-dialog' role='document'>
		                              <div class='modal-content'>
		                                 <div class='modal-header text-center'>
		                                    <h4 class='modal-title w-100 font-weight-bold'>Reject Report Number ` + data.schedule_id + `</h4>
		                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
		                                 </div>
		                                 <div class='modal-body mx-3'>
		                                    <div class='md-form'><i class='fas fa-pencil prefix grey-text'></i><label data-error='wrong' data-success='right' for='form8'>Please specify a reason: </label><br><textarea id='reason_text' name='reason_text' class='md-textarea form-control' rows='4' required='true'></textarea><input type='hidden' name='hw_report_id' id='hw_report_id' value='`+ data.schedule_id +`' /></div>
		                                 	</div>
		                                 <div class='modal-footer d-flex justify-content-center'><input type='submit' class='btn btn-success' value='Submit'/></div>
		                              </div>
		                           </div>
		                        </form>
		                     </div>`;

		                     html +=  `<button class='btn btn-danger btn-sm btn-primary' data-id='` + data.schedule_id + `' data-toggle='modal' data-target='#modalContactForm` + data.schedule_id + `'>Request</button>`;
							return html;
						}
					}
					]

			});

			// Need to fix
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
						{ data: null }
				],
				columnDefs: [
					{
						"targets": 3,
						"data": 'schedule_id',
						"render": function ( data, type, row ) {
							var html = "";
							html += `<div class='modal fade' id='modalContactForm` + data.schedule_id + `' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
		                        <form method='post' name='reject_form' action='reject-reason'>
		                           <div class='modal-dialog' role='document'>
		                              <div class='modal-content'>
		                                 <div class='modal-header text-center'>
		                                    <h4 class='modal-title w-100 font-weight-bold'>Reject Report Number ` + data.schedule_id + `</h4>
		                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
		                                 </div>
		                                 <div class='modal-body mx-3'>
		                                    <div class='md-form'><i class='fas fa-pencil prefix grey-text'></i><label data-error='wrong' data-success='right' for='form8'>Please specify a reason: </label><br><textarea id='reason_text' name='reason_text' class='md-textarea form-control' rows='4' required='true'></textarea><input type='hidden' name='hw_report_id' id='hw_report_id' value='`+ data.schedule_id +`' /></div>
		                                 	</div>
		                                 <div class='modal-footer d-flex justify-content-center'><input type='submit' class='btn btn-success' value='Submit'/></div>
		                              </div>
		                           </div>
		                        </form>
		                     </div>`;

		                     html +=  `<button class='btn btn-danger btn-sm btn-primary' data-id='` + data.schedule_id + `' data-toggle='modal' data-target='#modalContactForm` + data.schedule_id + `'>Request</button>`;
							return html;
						}
					}
					]
				});
			}
</script>