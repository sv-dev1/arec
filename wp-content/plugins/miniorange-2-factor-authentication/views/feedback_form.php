<?php function display_feedback_form(){
	if ( 'plugins.php' != basename($_SERVER['PHP_SELF']) ) {
			return;
		}
	
	$mo2f_message = get_option( 'mo2f_message');
    wp_enqueue_style( 'wp-pointer' );
    wp_enqueue_script( 'wp-pointer' );
    wp_enqueue_script( 'utils' );
	wp_enqueue_style( 'mo_2_factor_admin_plugins_page_style', plugins_url( '/../includes/css/mo2f_plugins_page.css?version=5.0.12', __FILE__ ) );
	?>

</head>
<body>





<!-- The Modal -->
<div id="myModal" class="mo2f_modal">

  <!-- Modal content -->
  <div class="mo2f_modal-content">
    <span class="mo2f_close">&times;</span>
    <h3>What Happened? </h3>
	
	<?php if($mo2f_message!=''){?>
					 <div style="padding:10px;">
                            <div class="alert alert-info" style="margin-bottom:0px">
                                <p style="font-size:15px"><?php echo $mo2f_message; ?></p>
                            </div>
                        </div>
					<?php } ?>
					<form name="f" method="post" action="" id="mo2f_feedback">
						<input type="hidden" name="mo2f_feedback" value="mo2f_feedback"/>
								<div >
									<p style="margin-left:2%">
										<?php 
											$deactivate_reasons = array(
												"Not Receiving OTP During Registration",
												"Does not have the features I'm looking for",
												"Not Working",
												"Redirecting back to login page after Authentication",
												"Confusing Interface",
												"Bugs in the plugin",
												"Other Reasons:"
											);

							
								foreach ( $deactivate_reasons as $deactivate_reasons ) {?>

								<div  class="radio" style="padding:1px;margin-left:2%">
									<label style="font-weight:normal;font-size:14.6px" for="<?php echo $deactivate_reasons; ?>">
									<input type="radio" name="deactivate_plugin" value="<?php echo $deactivate_reasons;?>" required>
									<?php echo $deactivate_reasons;?></label>
								</div>

			
									<?php } ?>
									<br>
											
											<textarea id="query_feedback" name="query_feedback"  rows="4" style="margin-left:2%" cols="50" placeholder="Write your query here"></textarea>
										<br><br>
										<div class="mo2f_modal-footer" >
											<input type="submit" name="miniorange_feedback_submit" class="button button-primary button-large" value="Submit" />
										</div>
								</div>
					</form>
					<form name="f" method="post" action="" id="mo2f_feedback_form_close">
						<input type="hidden" name="option" value="mo2f_skip_feedback"/>
					</form>
	
  </div>

</div>

<script>
 jQuery('a[aria-label="Deactivate miniOrange 2 Factor Authentication"]').click(function(){
// Get the mo2f_modal
	<?php if(!get_option('mo2f_feedback_form')){ ?>
var mo2f_modal = document.getElementById('myModal');

// Get the button that opens the mo2f_modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the mo2f_modal
var span = document.getElementsByClassName("mo2f_close")[0];

// When the user clicks the button, open the mo2f_modal 

    mo2f_modal.style.display = "block";

		// jQuery('#myModal').mo2f_modal('mo2f_toggle');
		
		
					 jQuery('input:radio[name="deactivate_plugin"]').click(function () {
						 var reason= jQuery(this).val();
							 jQuery('#query_feedback').removeAttr('required')
						  
						 if(reason=='Facing issues During Registration'){
							 jQuery('#query_feedback').attr("placeholder", "Can you please describe the issue in detail?");
						 }else if(reason=="Does not have the features I'm looking for"){
							 jQuery('#query_feedback').attr("placeholder", "Let us know what feature are you looking for");
						 }else if(reason=="Other Reasons:"){
						 jQuery('#query_feedback').attr("placeholder", "Can you let us know the reason for deactivation");
						 jQuery('#query_feedback').prop('required',true);

						 }else if(reason=="Not Receiving OTP During Registration"){
						 jQuery('#query_feedback').attr("placeholder", "Can you please describe the issue in detail?");

						 }else if(reason=="Bugs in the plugin"){
						 jQuery('#query_feedback').attr("placeholder", "Can you please let us know about the bug in detail?");

						 }else if(reason=="Redirecting back to login page after Authentication"){
						 jQuery('#query_feedback').attr("placeholder", "Can you please describe the issue in detail?");

						 }else if(reason=="Confusing Interface"){
						 jQuery('#query_feedback').attr("placeholder", "Finding it confusing? let us know so that we can improve the interface");

						 }else if(reason=="Not Working"){
						 jQuery('#query_feedback').attr("placeholder", "Can you please describe what is not working?");

						 }else if(reason=="Not Working"){
						 jQuery('#query_feedback').attr("placeholder", "Can you please describe what is not working?");

						 }else if(reason=="Login Credentials Not Working"){
						 jQuery('#query_feedback').attr("placeholder", "This is not a major issue please contact info@miniorange.com to get your issue resolved.");

						 }
					 });
		
		


		// When the user clicks on <span> (x), mo2f_close the mo2f_modal
		span.onclick = function() {
			mo2f_modal.style.display = "none";
			jQuery('#mo2f_feedback_form_close').submit();
		}

		// When the user clicks anywhere outside of the mo2f_modal, mo2f_close it
		window.onclick = function(event) {
			if (event.target == mo2f_modal) {
				mo2f_modal.style.display = "none";
			}
		}
return false;
<?php } ?>
 });
</script><?php
	}
	?>