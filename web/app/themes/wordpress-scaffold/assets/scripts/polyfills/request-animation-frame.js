/**
 * Simple requestAnimationFrame
 * @see http://elektronotdienst-nuernberg.de/bugs/requestAnimationFrame.html
 */
export default c =>
  setTimeout(
    () => {
      c(+new Date());
    },
    30
  );
