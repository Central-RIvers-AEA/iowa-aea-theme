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
	const sections = props.attributes.sections || [];

	const addSection = () => {
		const newSections = [
			...sections,
			{ 
				title: `Section ${sections.length + 1}`, 
				content: `Content for section ${sections.length + 1}` 
			}
		];
		props.setAttributes({ sections: newSections });
	};

	const updateSection = ( index, newContent ) => {
		const newSections = sections.map( ( section, i ) => {
			if ( i === index ) {
				return { ...section, ...newContent };
			}
			return section;
		} );
		props.setAttributes({ sections: newSections });
	};

	const removeSection = ( index ) => {
		const newSections = sections.filter( ( _, i ) => i !== index );
		props.setAttributes({ sections: newSections });
	};

	return (
			<div class='accordion-holder'>
				<div { ...useBlockProps() } >
					{ sections.map( ( section, index ) => (
						<div key={ index } className="accordion-section">
							<RichText
								identifier={`section-title-${index}`}
								tagName="h3"
								className={`section-header-${index}`}
								value={section.title}
								onChange={(value) => updateSection(index, { ...section, title: value })}
								placeholder={__('Enter heading text...', 'accordion')}
								allowedFormats={['core/italic']}
							/>
							<RichText
								identifier={`section-body-${index}`}
								tagName="p"
								className={`section-content-${index}`}
								value={section.content}
								onChange={(value) => updateSection(index, { ...section, content: value })}
								placeholder={__('Enter content text...', 'accordion')}
								allowedFormats={['core/italic', 'core/bold', 'core/link']}
							/>
							<button type='button' onClick={() => removeSection(index)} className='btn'>Remove Section</button>
						</div>
					) ) }
				</div>
				<button type='button' className='btn' onClick={ addSection }>Add Section</button>
			</div>
	);
}
