var base_url = "<?=base_url()?>";
var form_empty_error = "This field is required.";	
var form_script = "PHP and Javascripts are not allowed.";
var form_nohtml = "HTML Tags are not allowed.";
var form_invalid_password = "Password should have mininimum of 6 characters.";
//validation
var validate = {
	standard: function(element){
		var counter = 0;
		$(this).css('border-color','#b8b8b8');
		$(".validate_error_message").remove();
		var error_message = "<span class='validate_error_message'>"+form_empty_error+"<br></span>";
	    $(element).each(function(){
	    	var type = $(this).attr("type");
	    	var data_type = $(this).attr("data-type");
				if (type != "ckeditor") {
						if ($(this).val() != null) {
							var input = $(this).val().trim();
									if (input.length == 0) {
										$(this).addClass('err_inputs');
										if (type == "text" || type == "textarea" || type == "dropdown" || type == "email"  || type == "date" ) {
											$(error_message).insertAfter(this);
										} else if (data_type == "parent") { 
											$(error_message).insertAfter($(this).parent()); //this
										} else {
											$(error_message).insertAfter($(this).parent()); //this
										}
										counter++;
									} else {
											$(this).css('border-color','#b8b8b8');
											$(this).removeClass('err_inputs');
											$(this).next(".validate_error_message").remove();
									}
						} else {
							$(this).addClass('err_inputs');
							if (data_type == "parent") { 
								$(error_message).insertAfter($(this).parent()); //this
							} else {
								$(error_message).insertAfter(this);
							}
							counter++;
						}
					}
		});

		$(".password").each(function(){
			if ($(this).val() != "") {
				var err_pass = 0;
				var password = $(this).val();
				if (password.length<6) {
					err_pass++;
					counter++;
				}

				if (err_pass>0) {
					$(this).addClass('err_inputs');
	      			$("<span class='validate_error_message'>"+form_invalid_password+"<br></span>").insertAfter($(this).parent());
				} else {
					$(this).removeClass('err_inputs');
				}
			}
		});

		var element_script;
		$(element).each(function() {
			element_script = $(this).val();
			if (element_script != undefined) {
				element_script = element_script.trim();
				if(element_script.indexOf("<script") != -1){
					counter++;
					$(this).addClass('err_inputs');
					$("<span class='validate_error_message' style='color: red;'>"+form_script+"<br></span>").insertAfter(this);
				}

				if(element_script.indexOf("< script") != -1){
					counter++;
					$(this).addClass('err_inputs');
					$("<span class='validate_error_message' style='color: red;'>"+form_script+"<br></span>").insertAfter(this);
				}

				if(element_script.indexOf("<?php") != -1){
					counter++;
					$(this).addClass('err_inputs');
					$("<span class='validate_error_message' style='color: red;'>"+form_script+"<br></span>").insertAfter(this);
				}

				if(element_script.indexOf("<?=") != -1){
					counter++;
					$(this).addClass('err_inputs');
					$("<span class='validate_error_message' style='color: red;'>"+form_script+"<br></span>").insertAfter(this);
				}
			}
		});
		return counter;
	}
}