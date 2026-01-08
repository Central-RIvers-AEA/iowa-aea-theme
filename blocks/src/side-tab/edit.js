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
import { useBlockProps, InnerBlocks, BlockControls, InspectorControls, useSetting } from '@wordpress/block-editor';
import { ToolbarGroup, ToolbarButton, ColorPalette, PanelBody } from '@wordpress/components';
import { useSelect, useDispatch } from '@wordpress/data';

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
  const { attributes, setAttributes, clientId } = props;
	const { tabNumber, backgroundColor } = attributes;

	const { removeBlock } = useDispatch('core/block-editor');

  // Get the index of this block within its parent and sibling count
  const { tabIndex, siblingCount } = useSelect((select) => {
    const { getBlockRootClientId, getBlockOrder } = select('core/block-editor');
    const parentClientId = getBlockRootClientId(clientId);
    
    if (parentClientId) {
      const siblingBlocks = getBlockOrder(parentClientId);
      const currentIndex = siblingBlocks.indexOf(clientId);
      return {
        tabIndex: currentIndex + 1, // 1-based index
        siblingCount: siblingBlocks.length
      };
    }
    
    return {
      tabIndex: tabNumber || 1,
      siblingCount: 1
    };
  }, [clientId, tabNumber]);

  setAttributes({ tabNumber: tabIndex });

	const removeThisTab = () => {
		if (siblingCount > 1) {
			removeBlock(clientId);
		}
	};
	
	const blockTemplate = [
		[ 'core/heading', { 
			placeholder: `Tab ${tabIndex} Title`,
			level: 3,
			className: `tab-header-${tabIndex}`
		}],
		[ 'core/paragraph', { 
			placeholder: `Content for Tab ${tabIndex}`,
			className: `tab-content-${tabIndex}`
		}]
	];

	const bgColors = [
		'var(--wp--preset--color--primary)',
		'var(--wp--preset--color--alt-four)',
		'var(--wp--preset--color--alt-one)',
		'var(--wp--preset--color--alt-three)'
	];

	// Get theme color palette
	const colorPalette = useSetting('color.palette') || [
		{ name: 'Primary', slug: 'primary', color: '#9b2246' },
		{ name: 'Secondary', slug: 'secondary', color: '#f0b52b' },
		{ name: 'Alt One', slug: 'alt-one', color: '#001777' },
		{ name: 'Alt Two', slug: 'alt-two', color: '#582c63' },
		{ name: 'Alt Three', slug: 'alt-three', color: '#00826e' },
		{ name: 'Alt Four', slug: 'alt-four', color: '#d17829' },
		{ name: 'Background Color', slug: 'background-color', color: '#ffffff' },
		{ name: 'Base', slug: 'base', color: '#FFFFFF' },
		{ name: 'Text Color', slug: 'text-color', color: '#333333' }
	];

	// Set background color based on tab index
	const tabBgColor = bgColors[(tabIndex - 1) % bgColors.length];

	const blockProps = useBlockProps({
		className: 'impact-tab',
		'data-tab-num': tabIndex,
		style: {
			'--tab-background': attributes.backgroundColor || tabBgColor,
			'--tab-text-color': attributes.textColor || '#000000'
		}
	});

	return (
		<>
			<BlockControls>
				{siblingCount > 1 && (
					<ToolbarGroup>
						<ToolbarButton
							label={__('Remove This Tab', 'side-tab')}
							onClick={removeThisTab}
						/>
					</ToolbarGroup>
				)}
			</BlockControls>

			<InspectorControls>
				<PanelBody title={__('Settings', 'content-card')}>
					
					<span>Background Color</span>
					<ColorPalette
						label={__('Background Color', 'link-card')}
						value={attributes.backgroundColor}
						onChange={(value) => setAttributes({ backgroundColor: value })}
						colors={colorPalette}
						enableAlpha={false}
						clearable={true}
					/>
					<span>Text Color</span>
					<ColorPalette
						label={__('Text Color', 'link-card')}
						value={attributes.textColor}
						onChange={(value) => setAttributes({ textColor: value })}
						colors={colorPalette}
						enableAlpha={false}
						clearable={true}
					/>
				</PanelBody>
			</InspectorControls>
			
			<div {...blockProps}>
				<div style={{ 
					display: 'flex', 
					justifyContent: 'space-between', 
					alignItems: 'center',
					marginBottom: '10px',
					padding: '5px',
					backgroundColor: 'rgba(0,0,0,0.1)',
					borderRadius: '3px',
          position: 'absolute',
          width: 'fit-content',
          top: '10px',
          right: '10px'
				}}>
					<small><strong>Tab {tabIndex}</strong></small>
					{siblingCount > 1 && (
						<button 
							onClick={removeThisTab}
							style={{
								background: '#dc3545',
								color: 'white',
								border: 'none',
								borderRadius: '3px',
								padding: '2px 6px',
								fontSize: '12px',
								cursor: 'pointer'
							}}
						>
							Remove
						</button>
					)}
				</div>
				<InnerBlocks 
					template={blockTemplate}
					templateLock="all"
				/>
			</div>
		</>
	);
}