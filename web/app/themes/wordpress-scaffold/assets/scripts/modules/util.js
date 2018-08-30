export const getScrollPosition = () => {
  const supportPageOffset = window.pageXOffset !== undefined;
  const isCSS1Compat = ((document.compatMode || "") === "CSS1Compat");

  /* eslint-disable no-nested-ternary */
  const x = supportPageOffset ? window.pageXOffset : isCSS1Compat
    ? document.documentElement.scrollLeft : document.body.scrollLeft;

  const y = supportPageOffset ? window.pageYOffset : isCSS1Compat
    ? document.documentElement.scrollTop : document.body.scrollTop;
  return {
    x, y,
  };
};

export const closest = (elm, selector) => {
  let matchesFn;

  // find vendor prefix
  [
    'matches',
    'webkitMatchesSelector',
    'mozMatchesSelector',
    'msMatchesSelector',
    'oMatchesSelector',
  ].some(fn => {
    if (typeof document.body[fn] === 'function') {
      matchesFn = fn;
      return true;
    }
    return false;
  });

  // traverse parents
  /* eslint-disable no-param-reassign */
  while (elm !== null) {
    const parent = elm.parentElement;
    if (parent !== null && parent[matchesFn](selector)) {
      return parent;
    }
    elm = parent;
  }

  return null;
};

export const head = a => a[0];

export const forEach = (a, fn) => Array.prototype.forEach.call(a, fn);

export const filter = (a, fn) => Array.prototype.filter.call(a, fn);

export const not = fn => (...args) => !fn(...args);

export const objectByKey = (arr, key) => {
  return arr.reduce((prev, curr) => {
    if (typeof curr[key] === 'undefined') {
      return prev;
    }
    prev[curr[key]] = curr;
    return prev;
  }, {});
};
