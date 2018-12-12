const FETCH_PARAMS = {
  method: 'post',
  cache: 'no-cache',
  headers: {
    'Content-Type': 'application/json; charset=utf-8',
  },
};

const NewsletterSignup = form => {
  const emailInput = form.querySelector('[name="email"]');
  const alertElement = form.querySelector('[role="alert"]');

  const hideAlert = () => {
    emailInput.removeAttribute('aria-describedby');
    emailInput.removeAttribute('aria-invalid');
    alertElement.setAttribute('aria-hidden', 'true');
  };

  const showAlert = (message, type) => {
    if (type === 'error') {
      emailInput.setAttribute('aria-invalid', 'true');
      emailInput.setAttribute('aria-describedby', alertElement.id);
    }
    alertElement.setAttribute('aria-hidden', 'false');
    alertElement.setAttribute('data-type', type);
    alertElement.textContent = message;
  };

  const subsribe = ({ action, data }) => {
    return new Promise((resolve, reject) => {
      fetch(action, { ...FETCH_PARAMS, body: JSON.stringify(data) })
        .then(response => {
          if (!response.ok) {
            return response.json().then(result => reject(result.message));
          }
          return response.json().then(resolve);
        });
    });
  };

  const handleSubmit = e => {
    e.preventDefault();
    hideAlert();
    subsribe({
      action: form.getAttribute('action'),
      data: { 'email': emailInput.value },
    })
      .then(message => showAlert(message, 'success'))
      .catch(message => showAlert(message, 'error'));
  };

  return {
    init() {
      form.addEventListener('submit', handleSubmit);
    },
  };
};

export const enhancer = form => {
  const signup = NewsletterSignup(form);
  signup.init();
};
