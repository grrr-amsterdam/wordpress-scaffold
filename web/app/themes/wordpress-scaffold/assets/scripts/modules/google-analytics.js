export const trackEvent = (category, action, optLabel, optValue, optNoninteraction = false) => {
  const logArgs = {
    category: category,
    action: action,
    label: optLabel,
    value: optValue,
    nonInteraction: optNoninteraction
  };
  if (typeof gaRokin === 'undefined') {
    console.info('Tracking event (fake)', logArgs);
    return;
  }
  gaRokin('send', 'event', category, action, optLabel, optValue, {
    nonInteraction: optNoninteraction
  });
  console.info('Tracking event', logArgs);
};

export const handler = () => {
  const category = this.getAttribute('data-event-category');
  const action = this.getAttribute('data-event-action');
  const label = this.getAttribute('data-event-label');
  const value = this.getAttribute('data-event-value');
  trackEvent(category, action, label, value);
};

export const enhancer = () => {
  if (this.nodeName.toUpperCase() !== 'FORM') {
    console.log('I don\'t know how to enhance non-forms.');
  }
  this.addEventListener('submit', e => {
    const category = this.getAttribute('data-event-category');
    const action = this.getAttribute('data-event-action');
    const label = this.getAttribute('data-event-label');
    const value = this.getAttribute('data-event-value');
    trackEvent(category, action, label, value);
  });
};
