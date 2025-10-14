<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
?>
<div <?php echo get_block_wrapper_attributes(); ?> aria-live="polite">
	<div>
		<select id="district-select">
			<option value="">Select your School District</option>
		</select>
		<button type='button' class='btn'>Contact My AEA</button>

		<div id='aea-info'>
			<!-- AEA information will be displayed here -->
		</div>
	</div>

	<div class='img-block'>
		<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/blocks/images/iowa-map.png' ); ?>" alt="<?php esc_attr_e( 'Iowas AEAs', 'interactive-map' ); ?>" />
		<img style='--level: 0;' id='CentralRiversAEA' src="<?php echo esc_url( get_stylesheet_directory_uri() . '/blocks/images/CentralRiversAEA.svg' ); ?>" alt="<?php esc_attr_e( 'Central Rivers AEA', 'interactive-map' ); ?>" class='svg'/>
		<img style='--level: 0;' id='GrantWoodAEA' src="<?php echo esc_url( get_stylesheet_directory_uri() . '/blocks/images/GrantWoodAEA.svg' ); ?>" alt="<?php esc_attr_e( 'Grant Wood AEA', 'interactive-map' ); ?>" class='svg'/>
		<img style='--level: 0;' id='GreatPrairieAEA' src="<?php echo esc_url( get_stylesheet_directory_uri() . '/blocks/images/GreatPrairieAEA.svg' ); ?>" alt="<?php esc_attr_e( 'Great Prairie AEA', 'interactive-map' ); ?>" class='svg'/>
		<img style='--level: 0;' id='GreenHillsAEA' src="<?php echo esc_url( get_stylesheet_directory_uri() . '/blocks/images/GreenHillsAEA.svg' ); ?>" alt="<?php esc_attr_e( 'Green Hills AEA', 'interactive-map' ); ?>" class='svg'/>
		<img style='--level: 0;' id='HeartlandAEA' src="<?php echo esc_url( get_stylesheet_directory_uri() . '/blocks/images/HeartlandAEA.svg' ); ?>" alt="<?php esc_attr_e( 'Heartland AEA', 'interactive-map' ); ?>" class='svg'/>
		<img style='--level: 0;' id='KeystoneAEA' src="<?php echo esc_url( get_stylesheet_directory_uri() . '/blocks/images/KeystoneAEA.svg' ); ?>" alt="<?php esc_attr_e( 'Keystone AEA', 'interactive-map' ); ?>" class='svg'/>
		<img style='--level: 0;' id='MississippiBendAEA' src="<?php echo esc_url( get_stylesheet_directory_uri() . '/blocks/images/MississippiBendAEA.svg' ); ?>" alt="<?php esc_attr_e( 'Mississippi Bend AEA', 'interactive-map' ); ?>" class='svg'/>
		<img style='--level: 0;' id='NorthwestAEA' src="<?php echo esc_url( get_stylesheet_directory_uri() . '/blocks/images/NorthwestAEA.svg' ); ?>" alt="<?php esc_attr_e( 'Northwest AEA', 'interactive-map' ); ?>" class='svg'/>
		<img style='--level: 0;' id='PrairieLakesAEA' src="<?php echo esc_url( get_stylesheet_directory_uri() . '/blocks/images/PrairieLakesAEA.svg' ); ?>" alt="<?php esc_attr_e( 'Prairie Lakes AEA', 'interactive-map' ); ?>" class='svg'/>
	</div>
</div>
