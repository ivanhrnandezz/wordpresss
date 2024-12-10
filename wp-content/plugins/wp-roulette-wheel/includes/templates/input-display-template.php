<?php

/**
* Template for displaying the Roulette Wheel Input (Normally displayed via Shortcode or within the Admin Panel for preview purposes)
*/

// Fields are required in the website, but not required in the admin panel, where the form is not actually submitted 
if($isadmin ==='admin'){
	$required = '';
	$button_type = 'button';
	$container = 'div';
} else {
	$required = 'required';
	$button_type = 'submit';
	$container = 'form';
}

// Get Custom Style from Settings
echo '
	<style>
		.wprw_custominputdisplaycontainer{
			background-color: '.esc_attr(get_option('wprw_input_background_setting', '#156baa')).';
		}
		.ui.form .field> .wprw_custominputlabelcolor{
			color:'.esc_attr(get_option('wprw_input_label_setting', '#ffffff')).';
		}
		.ui.button.wprw_custominputbutton{
			background-color:'.esc_attr(get_option('wprw_submit_background_setting', '#fec522')).';
			color:'.esc_attr(get_option('wprw_submit_text_setting', '#5e5e5e')).';
		}
	</style>
';

if ($isadmin !== 'admin'){
	echo '
		<style>
			#wprw-btnSpin:hover{
				background-color:'.esc_attr(get_option('wprw_submit_background_hover_setting', '#e3a71e')).';
			}
		</style>
	';
}

// In the admin panel we have a Div, not an actual form, as that would interefere with the Settings form
if($isadmin ==='admin'){
	echo '
		<div id="wprw_input_form" class="ui large form wprw_custominputdisplaycontainer" >
	';
} else {
	echo '
		<form id="wprw_input_form" class="ui large form wprw_custominputdisplaycontainer" method="post" action="">
	';
}

echo '<input type="hidden" name="wprw_checksubmitted" value="1">';
if (intval(get_option( 'wprw_collect_firstname_setting', 1 )) === 1){
	echo '
		<div class="field">
		    <label class="wprw_custominputlabelcolor">'.esc_html__('First Name', 'wproulettewheel').'</label>
		    <input type="text" name="first-name" placeholder="'.esc_attr__('First Name','wproulettewheel').'" '.$required.'>
		</div>
	';
} 
if (intval(get_option( 'wprw_collect_lastname_setting', 0 )) === 1){
	echo '
		<div class="field">
		    <label class="wprw_custominputlabelcolor">'.esc_html__('Last Name', 'wproulettewheel').'</label>
		    <input type="text" name="last-name" placeholder="'.esc_attr__('Last Name','wproulettewheel').'" '.$required.'>
		</div>
	';
}
if (intval(get_option( 'wprw_collect_email_setting', 1 )) === 1){
	echo '
		<div class="field">
		    <label class="wprw_custominputlabelcolor">'.esc_html__('Email', 'wproulettewheel').'</label>
		    <input type="email" name="email" placeholder="'.esc_attr__('Email Address','wproulettewheel').'" '.$required.'>
		</div>
	';
}  
if (intval(get_option( 'wprw_collect_phonenumber_setting', 0 )) === 1){
	echo '
		<div class="field">
		    <label class="wprw_custominputlabelcolor">'.esc_html__('Phone Number', 'wproulettewheel').'</label>
		    <input type="tel" name="phone-number" placeholder="'.esc_attr__('Phone Number','wproulettewheel').'" '.$required.'>
		</div>
	';
}

if (intval(get_option( 'wprw_user_rules_setting', 0 )) === 1){
	echo '
		<div class="field">
		    <div class="ui checkbox">
		      <input type="checkbox" tabindex="0" '.$required.'>
		      <label class="wprw_custominputlabelcolor">'.esc_html__('I agree to the Terms and Conditions', 'wproulettewheel').'</label>
		   </div>
		</div>
	';
} 

echo '
	<div class="field">
		<label class="wprw_custominputlabelcolor">'.esc_html__('Choose Lucky Number', 'wproulettewheel').'</label>
		<input id="wprw-chosenField" type="number" min="0" max="36" '.$required.'>
	</div>

	<button id="wprw-btnSpin" class="ui button wprw_custominputbutton" type="'.$button_type.'">
		<i class="play icon"></i>'.esc_html(get_option('wprw_play_button_text_setting', __('Spin the Wheel!', 'wproulettewheel'))).'
	</button>
	</'.$container.'>
';
