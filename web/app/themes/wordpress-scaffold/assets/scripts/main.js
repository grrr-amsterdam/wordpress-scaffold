// Import libraries and polyfills
import Promise from 'promise-polyfill';
import 'whatwg-fetch';
import 'focus-visible';
import 'classlist-polyfill';
import { onDomReady } from '@grrr/ready';
import { handle, enhance } from '@grrr/hansel';
import rafPolyfill from './polyfills/request-animation-frame';

// Import functions that are executed on DOMready regardless of DOM
import { enhancer as scrollListener } from './modules/scroll-listener';
import { enhancer as responsive } from './modules/responsive';
import { enhancer as cookieConsent } from './modules/cookie-consent';
import { default as disableHoverStylesOnScroll } from './modules/disable-hover-styles-on-scroll';

// Import handlers
import { handler as classToggler } from './modules/class-toggler';
import { handler as cookieBarAccept } from './modules/cookie-bar';
import { handler as cookieConsentShow } from './modules/cookie-consent';
import { handler as gtmEventHandler } from './modules/gtm-event';

// Import enhancers
import { enhancer as cookieBar } from './modules/cookie-bar';
import { enhancer as gtmEventEnhancer } from './modules/gtm-event';
import { enhancer as newsletterSignup } from './modules/newsletter-signup';

const executeOnReady = () => {
  window.requestAnimationFrame = window.requestAnimationFrame || rafPolyfill;
  window.Promise = window.Promise || Promise;

  disableHoverStylesOnScroll(); // Disable hover styles on scroll
  scrollListener(); // Initialise central scroll listener
  responsive(); // Set document width on resize and orientation change
  cookieConsent(); // Initialise cookie consent module
};

const main = () => {
  executeOnReady();
  handle(document.documentElement, {
    classToggler,
    cookieBarAccept,
    cookieConsentShow,
    gtmEventHandler,
  });
  enhance(document.documentElement, {
    cookieBar,
    gtmEventEnhancer,
    newsletterSignup,
  });
};

onDomReady(main);
