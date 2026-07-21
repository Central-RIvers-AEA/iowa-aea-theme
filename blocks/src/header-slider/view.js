import { store, getContext, getElement } from '@wordpress/interactivity';



const { actions, state } = store( 'iowa-aea-theme/header-slider', {
  state: {
    currentSlide: 0,
    paused: false,
    interval: null,
  },
  actions: {
    nextSlide: (context) => {
      let next = state.currentSlide + 1;

      let slidesData = context.slides || [];

      if (next >= slidesData.length) {
        next = 0;
      }

      actions.setVisibleSlide(next);
    },
    prevSlide: (context) => {
      let next = state.currentSlide - 1;

      let slidesData = context.slides || [];

      if (next < 0) {
        next = slidesData.length - 1;
      }

      actions.setVisibleSlide(next);
    },
    loadSlideShow: () => {
      const context = getContext();
      const element = getElement();

      let slidesData = context.slides || [];

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
      tabContents.setAttribute('aria-label', 'Slide Navigation')
      contentTabContainer.appendChild(tabContents);

      let imageContents = document.createElement('div');
      imageContents.classList.add('image-contents');

      slide.appendChild(imageContents);

      slidesData.forEach((slide, index) => {

        // slide contents
        let slideContent = document.createElement('div');
        slideContent.id = `slide-${index}`;
        slideContent.classList.add('slide-content');
        slideContent.setAttribute('aria-roledescription', 'slide');

        slideContent.innerHTML = `
          <div class='slide-title'>${slide.title}</div>
          <p>${slide.content}</p>
          <div class='wp-block-button'>
            <a class='wp-block-button__link has-text-align-center' style='display: inline-block;' href="${slide.buttonUrl ? slide.buttonUrl : '#'}" class="button">${slide.buttonText ? slide.buttonText : 'Learn More'}</a>
          </div>
        `;
        slideContent.dataset.slideIndex = index;
        slideContents.appendChild(slideContent);

        // tab contents
        let tabContent = document.createElement('button');
        tabContent.classList.add('label-content')

        tabContent.setAttribute('id', `tab-${index}`);

        tabContent.innerHTML = slide.slideLabel;
        tabContent.dataset.slideTabIndex = index;
        tabContent.addEventListener('click', () => {
          actions.setVisibleSlide(index);
        })
        tabContents.appendChild(tabContent);

        // image contents
        let imageContent = document.createElement('div');
        imageContent.classList.add('image-content');
        imageContent.dataset.slideIndex = index;
        imageContent.innerHTML = `<img src="${slide.image}" alt="${slide.title}" loading="lazy" />`;
        imageContents.appendChild(imageContent);
      });

      actions.addControls();

      actions.startSlideshow();
    },
    addControls: () => {
      const element = getElement();
      let context = getContext();

      let previous = document.createElement('button')
      previous.innerHTML = '<span class="dashicons dashicons-controls-back"></span>';
      previous.setAttribute('aria-label', 'Previous Slide')
      previous.addEventListener('click', () => {
        actions.prevSlide(context);
      })

      let next = document.createElement('button')
      next.innerHTML = '<span class="dashicons dashicons-controls-forward"></span>';
      next.setAttribute('aria-label', 'Next Slide')
      next.addEventListener('click', () => {
        actions.nextSlide(context);
      })

      let pause = document.createElement('button')
      pause.innerHTML = '<span class="dashicons dashicons-controls-pause"></span>';
      pause.setAttribute('aria-label', 'Pause Slide')
      pause.addEventListener('click', () => {
        actions.pauseSlideShow();
        play.classList.remove('active')
        pause.classList.add('active')
      })

      let play = document.createElement('button')
      play.innerHTML = '<span class="dashicons dashicons-controls-play"></span>';
      play.setAttribute('aria-label', 'Play Slideshow')
      play.addEventListener('click', () => {
        actions.startSlideshow(context);
        play.classList.add('active')
        pause.classList.remove('active')
      })

      previous.classList.add('previous');
      next.classList.add('next');
      pause.classList.add('pause');
      play.classList.add('play');
      play.classList.add('active')

      let controls = document.createElement('div');
      controls.classList.add('controls');

      controls.appendChild(previous);
      controls.appendChild(pause);
      controls.appendChild(play);
      controls.appendChild(next);

      element.ref.appendChild(controls);
    },
    setVisibleSlide(index){
      state.currentSlide = index;
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
        tab.classList.toggle('active', tab.dataset.slideTabIndex == index);
        tab.setAttribute('aria-selected', tab.dataset.slideTabIndex == index);
      });
    },
    startSlideshow: (context) => {
      context ||= getContext();
      actions.setVisibleSlide(state.currentSlide);

      let interval = setInterval(() => {
        actions.nextSlide(context)
      }, 15000)

      state.interval = interval
    },
    pauseSlideShow: () => {
      clearInterval(state.interval)
    }
  },
  init: {
    setup: () => {
      actions.loadSlideShow();
    }
  }
});
