/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/link-card/block.json":
/*!**********************************!*\
  !*** ./src/link-card/block.json ***!
  \**********************************/
/***/ ((module) => {

module.exports = /*#__PURE__*/JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":3,"name":"iowa-aea-theme/link-card","version":"0.1.0","title":"Link Card","category":"widgets","icon":"index-card","attributes":{"linkText":{"type":"string","default":"Link Card"},"svgIcon":{"type":"string","default":"<svg width=\\"63\\" height=\\"74\\" viewBox=\\"0 0 63 74\\" fill=\\"none\\" xmlns=\\"http://www.w3.org/2000/svg\\"><g clip-path=\\"url(#clip0_712_513)\\"><path d=\\"M28.7266 56.3986H15.5693V72.6753H28.7266V56.3986Z\\" stroke-width=\\"3\\" stroke-linecap=\\"round\\" stroke-linejoin=\\"round\\"/><path d=\\"M61.6938 72.6753H4.63247C0.200268 68.18 0.200268 60.8939 4.63247 56.3986H61.7025C57.2703 60.8939 57.2703 68.18 61.7025 72.6753H61.6938Z\\" stroke-width=\\"3\\" stroke-linecap=\\"round\\" stroke-linejoin=\\"round\\"/><path d=\\"M23.2582 23.6952C21.0987 23.598 18.8347 23.7129 16.8929 26.5036C14.3764 30.1158 15.8392 35.1145 17.9987 39.071\\" stroke-width=\\"3\\" stroke-linecap=\\"round\\" stroke-linejoin=\\"round\\"/><path d=\\"M41.1263 1.59851C41.1263 1.59851 35.684 0.105973 31.7395 4.10669C27.9603 7.9396 30.2853 12.5939 30.2853 12.5939C30.2853 12.5939 34.8742 14.9519 38.6534 11.119C42.5979 7.11827 41.1263 1.59851 41.1263 1.59851Z\\" stroke-width=\\"3\\" stroke-linecap=\\"round\\" stroke-linejoin=\\"round\\"/><path d=\\"M31.426 18.2991C31.426 14.0246 29.3797 8.1339 22.8054 4.39813\\" stroke-width=\\"3\\" stroke-linecap=\\"round\\" stroke-linejoin=\\"round\\"/><path d=\\"M51.68 22.2645C45.2015 12.9648 36.5983 18.3256 31.426 18.3256C26.2536 18.3256 17.6505 12.9648 11.1719 22.2645C5.46842 30.4602 12.095 42.9834 17.1715 49.4305C21.5341 54.9767 25.0868 56.381 27.673 56.3898H27.6991C27.7688 56.3898 27.8384 56.3898 27.8994 56.3898H34.9439C35.0136 56.3898 35.0832 56.3898 35.1442 56.3898H35.1703C37.7565 56.381 41.3092 54.9767 45.6717 49.4305C50.7396 42.9834 57.3748 30.4514 51.6713 22.2645H51.68Z\\" stroke-width=\\"3\\" stroke-linecap=\\"round\\" stroke-linejoin=\\"round\\"/></g><defs><clipPath id=\\"clip0_712_513\\"><rect width=\\"63\\" height=\\"74\\" fill=\\"white\\"/></clipPath></defs></svg>"},"linkURL":{"type":"string","default":""},"backgroundColor":{"type":"string","default":""},"textColor":{"type":"string","default":"#333333"},"textHoverColor":{"type":"string","default":"#FFFFFF"}},"description":"A block for displaying important contacts.","example":{},"supports":{"html":false},"textdomain":"link-card","editorScript":"file:./index.js","editorStyle":"file:./index.css","style":"file:./style-index.css","viewScript":"file:./view.js"}');

/***/ }),

/***/ "./src/link-card/edit.js":
/*!*******************************!*\
  !*** ./src/link-card/edit.js ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Edit)
/* harmony export */ });
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./editor.scss */ "./src/link-card/editor.scss");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__);
/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */


/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */



/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */


/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */

