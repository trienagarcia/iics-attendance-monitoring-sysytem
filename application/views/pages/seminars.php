<div class="page-body">
	<div class="container">
		<div class="section-title">
			<div class="row" style="margin-top: 1em;" >
				<div class="col-md-2">
					<button type="button" id="btn-back" class="btn btn-primary btn-back mb-3">Back</button>
				</div>
			</div>
			<h3>Seminars</h3>
			<div class="section-content">
				<?php 
					foreach($result as $row) { ?>
				<div class="alert alert-success" role="alert">
					<div class="alert-content">
						<h5>
						<?php
							 if (!empty($row->title)) {
							 	echo $row->title;
							 }
						 ?>
						 </h5>
						<span>
							<?php
							 if (!empty($row->created_at)) {
							 	echo $row->created_at;
							 }
						 	?>

						</span>
						<p>
							<?php
							 if (!empty($row->description)) {
							 	echo $row->description;
							 }
						 	?>	
						</p>						
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).on('click', '.btn-back', function() {
		window.history.go(-1);
	});
</script>