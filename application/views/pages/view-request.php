<!-- anntonite -->
<div class="page-body">
	<div class="container">
		<div class="section-title">
			<h3>View Requests</h3>
		</div>
		<div class="section-body">
        <table id="table-submitted-requests" class="table table-hover dt-responsive" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Date</th>
                        <th>Professor</th>
						<th>Time From</th>
						<th>Time To</th>
						<th>Course</th>
						<th>Section</th>
						<th>Room</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Date</th>
                        <th>Professor</th>
						<th>Time From</th>
						<th>Time To</th>
						<th>Course</th>
						<th>Section</th>
						<th>Room</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>

<!-- annthonite -->
<script>
var requests = $("#table-submitted-requests").DataTable({
    ajax : {
        url     : "<?=base_url()?>ajax/get-requests",
        type    : 'GET',
        dataSrc : ''
    },
    responsive : true,
    "order"    : [[ 0, "desc" ]],
    columns    : [
        { data : 'request_date' },
        { data : 'last_name' },
        { data : 'start_time' },
        { data : 'end_time' },
        { data : 'course_code' },
        { data : 'section_name' },
        { data : 'room_number' },
        { data : 'status_name' },
        { data : null }
    ],
    columnDefs : [{
        "targets" : 8,
        "data"    : 'request_id',
        "render"  : function (data, type, row) {
            var html = "";
            html += "<button class='btn btn-info btn-sm' id='approveBtn' requestID='" + row['request_id'] + "'>Approve</button>";
            html += "<button class='btn btn-danger btn-sm' id='rejectBtn' requestID='" + row['request_id'] + "'>Reject</button>";
            return html;
        } 
    }]
});

$(document).on('click', '#approveBtn', function () {
    // Approved = 2
    changeRequestStatus($(this).attr('requestID'), 2);
});

$(document).on('click', '#rejectBtn', function () {
    // Rejected = 3
    changeRequestStatus($(this).attr('requestID'), 3);
});

function changeRequestStatus (requestID, requestStatus) {
    var sUrl = "<?=base_url()?>ajax/update-request-status";
    var oData = {
        'request_id' : requestID,
        'status_id'  : requestStatus
    }

    $.ajax({
        url     : sUrl,
        type    : 'POST',
        data    : oData,
        success : function(mData) {
            alert('Successfully updated');
        },
        error   : function (mData) {
            alert('Error Occured');
        }
    });

    requests.ajax.reload();
}

</script>