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
import { useBlockProps, RichText, MediaUpload, URLInput } from '@wordpress/block-editor';

import { Button, Popover, TextControl } from '@wordpress/components';
import { useDispatch } from '@wordpress/data';
import { useState } from '@wordpress/element';

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

	const [showUrlInput, setShowUrlInput] = useState(false);

	const blockProps = useBlockProps({ className: 'slide' });

	const { removeBlock } = useDispatch('core/block-editor');

	const handleRemove = () => {
		removeBlock(props.clientId);
	};

	const MAX_CHARACTERS = 50;

	const handleSlideChange = (property, value) => {
		setAttributes({ [property]: value });
	}

	return (
		<div { ...blockProps } style={{ textAlign: 'left' }}>
			<Button
					isDestructive
					variant="secondary"
					onClick={handleRemove}
					className="slide-remove-button"
				>
					{__('X', 'your-text-domain')}
			</Button>
			<div className='title-content'>
				<RichText
					key={`slide-title`}
					identifier={`slide-title`}
					tagName="h3"
					value={attributes.title || ''}
					onChange={(value) => handleSlideChange('title', value )}
					placeholder={__('Enter heading text...', 'side-tabs')}
					allowedFormats={['core/bold', 'core/italic']}
				/>
				<RichText
					key={`slide-content`}
					identifier={`slide-content`}
					tagName="div"
					value={attributes.content || ''}
					onChange={(value) => handleSlideChange('content', value )}
					placeholder={__('Enter content text...', 'side-tabs')}
					allowedFormats={['core/bold', 'core/italic']}
				/>
				<div style={{ position: 'relative' }}>
					<Button 
						variant="primary"
						onClick={() => setShowUrlInput(!showUrlInput)}
					>
						{attributes.buttonText || __('Learn More', 'side-tabs')}
					</Button>
					{attributes.buttonUrl && (
						<span style={{ marginLeft: '10px', fontSize: '12px', color: '#666' }}>
							{attributes.buttonUrl}
						</span>
					)}
					{showUrlInput && (
						<Popover position="bottom center" onClose={() => setShowUrlInput(false)}>
							<div style={{ padding: '16px', minWidth: '300px' }}>
								<TextControl
									label={__('Button Text', 'side-tabs')}
									value={attributes.buttonText}
									onChange={(text) => handleSlideChange('buttonText', text)}
									placeholder={__('Learn More', 'side-tabs')}
								/>
								<URLInput
									label={__('Button URL', 'side-tabs')}
									value={attributes.buttonUrl}
									onChange={(url) => handleSlideChange('buttonUrl', url)}
									placeholder={__('Enter URL...', 'side-tabs')}
								/>
								<Button
									variant="primary"
									onClick={() => setShowUrlInput(false)}
									style={{ marginTop: '8px' }}
								>
									{__('Apply', 'side-tabs')}
								</Button>
							</div>
						</Popover>
					)}
				</div>
			</div>
			<div className='image-content'>
				<MediaUpload
					onSelect={(media) => handleSlideChange('image', media.url)}
					allowedTypes={['image']}
					render={({ open }) => (
						<button onClick={open}>
							{ attributes.image ? <img src={attributes.image} alt={attributes.title} /> : __('Upload Image', 'header-slider') }
						</button>
					)}
					key={`slide-image`}
					identifier={`slide-image`}
				/>
			</div>
			<div className='label-content'>
				<RichText
					key={`slide-label`}
					identifier={`slide-label`}
					tagName="div"
					value={attributes.slide_label || ''}
					onChange={(value) => handleSlideChange('slide_label', value)}
					placeholder={__('Enter label text...', 'side-tabs')}
					allowedFormats={['core/bold', 'core/italic']}
				/>
				<div className='characters-remaining'>Characters remaining: {MAX_CHARACTERS - attributes.slide_label.length}</div>
			</div>
		</div>
	);
}
