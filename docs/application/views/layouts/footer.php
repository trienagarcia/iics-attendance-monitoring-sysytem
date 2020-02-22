		<footer class="footer">
			<div class="container text-center">
				<span class="footer-copyright">Copyright &copy; <?= date('Y') ?> UST IICS. All Rights Reserved.</span>
			</div>
		</footer>

		<?php if($this->session->userdata('start_rfid')) { ?>
			<script>
			$(document).ready(function(){

 
				function check_incoming_rfid(view = '')
				{
					$.ajax({
						url:"<?=base_url()?>ajax/check-incoming-rfid",
						method:"POST",
						data:{view:view},
						success:function(data)
						{
							// console.log("data: " + data);

							// console.log(data);

							var result = JSON.parse(data);

							if(result.success === true) {
								if(result.message === "existing") {
									console.log("existing rfid: " + result.data);
								}else{
									alert("Name: " + result.name + "\nNumber: " + result.number + "\nDateTime: " + result.time);
								}
							} else {
								if(result.message === "existing") {
									console.log("existing rfid");
								}else{
									alert(result.message);
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

				check_incoming_rfid();


				$(document).on('click', '.dropdown-toggle', function(){
					$('.count').html('');
					check_incoming_rfid('yes');
				});

				// setInterval(function(){ 
				// 	check_incoming_rfid();
				// }, 1500);

			});
		</script>

	<?php } $this->session->set_userdata('start_rfid', 'yes'); ?>

	</body>
	</html>