<form class="form-detail" action="#" method="post" id="form-customer" novalidate="novalidate">
	<h2><?php echo $atts[ 'title' ] ?></h2>

	<?php require ETDTP_PATH . 'templates/notification.php'; ?>

	<div class="form-group">
		<div class="form-row form-row-1">
			<label for="name"><?php echo $atts[ 'label_name' ] ?></label>
			<input type="text" name="name" id="name" class="input-text" maxlength="<?php echo $atts[ 'length_name' ] ?>">
		</div>
		<div class="form-row form-row-1">
			<label for="phone_number"><?php echo $atts[ 'label_phone' ] ?></label>
			<input type="text" name="phone_number" id="phone_number" class="input-text" maxlength="<?php echo $atts[ 'length_phone' ] ?>">
		</div>
	</div>
	<div class="form-row">
		<label for="email"><?php echo $atts[ 'label_email' ] ?></label>
		<input type="text" name="email" id="email" class="input-text" required="" pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}" aria-required="true" maxlength="<?php echo $atts[ 'length_email' ] ?>">
	</div>
	<div class="form-row">
		<label for="budget"><?php echo $atts[ 'label_budget' ] ?></label>
		<input type="text" name="budget" id="budget" class="input-text" required="" aria-required="true" maxlength="<?php echo $atts[ 'length_budget' ] ?>">
	</div>
	<div class="form-row">
		<label for="message"><?php echo $atts[ 'label_message' ] ?></label>
		<textarea name="message" id="message" class="input-text" maxlength="<?php echo $atts[ 'length_message' ] ?>" rows="<?php echo $atts[ 'textarea_rows' ] ?>" cols="<?php echo $atts[ 'textarea_cols' ] ?>"></textarea>
	</div>
	<div class="hidden-section">
		<input type="hidden" name="timezone" id="timezone">
		<input type="hidden" name="datetime" id="datetime">
		<?php wp_nonce_field( '6&eC&D:EuG#kDn', 'nonce' ); ?>
	</div>
	<div class="form-row-last">
		<input type="submit" name="register" class="register" value="<?php echo $atts[ 'label_submit' ] ?>">
	</div>
</form>