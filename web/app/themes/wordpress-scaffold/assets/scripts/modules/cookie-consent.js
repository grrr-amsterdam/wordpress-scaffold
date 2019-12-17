import CookieConsent from '@grrr/cookie-consent';
import { pushEvent } from './gtm-event';

export const enhancer = () => {

  const cookieConsent = new CookieConsent({
    cookies: [
      {
        id: 'functional',
        label: 'Functional',
        description: 'Nullam id dolor id nibh ultricies vehicula ut id elit. Vestibulum id ligula porta felis euismod semper. Etiam porta sem malesuada magna mollis euismod.',
        required: true,
      },
      {
        id: 'analytical',
        label: 'Analytical',
        description: 'Nullam id dolor id nibh ultricies vehicula ut id elit. Vestibulum id ligula porta felis euismod semper. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Vestibulum id ligula porta felis euismod semper. Etiam porta sem malesuada magna mollis euismod.',
        required: true,
      },
      {
        id: 'marketing',
        label: 'Marketing & Social Media',
        description: 'Nullam id dolor id nibh ultricies vehicula ut id elit. Vestibulum id ligula porta felis euismod semper. Etiam porta sem malesuada magna mollis euismod.',
        checked: true,
      },
    ],
  });

  // Update Tag Manager when `set` event is fired.
  cookieConsent.on('update', cookies => {
    cookies.filter(cookie => cookie.accepted).forEach(cookie => pushEvent({
      event: 'cookieConsent',
      cookieType: cookie.id,
    }));
  });

  // Make the object globally available.
  window.CookieConsent = cookieConsent;
};

export const handler = (el, e) => {
  e.preventDefault();
  window.CookieConsent.showDialog();
};
