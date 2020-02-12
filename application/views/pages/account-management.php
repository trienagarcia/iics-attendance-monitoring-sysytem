<div class="page-body">
	<div class="container">
		<div class="section-title">
			<h3>Manage Accounts</h3>
		</div>
		<div class="section-body">
			<button type="button" class="btn btn-primary mb-3" id="btn-add-account">Add Faculty Account</button>
			<table id="users" class="table table-hover dt-responsive" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="hidden">Person ID</th>
						<th>Email</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Faculty Number</th>
						<th>RFID</th>
						<th>Date Created</th>
						<th>Date Modified</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th class="hidden">Person ID</th>
						<th>Email</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Faculty Number</th>
						<th>RFID</th>
						<th>Date Created</th>
						<th>Date Modified</th>
						<th>Actions</th>
					</tr>
				</tfoot>
			</table>

		</div>
	</div>
</div>

<!-- Add Account Modal -->
	<div class="modal fade modal-fade-in-scale-up" id="add-account-modal" aria-hidden="true" aria-labelledby="exampleModalTitle"
	 role="dialog" tabindex="-1">
		<div class="modal-dialog modal-simple">
			<div class="modal-content">
				<div class="modal-header bgc-primary">
					<h4 class="modal-title white mt-15">Add New Account</h4>
					<button type="button" class="close white" data-dismiss="modal" aria-label="Close">
			       	 	<span aria-hidden="true">×</span>
			        </button>
				</div>
				<div class="modal-body mt-15">
					<form id="form-addadmin" method="post">
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<div class="label-input">Email <span class="required">*</span></div>
									<input type="email" class="form-control form-input" id="email" name="email">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<div class="label-input">Faculty Name <span class="required">*</span></div>
									<input type="text" class="form-control form-input" id="name" name="name">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<div class="label-input">Faculty Number</div>
									<input type="text" class="form-control form-input" id="faculty_number" name="faculty_number">
								</div>
								<div class="col-md-6">
									<div class="label-input">Password <span class="required">*</span></div>
									<input type="text" class="form-control form-input" id="pword" name="pword" readonly>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
		                        <div class="col-md-6">
									<div class="label-input">RFID <span class="required">*</span></div>
									<select class="form-control required-input" name="rfid" id="rfid" 
												data-parsley-required="true" >
		                            	<option value="" selected="selected">Select RFID</option>
		                        	</select>
		                        </div>
		                    </div>
						</div>
					</form>
					<div class="message"></div>
				</div>
				<div class="modal-footer">
						<button type="button" class="btn btn-dark" data-dismiss="modal">Cancel</button>
						<button type="button" id="btn-confirm-add-account" class="btn btn-primary">Confirm</button>
				</div>
			</div>
		</div>
	</div>
	<!-- End Add Account Modal -->

<script>
	var users;
	$(document).ready(function() {
		$('#account-management a').removeClass('nav-color');
		$('#account-management a').addClass('nav-active');
			users = $("#users").DataTable({
				ajax: {
					url: "<?=base_url()?>ajax/get-all-users",
					dataSrc: ''
				},
				responsive:true,
				"order": [[ 5, "desc" ]],
				columns: [
				{ data: 'person_id'},
				{ data: 'email' },
				{ data: 'first_name' },
				{ data: 'last_name' },
				{ data: 'person_number'},
				{ data: 'rfid_data'},
				{ data: 'created_at'},
				{ data: 'updated_at' },
				{ defaultContent: "<button class='btn btn-danger btn-sm btn-delete'>Delete</button>"}
				],
				columnDefs: [
				{ className: "hidden", "targets": [0]},
				{ className: "acct-name", "targets": [1]},
				]
		});


		$('.multi-select-dd').fSelect({
	      placeholder: 'Select some options',
	      numDisplayed: 5,
	      overflowText: '{n} selected',
	      noResultsText: 'No results found',
	      searchText: 'Search',
	      showSearch: true
	    });

		// $.ajax({
		// 	url: "<?=base_url()?>ajax/get-courses",
		// 	type: 'POST',
		// 	success: function (data) {
		// 		var courses = $('#courses');
		// 		$.each(JSON.parse(data), function (val, text) {
		// 			courses.append($('<option></option>').attr("value", val)
		// 				.text(text.course_code));
		// 			})
		// 		}
		//  });

		$.ajax({
			url: "<?=base_url()?>ajax/get-rfid",
			type: 'POST',
			success: function (data) {
				var rfid = $('#rfid');
				$.each(JSON.parse(data), function (val, text) {
					rfid.append($('<option></option>').attr("value", val)
						.text(text.rfid_data));
					})
				}
		 });


		$(document).on('click', '#btn-add-account', function() {
			$('#add-account-modal').modal('show');
			$("#email").val('');
			$("#faculty_number").val('');
			$("#name").val('');
			$("#rfid").val('');
			$("#courses").val('');
			$.ajax({
                url: '<?=base_url()?>ajax/get-new-password',
                type: 'GET',
                success:function(data) {
                	var result = JSON.parse(data);
                	$('#pword').val(result.password);
                }
            });
		});

		$(document).on('click', '#btn-confirm-add-account', function() {

			$.ajax({
                url: '<?=base_url()?>ajax/add-new-account',
                type: 'POST',
                data: {
                	email: $('#email').val(),
                	name : $('#name').val(),
                	password: $('#pword').val(),
                	faculty_number : $('#faculty_number').val(),
                	course: $('#courses').val(),
                	rfid:  $('#rfid').val()
                },
                success:function(data) {
                	console.log($('#courses').val());
                	$('#add-account-modal').modal('hide');
                	alert("Account Successfully Added!");
                	users.ajax.reload();
                }
            });
		});

		$(document).on('click', '.btn-delete', function() {
			var id = $(this).closest('tr').find('td').eq(0).text();
			$.ajax({
                url: '<?=base_url()?>ajax/delete-account',
                type: 'POST',
                data: {
                	id: id,
                },
                success:function(data) {
                	$('#add-account-modal').modal('hide');
                	alert("Account Successfully Deleted!");
                	users.ajax.reload();
                }
            });
		});

	});
</script>