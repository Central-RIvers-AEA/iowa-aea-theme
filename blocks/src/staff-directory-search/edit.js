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
import { useBlockProps } from '@wordpress/block-editor';

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
export default function Edit() {

	const staff = [
		{ id: 1, name: 'John Doe', position: 'Manager', email: 'john@example.com', image: '/wp-content/themes/iowa-aea-theme/assets/images/default-profile.png', job_title: 'Head of Department', phone: '123-456-7890' },
		{ id: 2, name: 'Jane Smith', position: 'Developer', email: 'jane@example.com', image: '/wp-content/themes/iowa-aea-theme/assets/images/default-profile.png', job_title: 'Senior Developer', phone: '123-456-7891' },
		{ id: 3, name: 'Alice Johnson', position: 'Designer', email: 'alice@example.com', image: '/wp-content/themes/iowa-aea-theme/assets/images/default-profile.png', job_title: 'Lead Designer', phone: '123-456-7892' }
	];

	return (
		<div { ...useBlockProps() }>
			<div className='staff-directory-search'>
				<div className='staff-directory-search-input'>
					<label>Name</label>
					<input type='text' placeholder={ __( 'Search staff...', 'iowa-aea-theme' ) } disabled/>
				</div>

				<div className='staff-directory-search-input'>
					<label>School District</label>
					<select disabled>
						<option value=''>Select a School District...</option>
					</select>
				</div>

				<div className='staff-directory-search-input'>
					<label>School Building</label>
					<select disabled>
						<option value=''>Select a School Building...</option>
					</select>
				</div>

				<div className='staff-directory-search-input'>
					<label>Content Area</label>
					<select disabled>
						<option value=''>Select a Content Area...</option>
					</select>
				</div>

				<div className='staff-directory-search-input'>
					<label>Position</label>
					<select disabled>
						<option value=''>Select a Position...</option>
					</select>
				</div>

				<button type='button' className='staff-directory-search-btn staff-directory-search-submit' disabled>Submit</button>
				<button type='button' className='staff-directory-search-btn staff-directory-search-reset' disabled>Reset</button>
			</div>

			<div className='staff-directory-results'>
				<ul>
					{ staff.map( member => (
						<li key={ member.id }>
							<div className='staff-member'>
								<img src={ member.image } alt={ member.name } className='staff-image' />
								<div className='staff-info'>
									<h3 className='staff-name'>{ member.name }</h3>
									<div className='staff-position'>{ member.position }</div>
									<div className='staff-email'>{ member.email }</div>
									<div className='staff-phone'>{ member.phone }</div>
								</div>
							</div>
						</li>
					) ) }
				</ul>
			</div>
		</div>
	);
}
