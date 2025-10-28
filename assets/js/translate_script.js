console.log("translate_script.js loaded");

// Google Translate
// const select = document.querySelector("#google_translate_element");

// const observer = new MutationObserver((mutations) => {
//   mutations.forEach((mutation) => {
//     if (mutation.type == "childList") {
//       observer.disconnect();
//       setupTranslateSelections(select);
//     }
//   });
// });

// const config = { attributes: false, childList: true, characterData: false };

// observer.observe(select, config);

function googleTranslateElementInit() {
  new google.translate.TranslateElement(
    {
      pageLanguage: "en",
      autoDisplay: false,
      includedLanguages:
        "ar,zh-CN,zh-TW,hr,nl,tl,fr,de,it,ja,ko,pl,pt,ro,ru,sr,es,vi",
    },
    "google_translate_element"
  );
  
  // Modify the default text after widget loads
  setTimeout(() => {
    modifyTranslateText();
  }, 500);
}

function modifyTranslateText() {
  const translateSelect = document.querySelector('.goog-te-combo');
  if (translateSelect && translateSelect.options[0]) {
    translateSelect
    // Change the first option text from "Choose A Language" to your custom text
    translateSelect.options[0].textContent = "Translate";
    translateSelect.options[0].innerText = "Translate";
  }

  const translateGadget = document.querySelector('.skiptranslate');
  if (translateGadget) {
    // Remove any text nodes from the gadget
    translateGadget.childNodes.forEach((node) => {
      if (node.nodeType === Node.TEXT_NODE || node.nodeType === Node.ELEMENT_NODE && node.tagName === 'A') {
        node.remove();
      }
    });
  }
}

// function setupTranslateSelections(select) {
//   // add classes to translation selection
//   const translationSelect = select.querySelector("select");
//   translationSelect.classList.add("translate-choices--input");
//   translationSelect.classList.add("is_hidden");
//   translationSelect.setAttribute("tabindex", -1);
//   translationSelect.setAttribute("aria-hidden", true);

//   // remove text nodes
//   const gadget = select.querySelector(".skiptranslate");
//   gadget.childNodes.forEach((node) => {
//     if (node.nodeType == 3) {
//       node.remove();
//     }
//   });

//   // append holder for translate-choices
//   const translateChoicesHolder = document.createElement("div");
//   translateChoicesHolder.classList = "translate-choices";
//   translateChoicesHolder.setAttribute("aria-label", "Translation choices");
//   translateChoicesHolder.setAttribute("data-type", "select-one");
//   // translateChoicesHolder.setAttribute('role', 'listbox')
//   translateChoicesHolder.setAttribute("tabindex", "0");
//   translateChoicesHolder.setAttribute("aria-haspopup", true);
//   translateChoicesHolder.setAttribute("dir", "ltr");

//   translateChoicesHolder.onclick = () => {
//     toggleTranslationDropdown();
//   };

//   const choiceInner = document.createElement("div");
//   choiceInner.classList = "translate-choices--inner";

//   const chosenItem = document.createElement("div");
//   chosenItem.classList =
//     "translate-choices--list translate-choices--list--single";

//   const initialChoice = document.createElement("div");
//   initialChoice.classList =
//     "translate-choices--item translate-choices--item--selectable";
//   initialChoice.setAttribute("data-id", 0);
//   initialChoice.innerText = "Translate";

//   chosenItem.append(initialChoice);
//   choiceInner.append(chosenItem);

//   choiceInner.append(translationSelect);
//   translateChoicesHolder.append(choiceInner);

//   select
//     .querySelector('[id=":0.targetLanguage"]')
//     .prepend(translateChoicesHolder);

//   // cycle through the selects options and create a custom dropdown
//   const translateChoicesListDropdown = document.createElement("div");
//   translateChoicesListDropdown.classList.add("translate-choices--list");
//   translateChoicesListDropdown.classList.add(
//     "translate-choices--list--dropdown"
//   );
//   translateChoicesListDropdown.setAttribute("aria-expanded", false);
//   translateChoicesHolder.append(translateChoicesListDropdown);

//   const choiceList = document.createElement("div");
//   choiceList.classList.add("translate-choices--list");
//   choiceList.setAttribute("dir", "ltr");
//   // choiceList.setAttribute('role', 'listbox')
//   translateChoicesListDropdown.append(choiceList);

//   // dropdown opens when main text is selected
//   chosenItem.onclick = () => {};

//   const selectObserver = new MutationObserver((mutations) => {
//     mutations.forEach((mutation) => {
//       if (mutation.type == "childList") {
//         setUpSelectOptions(translationSelect, choiceList, selectObserver);
//       }
//     });
//   });

//   const config = { attributes: false, childList: true, characterData: false };

//   selectObserver.observe(translationSelect, config);

//   const resizeObserver = new ResizeObserver(moveTranslationBox);
//   let header = document.querySelector("header");
//   resizeObserver.observe(header);

//   checkCurrentBox();
// }

// function checkCurrentBox() {
//   const width = window.innerWidth;
//   moveTranslationBox(
//     [{ target: { id: "header" }, contentRect: { width } }],
//     {}
//   );
// }

// function moveTranslationBox(entries, observer) {
//   const translateElement = document.querySelector(
//     ".skiptranslate.goog-te-gadget"
//   );

//   if (entries[0].target.id == "header" && entries[0].contentRect.width < 991) {
//     // mv to mobile menu
//     const mobileMenu = document.querySelector(
//       "#google_translate_element-mobile"
//     );
//     mobileMenu.append(translateElement);
//   } else {
//     // mv to main menu
//     const mainMenu = document.querySelector("#google_translate_element");
//     if (mainMenu != translateElement.parentNode) {
//       mainMenu.append(translateElement);
//     }
//   }
// }