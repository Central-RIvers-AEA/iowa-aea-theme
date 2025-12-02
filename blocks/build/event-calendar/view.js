import * as __WEBPACK_EXTERNAL_MODULE__wordpress_interactivity_8e89b257__ from "@wordpress/interactivity";
/******/ var __webpack_modules__ = ({

/***/ "@wordpress/interactivity":
/*!*******************************************!*\
  !*** external "@wordpress/interactivity" ***!
  \*******************************************/
/***/ ((module) => {

module.exports = __WEBPACK_EXTERNAL_MODULE__wordpress_interactivity_8e89b257__;

/***/ })

/******/ });
/************************************************************************/
/******/ // The module cache
/******/ var __webpack_module_cache__ = {};
/******/ 
/******/ // The require function
/******/ function __webpack_require__(moduleId) {
/******/ 	// Check if module is in cache
/******/ 	var cachedModule = __webpack_module_cache__[moduleId];
/******/ 	if (cachedModule !== undefined) {
/******/ 		return cachedModule.exports;
/******/ 	}
/******/ 	// Create a new module (and put it into the cache)
/******/ 	var module = __webpack_module_cache__[moduleId] = {
/******/ 		// no module.id needed
/******/ 		// no module.loaded needed
/******/ 		exports: {}
/******/ 	};
/******/ 
/******/ 	// Execute the module function
/******/ 	__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 
/******/ 	// Return the exports of the module
/******/ 	return module.exports;
/******/ }
/******/ 
/************************************************************************/
/******/ /* webpack/runtime/make namespace object */
/******/ (() => {
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = (exports) => {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/ })();
/******/ 
/************************************************************************/
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other modules in the chunk.
(() => {
/*!************************************!*\
  !*** ./src/event-calendar/view.js ***!
  \************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_interactivity__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/interactivity */ "@wordpress/interactivity");

const formatDate = dateString => {
  let comfortDateString = `${dateString}T00:00:00`;
  const month = new Intl.DateTimeFormat('en-US', {
    month: 'short',
    timeZone: 'America/Chicago'
  }).format(new Date(comfortDateString));
  const day = new Intl.DateTimeFormat('en-US', {
    day: 'numeric',
    timeZone: 'America/Chicago'
  }).format(new Date(comfortDateString));
  const year = new Intl.DateTimeFormat('en-US', {
    year: 'numeric',
    timeZone: 'America/Chicago'
  }).format(new Date(comfortDateString));
  return `<small>${month}</small> <strong>${day}</strong> <small>${year}</small>`;
};
const formatTime = timeString => {
  if (timeString == 'All Day') {
    return 'All Day';
  }
  let [time, modifier] = timeString.split(' ');
  if (!modifier) {
    modifier = 'AM';
  }
  let [hours, minutes] = time.split(':');
  hours = parseInt(hours, 10);
  if (hours > 12) {
    hours = (hours - 12).toString();
    modifier = 'PM';
  }
  return `${hours}:${minutes} ${modifier}`;
};
const fetchGoogleCalendarEvents = async (start_date, end_date, google_calendar_ids, google_calendar_api_key) => {
  // Simulate fetching events from Google Calendar APIs
  let events = [];
  for (let i = 0; i < google_calendar_ids.length; i++) {
    let calendarID = google_calendar_ids[i];
    let calendarURL = `https://www.googleapis.com/calendar/v3/calendars/${calendarID}/events?key=${google_calendar_api_key}&timeMin=${start_date}T00:00:00Z&timeMax=${end_date}T23:59:59Z`;

    // Fetch events from Google Calendar API
    const response = await fetch(calendarURL);
    const data = await response.json();
    console.log(data.items);
    if (!data.items) {
      return;
    }
    data.items.forEach(gEvent => {
      let event = {
        id: gEvent.id,
        title: {
          rendered: gEvent.summary
        },
        event_date: gEvent.start.date || gEvent.start.dateTime.split('T')[0],
        event_time: gEvent.start.dateTime ? formatTime(gEvent.start.dateTime.split('T')[1]) : 'All Day',
        event_end_time: gEvent.end.dateTime ? formatTime(gEvent.end.dateTime.split('T')[1]) : '',
        details: gEvent.description || ''
      };
      events.push(event);
    });
  }

  // Convert Google Calendar events to local format
  return events;
};
const fetchEvents = async (google_calendar_ids, google_calendar_api_key) => {
  // fetch from events api

  let [year, month, day] = state.currentDate.split('-');
  let firstOfMonth = new Date(year, parseInt(month) - 1, parseInt(day));
  firstOfMonth.setDate(1);
  let lastOfMonth = new Date(year, parseInt(month) - 1, parseInt(day));
  lastOfMonth.setMonth(lastOfMonth.getMonth() + 1);
  lastOfMonth.setDate(0);
  let start_date = firstOfMonth.toISOString().split('T')[0];
  let end_date = lastOfMonth.toISOString().split('T')[0];
  const response = await fetch(`/wp-json/wp/v2/event?event_date_after=${start_date}&event_date_before=${end_date}`);
  const localEvents = await response.json();
  console.log(localEvents);
  let fixedEvents = localEvents.map(event => {
    return {
      ...event,
      details: event.content?.rendered
    };
  });

  // Fetch events from google calendar API
  const googleCalendarEvents = await fetchGoogleCalendarEvents(start_date, end_date, google_calendar_ids, google_calendar_api_key);
  const allEvents = [...fixedEvents, ...googleCalendarEvents];
  state.events = allEvents;
  state.events.sort((a, b) => new Date(a.event_date) - new Date(b.event_date));
};
const {
  state,
  actions,
  callbacks
} = (0,_wordpress_interactivity__WEBPACK_IMPORTED_MODULE_0__.store)('iowa-aea-theme/events-calendar', {
  state: {
    events: [],
    visibleEvents: 100,
    topEventId: null,
    currentDate: new Date().toISOString().split('T')[0],
    currentMonth: new Date().toISOString().split('T')[0].slice(5, 7)
  },
  actions: {
    loadEvents: async () => {
      let {
        google_calendar_ids,
        google_calendar_api_key
      } = (0,_wordpress_interactivity__WEBPACK_IMPORTED_MODULE_0__.getContext)();
      await fetchEvents(google_calendar_ids, google_calendar_api_key);
      if (state.topEventId === null) {
        let currentDate = state.currentDate;
        let firstOfDate = state.events.find(event => event.event_date === currentDate);
        state.topEventId = firstOfDate?.id || null;
      }
      actions.updateEventsView();
    },
    updateEventsView: () => {
      let eventsList = document.querySelector('.event-calendar-list');
      if (!eventsList) return;

      // Load all_events
      let events = state.events;
      let params = new URLSearchParams(location.search);
      if (params.has('date')) {
        events = events.filter(event => event.event_date === params.get('date'));
      }
      eventsList.innerHTML = events.map((event, index) => `
        <div class='event-calendar-list-item' 
             ${event.details ? `role='button' aria-expanded='false' tabindex='0' aria-describedby='event-details-${event.id}' aria-label='${event.title.rendered}, ${formatTime(event.event_time)} on ${formatDate(event.event_date).replace(/<[^>]*>/g, '')}. Press Enter or Space to view details.'` : `role='article' aria-label='${event.title.rendered}, ${formatTime(event.event_time)} on ${formatDate(event.event_date).replace(/<[^>]*>/g, '')}'`}>
          <div class='event-calendar-list-item-date' aria-hidden='true'>${formatDate(event.event_date)}</div>
          <div class='event-calendar-list-item-details'>
            <strong class='event-calendar-list-item-title'>${event.title.rendered}</strong>
            <span class='event-calendar-list-item-time'>${formatTime(event.event_time)}</span>
            ${event.event_end_time ? `- <span class='event-calendar-list-item-end-time'>${formatTime(event.event_end_time)}</span>` : ''}
            ${event.registration_link ? `<br /><a href='${event.registration_link}' class='event-calendar-list-item-registration' aria-label='Register for ${event.title.rendered}'>Registration Link</a>` : ''}
          </div>
          ${event.details ? `<div class='event-calendar-list-item-details-long' id='event-details-${event.id}' role='region' aria-label='Event details for ${event.title.rendered}'>${event.details}</div>` : ''}
        </div>
      `).join('');
      if (state.events.length == 0) {
        eventsList.innerHTML = '<div class="event-calendar-list-item">No events found</div>';
      }
      eventsList.querySelectorAll('.event-calendar-list-item').forEach(item => {
        // Only add interaction for items with details
        if (item.getAttribute('role') === 'button') {
          const handleToggle = () => {
            const isExpanded = item.getAttribute('aria-expanded') === 'true';
            const newState = !isExpanded;
            item.setAttribute('aria-expanded', newState.toString());

            // Announce state change to screen readers
            const eventTitle = item.querySelector('.event-calendar-list-item-title').textContent;
            const announcement = newState ? `${eventTitle} details expanded` : `${eventTitle} details collapsed`;

            // Create temporary live region for announcement
            const announcement_el = document.createElement('div');
            announcement_el.setAttribute('aria-live', 'polite');
            announcement_el.setAttribute('aria-atomic', 'true');
            announcement_el.className = 'sr-only';
            announcement_el.textContent = announcement;
            document.body.appendChild(announcement_el);
            setTimeout(() => {
              document.body.removeChild(announcement_el);
            }, 1000);
          };

          // Click handler
          item.addEventListener('click', handleToggle);

          // Keyboard handler
          item.addEventListener('keydown', e => {
            // Enter or Space to toggle
            if ((e.key === 'Enter' || e.key === ' ') && e.target === item) {
              e.preventDefault();
              handleToggle();
            }
            // Escape to collapse if expanded
            else if (e.key === 'Escape' && item.getAttribute('aria-expanded') === 'true') {
              item.setAttribute('aria-expanded', 'false');
              item.focus(); // Maintain focus
            }
          });
        }
      });
      actions.loadCalendar();
    },
    loadCalendar: () => {
      let [year, month, day] = state.currentDate.split('-');
      let firstOfMonth = new Date(year, parseInt(month) - 1, parseInt(day));
      firstOfMonth.setDate(1);
      let lastOfMonth = new Date(year, parseInt(month) - 1, parseInt(day));
      lastOfMonth.setMonth(lastOfMonth.getMonth() + 1);
      lastOfMonth.setDate(0);
      let firstDayOfWeek = lastOfMonth.getDay();
      let days = [];
      for (let i = 1; i < firstDayOfWeek - 1; i++) {
        days.push(null);
      }
      for (let i = 1; i <= lastOfMonth.getDate(); i++) {
        days.push(i);
      }
      for (let i = 1; i < days.length % 7; i++) {
        days.push(null);
      }

      // Generate Calendar
      let calendar = document.querySelector('.event-calendar');
      if (!calendar) return;
      let calendarHeader = calendar.querySelector('.event-calendar-header h3');
      calendarHeader.innerHTML = `${firstOfMonth.toLocaleString('default', {
        month: 'long'
      })} ${firstOfMonth.getFullYear()}`;
      let calendarDays = calendar.querySelector('.event-calendar-days');
      calendarDays.innerHTML = `
        <div class='calendar-header' role='columnheader'>Sun</div>
        <div class='calendar-header' role='columnheader'>Mon</div>
        <div class='calendar-header' role='columnheader'>Tue</div>
        <div class='calendar-header' role='columnheader'>Wed</div>
        <div class='calendar-header' role='columnheader'>Thu</div>
        <div class='calendar-header' role='columnheader'>Fri</div>
        <div class='calendar-header' role='columnheader'>Sat</div>
      `;
      days.forEach((day, index) => {
        let dayEl = document.createElement('div');
        dayEl.classList.add('event-calendar-day');
        dayEl.setAttribute('role', 'gridcell');
        if (day) {
          let date = new Date(state.currentDate + 'T00:00:00');
          date.setDate(day);
          const formattedDate = date.toISOString().split('T')[0];
          const dayOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][date.getDay()];

          // Check for events
          let eventsForDay = state.events.filter(event => new Date(`${event.event_date}T00:00:00`).toLocaleString() === date.toLocaleString());
          if (eventsForDay.length > 0) {
            dayEl.innerHTML = `<a href='/events?date=${formattedDate}' 
                                  class='event-calendar-day-link' 
                                  aria-label='${dayOfWeek}, ${firstOfMonth.toLocaleString('default', {
              month: 'long'
            })} ${day}, ${firstOfMonth.getFullYear()}. ${eventsForDay.length} event${eventsForDay.length > 1 ? 's' : ''} scheduled.'
                                  tabindex='0'>${day}</a>`;
            dayEl.classList.add('has-events');
          } else {
            dayEl.innerHTML = day;
            dayEl.setAttribute('aria-label', `${dayOfWeek}, ${firstOfMonth.toLocaleString('default', {
              month: 'long'
            })} ${day}, ${firstOfMonth.getFullYear()}`);
          }
        } else {
          dayEl.innerHTML = '';
          dayEl.setAttribute('aria-hidden', 'true');
        }
        calendarDays.appendChild(dayEl);
      });
      calendar.appendChild(calendarDays);
    },
    nextMonth: () => {
      let currentDate = new Date(state.currentDate);
      currentDate.setMonth(currentDate.getMonth() + 1);
      state.currentDate = currentDate.toISOString().split('T')[0];
      actions.loadEvents();
    },
    previousMonth: () => {
      let currentDate = new Date(state.currentDate);
      currentDate.setMonth(currentDate.getMonth() - 1);
      state.currentDate = currentDate.toISOString().split('T')[0];
      actions.loadEvents();
    }
  },
  callbacks: {
    scrollEvents: () => {
      state.topEventId = state.events[state.events.map(event => event.id).indexOf(state.topEventId) + 1]?.id || null;
      if (state.events.map(event => event.id).indexOf(state.topEventId) > state.events.length - state.visibleEvents) {
        state.topEventId = state.events[state.events.length - state.visibleEvents]?.id || null;
      } else {
        actions.updateEventsView();
      }
      if (state.events.map(event => event.id).indexOf(state.topEventId) > state.events.length - state.visibleEvents - 1) {
        state.currentDate = new Date(new Date(state.currentDate).setDate(new Date(state.currentDate).getDate() + 1)).toISOString().split('T')[0];
        actions.loadEvents();
      }

      // set button states
      document.querySelector('.load-previous').disabled = false;
    },
    scrollBackEvents: () => {
      state.topEventId = state.events[state.events.map(event => event.id).indexOf(state.topEventId) - 1]?.id || state.events[0]?.id;
      actions.updateEventsView();

      // set button states
      if (state.events[0]?.id === state.topEventId) {
        document.querySelector('.load-previous').disabled = true;
      }
    },
    resetEvents: () => {
      state.topEventId = null;
      actions.loadEvents();
    }
  },
  init: {
    setup: () => {
      console.log('Events List block initialized');
    }
  }
});
})();


//# sourceMappingURL=view.js.map