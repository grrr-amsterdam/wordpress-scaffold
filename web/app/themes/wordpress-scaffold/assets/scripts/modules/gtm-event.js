const getDataLayer = () => window.dataLayer || [];

const getAttributes = el => ({
  type: el.getAttribute('data-event-type'),
  category: el.getAttribute('data-event-cat'),
  action: el.getAttribute('data-event-action'),
  label: el.getAttribute('data-event-label'),
  value: el.getAttribute('data-event-value'),
});

export const pushEvent = data => {
  getDataLayer().push(data);
  if (window.GOOGLE_TAG_MANAGER_DEBUG) {
    console.log('Tracking event', data);
  }
};

export const trackEvent = ({ type, category, action, label, value }) => {
  if (!type || !category || !action) {
    console.error('Missing arguments in trackEvent.');
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

export const handler = (el, e) => trackEvent(getAttributes(el));

export const enhancer = el => {
  if (el.nodeName.toUpperCase() !== 'FORM') {
    console.log('I don\'t know how to enhance non-forms.');
  }
  el.addEventListener('submit', e => trackEvent(getAttributes(el)));
};
