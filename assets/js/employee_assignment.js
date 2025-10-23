console.log('Loaded script');

console.log(assignment_vars)

/* 
  [
    'content_area' => 'slklkjdf',
    'district' => '1...1000',
    'district_wide' => true|false,
    'building' => '1....1000',
    'agency_wide' => true|false,
    'search_priority' => '1...5'
  ]
*/

function addAssignment(){
  let timestamp = new Date().getTime()

  let row = document.createElement('tr')

  let rowTemplate = document.querySelector('#rowTemplate').innerHTML

  rowTemplate = rowTemplate.replaceAll('NEW_RECORD', timestamp)

  row.innerHTML = rowTemplate

  row.querySelector('.remove').addEventListener('click', () => {
    row.remove()
  })

  // Handling when District Selected
  row.querySelector('.districtSelect').addEventListener('change', (e) => {
    let districtSelect = e.target

    let buildings = assignment_vars.buildings.filter(building => {
      return building.district_id == e.target.value
    })

    console.log(buildings, e.target.value)

    let buildingSelect = row.querySelector('.buildingSelect')
    buildingSelect.innerHTML = '<option value="">Select A Building</option>'

    buildings.forEach(building => {
      let option = `<option value='${building.ID}'>${building.post_title}</option>`
      buildingSelect.insertAdjacentHTML('beforeend', option)
    })
  })


  let table = document.querySelector('#assignmentList tbody')

  table.append(row)
}

document.addEventListener('DOMContentLoaded', () => {
  let assignmentButton = document.querySelector('#addAssignment')

  if(assignmentButton){
    assignmentButton.addEventListener('click', addAssignment)
  }
})