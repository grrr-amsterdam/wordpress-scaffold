// Import libraries and polyfills
import 'classlist-polyfill';
import domready from 'domready';

// Handler and Enhancer utility
import handle from './modules/handle';
import enhance from './modules/enhance';

// Import functions that are executed on DOMready regardless of DOM
import { enhancer as scrollListener } from './modules/scroll-listener';
import { enhancer as responsive } from './modules/responsive';
import { default as disableHoverStylesOnScroll } from './modules/disable-hover-styles-on-scroll';

// Import handlers
import { handler as classToggler } from './modules/class-toggler';
import { handler as gtmEventHandler } from './modules/gtm-event';

// Import enhancers
import { enhancer as gtmEventEnhancer } from './modules/gtm-event';

const executeOnReady = () => {
  disableHoverStylesOnScroll(); // Disable hover styles on scroll
  scrollListener(); // Initialise central scroll listener
  responsive(); // Set document width on resize and orientation change

  /**
   * Simple requestAnimationFrame
   * @see http://elektronotdienst-nuernberg.de/bugs/requestAnimationFrame.html
   */
  // eslint-disable-next-line func-names
  window.requestAnimationFrame = window.requestAnimationFrame || function(c) {
    return setTimeout(() => {
      c(+new Date());
    }, 30);
  };
};

function main() {
  executeOnReady();

  handle({
    classToggler,
    gtmEventHandler,
  });

  enhance({
    gtmEventEnhancer,
  });
}

domready(() => {
  main();
});
