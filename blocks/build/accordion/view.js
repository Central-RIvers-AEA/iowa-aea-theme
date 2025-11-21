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

// Grab accordions and only affect the accordion
const accordions = document.querySelectorAll('.accordion-holder');
accordions.forEach(accordion => {
  let sections = accordion.querySelectorAll('.accordion-section');
  sections.forEach(section => {
    if (section.dataset.prepared) {
      return;
    }
    section.dataset.prepared = 1;
    section.querySelector('.section-heading').addEventListener('click', e => {
      if (section.classList.contains('open')) {
        section.classList.remove('open');
      } else {
        section.classList.add('open');
      }
    });
  });
});
/******/ })()
;
//# sourceMappingURL=view.js.map