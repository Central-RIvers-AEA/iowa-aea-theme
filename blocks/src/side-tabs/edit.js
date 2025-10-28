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
import { useBlockProps, InnerBlocks, InspectorControls, BlockControls } from '@wordpress/block-editor';
import { PanelBody, Button, ToolbarGroup, ToolbarButton } from '@wordpress/components';
import { useSelect, useDispatch } from '@wordpress/data';
import { createBlock } from '@wordpress/blocks';

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
	const { clientId } = props;
	
	const { insertBlock, removeBlock } = useDispatch('core/block-editor');
	
	// Get current inner blocks
	const innerBlocks = useSelect((select) => {
		return select('core/block-editor').getBlocks(clientId);
	}, [clientId]);

	// Initial template for new installations
	const blockTemplate = [
		[ 'iowa-aea-theme/side-tab' ],
		[ 'iowa-aea-theme/side-tab' ]
	];

	const addTab = () => {
		const newBlock = createBlock('iowa-aea-theme/side-tab');
		insertBlock(newBlock, innerBlocks.length, clientId);
	};

	const removeLastTab = () => {
		if (innerBlocks.length > 1) {
			const lastBlock = innerBlocks[innerBlocks.length - 1];
			removeBlock(lastBlock.clientId);
		}
	};

	return (
		<>
			<BlockControls>
				<ToolbarGroup>
					<ToolbarButton
						label={__('Add Tab', 'side-tabs')}
						onClick={addTab}
					/>
					{innerBlocks.length > 1 && (
						<ToolbarButton
							label={__('Remove Last Tab', 'side-tabs')}
							onClick={removeLastTab}
						/>
					)}
				</ToolbarGroup>
			</BlockControls>
			
			<InspectorControls>
				<PanelBody title={__('Tab Management', 'side-tabs')}>
					<div style={{ marginBottom: '16px' }}>
						<strong>{__('Current tabs:', 'side-tabs')} {innerBlocks.length}</strong>
					</div>
					<Button 
						variant="primary" 
						onClick={addTab}
						style={{ marginRight: '8px' }}
					>
						{__('Add Tab', 'side-tabs')}
					</Button>
					{innerBlocks.length > 1 && (
						<Button 
							variant="secondary" 
							onClick={removeLastTab}
						>
							{__('Remove Last Tab', 'side-tabs')}
						</Button>
					)}
				</PanelBody>
			</InspectorControls>
			
			<div { ...useBlockProps() }>
				<InnerBlocks 
					template={blockTemplate}
					allowedBlocks={['iowa-aea-theme/side-tab']}
					renderAppender={false}
				/>
			</div>
		</>
	);
}
