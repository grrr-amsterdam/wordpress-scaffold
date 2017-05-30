const TRIGGER_SELECTOR = '.js-class-toggler';
const DATA_ATTR_TARGET = 'data-target';
const DATA_ATTR_CLASS = 'data-target-class';
const DATA_CALLBACK = 'data-callback';

import { trackEvent } from './google-analytics.js';

const triggerIsValid = item => item.getAttribute(DATA_ATTR_TARGET)
  && item.getAttribute(DATA_ATTR_CLASS);

export const handler = (elm, e) => {
  e.preventDefault();
  if (!triggerIsValid(elm)) {
    return;
  }
  const target = document.querySelector(elm.getAttribute(DATA_ATTR_TARGET));
  if (!target) {
    return;
  }
  target.classList.toggle(elm.getAttribute(DATA_ATTR_CLASS));
  if (elm.hasAttribute(DATA_CALLBACK)) {
    window[elm.getAttribute(DATA_CALLBACK)]();
  }

  if (elm.getAttribute('data-track-event')) {
    trackEvent(
      elm.getAttribute('data-event-category'),
      elm.getAttribute('data-event-action'),
      elm.getAttribute(
        target.classList.contains(elm.getAttribute(DATA_ATTR_CLASS)) ?
        'data-event-label-on' : 'data-event-label-off'
      )
    );
  }
};
