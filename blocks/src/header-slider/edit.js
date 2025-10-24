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
import { useBlockProps, RichText, MediaUpload } from '@wordpress/block-editor';

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
	const { slides } = attributes;

	const MAX_CHARACTERS = 50;

	// Handle slide changes
	const handleSlideChange = (index, updatedSlide) => {
		const updatedSlides = [...slides];
		updatedSlides[index] = updatedSlide;
		setAttributes({ slides: updatedSlides });
	}

	const handleLabelChange = (index, value) => {
		const updatedSlides = [...slides];

		if (value.length <= MAX_CHARACTERS) {
			value = value.substring(0, MAX_CHARACTERS);
			console.log(value)
			updatedSlides[index].slide_label = value;
			setAttributes({ slides: updatedSlides });
		}
	}

	const addSlide = () => {
		const newSlide = {
			image: '',
			title: '',
			slide_label: '',
			content: ''
		};
		setAttributes({ slides: [...slides, newSlide] });
	}

	const removeSlide = (index) => {
		const updatedSlides = [...slides];
		updatedSlides.splice(index, 1);
		setAttributes({ slides: updatedSlides });
	}

	return (
		<div { ...useBlockProps() }>
			{ slides && slides.map((slide, index) => (
				<div key={ index } className='slide'>
					<div className='title-content'>
						<button onClick={() => removeSlide(index)}>Remove Slide</button>
						<RichText
							key={`slide-title-${index}`}
							identifier={`slide-title-${index}`}
							tagName="h3"
							value={slide.title || ''}
							onChange={(value) => handleSlideChange(index, { ...slide, title: value })}
							placeholder={__('Enter heading text...', 'side-tabs')}
							allowedFormats={['core/bold', 'core/italic']}
						/>
						<RichText
							key={`slide-content-${index}`}
							identifier={`slide-content-${index}`}
							tagName="div"
							value={slide.content || ''}
							onChange={(value) => handleSlideChange(index, { ...slide, content: value })}
							placeholder={__('Enter content text...', 'side-tabs')}
							allowedFormats={['core/bold', 'core/italic']}
						/>
					</div>
					<div className='image-content'>
						<MediaUpload
							onSelect={(media) => handleSlideChange(index, { ...slide, image: media.url })}
							allowedTypes={['image']}
							render={({ open }) => (
								<button onClick={open}>
									{ slide.image ? <img src={slide.image} alt={slide.title} /> : __('Upload Image', 'header-slider') }
								</button>
							)}
							key={`slide-image-${index}`}
							identifier={`slide-image-${index}`}
						/>
					</div>
					<div className='label-content'>
						<RichText
							key={`slide-label-${index}`}
							identifier={`slide-label-${index}`}
							tagName="div"
							value={slide.slide_label || ''}
							onChange={(value) => handleLabelChange(index, value)}
							placeholder={__('Enter label text...', 'side-tabs')}
							allowedFormats={['core/bold', 'core/italic']}
						/>
						<div className='characters-remaining'>Characters remaining: {MAX_CHARACTERS - slide.slide_label.length}</div>
					</div>
				</div>
			)) }

			<button onClick={ addSlide }>
				{ __( 'Add Slide', 'header-slider' ) }
			</button>
		</div>
	);
}
