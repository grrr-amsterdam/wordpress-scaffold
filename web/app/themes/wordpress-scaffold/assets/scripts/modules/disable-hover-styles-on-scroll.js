import { register } from './scroll-listener';

/**
 * Add class to the body when scrolling.
 * This class disabled pointer-events in the CSS. Greatly enhanced performance.
 */

export default () => {
  const body = document.body;
  let timer;
  if (!body) {
    return;
  }
  register('hover-styles', () => {
    clearTimeout(timer);
    if (!body.classList.contains('disable-hover')) {
      body.classList.add('disable-hover');
    }

    timer = setTimeout(() => {
      body.classList.remove('disable-hover');
    }, 300);
  });
};
