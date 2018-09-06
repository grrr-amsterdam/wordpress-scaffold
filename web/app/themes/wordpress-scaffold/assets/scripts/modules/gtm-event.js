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

export const trackEvent = ({ type, category, action, label, value }) => {
  if (!type || !category || !action) {
    console.error('Missing arguments in trackEvent');
    return;
  }
  const data = {
    eventType: type,
    eventCategory: category,
    eventAction: action,
    eventLabel: label,
    eventValue: value,
  };
  pushEvent({ event: type, ...data });
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
