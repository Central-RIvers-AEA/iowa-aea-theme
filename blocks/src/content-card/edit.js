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
import { useBlockProps, InspectorControls, withColorContext, useSetting, InnerBlocks } from '@wordpress/block-editor';
import { PanelBody, ToggleControl, SelectControl, TextControl, ColorPalette } from '@wordpress/components';

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
  const { attributes, setAttributes } = props;
  const { backgroundColor } = attributes;

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

  let template = [
    [ 'core/paragraph', {
      placeholder: __('Add your content here...', 'content-card')
    } ],
  ];
  

  return (
    <>
      <InspectorControls>
        {/* You can add control panels here if needed */}
        <PanelBody title={__('Settings', 'content-card')}>
          <ColorPalette
            label={__('Background Color', 'content-card')}
            value={attributes.backgroundColor}
            onChange={(value) => setAttributes({ backgroundColor: value })}
            colors={colorPalette}
            enableAlpha={false}
            clearable={true}
          />
        </PanelBody>
      </InspectorControls>

      <div {...useBlockProps({ style: { '--card-color': backgroundColor }})}>
        <InnerBlocks template={template} />
      </div>
    </>
  );
}

