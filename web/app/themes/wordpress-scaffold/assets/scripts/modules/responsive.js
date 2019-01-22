import { debounce } from './util';

/**
 * Responsive breakpoint registry
 */

let docWidth;

const BREAKPOINT_TINY = 480;
const BREAKPOINT_SMALL = 640;
const BREAKPOINT_MEDIUM = 960;
const BREAKPOINT_LARGE = 1280;
const BREAKPOINT_HUGE = 1680;

const setDocWidth = () => {
  docWidth = window.innerWidth || document.documentElement.clientWidth;
};

export const getDocWidth = () => {
  if (!docWidth) {
    setDocWidth();
  }
  return docWidth;
};

export const matchesBreakpoint = breakpoint => {
  switch (breakpoint) {
    case 'tiny':
      return getDocWidth() >= BREAKPOINT_TINY;
    case 'small':
      return getDocWidth() >= BREAKPOINT_SMALL;
    case 'medium':
      return getDocWidth() >= BREAKPOINT_MEDIUM;
    case 'large':
      return getDocWidth() >= BREAKPOINT_LARGE;
    case 'huge':
      return getDocWidth() >= BREAKPOINT_HUGE;
    default:
      return false;
  }
};

export const getCurrentBreakpoint = () => {
  const breakpoints = ['tiny', 'small', 'medium', 'large', 'huge'];
  const matches = breakpoints.filter(matchesBreakpoint);
  return matches[matches.length - 1];
};

export const enhancer = () => {
  window.addEventListener('resize', debounce(setDocWidth, 300));
  window.addEventListener('orientationchange', debounce(setDocWidth, 300));
};
