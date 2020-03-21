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
						<option value="1" selected>1 hour</option>
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
					url: "<?=base_url()?>ajax/get-schedules?interval=1",
					type: 'GET',
					dataSrc: ''
				},
				responsive:true,
				"order": [[ 2, "asc" ]],
				columns: [
					// { data: 'date'},
					{ data: 'start_time' },
					{ data: 'end_time' },
					{ data: 'room_number' },
					{ data: null }
				],
				columnDefs: [
					{
						"targets": 3,
						"data": 'schedule_id',
						"render": function ( data, type, row ) {
							var html = "";
							html += `<div class='modal fade' id='modalContactForm` + data.schedule_id + `' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
		                        <form method='post' name='reject_form' action='submit-request'>
		                           <div class='modal-dialog' role='document'>
		                              <div class='modal-content'>
		                                 <div class='modal-header text-center'>
		                                    <h4 class='modal-title w-100 font-weight-bold'>Request this Schedule</h4>
		                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
		                                 </div>
		                                 <div class='modal-body mx-3'>
		                                 <div class="label-input">Please fill in the following: </div>
		                                    <div class="form-group">
												<div class="row">
													<div class="col-md-6">
														<div class="label-input">Date <span class="required">*</span></div>
															<input type="text" class="form-control form-input" id="date`+data.schedule_id+`" name="date" value='`+ data.date +`' readonly>
													</div>
													<div class="col-md-6">
														<div class="label-input">Room <span class="required">*</span></div>
															<input type="text" class="form-control form-input" id="room`+data.schedule_id+`" name="room" value='`+ data.room_number +`' readonly>
															<input type="hidden" name="room_id" id="room_id_`+data.schedule_id+`" 
																value="`+data.room_id+`" />
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="row">
													<div class="col-md-6">
														<div class="label-input">Start Time<span class="required">*</span></div>
														<input type="text" class="form-control form-input" id="start_time`+data.schedule_id+`" name="start_time" value='`+data.start_time+`' readonly>
													</div>
													<div class="col-md-6">
														<div class="label-input">End Time<span class="required">*</span></div>
														<input type="text" class="form-control form-input" id="end_time`+data.schedule_id+`" name="end_time" value='`+data.end_time+`' readonly>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="row">
							                        <div class="col-md-6">
														<div class="label-input">Course<span class="required">*</span></div>
														<select class="form-control required-input" name="course" id="course`+ data.schedule_id +`" 
																	data-parsley-required="true" >
							                            	<option value="" selected="selected">Select Course</option>
							                        	</select>
							                        </div>
							                        <div class="col-md-6">
														<div class="label-input">Section<span class="required">*</span></div>
														<select class="form-control required-input" name="section" id="section`+ data.schedule_id +`" 
																	data-parsley-required="true" >
							                            	<option value="" selected="selected">Select Section</option>
							                        	</select>
							                        </div>
							                    </div>
											</div>
										</div>
		                                 <div class='modal-footer d-flex justify-content-center'><input type='submit' class='btn btn-success' value='Submit'/></div>
		                              </div>
		                           </div>
		                        </form>
		                     </div>`;

		                     html +=  `<button class='btn btn-danger btn-sm btn-primary' data-id='` + data.schedule_id + `' data-toggle='modal' data-target='#modalContactForm` + data.schedule_id + `'>Request</button>`;

		                     addCourses( data.schedule_id );
		                     addSections( data.schedule_id );

							return html;
						}
					}
					]

			});


			function addCourses( schedule_id ) {
				$.ajax({
				url: "<?=base_url()?>ajax/get-courses",
				type: 'POST',
				// async: false,
				success: function (data) {
					var courseId = 'course' + schedule_id;
					var course = $('#' + courseId);
					course.empty();
					// console.log(courseId);
					$.each(JSON.parse(data), function (val, text) {
						// console.log('val: ' + val + ' schedule_id: ' + schedule_id);
						course.append($('<option></option>').attr("value", (val+1))
							.text(text.course_code + ' : ' + text.course_name));
						})
					}
			 	});
			}


			function addSections( schedule_id ) {
				$.ajax({
				url: "<?=base_url()?>ajax/get-sections",
				type: 'POST',
				success: function (data) {
					var sectionId = 'section' + schedule_id;
					var section = $('#' + sectionId);
					section.empty();
					$.each(JSON.parse(data), function (val, text) {
						section.append($('<option></option>').attr("value", (val+1))
							.text(text.section_name));
						})
					}
			 	});
			}

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
					"order": [[ 2, "asc" ]],
					columns: [
						// { data: 'date'},
						{ data : 'start_time' },
						{ data : 'end_time' },
						{ data: 'room_number' },
						{ data: null }
				],
				columnDefs: [
					{
						"targets": 3,
						"data": 'schedule_id',
						"render": function ( data, type, row ) {
							var html = "";
							html += `<div class='modal fade' id='modalContactForm` + data.schedule_id + `' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
		                        <form method='post' name='reject_form' action='submit-request'>
		                           <div class='modal-dialog' role='document'>
		                              <div class='modal-content'>
		                                 <div class='modal-header text-center'>
		                                    <h4 class='modal-title w-100 font-weight-bold'>Request this Schedule</h4>
		                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
		                                 </div>
		                                 <div class='modal-body mx-3'>
		                                 <div class="label-input">Please fill in the following: </div>
		                                    <div class="form-group">
												<div class="row">
													<div class="col-md-6">
														<div class="label-input">Date <span class="required">*</span></div>
															<input type="text" class="form-control form-input" id="date`+data.schedule_id+`" name="date" value='`+ data.date +`' readonly>
													</div>
													<div class="col-md-6">
														<div class="label-input">Room <span class="required">*</span></div>
															<input type="text" class="form-control form-input" id="room`+data.schedule_id+`" name="room" value='`+ data.room_number +`' readonly>
															<input type="hidden" name="room_id" id="room_id_`+data.schedule_id+`" 
																value="`+data.room_id+`" />
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="row">
													<div class="col-md-6">
														<div class="label-input">Start Time<span class="required">*</span></div>
														<input type="text" class="form-control form-input" id="start_time`+data.schedule_id+`" name="start_time" value='`+data.start_time+`' readonly>
													</div>
													<div class="col-md-6">
														<div class="label-input">End Time<span class="required">*</span></div>
														<input type="text" class="form-control form-input" id="end_time`+data.schedule_id+`" name="end_time" value='`+data.end_time+`' readonly>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="row">
							                        <div class="col-md-6">
														<div class="label-input">Course<span class="required">*</span></div>
														<select class="form-control required-input" name="course" id="course`+ data.schedule_id +`" 
																	data-parsley-required="true" >
							                            	<option value="" selected="selected">Select Course</option>
							                        	</select>
							                        </div>
							                        <div class="col-md-6">
														<div class="label-input">Section<span class="required">*</span></div>
														<select class="form-control required-input" name="section" id="section`+ data.schedule_id +`" 
																	data-parsley-required="true" >
							                            	<option value="" selected="selected">Select Section</option>
							                        	</select>
							                        </div>
							                    </div>
											</div>
										</div>
		                                 <div class='modal-footer d-flex justify-content-center'><input type='submit' class='btn btn-success' value='Submit'/></div>
		                              </div>
		                           </div>
		                        </form>
		                     </div>`;

		                     html +=  `<button class='btn btn-danger btn-sm btn-primary' data-id='` + data.schedule_id + `' data-toggle='modal' data-target='#modalContactForm` + data.schedule_id + `'>Request</button>`;

		                    addCourses( data.schedule_id );
		                    addSections( data.schedule_id );
							return html;
						}
					}
					]
				});
			}

			// jansen 03-15-2020
			// $.ajax({
			// url: "<?=base_url()?>ajax/get-courses",
			// type: 'POST',
			// success: function (data) {
			// 	var course = $('#course');
			// 	$.each(JSON.parse(data), function (val, text) {
			// 		course.append($('<option></option>').attr("value", val)
			// 			.text(text.course_code + ' : ' + text.course_name));
			// 		})
			// 	}
		 // 	});

		 // 	$.ajax({
			// url: "<?=base_url()?>ajax/get-sections",
			// type: 'POST',
			// success: function (data) {
			// 	var section = $('#section');
			// 	$.each(JSON.parse(data), function (val, text) {
			// 		section.append($('<option></option>').attr("value", val)
			// 			.text(text.section_name));
			// 		})
			// 	}
		 // 	});
		 	// jansen 03-15-2020
</script>