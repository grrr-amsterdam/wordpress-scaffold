import CookieConsent from '@grrr/cookie-consent';
import { pushEvent } from './gtm-event';

export const enhancer = () => {

  const cookieConsent = new CookieConsent({
    cookies: [
      {
        id: 'analytical',
        label: 'Analytical',
        description: 'Analytical cookies help us understand how visitors interact with websites by collecting and reporting anonymised information.',
        required: true,
      },
      {
        id: 'marketing',
        label: 'Marketing & Social Media',
        description: 'Marketing and social media cookies are used to track visitors across websites. The intention could be to display retargeting ads, or to show embedded content from third parties.',
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
