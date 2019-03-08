const COOKIE_BAR_SELECTOR = '.js-cookie-bar';
const STORAGE_KEY = 'accepts_cookies';

const hasLocalStorage = () => {
  try {
    localStorage.setItem(`${STORAGE_KEY}_test`, `${STORAGE_KEY}_test`);
    localStorage.removeItem(`${STORAGE_KEY}_test`);
    return true;
  } catch (e) {
    return false;
  }
};

export const enhancer = el => {
  if (!hasLocalStorage() || localStorage.getItem(STORAGE_KEY)) {
    return;
  }
  el.style.display = 'flex';
  window.setTimeout(e => el.setAttribute('aria-hidden', 'false'), 1000 / 60);
};

export const handler = (el, e) => {
  localStorage.setItem(STORAGE_KEY, 'true');
  const bar = document.querySelector(COOKIE_BAR_SELECTOR);
  if (!bar) {
    return;
  }
  bar.setAttribute('aria-hidden', 'true');
};
