<?php

	/**
	* Template for displaying the Pop-Up
	*/

	// Check if pop-up style is custom. If custom, retrieve the style from options
	if (get_option( 'wprw_popup_preset_setting', 'wprw_midnight_blue' ) === 'wprw_custom_style'){
		$border_color = get_option('wprw_popup_border_color_setting','#111111');
		$text_color = get_option('wprw_popup_text_color_setting', '#ffffff');
		$submit_background_color = get_option('wprw_popup_submit_background_color_setting', '#fec522');
		$submit_background_hover_color = get_option('wprw_popup_submit_background_hover_color_setting', '#d7aa29');
		$submit_text_color = get_option('wprw_popup_submit_text_color_setting', '#2e2e2e');
		$background_gradient_start = get_option('wprw_popup_background_gradient_start_setting', '#111111');
		$background_gradient_end = get_option('wprw_popup_background_gradient_end_setting', '#cccccc');
 		echo '
	 		<style>
		 		.wprw_custom_style{
		 			border-right:3px solid '.esc_attr($border_color).';
		 			background:linear-gradient('.esc_attr($background_gradient_start).', '.esc_attr($background_gradient_end).');
				}
				.wprw_custom_style .ui.form .field > label, .wprw_custom_style .ui.form .field .checkbox > label,  .wprw_custom_style #wprw_popup_header, .wprw_custom_style #wprw_popup_header_icon{
					color: '.esc_attr($text_color).';
				}
				.wprw_custom_style .ui .button{
					background-color: '.esc_attr($submit_background_color).';
					color: '.esc_attr($submit_text_color).';
				}
				.wprw_custom_style .ui .button:hover{
					background-color: '.esc_attr($submit_background_hover_color).';
					color: '.esc_attr($submit_text_color).';
				}		
	 		</style>
 		';
	} 

	?>
	<div id='particlesContainer'></div>
	<div id='wprw-popUpBg' class="wprwPopUpBgHide">
		<div id='wprw-popUpContent' class="<?php echo esc_attr(get_option( 'wprw_popup_preset_setting', 'wprw_midnight_blue' )); ?>">
			<div id="wprw_close_button">
				<?php esc_html_e('Close', 'wproulettewheel'); ?>
				<i class="window close icon"></i>
			</div>
			<div class="ui stackable grid wprw_width100">
				<div id="wprw_popup_wheel_container_left" class="ten wide column middle aligned ">
					<?php echo Wproulettewheel::wprw_wheelContent('popup'); ?>	
				</div>
				<div id="wprw_popup_wheel_container_right" class="six wide column middle aligned">
					<h2 id="wprw_popup_header_container" class="ui header">
						<i id="wprw_popup_header_icon" class="gift icon"></i>
						<div id="wprw_popup_header" class="content">
							<?php echo esc_html(get_option('wprw_popup_header_text_setting', __('Spin to Win a Prize', 'wproulettewheel')));  ?>
						</div>
					</h2>
					<form id="wprw_main_popup_form" class="ui large form" method="post" action="">
						<input type="hidden" name="wprw_checksubmitted" value="1">
						<?php
						if (intval(get_option( 'wprw_collect_firstname_setting', 1 )) === 1){
							echo '
							<div class="field">
							    <label>'.esc_html__('First Name', 'wproulettewheel').'</label>
							    <input type="text" name="first-name" placeholder="'.esc_attr__('First Name','wproulettewheel').'" required>
							</div>
							';
						} 
						if (intval(get_option( 'wprw_collect_lastname_setting', 0 )) === 1){
							echo '
							<div class="field">
							    <label>'.esc_html__('Last Name', 'wproulettewheel').'</label>
							    <input type="text" name="last-name" placeholder="'.esc_attr__('Last Name','wproulettewheel').'" required>
							</div>
							';
						}
						if (intval(get_option( 'wprw_collect_email_setting', 1 )) === 1){
							echo '
							<div class="field">
							    <label>'.esc_html__('Email', 'wproulettewheel').'</label>
							    <input type="email" name="email" placeholder="'.esc_attr__('Email Address','wproulettewheel').'" required>
							</div>
							';
						}  
						if (intval(get_option( 'wprw_collect_phonenumber_setting', 0 )) === 1){
							echo '
							<div class="field">
							    <label>'.esc_html__('Phone Number', 'wproulettewheel').'</label>
							    <input type="tel" name="phone-number" placeholder="'.esc_attr__('Phone Number','wproulettewheel').'" required>
							</div>
							';
						}
						if (intval(get_option( 'wprw_user_rules_setting', 0 )) === 1){
							echo '
							<div class="field">
							    <div class="ui checkbox">
							      <input type="checkbox" tabindex="0" required>
							      <label>'.esc_html__('I agree to the Terms and Conditions', 'wproulettewheel').'</label>
							   </div>
							</div>
							';
						} 
						
						?>
						<div class="field">
							<label>Choose Lucky Number</label>
							<input id="wprw-chosenField" type="number" min="0" max="36" required="required" aria-required="true">
						</div>
							
						<button id="wprw-btnSpin" class="ui button" type="submit">
							<i class="play icon"></i>
							<?php 
							echo esc_html(get_option('wprw_play_button_text_setting', __('Spin the Wheel!', 'wproulettewheel'))); 
							?>
						</button>
					</form>
				</div>
			</div>
		</div>
	</div>
