/**
 * @NOTE Most utils have moved to the `@grrr/utils` package. Feel free to add
 * missing functions there.
 */

export const getScrollPosition = () => {
  const supportPageOffset = window.pageXOffset !== undefined;
  const isCSS1Compat = (document.compatMode || "") === "CSS1Compat";

  /* eslint-disable no-nested-ternary */
  const x = supportPageOffset
    ? window.pageXOffset
    : isCSS1Compat ? document.documentElement.scrollLeft : document.body.scrollLeft;

  const y = supportPageOffset
    ? window.pageYOffset
    : isCSS1Compat ? document.documentElement.scrollTop : document.body.scrollTop;
  return {
    x,
    y,
  };
  /* eslint-enable no-nested-ternary */
};
