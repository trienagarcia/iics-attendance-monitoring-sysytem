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
<div class="modal fade" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="requestModalLabel">
            <!-- Modal Title -->
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Modal Body -->
      </div>
      <div class="modal-footer">
        <!-- Modal Footer -->
        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-info">Yes</button> -->
      </div>
    </div>
  </div>
</div>



<!-- annthonite -->
<script>

$('#requests a').removeClass('nav-color');
$('#requests a').addClass('nav-active');

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
            html += row['status_id'] == 1 ? "<button class='btn btn-info btn-sm' id='approveBtn' requestID='" + row['request_id'] + "'>Approve</button>" : "";
            html += row['status_id'] == 1 ? "<button class='btn btn-danger btn-sm' id='rejectBtn' requestID='" + row['request_id'] + "'>Reject</button>" : "";
            return html;
        } 
    }]
});

$(document).on('click', '#approveBtn', function () {
    // Approved = 2
    var oModal = $('#requestModal');
    var sTitle = `Confirmation`;
    var sBody = `<p>Are you sure you want to approve?</p>`;
    var sFooter = `
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-info" id="updateRequestBtn" requestID="` + $(this).attr('requestID') + `" requestStatus="2">Yes</button>
    `;

    oModal.find('.modal-title').text(sTitle);
    oModal.find('.modal-body').html(sBody);
    oModal.find('.modal-footer').html(sFooter);
    oModal.modal('show');
});

$(document).on('click', '#rejectBtn', function () {
    // Rejected = 3
    var oModal = $('#requestModal');
    var sTitle = `Confirmation`;
    var sBody = `<p>Are you sure you want to approve?</p>`;
    var sFooter = `
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-info" id="updateRequestBtn" requestID="` + $(this).attr('requestID') + `" requestStatus="3">Yes</button>
    `;

    oModal.find('.modal-title').text(sTitle);
    oModal.find('.modal-body').html(sBody);
    oModal.find('.modal-footer').html(sFooter);
    oModal.modal('show');
});

$(document).on('click', '#updateRequestBtn', function () {
    var sUrl = "<?=base_url()?>ajax/update-request-status";
    var oData = {
        'request_id' : $(this).attr('requestID'),
        'status_id'  : $(this).attr('requestStatus')
    }

    $.ajax({
        url     : sUrl,
        type    : 'POST',
        data    : oData,
        success : function(mData) {
            $('#requestModal').modal('hide');
        },
        error   : function (mData) {
            $('#requestModal').modal('hide');
            alert('Error occured!');
        }
    });

    requests.ajax.reload();
});
</script>