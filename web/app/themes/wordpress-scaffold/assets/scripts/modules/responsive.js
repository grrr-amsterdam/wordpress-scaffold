/**
 * Responsive breakpoint registry
 */

let docWidth;
const BREAKPOINT_SMALL = 540;
const BREAKPOINT_MEDIUM = 720;
const BREAKPOINT_LARGE = 1020;
const BREAKPOINT_EXTRA_LARGE = 1400;

const setDocWidth = () => {
  docWidth = document.documentElement.clientWidth;
};

export const getDocWidth = () => {
  if (!docWidth) {
    setDocWidth();
  }
  return docWidth;
};

export const matchesBreakpoint = breakpoint => {
  switch (breakpoint) {
    case 'small':
      return getDocWidth() >= BREAKPOINT_SMALL;
    case 'medium':
      return getDocWidth() >= BREAKPOINT_MEDIUM;
    case 'large':
      return getDocWidth() >= BREAKPOINT_LARGE;
    case 'extraLarge':
      return getDocWidth() >= BREAKPOINT_EXTRA_LARGE;
    default:
      return false;
  }
};

export const getCurrentBreakpoint = () => {
  const tries = ['small', 'medium', 'large', 'extraLarge'];
  const i = 0;
  let bp = 'small';

  do {
    bp = tries[i];
  } while (matchesBreakpoint(tries[i + 1]));
  return bp;
};

export const enhancer = () => {
  window.addEventListener('resize', setDocWidth);
  window.addEventListener('orientationchange', setDocWidth);
};
