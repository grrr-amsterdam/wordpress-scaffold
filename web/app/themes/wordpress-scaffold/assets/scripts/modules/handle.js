/**
 * Runner of handlers
 */
const findElementWithHandler = elm => {
  if (!elm || elm.tagName === 'HTML') {
    return null;
  }
  if (elm.getAttribute('data-handler')) {
    return elm;
  }
  if (!elm.parentNode || elm.parentNode.nodeName === 'BODY') {
    return false;
  }
  return findElementWithHandler(elm.parentNode);
};

export default handlers => {
  if (!handlers) {
    throw new Error('Nothing to handle');
  }

  document.documentElement.addEventListener('click', (e) => {
    if (e.target.tagName === 'HTML') {
      return;
    }

    const trigger = findElementWithHandler(e.target || e.srcElement);
    if (!trigger) {
      return;
    }

    const handlerCollection = trigger.getAttribute('data-handler');
    if (!handlerCollection) {
      return;
    }

    if (trigger.tagName === 'A' && (e.metaKey || e.ctrlKey || e.shiftKey)) {
      // honour default behaviour on <a>s when using modifier keys when clicking
      // meta / ctrl open in new tab
      // shift opens in a new window
      return;
    }

    handlerCollection.split(',').forEach(handler => {
      if (typeof handlers[handler] === 'function') {
        handlers[handler](trigger, e);
      } else if (console && console.log) {
        console.log('Non-existing handler: "%s" on %o', handler, this);
      }
    });
  });
};
