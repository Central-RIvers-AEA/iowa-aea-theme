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
import { useBlockProps, RichText } from '@wordpress/block-editor';

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
	const { titleOne, tabContentOne, titleTwo, tabContentTwo, titleThree, tabContentThree, titleFour, tabContentFour } = attributes;

	return (
		<div { ...useBlockProps() }>
			<div className='impact-tab' style={{ '--tab-background': '#9B2246' }} data-tab-num="1" key="tab-one">
				<RichText
					key="title-one"
					identifier="tab-title-one"
					tagName="h3"
					className='tab-header-one'
					value={titleOne || ''}
					onChange={(value) => setAttributes({ titleOne: value })}
					placeholder={__('Enter heading text...', 'side-tabs')}
					allowedFormats={['core/bold', 'core/italic']}
				/>

				<RichText
					key="content-one"
					identifier="tab-content-one"
					tagName="div"
					className="tab-content-one"
					value={tabContentOne || ''}
					onChange={(value) => setAttributes({ tabContentOne: value })}
					placeholder={__('Enter content...', 'side-tabs')}
					multiline="p"
					
				/>
			</div>

			<div className='impact-tab' style={{ '--tab-background': '#D17829' }} data-tab-num="2" key="tab-two">
				<RichText
					key="title-two"
					identifier="tab-title-two"
					tagName="h3"
					className='tab-header-two'
					value={titleTwo || ''}
					onChange={(value) => setAttributes({ titleTwo: value })}
					placeholder={__('Enter heading text...', 'side-tabs')}
					allowedFormats={['core/bold', 'core/italic']}
				/>

				<RichText
					key="content-two"
					identifier="tab-content-two"
					tagName="div"
					className="tab-content-two"
					value={tabContentTwo || ''}
					onChange={(value) => setAttributes({ tabContentTwo: value })}
					placeholder={__('Enter content...', 'side-tabs')}
					multiline="p"
				/>
			</div>

			<div className='impact-tab' style={{ '--tab-background': '#001777' }} data-tab-num="3" key="tab-three">
				<RichText
					key="title-three"
					identifier="tab-title-three"
					tagName="h3"
					className='tab-header-three'
					value={titleThree || ''}
					onChange={(value) => setAttributes({ titleThree: value })}
					placeholder={__('Enter heading text...', 'side-tabs')}
					allowedFormats={['core/bold', 'core/italic']}
				/>

				<RichText
					key="content-three"
					identifier="tab-content-three"
					tagName="div"
					className="tab-content-three"
					value={tabContentThree || ''}
					onChange={(value) => setAttributes({ tabContentThree: value })}
					placeholder={__('Enter content...', 'side-tabs')}
					multiline="p"
				/>
			</div>

			<div className='impact-tab' style={{ '--tab-background': '#00826E' }} data-tab-num="4" key="tab-four">
				<RichText
					key="title-four"
					identifier="tab-title-four"
					tagName="h3"
					className='tab-header-four'
					value={titleFour || ''}
					onChange={(value) => setAttributes({ titleFour: value })}
					placeholder={__('Enter heading text...', 'side-tabs')}
					allowedFormats={['core/bold', 'core/italic']}
				/>

				<RichText
					key="content-four"
					identifier="tab-content-four"
					tagName="div"
					className="tab-content-four"
					value={tabContentFour || ''}
					onChange={(value) => setAttributes({ tabContentFour: value })}
					placeholder={__('Enter content...', 'side-tabs')}
					multiline="p"
				/>
			</div>
		</div>
	);
}
