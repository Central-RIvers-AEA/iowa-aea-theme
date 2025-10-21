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
		{ id: 2, title: 'Event 2', date: '2023-09-13', time: '11:00 AM' },
		{ id: 3, title: 'Event 3', date: '2023-09-17', time: '12:00 PM' }
	];

	const formatDate = ( dateString ) => {
		const month = new Intl.DateTimeFormat( 'en-US', { month: 'short' } ).format( new Date( dateString ) );
		const day = new Intl.DateTimeFormat( 'en-US', { day: 'numeric' } ).format( new Date( dateString ) );
		const year = new Intl.DateTimeFormat( 'en-US', { year: 'numeric' } ).format( new Date( dateString ) );
		return <><small>{month}</small> <strong>{day}</strong> <small>{year}</small></>;
	};

	const generateCalendarDays = () => {
		const days = [];
		for ( let i = 1; i <= 30; i++ ) {
			days.push( { day: i, events: events.filter( event => new Date( event.date ).getDate() === i ) } );
		}
		return days;
	};

	return (
		<div { ...useBlockProps() }>
			<div className="event-calendar-list">
				{ events.map( event => (
					<div key={ event.id } className="event-calendar-list-item">
						<div className="event-calendar-list-item-date">{ formatDate( event.date ) }</div>
						<div className="event-calendar-list-item-details">
							<strong className="event-calendar-list-item-title">{ event.title }</strong>
							<span className="event-calendar-list-item-time">{ event.time }</span>
						</div>
					</div>
				) ) }
			</div>
			<div className="event-calendar">
				<div className="event-calendar-header">
					<button>Previous</button>
					<h3>Sept 2023</h3>
					<button>Next</button>
				</div>
				<div className="event-calendar-days">
					<div className='calendar-header'>Sun</div>
					<div className='calendar-header'>Mon</div>
					<div className='calendar-header'>Tue</div>
					<div className='calendar-header'>Wed</div>
					<div className='calendar-header'>Thu</div>
					<div className='calendar-header'>Fri</div>
					<div className='calendar-header'>Sat</div>
					{ generateCalendarDays().map( day => (
						<div key={ day.day } className={`event-calendar-day ${day.events.length > 0 ? 'has-events' : ''}`}>
							<div className='event-calendar-day-number'>{ day.day }</div>
						</div>
					) ) }
					<div className="event-calendar-day"></div>
					<div className="event-calendar-day"></div>
					<div className="event-calendar-day"></div>
					<div className="event-calendar-day"></div>
					<div className="event-calendar-day"></div>
				</div>
			</div>
		</div>
	);
}
