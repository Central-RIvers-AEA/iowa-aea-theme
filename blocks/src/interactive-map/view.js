/**
 * Use this file for JavaScript code that you want to run in the front-end
 * on posts/pages that contain this block.
 *
 * When this file is defined as the value of the `viewScript` property
 * in `block.json` it will be enqueued on the front end of the site.
 *
 * Example:
 *
 * ```js
 * {
 *   "viewScript": "file:./view.js"
 * }
 * ```
 *
 * If you're not making any changes to this file because your project doesn't need any
 * JavaScript running in the front-end, then you should delete this file and remove
 * the `viewScript` property from `block.json`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-metadata/#view-script
 */

/* eslint-disable no-console */
console.log( 'Hello World! (from iowa-aea-theme-interactive-map block)' );
/* eslint-enable no-console */

let districts = []
let aeaInfo = []

document.addEventListener('DOMContentLoaded', () => {
  let districtSelect = document.getElementById('district-select');

  fetch('/wp-json/wp/v2/district?per_page=400')
    .then(response => response.json())
    .then(data => {
      districts = data;
      console.log('Districts:', districts);

      districts = districts.sort((a, b) => a.title.rendered.localeCompare(b.title.rendered));

      districts.forEach(district => {
        let option = document.createElement('option');
        option.value = district.id;
        option.textContent = district.title.rendered;
        districtSelect.appendChild(option);
      });
    })
    .catch(error => {
      console.error('Error fetching districts:', error);
    });

  fetch('/wp-json/wp/v2/aea')
    .then(response => response.json())
    .then(data => {
      aeaInfo = data;
      console.log('AEAs:', aeaInfo);
    })
    .catch(error => {
      console.error('Error fetching AEAs:', error);
    });

  districtSelect.addEventListener('change', (event) => {
    let selectedDistrict = districts.find(district => district.id === parseInt(event.target.value));

    console.log('Selected District:', selectedDistrict);
    let aeaMaps = document.querySelectorAll('.img-block .svg');
    aeaMaps.forEach(map => {
      map.style = '--level: 0';
    });

    if (selectedDistrict) {
      // Show the corresponding AEA map
      let aea = aeaInfo.find(info => info.id == selectedDistrict.aea);

      console.log(aea);

      let aeaMap = document.getElementById(aea.map_id);
      if (aeaMap) {
        aeaMap.style = '--level: 11';
      }

      let aeaInfoBlock = document.getElementById('aea-info');
      if (aeaInfo) {
        aeaInfoBlock.innerHTML = '';

        if (aea) {
          aeaInfoBlock.innerHTML = `
            <hr />
            <h3>${aea.title.rendered}</h3>
            <p>Address: ${aea.address}</p>
            <p>Phone: ${aea.phone_number}</p>
          `;
        }
      }
    }
  });

});