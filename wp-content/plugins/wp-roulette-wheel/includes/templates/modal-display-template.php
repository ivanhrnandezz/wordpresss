<?php

	/**
	* Template for displaying the Win / Lose Modals (only for shortcode website integration)
	*/

?>
<div class="ui tiny modal wprw_modal_init">
	<i class="close icon"></i>
	<div id="wprw_modaltop" class="header"></div>
	<div class="image content">
		<div id="wprw_modalIconContainer" class="ui medium image">
		      <i id="wprw_modalIcon" class="trophy icon"></i>
		</div>
		<div class="description">
			<div id="wprw_modalContentTop" class="ui header"></div>
			<p id="wprw_modalMessage"></p>
		</div>
	</div>
	<div class="actions">
		<div class="ui positive right labeled icon button">
			<?php esc_html_e('Got It!', 'wproulettewheel') ?>
			<i class="checkmark icon"></i>
		</div>
	</div>
</div>