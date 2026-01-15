<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

	$context = array("attributes" => $attributes);
?>
<div <?php echo get_block_wrapper_attributes(); ?>>
	<h2><?php esc_html_e( 'Important Contacts', 'important-contacts' ); ?></h2>
	<div class='contacts-block'>
		<?php 
			$contacts = $context['attributes']['contacts'] ?? [];

			foreach ( $contacts as $contact ) {
				?>
					<div class='contact-item'>
						<div class='staff-img'>
							<img src='<?php echo esc_url( $contact['image'] ); ?>' alt='<?php echo esc_attr( $contact['name'] ); ?>' />
						</div>
						<div  class="contact-info">
							<h3><?php echo esc_html( $contact['name'] ); ?></h3>
							<p><?php echo esc_html( $contact['jobTitle'] ); ?></p>
							<p><a href="mailto:<?php echo esc_html( $contact['email'] ); ?>"><?php echo esc_html( $contact['email'] ); ?></a></p>
							<p><a href="tel:<?php echo esc_html( $contact['phone'] ); ?>"><?php echo esc_html( $contact['phone'] ); ?></a></p>
						</div>
					</div>
				<?php
			}
		?>
	</div>
</div>
