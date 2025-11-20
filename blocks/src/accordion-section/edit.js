/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';
import { Button } from '@wordpress/components';
import { useDispatch } from '@wordpress/data';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit(props) {
	const blockProps = useBlockProps({ className: 'accordion-section'});

	const { removeBlock } = useDispatch('core/block-editor');

	const handleRemove = () => {
		removeBlock(props.clientId);
	};

	return (
		<div { ...blockProps } >
			<Button
					isDestructive
					variant="secondary"
					onClick={handleRemove}
					className="accordion-remove-button"
				>
					{__('X', 'your-text-domain')}
			</Button>
			<InnerBlocks
				template={[
					[ 'core/heading', { 
						level: 3,
						placeholder: 'Enter heading...',
						className: 'section-heading',
						lock: {
							move: true,
							remove: true
						}
					} ],
					[ 'core/paragraph', { 
						placeholder: `Content for section`,
						className: `section-content`,
					} ]
				]}
			/>
		</div>
	);
}