<?php if ( isset( $_GET['success'] ) && $_GET['success'] == 1 ) : ?>

<div class="alert alert-success"><?php esc_html_e( 'Your data has been saved, thank you for contacting us!', 'et-dev-test-project' ) ?></div>

<?php elseif ( isset( $_GET['success'] ) && $_GET['success'] == 0 ) : ?>

<div class="alert alert-danger"><?php esc_html_e( 'An error has been encountered!, please try again later', 'et-dev-test-project' ) ?></div>

<?php endif ?>

<div class="alert alert-danger hidden-section"><?php esc_html_e( 'Please fill all provided fields before submit!', 'et-dev-test-project' ) ?></div>