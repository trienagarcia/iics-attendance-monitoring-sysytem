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
					<table id="table-compiled-reports" class="table table-hover dt-responsive" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th rowspan="2">HW Number</th>
								<th rowspan="2">HW Class</th>
								<th rowspan="2">HW Catalouging</th>
								<th rowspan="2">HW Nature</th>
								<th colspan="2">Remaining Quantity</th>
								<th colspan="2">Quantity in Kg</th>
							</tr>
							<tr>
								<th>Quantity</th>
								<th>Unit</th>
								<th>Quantity</th>
								<th>Unit</th>
							</tr>
						</thead>
					</table>

				</div>
			</div>
		</div>



		<script>
			var reports;
			var year;
			var quarter;
			$(document).ready(function() {
				year = $('#year').val();
				quarter  = $('#quarter').val();
				$('#compiled-reports a').removeClass('nav-color');
				$('#compiled-reports a').addClass('nav-active');

				GetCompiledReports();
				$(document).on('change', '#year', function() {
					year = $(this).val();
					reports.destroy();
					GetCompiledReports();
				});

				$(document).on('change', '#quarter', function() {
					quarter = $(this).val();
					reports.destroy();
					GetCompiledReports();
				});

				$(document).on('click', '#btn-export', function() {
					window.open('<?=base_url()?>compiled-reports/export/'+year+'/'+quarter, '_blank');
				});
			});

			function GetCompiledReports() {
		// reports = $("#table-compiled-reports").DataTable({
		// 		ajax: {
		// 			url: "<?=base_url()?>ajax/get-user-compiled-reports",
		// 			type: 'POST',
		// 			data: {
		// 				year: year,
		// 				quarter: quarter
		// 			},
		// 			dataSrc: ""
		// 		},
		// 		responsive:true,
		// 		"order": [[ 4, "desc" ]],
		// 		columns: [
		// 		{ data: 'hw_number' },
		// 		{ data: 'hw_class'},
		// 		{ data: 'hw_catalogue' },
		// 		{ data: 'hw_nature'},
		// 		{ data: 'remain_waste'},
		// 		{ data: null,
		// 			render: function (data) {
		// 					return "kg";
		// 				} 
		// 		},
		// 		{ data: 'report_quantity'},
		// 		{ data: null,
		// 			render: function (data) {
		// 					return "kg";
		// 				} 
		// 		},
		// 		]
		// });
	}
</script>