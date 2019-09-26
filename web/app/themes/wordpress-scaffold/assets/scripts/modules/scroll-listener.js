import { getScrollPosition } from './util';

const listeners = {};

const onScroll = e => {
  Object.keys(listeners).forEach(key => {
    if (typeof listeners[key] === 'function') {
      listeners[key](e);
    }
  });
};

export const register = (key, fn) => {
  listeners[key] = fn;
};

export const unregister = key => delete listeners[key];

// Can be called with element or with number.
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

export const isVisibleOrScrolledPast = (elm, offset = 0) => {
  const dims = elm.getBoundingClientRect();
  return dims.top - window.innerHeight <= offset;
};

export const isInView = (elm, offset = 0) => {
  const top = elm.getBoundingClientRect().top - window.innerHeight <= 0;
  const bottom = elm.getBoundingClientRect().bottom >= 0;
  return top && bottom;
};

export const enhancer = () => {
  window.addEventListener('scroll', onScroll);
};
