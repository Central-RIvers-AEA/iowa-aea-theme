import { store, getContext, getElement } from '@wordpress/interactivity';


const { actions, callbacks } = store( 'iowa-aea-theme/staff-directory-search', {
  actions: {
    searchStaff: (e) => {
      e.preventDefault();

      let context = getContext();

      context.loading = true;

      let formData = new FormData(e.target);
      
      const url = new URL(window.location.href);

      url.searchParams.delete('currentPage')
      
      let query = formData.get('staff-name');
      if(query) {
        url.searchParams.has('search') ? url.searchParams.set('search', query) : url.searchParams.append('search', query)
      } else {
        url.searchParams.delete('search');
      }

      let contentArea = formData.get('content-area')
      if(contentArea) {
        url.searchParams.has('content-area') ? url.searchParams.set('content-area', contentArea) : url.searchParams.append('content-area', contentArea)
      } else {
        url.searchParams.delete('content-area');
      }

      let position = formData.get('position')
      if(position) {
        url.searchParams.has('position') ? url.searchParams.set('position', position) : url.searchParams.append('position', position)
      } else {
        url.searchParams.delete('position');
      }

      let district = formData.get('school-district')
      if(district) {
        url.searchParams.has('school-district') ? url.searchParams.set('school-district', district) : url.searchParams.append('school-district', district);
      } else {
        url.searchParams.delete('school-district');
      }

      let building = formData.get('school-building')
      if(building) {
        url.searchParams.has('school-building') ? url.searchParams.set('school-building', building) : url.searchParams.append('school-building', building);
      } else {
        url.searchParams.delete('school-building');
      }

      let location = formData.get('location')
      if(location) {
        url.searchParams.has('location') ? url.searchParams.set('location', location) : url.searchParams.append('location', location);
      } else {
        url.searchParams.delete('location');
      }

      let staffList = document.querySelector('.staff-directory-results ul');
      staffList.innerHTML = '';

      window.location.href = url.href;

      // Query Employee Endpoint
      // fetch(`${context.staffEndpoint}?${queryString}`)
      //   .then(response => response.json())
      //   .then(data => {
      //     context.staff = data;
      //     context.loading = false;
      //   });
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
      e.preventDefault()
      let form = e.target.closest('form');
      form.reset();

      actions.searchStaff({ target: form, preventDefault: () => {} })
      
      // Reset building select
      let buildingSelect = form.querySelector('select[name="school-building"]');
      if(buildingSelect){
        buildingSelect.innerHTML = '<option value="">Select a District to view Buildings</option>';
        buildingSelect.disabled = true;
      }
    }
  },
  callbacks: {
    renderStaffList: () => {
      let context = getContext();

      let staffList = document.querySelector('.staff-directory-results ul');
      staffList.innerHTML = '';

      let filteredStaff = context.staff

      if(context.internal){
        let dist = document.querySelector('#school-district')

        if(dist){
          if(dist.value != ''){
            filteredStaff = filteredStaff.filter(employee => {
              return Object.keys(employee.assignments).some((key) => {
                let assign = employee.assignments[key]
                return assign.district == dist.value || assign.agency_wide == 'true'
              })
            })
          }
  
          let build = document.querySelector("#school-building")
          if(build.value != ''){
            filteredStaff = filteredStaff.filter(employee => {
              return Object.keys(employee.assignments).some((key) => {
                let assign = employee.assignments[key]
                return assign.building == build.value || assign.district_wide == 'true' || assign.agency_wide == 'true'
              })
            })
          }
        }
      }

      let sortedStaff = sortByAssignmentPriority(filteredStaff);
      let pageStaff = sortedStaff

      if(sortedStaff.length > 0){
        let paginatedStaff = []
  
        for(let i = 0; i < sortedStaff.length; i += parseInt(context.perPage)){
          paginatedStaff.push(sortedStaff.slice(i, i + parseInt(context.perPage)))
        }

        pageStaff = paginatedStaff[context.currentPage - 1]

        if(!pageStaff){
            pageStaff = paginatedStaff[paginatedStaff.length - 1]
            context.currentPage = paginatedStaff.length - 1
        }
      }

      if(pageStaff){

        pageStaff.forEach( member => {
          // Render each staff member
          let li = document.createElement('li');
          let staffMemberTemplate = `
            <div class='staff-member'>
              <figure class='staff-image'>
                <img src='${ member.image }' width='135' height='154' alt='${ member.full_name }' loading="lazy" />
              </figure>
              <div class='staff-info'>
                <h2 class='staff-name'>${member.full_name}</h2>
                <div class='staff-position'>${member.position}</div>
                ${ context.include_location ? `<div class='staff-location'>${member.location}</div>` : '' }
                <div ${ context.include_location ? `style='display: flex; gap: 15px'` : '' }>
                  <div class='staff-email'>${member.email}</div>
                  <div class='staff-phone'>${member.phone}</div>
                </div>
              </div>
            </div>
          `
  
          li.innerHTML = staffMemberTemplate;
  
          staffList.appendChild(li);
        });
      }

      if(!pageStaff || (pageStaff.length === 0 && !context.loading)) {
        let li = document.createElement('li');
        li.innerHTML = `<p>No staff members found matching your criteria. Please try adjusting your search.</p>`;
        staffList.appendChild(li);
      }
    },
    fillFormOptions: () => {
      let context = getContext();
      context.loading = true;

      let form = getElement();

      let url = new URLSearchParams(window.location.search);
      let schoolDistrictValue = url.get('school-district');
      console.log(schoolDistrictValue)
      let schoolBuildingValue = url.get('school-building');
      let positionValue = url.get('position');
      let locationValue = url.get('location');
      let contentAreaValue = url.get('content-area');

      if(form.ref.querySelector('select[name="school-district"]')){
        context.districts.forEach(district => {
          let option = document.createElement('option');
          
          if(district.id){
            option.value = district.id;
          } else {
            option.value = district.ID;
          }
  
          if(district.name){
            option.textContent = district.name;
          } else {
            option.textContent = district.post_title;
          }
          

          let district_id = district.ID
          district_id ||= district.id

          console.log(district)

          if(district_id == parseInt(schoolDistrictValue)){
            option.selected = true
          }

          form.ref.querySelector('select[name="school-district"]').appendChild(option);
        });
      }

      if(form.ref.querySelector('select[name="position"]')){
        context.positions.sort().forEach(position => {
          let option = document.createElement('option');
          if(typeof position == 'object'){
            option.value = position.name;
            option.innerText = position.name;
            form.ref.querySelector('select[name="position"]').appendChild(option);
          } else if(position.trim() != '') {
            option.innerText = position.trim();
            form.ref.querySelector('select[name="position"]').appendChild(option);
          }

          if(option.value == positionValue){
            option.selected = true
          }
        })
      }
      
      if(form.ref.querySelector('select[name="content-area"]')){
        context.contentAreas.sort().forEach(area => {
          let option = document.createElement('option');
          if(typeof area == 'object'){
            option.value = area.id;
            option.innerText = area.name;
            form.ref.querySelector('select[name="content-area"]').appendChild(option);
  
          } else if(area.trim() != '') {
            option.innerText = area.trim();
            form.ref.querySelector('select[name="content-area"]').appendChild(option);
          }
          if(option.value == contentAreaValue){
            option.selected = true
          }
        })
      }

      if(form.ref.querySelector('select[name="location"]')){
        context.locations.sort().forEach(location => {
          let option = document.createElement('option');
          if(typeof location == 'object'){
            option.value = location.id;
            option.innerText = location.name;
            form.ref.querySelector('select[name="location"]').appendChild(option);
  
          } else if(location.trim() != '') {

            option.innerText = location.trim();
            form.ref.querySelector('select[name="location"]').appendChild(option);
          }

          if(option.value == locationValue){
            option.selected = true
          }
        })
      }
    },
    loadStaffData: () => {
      let context = getContext();

      context.loading = true;

      let url = new URL(window.location.href)

      let queryParams = url.searchParams
      
      // Initial fetch of all staff
      fetch(`${context.staffEndpoint}?${queryParams.toString()}`)
        .then(response => response.json())
        .then(data => {
          context.staff = data;
        })
        .finally(() => {
          context.loading = false;
        });
    },
    setupPagination: () => {
      let context = getContext();
      let directoryResults = document.querySelector('.staff-directory-results')
      let pagination = directoryResults.querySelector('.pagination-links');

      if(pagination) {
        let filteredStaff = context.staff

        pagination.innerHTML = ''

        let pageCount = Math.ceil(filteredStaff.length / context.perPage)

        if(pageCount > 1){
          let previousLink = document.createElement('a')
          previousLink.innerText = 'Previous'

          if(parseInt(context.currentPage) > 1){
            previousLink.addEventListener('click', () => {
              const perviousUrl = new URL(window.location.href);
              context.currentPage = parseInt(context.currentPage) - 1;
              perviousUrl.searchParams.set(context.pageParam, context.currentPage)
              window.history.pushState({currentPage: context.currentPage}, '', perviousUrl.href)
            })
          }else{
            previousLink.setAttribute('disabled', 'true')
          }

          pagination.appendChild(previousLink)

          // starting point

          let start = 0;
          let end = pageCount

          let offset = 2

          if(context.currentPage > (2 + offset)){
            let pageLink = document.createElement('a')
            pageLink.innerText = 1
            pagination.appendChild(pageLink)

            let pageUrl = new URL(window.location.href);
            pageUrl.searchParams.set(context.pageParam, 1)

            pageLink.addEventListener('click', () => {
              const perviousUrl = new URL(window.location.href);
              context.currentPage = 1;
              perviousUrl.searchParams.set(context.pageParam, context.currentPage)
              window.history.pushState({currentPage: context.currentPage}, '', pageUrl.href)
            })


            start = parseInt(context.currentPage) - (offset + 1)
            let spacer = document.createElement('span')
            spacer.innerText = '...'

            pagination.appendChild(spacer)
          }

          if(parseInt(context.currentPage) < pageCount - (offset + 1)){
            end = parseInt(context.currentPage) + offset
          }

          for(let i = start; i < end; i++){
            let pageLink = document.createElement('a')
            pageLink.innerText = i + 1
            pagination.appendChild(pageLink)

            let pageUrl = new URL(window.location.href);
            pageUrl.searchParams.set(context.pageParam, i + 1)

            pageLink.addEventListener('click', () => {
              const perviousUrl = new URL(window.location.href);
              context.currentPage = i + 1;
              perviousUrl.searchParams.set(context.pageParam, context.currentPage)
              window.history.pushState({currentPage: context.currentPage}, '', pageUrl.href)
            })

            if(i === parseInt(context.currentPage) - 1){
              pageLink.ariaCurrent = 'page'
            }

          }

          if(parseInt(context.currentPage) < pageCount - (offset + 1)){
            let spacer = document.createElement('span')
            spacer.innerText = '...'
            pagination.appendChild(spacer)

            let pageLink = document.createElement('a')
            pageLink.innerText = pageCount
            pagination.appendChild(pageLink)

            let pageUrl = new URL(window.location.href);
            pageUrl.searchParams.set(context.pageParam, pageCount)

            pageLink.addEventListener('click', () => {
              const perviousUrl = new URL(window.location.href);
              context.currentPage = pageCount;
              perviousUrl.searchParams.set(context.pageParam, context.currentPage)
              window.history.pushState({currentPage: context.currentPage}, '', pageUrl.href)
            })
          }

          let nextLink = document.createElement('a')
          nextLink.innerText = 'Next'
          

          if(parseInt(context.currentPage) < pageCount){
            nextLink.addEventListener('click', () => {
              const nextUrl = new URL(window.location.href);
              context.currentPage = parseInt(context.currentPage) + 1;
              nextUrl.searchParams.set(context.pageParam, context.currentPage)
              window.history.pushState({currentPage: context.currentPage}, '', nextUrl.href)
            })
          } else {
            nextLink.setAttribute('disabled', 'true')
          }

          pagination.appendChild(nextLink)
        
        }

      }
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
    if(districtSelect && districtSelect.value != ''){
      let assignmentA = itemA.assignments_array.find((assignment) => assignment.district == districtSelect.value || assignment.agency_wide)
      let assignmentB = itemB.assignments_array.find((assignment) => assignment.district == districtSelect.value || assignment.agency_wide)

      if(buildingSelect.value != ''){
        
        assignmentA = itemA.assignments_array.find((assignment) => assignment.district == districtSelect.value && assignment.building == buildingSelect.value)
        assignmentB = itemB.assignments_array.find((assignment) => assignment.district == districtSelect.value && assignment.building == buildingSelect.value)
      }

      if(assignmentA == undefined){
        assignmentA = itemA.assignments_array.find((assignment) => assignment.district == districtSelect.value && assignment.district_wide == 'true')
      }
      if(assignmentB == undefined){
        assignmentB = itemB.assignments_array.find((assignment) => assignment.district == districtSelect.value && assignment.district_wide == 'true')
      }

      if(assignmentA == undefined || assignmentB == undefined){
        return 0
      }

      if(!assignmentA.hasOwnProperty('search_priority')){ assignmentA.search_priority = 100 }
      if(!assignmentB.hasOwnProperty('search_priority')){ assignmentB.search_priority = 100 }
      
      if(assignmentA.search_priority == ''){ assignmentA.search_priority = 100 }
      if(assignmentB.search_priority == ''){ assignmentB.search_priority = 100 }

      return assignmentA.search_priority - assignmentB.search_priority || itemA.last_name.localeCompare(itemB.last_name)
      
    } else {
      return 0;
    }
  })

  return sortedItems
}