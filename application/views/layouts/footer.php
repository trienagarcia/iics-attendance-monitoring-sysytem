		<footer class="footer">
			<div class="container text-center">
				<span class="footer-copyright">Copyright &copy; <?= date('Y') ?> UST IICS. All Rights Reserved. <a href="https://www.termsfeed.com/privacy-policy/3f1a524a3bfb1f9413d4d826536b0390" target="_blank">Privacy Policy.</a> </span>
			</div>
		</footer>

<!-- 		<?php// if($this->session->userdata('start_rfid')) { ?> -->
			<script>
			$(document).ready(function(){

 
				function check_incoming_rfid(view = '')
				{
					$.ajax({
						url:"<?=base_url()?>ajax/compare-rfid-counter",
						method:"POST",
						data:{view:view},
						success:function(data)
						{
							// console.log("data: " + data);

							console.log(data);
							var html = "";
							var result = JSON.parse(data);

							if(result.success === true) {
								if(result.message === "existing") {
									console.log("existing rfid: " + result.data);
								}else{
									// $('#rfid-alert').modal('show');

									// console.log(result.name);
									// alert("Name: " + result.name + "\nNumber: " + result.number + "\nDateTime: " + result.time);
									$('#welcome_title').text(result.message);
									$("#rfid_data").text(result.rfid_data);
									$('#first_name').text(result.first_name);
									$('#last_name').text(result.last_name);
									$('#faculty_number').text(result.number);
									$('#sign_datetime').text(result.time);
									$('#rfid-alert').modal('show');

								}
							} else {
								if(result.message === "existing") {
									console.log("existing rfid");
								}else{
									// alert(result.message);
									$('#rfid-does-not-exist').modal('show');
								}
							}
						},
						error:function(req, status, error)
						{
							console.log("req: " + req);
							console.log("status: " + status);
							console.log("error: " + error);
						}
					});
				}

				function check_request_date()
				{
					$.ajax({
						url:"<?=base_url()?>ajax/check-request-date",
						method:"POST",
						success:function(data)
						{
							// console.log(data);
						},
						error:function(req, status, error)
						{
							console.log("req: " + req);
							console.log("status: " + status);
							console.log("error: " + error);
						}
					});
				}

				function check_grace_period_before_absent()
				{
					$.ajax({
						url:"<?=base_url()?>ajax/check-grace-period",
						method:"POST",
						success:function(data)
						{
							// console.log(data);
						},
						error:function(req, status, error)
						{
							console.log("req: " + req);
							console.log("status: " + status);
							console.log("error: " + error);
						}
					});
				}

				check_incoming_rfid();
				check_request_date();
				// check_grace_period_before_absent();


				$(document).on('click', '.dropdown-toggle', function(){
					$('.count').html('');
					check_incoming_rfid('yes');
					check_request_date();
				});

				setInterval(function(){ 
					check_incoming_rfid();
					check_request_date();
				}, 1500);


				setInterval(function(){
					// check_grace_period_before_absent();
				}, 300000)

			});
		</script>


	<div class="modal fade modal-fade-in-scale-up" id="rfid-alert" aria-hidden="true" aria-labelledby="exampleModalTitle"
	 role="dialog" tabindex="-1">
		<div class="modal-dialog modal-simple">
			<div class="modal-content">
				<div class="modal-header bgc-primary">
					<h4 class="modal-title white mt-15"><span id="welcome_title" name="welcome_title"></span></h4>
					<button type="button" class="close white" data-dismiss="modal" aria-label="Close">
			       	 	<span aria-hidden="true">×</span>
			        </button>
				</div>
				<div class="modal-body mt-15">
					<div class="form-group">
						<div class="row">
	                        <div class="col-md-6">
								<div class="label-input">Faculty Number: <b><span id="faculty_number" name="faculty_number"></span></b></div>
	                        </div>
	                    </div>
						<div class="row">
	                        <div class="col-md-12">
								<div class="label-input">Name: <b><span id="first_name" name="first_name"></span>&nbsp;<span id="last_name" name="last_name"></span></b></div>
	                        </div>
	                    </div>
	                    <div class="row">
	                        <div class="col-md-12">
								<div class="label-input">Date and Time: <b><span id="sign_datetime" name="sign_datetime"></span></b></div>
	                        </div>
	                    </div>
					</div>
					<div class="message"></div>
				</div>
				<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade modal-fade-in-scale-up" id="rfid-does-not-exist" aria-hidden="true" aria-labelledby="exampleModalTitle"
	 role="dialog" tabindex="-1">
		<div class="modal-dialog modal-simple">
			<div class="modal-content">
				<div class="modal-header bgc-primary">
					<h4 class="modal-title white mt-15">RFID Does Not Exist</span></h4>
					<button type="button" class="close white" data-dismiss="modal" aria-label="Close">
			       	 	<span aria-hidden="true">×</span>
			        </button>
				</div>
				<div class="modal-body mt-15">
					<div class="message">RFID Not Recognized. Please Sign up for an account.</div>
				</div>
				<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>




	</body>
	</html>