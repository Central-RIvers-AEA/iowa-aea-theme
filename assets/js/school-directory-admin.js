function addMultiItem(e, label){
  const button = e.target
  const multiField = button.closest('.sd-multi-field')
  const lowerLabel = label.toLowerCase().split().join('-')

  const multiFieldTable = multiField.querySelector('table')
  const multiFieldTableBody = multiFieldTable.querySelector('tbody')
  const multiFieldInputExample = multiFieldTable.querySelector('.example-row')

  const multiFieldInputClone = multiFieldInputExample.cloneNode(true)
  multiFieldInputClone.classList.remove('example-row')

  const inputNameBase = `${lowerLabel}[${Date.now()}]`

  multiFieldInputClone.querySelectorAll('td').forEach(td => {
    const {type, name} = td.dataset

    if(type && name){
      const input = document.createElement('input')
      input.type = type
      input.name = `${inputNameBase}[${name}]`
  
      td.append(input)
    }
  })

  multiFieldTableBody.append(multiFieldInputClone)

  console.log(multiFieldInputClone)

}


function removeRow(e){
  const button = e.target
  const row = button.closest('tr')
  row.remove()
}