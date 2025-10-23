document.addEventListener('DOMContentLoaded', () => {
  const schoolDirectoryList = document.querySelector('.school-directory--list')

  if(!schoolDirectoryList){ return }
  console.log('loading list')

  displayDistricts(sd_districts)


  // Put in all cities
  const cityDropDown = document.querySelector('#school_district_city')

  if(cityDropDown){
    const cities = Array.from(new Map(sd_districts.map(district => [district.city_state_zip.split(',')[0], 1])).keys()).sort()
    cityDropDown.innerHTML = "<option value=''>All Cities</option>"
    cities.forEach(city => {
      const option = document.createElement('option')
      option.value = city
      option.innerText = city

      cityDropDown.append(option)
    })

    cityDropDown.addEventListener('change', () => {
      displayDistricts(sd_districts)
    })
  }

  const schoolDistrictDropDown = document.querySelector('#school_district_name')

  if(schoolDistrictDropDown){
    sd_districts.sort((da, db) => da.post_title < db.post_title ? -1 : 1).forEach(district => {
      const option = document.createElement('option')
      option.value = district.ID
      option.innerText = district.post_title

      schoolDistrictDropDown.append(option)
    })

    schoolDistrictDropDown.addEventListener('change', () => {
      displayDistricts(sd_districts)
    })
  }

  const superintendentField = document.querySelector('#school_district_superintendent')
  if(superintendentField){
    superintendentField.addEventListener('keyup', () => {
      console.log('key upiing')
      displayDistricts(sd_districts)
    })
  }

  // handle on reset
  const schoolDirectoryForm = document.querySelector('#school-directory--filter-form')
  if(schoolDirectoryForm){
    schoolDirectoryForm.addEventListener('reset', () => {
      setTimeout(function(){
        displayDistricts(sd_districts)
      }, 100)
    })
  }
})

function displayDistricts(districts){
  const filteredDistricts = getFilteredDistricts(districts)

  const schoolDirectoryList = document.querySelector('.school-directory--list')
  schoolDirectoryList.innerHTML = ''

  filteredDistricts.forEach(district => {

    // Create Cards
    const districtCard = document.createElement('li')
    districtCard.classList.add('school-directory--card-district')

    const districtLink = document.createElement('a')
    districtLink.href = district.link
    districtLink.innerText = district.post_title

    districtCard.append(districtLink)

    const districtCity = document.createElement('span')
    districtCity.innerText = district.city_state_zip.split(',')[0]

    districtCard.append(districtCity)

    schoolDirectoryList.append(districtCard)
  })
}

function getFilteredDistricts(districts){
  const cityDropDown = document.querySelector('#school_district_city')
  const schoolDistrictDropDown = document.querySelector('#school_district_name')
  const superintendentField = document.querySelector('#school_district_superintendent')

  let filteredDistricts = districts

  if(cityDropDown.value != ''){
    filteredDistricts = filteredDistricts.filter(district => district.city_state_zip.includes(cityDropDown.value))
  }

  if(schoolDistrictDropDown.value != ''){
    filteredDistricts = filteredDistricts.filter(district => district.ID == schoolDistrictDropDown.value )
  }

  if(superintendentField.value != ''){
    filteredDistricts = filteredDistricts.filter(district => {
      if(district.school_personnel != ''){
        return Object.keys(district.school_personnel)
                .map(key => district.school_personnel[key])
                .some(person => person.name.toLowerCase().includes(superintendentField.value.toLowerCase()))
      }
    })
  }

  return filteredDistricts
}