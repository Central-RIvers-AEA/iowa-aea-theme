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
/*!********************************************!*\
  !*** ./src/staff-directory-search/view.js ***!
  \********************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_interactivity__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/interactivity */ "@wordpress/interactivity");

const {
  actions
} = (0,_wordpress_interactivity__WEBPACK_IMPORTED_MODULE_0__.store)('iowa-aea-theme/staff-directory-search', {
  actions: {
    searchStaff: e => {
      e.preventDefault();
      let context = (0,_wordpress_interactivity__WEBPACK_IMPORTED_MODULE_0__.getContext)();
      let formData = new FormData(e.target);
      let query = formData.get('staff-name');
      let district = formData.get('district');
      let building = formData.get('building');
      let area = formData.get('area');
      let queryObj = {};
      if (query) queryObj.search = query;
      if (district) queryObj.district = district;
      if (building) queryObj.building = building;
      if (area) queryObj.area = area;
      let queryString = new URLSearchParams(queryObj).toString();

      // Query Employee Endpoint
      fetch(`${context.staffEndpoint}?${queryString}`).then(response => response.json()).then(data => {
        console.log(data);
        context.staff = data;
      });
    },
    filterBuildings: () => {
      let context = (0,_wordpress_interactivity__WEBPACK_IMPORTED_MODULE_0__.getContext)();
      let districtSelect = (0,_wordpress_interactivity__WEBPACK_IMPORTED_MODULE_0__.getElement)();
      let district = districtSelect.ref.value;

      // Clear existing options
      let form = districtSelect.ref.closest('form');
      let buildingSelect = form.querySelector('select[name="school-building"]');
      buildingSelect.innerHTML = '<option value="">Select a District to view Buildings</option>';
      let buildings = context.buildings.filter(building => building.district_id == district);
      if (district) {
        buildings.forEach(building => {
          let option = document.createElement('option');
          option.value = building.id;
          option.textContent = building.name;
          buildingSelect.appendChild(option);
        });
        buildingSelect.disabled = false;
      } else {
        buildingSelect.innerHTML = '<option value="">Select a Building</option>';
        buildingSelect.disabled = true;
      }
    },
    filterStaff: () => {
      let context = (0,_wordpress_interactivity__WEBPACK_IMPORTED_MODULE_0__.getContext)();
      let form = (0,_wordpress_interactivity__WEBPACK_IMPORTED_MODULE_0__.getElement)();
      let query = form.ref.querySelector('input[name="staff-name"]').value;
      let district = form.ref.querySelector('select[name="school-district"]').value;
      let building = form.ref.querySelector('select[name="school-building"]').value;
      let area = form.ref.querySelector('select[name="content-area"]').value;
      let position = form.ref.querySelector('select[name="position"]').value;
      let filteredStaff = context.staff.filter(member => {
        let assignments = Object.keys(member.assignments).map(key => member.assignments[key]);
        return (!query || member.full_name.toLowerCase().includes(query.toLowerCase())) && (!district || assignments.some(assignment => assignment.district == district)) && (!building || assignments.some(assignment => assignment.building == building)) && (!area || assignments.some(assignment => assignment.content_area == area)) && (!position || member.position == position);
      });
      return filteredStaff;
    }
  },
  callbacks: {
    renderStaffList: () => {
      let context = (0,_wordpress_interactivity__WEBPACK_IMPORTED_MODULE_0__.getContext)();
      let staffList = document.querySelector('.staff-directory-results ul');
      staffList.innerHTML = '';
      let filteredStaff = actions.filterStaff();
      let sortedStaff = sortByAssignmentPriority(filteredStaff);
      sortedStaff.forEach(member => {
        // Render each staff member
        let li = document.createElement('li');
        let staffMemberTemplate = `
          <div class='staff-member'>
            <figure class='staff-image'>
              <img src='${member.image}' width='135' height='154' alt='${member.full_name}' />
            </figure>
            <div class='staff-info'>
              <h3 class='staff-name'>${member.full_name}</h3>
              <div class='staff-position'>${member.position}</div>
              <div class='staff-email'>${member.email}</div>
              <div class='staff-phone'>${member.phone}</div>
            </div>
          </div>
        `;
        li.innerHTML = staffMemberTemplate;
        staffList.appendChild(li);
      });
    },
    fillFormOptions: () => {
      let context = (0,_wordpress_interactivity__WEBPACK_IMPORTED_MODULE_0__.getContext)();
      let form = (0,_wordpress_interactivity__WEBPACK_IMPORTED_MODULE_0__.getElement)();
      context.districts.forEach(district => {
        let option = document.createElement('option');
        option.value = district.id;
        option.textContent = district.name;
        form.ref.querySelector('select[name="school-district"]').appendChild(option);
      });
      context.positions.sort().forEach(position => {
        if (position.trim() != '') {
          let option = document.createElement('option');
          option.innerText = position.trim();
          form.ref.querySelector('select[name="position"]').appendChild(option);
        }
      });
      context.contentAreas.sort().forEach(area => {
        if (area.trim() != '') {
          let option = document.createElement('option');
          option.innerText = area.trim();
          form.ref.querySelector('select[name="content-area"]').appendChild(option);
        }
      });
    }
  }
});
function sortByAssignmentPriority(staff) {
  console.log(staff);
  let districtSelect = document.querySelector('#school-district');
  let buildingSelect = document.querySelector('#school-building');
  let contentAreaSelect = document.querySelector('#content-area');
  let adjustedItems = staff.map(item => {
    let newItem = {
      ...item
    };
    newItem.assignments_array = [];
    if (newItem.assignments) {
      Object.keys(newItem.assignments).forEach(assignment => {
        newItem.assignments_array.push(newItem.assignments[assignment]);
      });
    }
    return newItem;
  });
  console.log(adjustedItems);
  let sortedItems = adjustedItems.sort((itemA, itemB) => {
    if (districtSelect.value != '') {
      let assignmentA = itemA.assignments_array.find(assignment => assignment.district == districtSelect.value);
      let assignmentB = itemB.assignments_array.find(assignment => assignment.district == districtSelect.value);
      if (assignmentA.search_priority == '') {
        assignmentA.search_priority = 100;
      }
      if (assignmentB.search_priority == '') {
        assignmentB.search_priority = 100;
      }
      return assignmentA.search_priority - assignmentB.search_priority || itemA.last_name.localeCompare(itemB.last_name);
    } else {
      return 0;
    }
  });
  console.log(sortedItems);
  console.log('sorted');
  return sortedItems;
}
})();


//# sourceMappingURL=view.js.map