import domready from 'domready';

import handle from './modules/handle';
import enhance from './modules/enhance';

// Import functions that are executed on DOMready regardless of DOM
import { enhancer as scrollListener } from './modules/scroll-listener';
import { enhancer as responsive } from './modules/responsive';
import { default as disableHoverStylesOnScroll } from './modules/disable-hover-styles-on-scroll';

// Import handlers
import { handler as classToggler } from './modules/class-toggler';
import { handler as googleAnalyticsEventHandler } from './modules/google-analytics';

// Import enhancers
import { enhancer as googleAnalyticsEventEnhancer } from './modules/google-analytics';

const executeOnReady = () => {
  disableHoverStylesOnScroll(); // Disable hover styles on scroll
  scrollListener(); // Initialise central scroll listener
  responsive(); // Set document width on resize and orientation change

  /**
   * Simple requestAnimationFrame
   * @see http://elektronotdienst-nuernberg.de/bugs/requestAnimationFrame.html
   */
  window.requestAnimationFrame = window.requestAnimationFrame || function(c) {
    return setTimeout(() => {
      c(+new Date);
    }, 30);
  };
};

function main() {
  executeOnReady();

  handle({
    classToggler,
    googleAnalyticsEventHandler,
  });

  enhance({
    googleAnalyticsEventEnhancer,
  });
}

domready(() => {
  main();
});
