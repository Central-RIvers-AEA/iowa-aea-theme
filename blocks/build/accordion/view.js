/******/ (() => { // webpackBootstrap
/*!*******************************!*\
  !*** ./src/accordion/view.js ***!
  \*******************************/
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
console.log('Hello World! (from iowa-aea-accordion block)');
/* eslint-enable no-console */

// Select accordion section
const accordionSections = document.querySelectorAll('.accordion-section');

// Add click event listener to each section
accordionSections.forEach(section => {
  const header = section.querySelector('h3');
  header.addEventListener('click', () => {
    document.querySelectorAll('.accordion-section.open').forEach(openSection => {
      if (openSection !== section) {
        openSection.classList.remove('open');
      }
    });
    section.classList.toggle('open');
  });
});
/******/ })()
;
//# sourceMappingURL=view.js.map