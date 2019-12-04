<div class="page-body" >
	<div class="container">
		<div class="section-title">
			<h3>My Time Logs</h3>
		</div>
		<div class="section-body body-part" >
			<table id="table-submitted-reports" class="table table-hover dt-responsive" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Date</th>
						<th>Person Name</th>
						<th>Time In</th>
						<th>Time Out</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Date</th>
						<th>Person Name</th>
						<th>Time In</th>
						<th>Time Out</th>
					</tr>
				</tfoot>
			</table>

		</div>
	</div>

	
</div>

<script>
	var reports
	$(document).ready(function() {
		$('#submitted-reports a').removeClass('nav-color');
		$('#submitted-reports a').addClass('nav-active');
			reports = $("#table-submitted-reports").DataTable({
				ajax: {
					url: "<?=base_url()?>ajax/get-user-time-logs",
					type: 'GET',
					dataSrc: ''
				},
				responsive:true,
				"order": [[ 0, "desc" ]],
				columns: [
				{ data: 'date' },
				{ data: 'name'},
				{ data: 'time_in' },
				{ data: 'time_out'},
				],
				columnDefs: [
					]
		});

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
</script>