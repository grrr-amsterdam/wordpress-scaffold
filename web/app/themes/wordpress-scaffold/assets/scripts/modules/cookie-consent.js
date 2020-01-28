import CookieConsent from '@grrr/cookie-consent';
import { pushEvent } from './gtm-event';

export const enhancer = () => {

  // Construct and initialize the module.
  const cookieConsent = CookieConsent(window.COOKIE_CONSENT_CONFIG);

  // Update Tag Manager when `update` event is fired.
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
