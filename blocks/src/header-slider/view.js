import { store, getContext, getElement } from '@wordpress/interactivity';



const { actions } = store( 'iowa-aea-theme/header-slider', {
  state: {
    currentSlide: 0
  },
  actions: {
    nextSlide: () => {
      console.log('Next slide');
    },
    prevSlide: () => {
      console.log('Previous slide');
    },
    loadSlideShow: () => {
      console.log('Loading slideshow');

      const context = getContext();
      const element = getElement();

      let slidesData = context.attributes.slides || [];

      let slide = document.createElement('div');
      slide.classList.add('slide');

      element.ref.appendChild(slide);

      let contentTabContainer = document.createElement('div');
      contentTabContainer.classList.add('content-tab-container');

      slide.appendChild(contentTabContainer);

      let slideContents = document.createElement('div');
      slideContents.classList.add('slide-contents');
      contentTabContainer.appendChild(slideContents);

      let tabContents = document.createElement('div');
      tabContents.classList.add('tab-contents');
      contentTabContainer.appendChild(tabContents);

      let imageContents = document.createElement('div');
      imageContents.classList.add('image-contents');

      slide.appendChild(imageContents);

      slidesData.forEach((slide, index) => {
        console.log(`Slide ${index}:`, slide);

        // slide contents
        let slideContent = document.createElement('div');
        slideContent.classList.add('slide-content');
        slideContent.innerHTML = `
          <h3>${slide.title}</h3>
          <p>${slide.content}</p>
        `;
        slideContent.dataset.slideIndex = index;
        slideContents.appendChild(slideContent);

        // tab contents
        let tabContent = document.createElement('div');
        tabContent.classList.add('label-content');
        tabContent.innerHTML = slide.slide_label;
        tabContent.dataset.slideTabIndex = index;
        tabContent.addEventListener('click', () => {
          actions.setVisibleSlide(index);
        })
        tabContents.appendChild(tabContent);

        // image contents
        let imageContent = document.createElement('div');
        imageContent.classList.add('image-content');
        imageContent.dataset.slideIndex = index;
        imageContent.innerHTML = `<img src="${slide.image}" alt="${slide.title}" />`;
        imageContents.appendChild(imageContent);
      });

      actions.setVisibleSlide(0);

    },
    setVisibleSlide(index){
      let currentHiddenSlides = document.querySelectorAll('[data-slide-index].hide');

      currentHiddenSlides.forEach((currentHiddenSlide) => {
        currentHiddenSlide.classList.remove('hide');
      });

      let currentSlides = document.querySelectorAll('[data-slide-index].show');

      currentSlides.forEach((currentSlide) => {
        currentSlide.classList.remove('show');
        currentSlide.classList.add('hide');
      });

      const slides = document.querySelectorAll('[data-slide-index]');
      slides.forEach((slide) => {
        if (slide.dataset.slideIndex == index) {
          slide.classList.add('show');
        }
      });

      const slideTabs = document.querySelectorAll('[data-slide-tab-index]');
      slideTabs.forEach((tab) => {
        console.log(tab)
        tab.classList.toggle('active', tab.dataset.slideTabIndex == index);
      });
    }
  },
  callbacks: {
    onSlideChange: (newSlide) => {
      console.log('Slide changed to:', newSlide);
    }
  },
  init: {
    setup: () => {
      console.log('Header Slider block initialized');
      actions.loadSlideShow();
    }
  }
});
