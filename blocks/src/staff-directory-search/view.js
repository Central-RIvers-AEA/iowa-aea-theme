import { store, getContext, getElement } from '@wordpress/interactivity';


const { actions, callbacks } = store( 'iowa-aea-theme/staff-directory-search', {
  actions: {
    searchStaff: (e) => {
      e.preventDefault();

      let context = getContext();

      context.loading = true;

      let formData = new FormData(e.target);
      
      let queryObj = {}
      
      let query = formData.get('staff-name');
      if(query) queryObj.search = query;

      let contentArea = formData.get('content-area')
      if(contentArea) queryObj.content_area = contentArea

      let position = formData.get('position')
      if(position) queryObj.position = position

      let district = formData.get('school-district')
      if(district) queryObj.district = district

      let building = formData.get('school-building')
      if(building) queryObj.building = building

      let queryString = new URLSearchParams(queryObj).toString();

      console.log(queryString)

      let staffList = document.querySelector('.staff-directory-results ul');
      staffList.innerHTML = '';

      // Query Employee Endpoint
      fetch(`${context.staffEndpoint}?${queryString}`)
        .then(response => response.json())
        .then(data => {
          context.staff = data;
          context.loading = false;
        });
    },
    filterBuildings: () => {
      let context = getContext();
      let districtSelect = getElement();

      let district = districtSelect.ref.value;

      // Clear existing options
      let form = districtSelect.ref.closest('form');
      let buildingSelect = form.querySelector('select[name="school-building"]');
      
      let buildings = context.buildings.filter(building => building.district_id == district)
      
      if(district) {
        buildingSelect.innerHTML = '<option value="">Select a Building</option>';
        buildings.forEach(building => {
          let option = document.createElement('option');
          option.value = building.id;
          option.textContent = building.name;
          buildingSelect.appendChild(option);
        });
        buildingSelect.disabled = false;
      } else {
        buildingSelect.innerHTML = '<option value="">Select a District to view Buildings</option>';
        buildingSelect.disabled = true;
      }
    },
    filterStaff: () => {
      let context = getContext();
      let form = getElement();

      context.loading = true;

      let query = form.ref.querySelector('input[name="staff-name"]').value;
      let district = form.ref.querySelector('select[name="school-district"]').value;
      let building = form.ref.querySelector('select[name="school-building"]').value;
      let area = form.ref.querySelector('select[name="content-area"]').value;
      let position = form.ref.querySelector('select[name="position"]').value;


      let filteredStaff = context.staff.filter(member => {
        let assignments = Object.keys(member.assignments).map(key => member.assignments[key]);

        return (!query || member.full_name.toLowerCase().includes(query.toLowerCase())) &&
               (!district || assignments.some(assignment => assignment.district == district)) &&
               (!building || assignments.some(assignment => assignment.building == building)) &&
               (!area || assignments.some(assignment => assignment.content_area == area)) &&
               (!position || member.position == position)
      });

      // limit to 10 results if no filters are applied
      if(!query && !district && !building && !area && !position) {
        filteredStaff = filteredStaff.slice(0, 10);
      }

      return filteredStaff;
    },
    formReset: (e) => {
      e.preventDefault();

      let form = e.target.closest('form');
      form.reset();
      
      // Reset building select
      let buildingSelect = form.querySelector('select[name="school-building"]');
      buildingSelect.innerHTML = '<option value="">Select a District to view Buildings</option>';
      buildingSelect.disabled = true;
    }
  },
  callbacks: {
    renderStaffList: () => {
      let context = getContext();

      let staffList = document.querySelector('.staff-directory-results ul');
      staffList.innerHTML = '';

      let filteredStaff = context.staff

      let sortedStaff = sortByAssignmentPriority(filteredStaff);

      sortedStaff.forEach( member => {
        // Render each staff member
        let li = document.createElement('li');
        let staffMemberTemplate = `
          <div class='staff-member'>
            <figure class='staff-image'>
              <img src='${ member.image }' width='135' height='154' alt='${ member.full_name }' />
            </figure>
            <div class='staff-info'>
              <h3 class='staff-name'>${member.full_name}</h3>
              <div class='staff-position'>${member.position}</div>
              <div class='staff-email'>${member.email}</div>
              <div class='staff-phone'>${member.phone}</div>
            </div>
          </div>
        `

        li.innerHTML = staffMemberTemplate;

        staffList.appendChild(li);
      });

      if(sortedStaff.length === 0 && !context.loading) {
        let li = document.createElement('li');
        li.innerHTML = `<p>No staff members found matching your criteria. Please try adjusting your search.</p>`;
        staffList.appendChild(li);
      }
    },
    fillFormOptions: () => {
      let context = getContext();
      context.loading = true;

      let form = getElement();

      context.districts.forEach(district => {
        let option = document.createElement('option');
        option.value = district.id;
        option.textContent = district.name;
        form.ref.querySelector('select[name="school-district"]').appendChild(option);
      });
      
      context.positions.sort().forEach(position => {
        if(typeof position == 'object'){
          let option = document.createElement('option');
          option.value = position.name;
          option.innerText = position.name;
          form.ref.querySelector('select[name="position"]').appendChild(option);

        } else if(position.trim() != '') {
          let option = document.createElement('option');
          option.innerText = position.trim();
          form.ref.querySelector('select[name="position"]').appendChild(option);
        }
      })

      context.contentAreas.sort().forEach(area => {
        if(typeof area == 'object'){
          let option = document.createElement('option');
          option.value = area.id;
          option.innerText = area.name;
          form.ref.querySelector('select[name="content-area"]').appendChild(option);

        } else if(area.trim() != '') {
          let option = document.createElement('option');
          option.innerText = area.trim();
          form.ref.querySelector('select[name="content-area"]').appendChild(option);
        }
      })
    },
    loadStaffData: () => {
      let context = getContext();

      context.loading = true;
      
      // Initial fetch of all staff
      fetch(`${context.staffEndpoint}`)
        .then(response => response.json())
        .then(data => {
          context.staff = data;
        })
        .finally(() => {
          context.loading = false;
        });
    }
  }
});

function sortByAssignmentPriority(staff){
  let districtSelect = document.querySelector('#school-district')
  let buildingSelect = document.querySelector('#school-building')
  let contentAreaSelect = document.querySelector('#content-area')

  let adjustedItems = staff.map(item => {
    let newItem = {...item}
    newItem.assignments_array = []

    if(newItem.assignments) {
      Object.keys(newItem.assignments).forEach(assignment => {
        newItem.assignments_array.push(newItem.assignments[assignment])
      })
    }

    return newItem
  })

  let sortedItems = adjustedItems.sort((itemA, itemB) => {
    if(districtSelect.value != ''){
      let assignmentA = itemA.assignments_array.find((assignment) => assignment.district == districtSelect.value)
      let assignmentB = itemB.assignments_array.find((assignment) => assignment.district == districtSelect.value)
  
      if(!Object.hasOwnProperty(assignmentA, 'search_priority') || assignmentA.search_priority == ''){ assignmentA = {...assignmentA, search_priority: 100} }
      if(!Object.hasOwnProperty(assignmentB, 'search_priority') || assignmentB.search_priority == ''){ assignmentB = {...assignmentB, search_priority: 100} }

      return assignmentA.search_priority - assignmentB.search_priority || itemA.last_name.localeCompare(itemB.last_name)
      
    } else {
      return 0;
    }
  })

  return sortedItems
}