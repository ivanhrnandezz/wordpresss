<?php

	/**
	* Template for displaying the Roulette Wheel
	*/

	if($ispopup === 'no'){
		// if not pop-up (is website integration), wheel size is defined by user setting
		echo '
		<style>
			.wprw_customwheelsize{
				font-size:calc(2px*'.esc_attr(get_option('wprw_wheel_size_setting', 5)).');
			}

		</style>
		';

		echo '
		<div class="wprw-spinner wprw_customwheelsize">
		';
	} else if ($ispopup === 'popup'){
		//if is popup show default pop-up size
		echo '
		<div class="wprw-spinner wprw_wheel_popup_size" >
		';		
	}
	?>
		 	<div class="wprw-ball">
		 		<span></span>
		 	</div>
		 	<div class="wprw-platebg"></div>
		  	<div id="wprw-toppart" class="wprw-topnodebox">
		        <div class="wprw-platetop"></div>
				<div class="wprw-topparttop2">
				    <div class="wprw-silvernode"></div>
				    <div class="wprw-topnode wprw-silverbg"></div>
				    <span class="wprw-top wprw-silverbg"></span>
				    <span class="wprw-right wprw-silverbg"></span>
				    <span class="wprw-down wprw-silverbg"></span>
				    <span class="wprw-left wprw-silverbg"></span>
				</div>
		  	</div>
			<div id="wprw-rcircle" class="wprw-pieContainer">
			    <div class="wprw-pieBackground"></div>
			</div>
		</div>
