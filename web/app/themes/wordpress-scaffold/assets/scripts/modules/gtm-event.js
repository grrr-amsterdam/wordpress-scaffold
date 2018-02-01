const getAttributes = (el) => {
  return {
    type: el.getAttribute('data-event-type'),
    category: el.getAttribute('data-event-cat'),
    action: el.getAttribute('data-event-action'),
    label: el.getAttribute('data-event-label'),
    value: el.getAttribute('data-event-value'),
  };
};

const hasProductionDefined = () => {
  window.dataLayer = window.dataLayer || [];
  return window.dataLayer.length
    && window.dataLayer[0].platformEnvironment === 'production';
};

export const pushEvent = (data) => {
  window.dataLayer = window.dataLayer || [];
  window.dataLayer.push(data);
  if (!hasProductionDefined()) {
    console.log('Tracking event', data);
  }
};

export const trackEvent = (args) => {
  if (!args || !args.type || !args.category || !args.action) {
    console.error('Missing arguments in trackEvent', args);
    return;
  }
  const data = {
    eventType: args.type,
    eventCategory: args.category,
    eventAction: args.action,
    eventLabel: args.label,
    eventValue: args.value,
  };
  pushEvent({ event: args.type, ...data });
};

export const handler = (el, e) => {
  trackEvent(getAttributes(el));
};

export const enhancer = (el) => {
  if (this.nodeName.toUpperCase() !== 'FORM') {
    console.log('I don\'t know how to enhance non-forms.');
  }
  this.addEventListener('submit', (e) => {
    trackEvent(getAttributes(el));
  });
};