function Edit(props) {
  const {
    attributes,
    setAttributes
  } = props;
  const {
    tabNumber,
    backgroundColor
  } = attributes;

  // Get theme color palette
  const colorPalette = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.useSetting)('color.palette') || [{
    name: 'Primary',
    slug: 'primary',
    color: '#9b2246'
  }, {
    name: 'Secondary',
    slug: 'secondary',
    color: '#f0b52b'
  }, {
    name: 'Alt One',
    slug: 'alt-one',
    color: '#001777'
  }, {
    name: 'Alt Two',
    slug: 'alt-two',
    color: '#582c63'
  }, {
    name: 'Alt Three',
    slug: 'alt-three',
    color: '#00826e'
  }, {
    name: 'Alt Four',
    slug: 'alt-four',
    color: '#d17829'
  }, {
    name: 'Background Color',
    slug: 'background-color',
    color: '#ffffff'
  }, {
    name: 'Base',
    slug: 'base',
    color: '#FFFFFF'
  }, {
    name: 'Text Color',
    slug: 'text-color',
    color: '#333333'
  }];

  // SVG Options
  let svgs = [{
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Apple Book', 'link-card'),
    value: '<svg width="63" height="74" viewBox="0 0 63 74" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_712_513)"><path d="M28.7266 56.3986H15.5693V72.6753H28.7266V56.3986Z" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M61.6938 72.6753H4.63247C0.200268 68.18 0.200268 60.8939 4.63247 56.3986H61.7025C57.2703 60.8939 57.2703 68.18 61.7025 72.6753H61.6938Z" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M23.2582 23.6952C21.0987 23.598 18.8347 23.7129 16.8929 26.5036C14.3764 30.1158 15.8392 35.1145 17.9987 39.071" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M41.1263 1.59851C41.1263 1.59851 35.684 0.105973 31.7395 4.10669C27.9603 7.9396 30.2853 12.5939 30.2853 12.5939C30.2853 12.5939 34.8742 14.9519 38.6534 11.119C42.5979 7.11827 41.1263 1.59851 41.1263 1.59851Z" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M31.426 18.2991C31.426 14.0246 29.3797 8.1339 22.8054 4.39813" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M51.68 22.2645C45.2015 12.9648 36.5983 18.3256 31.426 18.3256C26.2536 18.3256 17.6505 12.9648 11.1719 22.2645C5.46842 30.4602 12.095 42.9834 17.1715 49.4305C21.5341 54.9767 25.0868 56.381 27.673 56.3898H27.6991C27.7688 56.3898 27.8384 56.3898 27.8994 56.3898H34.9439C35.0136 56.3898 35.0832 56.3898 35.1442 56.3898H35.1703C37.7565 56.381 41.3092 54.9767 45.6717 49.4305C50.7396 42.9834 57.3748 30.4514 51.6713 22.2645H51.68Z" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></g><defs><clipPath id="clip0_712_513"><rect width="63" height="74" fill="white"/></clipPath></defs></svg>'
  }, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Grad Cap', 'link-card'),
    value: '<svg width="84" height="64" viewBox="0 0 84 64" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_712_520)"><path d="M68.1207 21.9937V48.9607C68.1207 50.2785 67.1288 51.9788 65.8825 52.6674C50.9951 60.7864 32.9963 60.7864 18.109 52.6674C16.8627 51.9788 15.8708 50.27 15.8708 48.9607C15.8708 39.9745 15.8708 30.9883 15.8708 21.9937" stroke-width="3" stroke-linejoin="round"/><path d="M81.7957 15.3369C83.0335 15.7874 83.0335 16.5356 81.7957 16.9862L44.2551 30.7077C43.0174 31.1583 40.9826 31.1583 39.7364 30.7077L2.20428 16.9947C0.966493 16.5441 0.966493 15.7959 2.20428 15.3454L39.7449 1.61528C40.9826 1.1647 43.0174 1.1647 44.2636 1.61528L81.8042 15.3369H81.7957Z" stroke-width="3" stroke-linejoin="round"/><path d="M42 16.1616L60.8127 24.6632V62.7248" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></g><defs><clipPath id="clip0_712_520"><rect width="84" height="64" fill="white"/></clipPath></defs></svg>'
  }, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Certificate', 'link-card'),
    value: '<svg width="74" height="69" viewBox="0 0 74 69" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_712_524)"><path d="M20.9004 20.2006H53.0996" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M24.7943 45.8178H3.60267C2.30471 45.8178 1.24805 44.7577 1.24805 43.4739V3.58627C1.24805 2.29423 2.31303 1.24237 3.60267 1.24237H70.389C71.687 1.24237 72.7437 2.30251 72.7437 3.58627V43.4656C72.7437 44.7577 71.6787 45.8095 70.389 45.8095H49.2058" stroke-width="3" stroke-linejoin="round"/><path d="M49.2557 38.5542H58.1666C58.1666 34.5456 61.4365 31.2906 65.4635 31.2906V15.7613C61.4365 15.7613 58.1666 12.5063 58.1666 8.49768H15.8334C15.8334 12.5063 12.5719 15.7613 8.53656 15.7613V31.2906C12.5635 31.2906 15.8334 34.5456 15.8334 38.5542H24.7443" stroke-width="3" stroke-linejoin="round"/><path d="M37 54.8124C44.049 54.8124 49.7632 49.1241 49.7632 42.1073C49.7632 35.0905 44.049 29.4022 37 29.4022C29.9511 29.4022 24.2368 35.0905 24.2368 42.1073C24.2368 49.1241 29.9511 54.8124 37 54.8124Z" stroke-width="3" stroke-linejoin="round"/><path d="M37 49.0396C40.8462 49.0396 43.9641 45.9359 43.9641 42.1073C43.9641 38.2787 40.8462 35.175 37 35.175C33.1539 35.175 30.036 38.2787 30.036 42.1073C30.036 45.9359 33.1539 49.0396 37 49.0396Z" stroke-width="3" stroke-linejoin="round"/><path d="M44.7544 52.2034C45.6031 55.359 47.9411 62.5315 52.3342 65.7367L44.6712 63.1444L42.8907 67.7659C42.8907 67.7659 38.7972 63.691 37.208 54.8206" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M29.2539 52.2034C28.4052 55.359 26.0673 62.5315 21.6742 65.7367L29.3371 63.1444L31.1176 67.7659C31.1176 67.7659 35.2112 63.691 36.8003 54.8206" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></g><defs><clipPath id="clip0_712_524"><rect width="74" height="69" fill="white"/></clipPath></defs></svg>'
  }, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Computer', 'link-card'),
    value: '<svg width="82" height="68" viewBox="0 0 82 68" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_731_27)"><path d="M76.9225 1.32983H5.07755C3.00484 1.32983 1.32458 3.01679 1.32458 5.09776V49.3022C1.32458 51.3832 3.00484 53.0701 5.07755 53.0701H76.9225C78.9952 53.0701 80.6754 51.3832 80.6754 49.3022V5.09776C80.6754 3.01679 78.9952 1.32983 76.9225 1.32983Z"  stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M33.9356 53.0701C33.9356 53.0701 33.5382 54.7635 33.0525 56.8381C32.5668 58.9126 30.6506 60.606 28.7962 60.606H25.423"  stroke-width="3" stroke-linejoin="round"/><path d="M48.0555 53.0701C48.0555 53.0701 48.4529 54.7635 48.9386 56.8381C49.4243 58.9126 51.3405 60.606 53.1949 60.606H56.5681"  stroke-width="3" stroke-linejoin="round"/><path d="M59.2261 60.6149H22.7738V66.679H59.2261V60.6149Z"  stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M26.5442 36.4246C25.5927 37.3775 25.5927 38.9241 26.5442 39.8769L29.5644 42.901C30.5159 43.8539 32.0604 43.8539 33.012 42.901L53.5599 22.3257L55.7526 13.6536L47.0921 15.8493L26.5442 36.4246Z"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M35.7425 40.1807L29.2748 33.7043"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M38.2248 37.6951L31.7571 31.2048"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M53.5599 22.3394L47.0922 15.863"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M34.9978 34.4499L50.3191 19.0944"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M52.8842 14.3855L55.0355 16.5259"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M30.1297 26.3303L29.6608 28.084L29.1919 26.3303C28.792 24.8389 27.6198 23.6652 26.1304 23.2647L24.379 22.7952L26.1304 22.3257C27.6198 21.9252 28.792 20.7515 29.1919 19.2601L29.6608 17.5063L30.1297 19.2601C30.5296 20.7515 31.7018 21.9252 33.1912 22.3257L34.9426 22.7952L33.1912 23.2647C31.7018 23.6652 30.5296 24.8389 30.1297 26.3303Z"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M51.4223 40.885L51.2431 41.5616L51.0638 40.885C50.5949 39.1588 49.2572 37.8194 47.5472 37.3637L46.8715 37.1841L47.5472 37.0046C49.271 36.5351 50.6087 35.1957 51.0638 33.4833L51.2431 32.8067L51.4223 33.4833C51.8912 35.2095 53.2289 36.5489 54.9389 37.0046L55.6147 37.1841L54.9389 37.3637C53.2151 37.8332 51.8774 39.1726 51.4223 40.885Z"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M38.3902 17.1197V17.1749L38.3626 17.1197C37.9489 15.6007 36.7629 14.4131 35.246 13.9988H35.1908L35.246 13.9712C36.7629 13.557 37.9489 12.3694 38.3626 10.8504V10.7952L38.3902 10.8504C38.8039 12.3694 39.9899 13.557 41.5069 13.9712H41.562L41.5069 13.9988C39.9899 14.4131 38.8039 15.6007 38.3902 17.1197Z"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></g><defs><clipPath id="clip0_731_27"><rect width="82" height="68" fill="white"/></clipPath></defs></svg>'
  }, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Speech Bubble', 'link-card'),
    value: '<svg width="71" height="59" viewBox="0 0 71 59" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M43.4962 2H26.4937C12.4722 2 1 12.1216 1 24.5012C1 36.872 12.4722 47.0024 26.5038 47.0024H41.8L57.6683 57V43.1769C64.4934 39.1301 69 32.2584 69 24.5012C69 12.1304 57.5278 2 43.4962 2Z" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M24.08 26.32C24.8588 26.32 25.49 25.6887 25.49 24.91C25.49 24.1313 24.8588 23.5 24.08 23.5C23.3013 23.5 22.67 24.1313 22.67 24.91C22.67 25.6887 23.3013 26.32 24.08 26.32Z" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M35.3701 26.32C36.1488 26.32 36.7801 25.6887 36.7801 24.91C36.7801 24.1313 36.1488 23.5 35.3701 23.5C34.5914 23.5 33.9601 24.1313 33.9601 24.91C33.9601 25.6887 34.5914 26.32 35.3701 26.32Z" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M46.67 26.32C47.4487 26.32 48.08 25.6887 48.08 24.91C48.08 24.1313 47.4487 23.5 46.67 23.5C45.8913 23.5 45.26 24.1313 45.26 24.91C45.26 25.6887 45.8913 26.32 46.67 26.32Z" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>'
  }, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Plus', 'link-card'),
    value: ' <svg width="58" height="58" viewBox="0 0 58 58" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M29 56.1965C44.0202 56.1965 56.1965 44.0202 56.1965 29C56.1965 13.9798 44.0202 1.80347 29 1.80347C13.9798 1.80347 1.80347 13.9798 1.80347 29C1.80347 44.0202 13.9798 56.1965 29 56.1965Z" stroke-width="3" stroke-miterlimit="10"/><path d="M29 12.6965V45.3035" stroke-width="3" stroke-miterlimit="10" stroke-linecap="round"/><path d="M45.3035 29H12.6965" stroke-width="3" stroke-miterlimit="10" stroke-linecap="round"/></svg>'
  }];
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.Fragment, {
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.InspectorControls, {
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.PanelBody, {
        title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Settings', 'link-card'),
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.SelectControl, {
          label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('SVG Icon', 'link-card'),
          value: attributes.svgIcon,
          options: svgs,
          onChange: value => setAttributes({
            svgIcon: value
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.TextControl, {
          label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Link Text', 'link-card'),
          value: attributes.linkText,
          onChange: value => setAttributes({
            linkText: value
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.TextControl, {
          label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Link URL', 'link-card'),
          value: attributes.linkURL,
          onChange: value => setAttributes({
            linkURL: value
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("span", {
          children: "Background Color"
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.ColorPalette, {
          label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Background Color', 'link-card'),
          value: attributes.backgroundColor,
          onChange: value => setAttributes({
            backgroundColor: value
          }),
          colors: colorPalette,
          enableAlpha: false,
          clearable: true
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("span", {
          children: "Text Color"
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.ColorPalette, {
          label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Text Color', 'link-card'),
          value: attributes.textColor,
          onChange: value => setAttributes({
            textColor: value
          }),
          colors: colorPalette,
          enableAlpha: false,
          clearable: true
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("span", {
          children: "Text Hover Color"
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.ColorPalette, {
          label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Text Hover Color', 'link-card'),
          value: attributes.textHoverColor,
          onChange: value => setAttributes({
            textHoverColor: value
          }),
          colors: colorPalette,
          enableAlpha: false,
          clearable: true
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("span", {
          children: "SVG Icon Raw HTML"
        })]
      })
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("a", {
      href: "",
      ...(0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.useBlockProps)({
        className: 'icon-card',
        style: {
          '--card-color': attributes.backgroundColor,
          '--card-text-color': attributes.textColor,
          '--card-text-hover-color': attributes.textHoverColor
        }
      }),
      onClick: e => e.preventDefault(),
      children: [attributes.svgIcon ? /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("span", {
        class: "icon-card__icon",
        dangerouslySetInnerHTML: {
          __html: attributes.svgIcon
        }
      }) : null, /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("span", {
        children: attributes.linkText || (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Link Card', 'link-card')
      })]
    })]
  });
}

/***/ }),

/***/ "./src/link-card/editor.scss":
/*!***********************************!*\
  !*** ./src/link-card/editor.scss ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/link-card/index.js":
/*!********************************!*\
  !*** ./src/link-card/index.js ***!
  \********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./style.scss */ "./src/link-card/style.scss");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./edit */ "./src/link-card/edit.js");
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./save */ "./src/link-card/save.js");
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./block.json */ "./src/link-card/block.json");
/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */


/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */


/**
 * Internal dependencies
 */




/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockType)(_block_json__WEBPACK_IMPORTED_MODULE_4__.name, {
  /**
   * @see ./edit.js
   */
  edit: _edit__WEBPACK_IMPORTED_MODULE_2__["default"],
  save: _save__WEBPACK_IMPORTED_MODULE_3__["default"]
});

/***/ }),

/***/ "./src/link-card/save.js":
/*!*******************************!*\
  !*** ./src/link-card/save.js ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ save)
/* harmony export */ });
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__);
/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */


/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @return {Element} Element to render.
 */

function save({
  attributes
}) {
  const {
    backgroundColor,
    textColor,
    textHoverColor,
    svgIcon,
    linkText,
    linkURL
  } = attributes;
  const blockProps = _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__.useBlockProps.save({
    className: 'icon-card',
    style: {
      '--card-color': backgroundColor,
      '--card-text-color': textColor,
      '--card-text-hover-color': textHoverColor
    }
  });
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("a", {
    href: linkURL,
    ...blockProps,
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("span", {
      class: "icon-card__icon",
      dangerouslySetInnerHTML: {
        __html: svgIcon
      }
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("span", {
      children: linkText || __('Link Card', 'link-card')
    })]
  });
}

/***/ }),

/***/ "./src/link-card/style.scss":
/*!**********************************!*\
  !*** ./src/link-card/style.scss ***!
  \**********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ ((module) => {

module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ ((module) => {

module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ ((module) => {

module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ ((module) => {

module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "react/jsx-runtime":
/*!**********************************!*\
  !*** external "ReactJSXRuntime" ***!
  \**********************************/
/***/ ((module) => {

module.exports = window["ReactJSXRuntime"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"link-card/index": 0,
/******/ 			"link-card/style-index": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = globalThis["webpackChunkinteractive_map"] = globalThis["webpackChunkinteractive_map"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["link-card/style-index"], () => (__webpack_require__("./src/link-card/index.js")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=index.js.map