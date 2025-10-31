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
/*!*********************************!*\
  !*** ./src/events-list/view.js ***!
  \*********************************/
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
const fetchGoogleCalendarEvents = async (start_date, end_date) => {
  // Simulate fetching events from Google Calendar API
  let calendarIDs = state.calendarIDs;
  let apiKey = state.apiKey;
  let events = [];
  if (!calendarIDs.length || !apiKey) {
    return [];
  }

  // For simplicity, fetch from the first calendar ID only
  let calendarID = calendarIDs[0];
  try {
    let calendarURL = `https://www.googleapis.com/calendar/v3/calendars/${calendarID}/events?key=${apiKey}&timeMin=${start_date}T00:00:00Z&timeMax=${end_date}T23:59:59Z`;

    // Fetch events from Google Calendar API
    const response = await fetch(calendarURL);
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    const data = await response.json();

    // Convert Google Calendar events to local format
    events = data.items.map(gEvent => {
      let event = {
        id: gEvent.id,
        title: {
          rendered: gEvent.summary
        },
        event_date: gEvent.start.date || gEvent.start.dateTime.split('T')[0],
        event_time: gEvent.start.dateTime ? formatTime(gEvent.start.dateTime.split('T')[1]) : 'All Day'
      };
      return event;
    });
  } catch (error) {
    console.error('Error fetching Google Calendar events:', error);
    return events;
  }
  return events;
};
const fetchEvents = async () => {
  // fetch from events api
  let firstOfLastMonth = new Date(state.currentDate);
  firstOfLastMonth.setDate(1);
  firstOfLastMonth.setMonth(firstOfLastMonth.getMonth() - 1);
  let lastOfNextMonth = new Date(state.currentDate);
  lastOfNextMonth.setMonth(lastOfNextMonth.getMonth() + 1);
  lastOfNextMonth.setDate(0);
  let start_date = firstOfLastMonth.toISOString().split('T')[0];
  let end_date = lastOfNextMonth.toISOString().split('T')[0];
  const response = await fetch(`/wp-json/wp/v2/event?start_date=${start_date}&end_date=${end_date}`);
  const localEvents = await response.json();

  // Fetch events from google calendar API
  const googleCalendarEvents = await fetchGoogleCalendarEvents(start_date, end_date);
  const allEvents = [...localEvents, ...googleCalendarEvents];
  allEvents.forEach(event => {
    if (!state.events.find(e => e.id === event.id)) {
      state.events.push(event);
    }
  });
  state.events.sort((a, b) => new Date(a.event_date) - new Date(b.event_date));
};
const {
  state,
  actions,
  callbacks
} = (0,_wordpress_interactivity__WEBPACK_IMPORTED_MODULE_0__.store)('iowa-aea-theme/events-list', {
  state: {
    events: [],
    visibleEvents: 3,
    topEventId: null,
    currentDate: new Date().toISOString().split('T')[0],
    currentMonth: new Date().toISOString().split('T')[0].slice(0, 7),
    apiKey: '',
    calendarIDs: []
  },
  actions: {
    loadEvents: async () => {
      let context = (0,_wordpress_interactivity__WEBPACK_IMPORTED_MODULE_0__.getContext)();
      state.apiKey = context.apiKey || '';
      state.calendarIDs = context.calendarIds || [];
      await fetchEvents();
      if (state.topEventId === null) {
        let currentDate = state.currentDate;
        let firstOfDate = state.events.find(event => event.event_date === currentDate);
        state.topEventId = firstOfDate?.id || state.events.find(event => event.event_date >= currentDate)?.id;
      }
      actions.updateEventsView();
    },
    updateEventsView: () => {
      let eventsList = document.querySelector('.events-list');
      if (!eventsList) return;

      // Load chunk of events
      let chunkStart = state.events.map(event => event.id).indexOf(state.topEventId);
      const chunk = state.events.slice(chunkStart, chunkStart + state.visibleEvents);
      eventsList.innerHTML = chunk.map(event => `
        <li>
          <div class='event-item'>
            <div class='event-date'>${formatDate(event.event_date)}</div>
            <div class='event-details'>
              <strong class='event-title'>${event.title.rendered}</strong>
              <span class='event-time'>${formatTime(event.event_time)}</span>
              </div>
          </div>
        </li>
      `).join('');
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
  init: {}
});
})();


//# sourceMappingURL=view.js.map