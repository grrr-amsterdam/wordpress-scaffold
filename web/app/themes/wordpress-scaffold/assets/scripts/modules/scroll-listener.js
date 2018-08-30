import { getScrollPosition } from './util';

const listeners = {};

const onScroll = e => {
  Object.keys(listeners).forEach(key => {
    if (typeof listeners[key] === 'function') {
      listeners[key](e);
    }
  });
};

export const enhancer = () => {
  window.addEventListener('scroll', onScroll);
};

export const register = (key, fn) => {
  listeners[key] = fn;
};

// Can be called with element or with number
export const isScrolledPast = elm => {
  if (typeof elm === 'number') {
    return getScrollPosition().y >= elm;
  }
  const scrollY = getScrollPosition().y;
  return scrollY + elm.getBoundingClientRect().top <= scrollY;
};

export const isVisible = (elm, offset = 0) => {
  return elm.getBoundingClientRect().top - window.innerHeight <= offset;
};
