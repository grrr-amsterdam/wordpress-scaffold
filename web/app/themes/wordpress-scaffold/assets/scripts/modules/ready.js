const isDomReady = () => document.readyState !== 'loading';
const isDocumentLoaded = () => document.readyState === 'complete';

/**
 * Execute function when document is fully loaded, for example to initiate
 * a slider after the images are loaded.
 */
export const onDocumentLoaded = fn => {
  const execute = () => {
    if (!isDocumentLoaded()) {
      return;
    }
    fn();
  };

  if (isDocumentLoaded()) {
    fn();
  } else {
    document.addEventListener('readystatechange', execute, false);
  }
};

/**
 * Execute function when DOM is ready, eg. the `main` function.
 */
export const onDomReady = fn => {
  let isReady = false;
  const execute = () => {
    if (isReady) {
      return;
    }
    isReady = true;
    fn();
  };

  if (isDomReady()) {
    fn();
  } else {
    document.addEventListener('DOMContentLoaded', execute, false);
    document.addEventListener('readystatechange', execute, false);
  }
};
