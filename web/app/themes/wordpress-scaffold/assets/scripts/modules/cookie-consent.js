import CookieConsent from '@grrr/cookie-consent';
import { pushEvent } from './gtm-event';

export default () => {

  // Construct and initialize the module if a config is found.
  const config = window.COOKIE_CONSENT_CONFIG;
  if (!config) {
    return;
  }
  const cookieConsent = new CookieConsent(config);

  // Update Tag Manager when `update` event is fired.
  cookieConsent.on('update', cookies => {

    // Example 1: Fire for all accepted cookie types.
    cookies.filter(cookie => cookie.accepted).forEach(cookie => pushEvent({
      event: 'cookieConsent',
      cookieType: cookie.id,
    }));

    // Example 2: Fire only the selected cookie type (e.g. when used with radio buttons).
    pushEvent({
      event: 'cookieConsent',
      cookieConsent: cookies.find(cookie => cookie.accepted).id,
    });

  });

  // Make the object globally available.
  window.CookieConsent = cookieConsent;

};

export const handler = (el, e) => {
  e.preventDefault();
  window.CookieConsent.showDialog();
};
