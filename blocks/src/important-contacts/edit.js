/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

import { useEffect, useState } from '@wordpress/element'
import apiFetch from '@wordpress/api-fetch';

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
export default function Edit(props) {
	const [full_contacts_list, setFullContactsList] = useState([]);
	let contacts = props.attributes.contacts || [];

	const addImportantContact = () => {
		// Logic to add an important contact
		console.log('adding contact')
		let updatedContacts = [...contacts];
		updatedContacts.push({ id: Date.now(), name: 'Select a Contact', email: 'new.contact@example.com', phone: '123-456-7890', jobTitle: 'New Job Title', image: '' });

		props.setAttributes({ contacts: updatedContacts });
	};

	const removeImportantContact = ( index ) => {
		let updatedContacts = contacts.filter( ( contact, conIndex ) => conIndex !== index );
		props.setAttributes({ contacts: updatedContacts });
	};

	// on mount query existing contacts
	useEffect( () => {
		// Use WordPress apiFetch which handles authentication automatically
		apiFetch( { path: '/staff-directory/v1/employees' } )
			.then( ( data ) => {
				setFullContactsList( data );
				console.log('Fetched staff data:', data);
			} )
			.catch( ( error ) => {
				console.error( 'Error fetching staff directory:', error );
				// Fallback: if staff directory isn't available, continue without it
				setFullContactsList([]);
			} );	
	}, [] );

	const handleContactChange = ( index, newContactId ) => {
		let updatedContacts = contacts.map( ( contact, conIndex ) => {
			if ( conIndex == index) {
				let newContact = full_contacts_list.find( ( c ) => c.id == newContactId );
				return { ...newContact };
			}
			return contact;
		} );
		props.setAttributes({ contacts: updatedContacts });
	};

	return (
		<div { ...useBlockProps() }>
			<h2>{ __( 'Important Contacts', 'important-contacts' ) }</h2>
			<div className='contacts-block'>
				{ contacts.map( ( contact, index ) => (
					<div key={ index } className="contact-item">
						<img src={ contact.image } alt={ contact.name } />
						<div className="contact-info">
							<h3>
								<select onChange={ (e) => handleContactChange( index, e.target.value ) }>
									<option value=''>Select a Contact</option>
									{ full_contacts_list.map( ( full_contact ) => (
										<option key={ full_contact.id } value={ full_contact.id } selected={ full_contact.id === contact.id }>
											{ full_contact.name }
										</option>
									) ) }
								</select>
							</h3>
							<p>{ contact.jobTitle }</p>
							<p>{ contact.email }</p>
							<p>{ contact.phone }</p>
							<button onClick={ () => removeImportantContact( index ) } className='btn'>
								{ __( 'Remove', 'important-contacts' ) }
							</button>
							
						</div>
					</div>
				) ) }
			</div>
			<button onClick={ addImportantContact } className='btn'>
				{ __( 'Add Important Contact', 'important-contacts' ) }
			</button>
		</div>
	);
}
