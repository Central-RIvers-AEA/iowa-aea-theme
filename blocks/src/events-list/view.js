import { store, getContext, getElement } from '@wordpress/interactivity';

store( 'iowa-aea-theme/events-list', {
  actions: {
    toggle: () => {
      console.log('Toggle action called!');
      const context = getContext();
      console.log('Current context:', context);
      console.log('Current isOpen value:', context.isOpen);
      context.isOpen = !context.isOpen;
      console.log('New isOpen value:', context.isOpen);
    },
  },
  callbacks: {},
  init: {
    setup: () => {
      console.log('Events List block initialized');
    }
  }
});
