<?php if ( isset( $_GET[ 'success' ] ) && $_GET[ 'success' ] == 1 ) : ?>

	<div class="alert alert-success">Your data has been saved, thank you for contacting us!</div>

<?php elseif ( isset( $_GET[ 'success' ] ) && $_GET[ 'success' ] == 0 ) : ?>

	<div class="alert alert-danger">An error has been encountered!, please try again later</div>

<?php endif ?>

<div class="alert alert-danger hidden-section">Please fill all provided fields before submit!</div>