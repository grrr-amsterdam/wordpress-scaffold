import { register as registerScrollListener } from './scroll-listener';

/**
 * Add class to the body when scrolling.
 * This class disabled pointer-events in the CSS. Greatly enhanced performance.
 */

export default () => {
  let timer;
  registerScrollListener('hover-styles', () => {
    clearTimeout(timer);
    if (!document.body.classList.contains('disable-hover')) {
      document.body.classList.add('disable-hover');
    }
    timer = setTimeout(() => {
      document.body.classList.remove('disable-hover');
    }, 300);
  });
};
