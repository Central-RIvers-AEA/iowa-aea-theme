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

	const events = [
		{ id: 1, title: 'Event 1', date: '2023-09-01', time: '10:00 AM' },
		{ id: 2, title: 'Event 2', date: '2023-09-02', time: '11:00 AM' },
		{ id: 3, title: 'Event 3', date: '2023-09-03', time: '12:00 PM' }
	];

	const formatDate = ( dateString ) => {
		const month = new Intl.DateTimeFormat( 'en-US', { month: 'short' } ).format( new Date( dateString ) );
		const day = new Intl.DateTimeFormat( 'en-US', { day: 'numeric' } ).format( new Date( dateString ) );
		const year = new Intl.DateTimeFormat( 'en-US', { year: 'numeric' } ).format( new Date( dateString ) );
		return <><small>{month}</small> <strong>{day}</strong> <small>{year}</small></>;
	};

	return (
		<div { ...useBlockProps() }>
			<ul>
				{ events.map( event => (
					<li key={ event.id }>
						<div className='event-item'>
							<div className='event-date'>{ formatDate( event.date ) }</div>
							<div className='event-details'>
								<strong className='event-title'>{ event.title }</strong>
								<span className='event-time'>{ event.time }</span>
								</div>
						</div>
					</li>
				) ) }
			</ul>
		</div>
	);
}
