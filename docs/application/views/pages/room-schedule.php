<div class="page-body">
	<div class="container">
		<div class="section-title">
			<h3>Add New Room Schedule</h3>
		</div>
		<div class="section-bod">
			<?php 
				if($this->session->flashdata('errors')): 
					echo "<font color='red'>" . $this->session->flashdata('errors') . "</font>";
				endif;

				if($this->session->flashdata('server_errors')):
					echo "<font color='red'>" . $this->session->flashdata('server_errors') . "</font>";
				endif;

				if($this->session->flashdata('college')):

				endif;
			?>
			<form id="form-addadmin" method="post" action="insert">
				<div class="form-group">
					<input type="hidden" name="hw_report_id" value=<?php echo $this->session->flashdata('hw_report_id') ? 
									$this->session->flashdata('hw_report_id') : '' ?> />
                	<div class="row">
						<div class="col-md-4">
							<div class="label-input">Room Number <span class="required">*</span></div>
							<select class="form-control required-input" name="room" id="room" data-parsley-required="true">
		                    	
		                	</select>
						</div>
					</div>
				</div>
				
			<hr>
			<div class="chem-table-fields">
			<div class="form-group chem-fields"> 
			<div class="form-group"> 
			</div>

			<div class="row">
				<div class="col-md-9" >
				</div>
				<div class="col-md-3">
					<button type="button" class='btn btn-primary confirm-submit-btn'>Submit</button>
				</div>
			</div>

			</form>
		</div>
	</div>
</div>

<script>
	var chem_field = 1;
	$(document).ready(function() {
		$('#make-report a').removeClass('nav-color');
		$('#make-report a').addClass('nav-active');
		

		

	});
</script>