/**
 * Runner of enhancers
 */

import { forEach } from './util';

export default enhancers => {
  if (!enhancers) {
    return;
  }
  const enhancerElms = document.querySelectorAll('[data-enhancer]');
  forEach(enhancerElms, (elm) => {
    // allow multiple comma-separated enhancers
    const enhancerCollection = elm.getAttribute('data-enhancer');
    enhancerCollection.split(',').forEach(enhancer => {
      if (typeof enhancers[enhancer] === 'function') {
        enhancers[enhancer](elm);
      } else {
        if (window.console && typeof console.log === 'function') {
          console.log('Non-existing enhancer: "%s" on %o', enhancer, this);
        }
      }
    });
  });
};
