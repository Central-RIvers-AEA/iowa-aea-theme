/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

import { useSelect } from '@wordpress/data';

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @return {Element} Element to render.
 */
export default function save({ attributes }) {

  const { tabNumber } = attributes;

  const bgColors = [
		'var(--wp--preset--color--primary)',
		'var(--wp--preset--color--alt-four)',
		'var(--wp--preset--color--alt-one)',
		'var(--wp--preset--color--alt-three)'
	];

	// Set background color based on tab index
	const tabBgColor = bgColors[(tabNumber - 1) % bgColors.length];

	const blockProps = useBlockProps.save({
		className: 'impact-tab',
		'data-tab-num': tabNumber || 1,
    'style': { backgroundColor: tabBgColor }
	});

	return (
		<div {...blockProps}>
			<InnerBlocks.Content />
		</div>
	);
}