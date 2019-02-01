// Import libraries and polyfills
import Promise from 'promise-polyfill';
import 'whatwg-fetch';
import 'classlist-polyfill';
import { handle, enhance } from '@grrr/hansel';
import rafPolyfill from './polyfills/request-animation-frame';

// Import functions that are executed on DOMready regardless of DOM
import { onDomReady } from './modules/ready';
import { enhancer as scrollListener } from './modules/scroll-listener';
import { enhancer as responsive } from './modules/responsive';
import { default as disableHoverStylesOnScroll } from './modules/disable-hover-styles-on-scroll';

// Import handlers
import { handler as classToggler } from './modules/class-toggler';
import { handler as gtmEventHandler } from './modules/gtm-event';

// Import enhancers
import { enhancer as gtmEventEnhancer } from './modules/gtm-event';
import { enhancer as newsletterSignup } from './modules/newsletter-signup';

const executeOnReady = () => {
  disableHoverStylesOnScroll(); // Disable hover styles on scroll
  scrollListener(); // Initialise central scroll listener
  responsive(); // Set document width on resize and orientation change

  window.requestAnimationFrame = window.requestAnimationFrame || rafPolyfill;

  if (typeof window.Promise === 'undefined') {
    window.Promise = Promise;
  }
};

const main = () => {
  executeOnReady();
  handle({
    classToggler,
    gtmEventHandler,
  });
  enhance({
    gtmEventEnhancer,
    newsletterSignup,
  });
};

onDomReady(main);
