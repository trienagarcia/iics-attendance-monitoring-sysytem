<div class="page-body">
	<div class="container">
		<div class="section-title">
			<h3>Change Password</h3>
			<div class="section-content">
				<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-6 alert alert-success" role="alert">
						<div class="alert-content">
							<form>
								<div class="form-group">
									<div class="row">
										<div class="col-md-5">
											<label>Old Password:</label>
										</div>
										<div class="col-md-7">
											<input type="password" class="form-control required-input password" id="current-password" name="current_password">
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-md-5">
											<label>New Password:</label>
										</div>
										<div class="col-md-7">
											<input type="password" class="form-control required-input password" id="new-password" name="username">
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-md-5">
											<label>Confirm Password:</label>
										</div>
										<div class="col-md-7">
											<input type="password" class="form-control required-input password" id="confirm-new-password" name="confirm_new_password">
											
											<button type="button" class="btn btn-primary mt-5 btn-update-password">Update</button>
										</div>
									</div>
								</div>
								<div class="alert alert-danger d-none error-message text-center"></div>
							</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	  $(document).on('click', '.btn-update-password', function(){
	  	$('.error-message').removeClass('d-block').addClass('d-none').html("");
  		if(validate.standard('.required-input') == 0){
	    	var current_password = $('#current-password').val();
	    	var new_password = $('#new-password').val();
	    	var confirm_new_password = $('#confirm-new-password').val();
	    	$.ajax({
	    		url: "<?=base_url()?>ajax/update-password",
	    		type: "POST",
	    		data: { current_password:current_password,
	    				new_password:new_password,
	    				confirm_new_password: confirm_new_password
	    			},
	    		success: function(data) {
			    		var result = JSON.parse(data);
			    		$('input[type=password]').val('');
			    		$('.error-message').removeClass('d-none').addClass('d-block').html(result.message);
				}
	    	});
    	}
    });

</script>