const EMAIL_REGEX = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const PASSWORD_REGEX = /^(?=.*[A-Za-z])(?=.*\d).{8,}$/;

function showMessage(elementId, message, isSuccess) {
  const msgElement = document.getElementById(elementId);
  if (!msgElement) {
    if (message) alert(message);
    return;
  }
  msgElement.textContent = message || "";
  msgElement.className = isSuccess ? "alert alert-success" : "alert alert-danger";
  msgElement.style.display = message ? "block" : "none";
  if (isSuccess) {
    setTimeout(() => {
      msgElement.style.display = "none";
    }, 3000);
  }
}

function getErrorElement(inputEl) {
  if (!inputEl || !inputEl.id) return null;
  return document.getElementById(`${inputEl.id}Error`);
}

function setFieldError(inputEl, message) {
  if (!inputEl) return;
  inputEl.classList.add("is-invalid");
  const errEl = getErrorElement(inputEl);
  if (errEl) {
    errEl.textContent = message || "";
  }
}

function clearFieldError(inputEl) {
  if (!inputEl) return;
  inputEl.classList.remove("is-invalid");
  const errEl = getErrorElement(inputEl);
  if (errEl) {
    errEl.textContent = "";
  }
}

function clearFormErrors(form) {
  if (!form) return;
  const invalidFields = form.querySelectorAll(".is-invalid");
  invalidFields.forEach((field) => clearFieldError(field));
}

function normalizePhone(value) {
  return value.replace(/\s+/g, "");
}

function isValidPhone(value) {
  if (!value) return false;
  const trimmed = normalizePhone(value);
  if (!/^\+?\d+$/.test(trimmed)) return false;
  const digitsOnly = trimmed.replace(/\D/g, "");
  return digitsOnly.length >= 8;
}

function startSubmitting(form, button, label) {
  if (form) form.dataset.submitting = "true";
  if (button) {
    button.disabled = true;
    button.dataset.originalText = button.textContent;
    button.textContent = label;
  }
}

function stopSubmitting(form, button) {
  if (form) form.dataset.submitting = "false";
  if (button) {
    button.disabled = false;
    if (button.dataset.originalText) {
      button.textContent = button.dataset.originalText;
    }
  }
}

function wireFieldClearOnInput(formId) {
  const form = document.getElementById(formId);
  if (!form) return;
  form.addEventListener("input", (e) => {
    if (e.target && e.target.classList.contains("form-control")) {
      clearFieldError(e.target);
    }
  });
}

document.addEventListener("DOMContentLoaded", () => {
  wireFieldClearOnInput("loginForm");
  wireFieldClearOnInput("registerForm");
  wireFieldClearOnInput("contactForm");
});

document.addEventListener("submit", async function (e) {
  if (e.target && e.target.id === "loginForm") {
    e.preventDefault();
    const form = e.target;
    if (form.dataset.submitting === "true") return;

    clearFormErrors(form);
    showMessage("loginMessage", "", false);

    const emailInput = document.getElementById("loginEmail");
    const passwordInput = document.getElementById("loginPassword");
    const email = emailInput.value.trim();
    const password = passwordInput.value.trim();
    let hasErrors = false;

    if (!email) {
      setFieldError(emailInput, "Email is required.");
      hasErrors = true;
    } else if (!EMAIL_REGEX.test(email)) {
      setFieldError(emailInput, "Enter a valid email.");
      hasErrors = true;
    }

    if (!password) {
      setFieldError(passwordInput, "Password is required.");
      hasErrors = true;
    }

    if (hasErrors) {
      showMessage("loginMessage", "Please fix the errors below.", false);
      return;
    }

    const btn = document.getElementById("loginBtn");
    startSubmitting(form, btn, "Logging in...");

    try {
      const data = await AuthService.login({ email: email, password: password });
      const payload = data && data.data ? data.data : data;
      const token = payload && payload.token ? payload.token : null;

      if (token) {
        localStorage.setItem("token", token);
        const userData = Object.assign({}, payload);
        delete userData.token;
        localStorage.setItem("user", JSON.stringify(userData));

        showMessage("loginMessage", "Login successful!", true);
        setTimeout(() => {
          window.location.hash = "#dashboard";
        }, 500);
      } else {
        showMessage("loginMessage", "Login succeeded but token missing.", false);
      }
    } catch (err) {
      showMessage("loginMessage", err.message || "Login failed.", false);
    } finally {
      stopSubmitting(form, btn);
    }
  }

  if (e.target && e.target.id === "registerForm") {
    e.preventDefault();
    const form = e.target;
    if (form.dataset.submitting === "true") return;

    clearFormErrors(form);
    showMessage("registerMessage", "", false);

    const nameInput = document.getElementById("registerName");
    const lastNameInput = document.getElementById("registerLastName");
    const emailInput = document.getElementById("registerEmail");
    const passwordInput = document.getElementById("registerPassword");
    const confirmInput = document.getElementById("registerConfirmPassword");

    const name = nameInput.value.trim();
    const lastname = lastNameInput.value.trim();
    const email = emailInput.value.trim();
    const password = passwordInput.value.trim();
    const confirmPassword = confirmInput.value.trim();

    let hasErrors = false;

    if (!name) {
      setFieldError(nameInput, "First name is required.");
      hasErrors = true;
    }
    if (!lastname) {
      setFieldError(lastNameInput, "Last name is required.");
      hasErrors = true;
    }
    if (!email) {
      setFieldError(emailInput, "Email is required.");
      hasErrors = true;
    } else if (!EMAIL_REGEX.test(email)) {
      setFieldError(emailInput, "Enter a valid email.");
      hasErrors = true;
    }
    if (!password) {
      setFieldError(passwordInput, "Password is required.");
      hasErrors = true;
    } else if (!PASSWORD_REGEX.test(password)) {
      setFieldError(passwordInput, "Min 8 chars with letters and numbers.");
      hasErrors = true;
    }
    if (!confirmPassword) {
      setFieldError(confirmInput, "Confirm your password.");
      hasErrors = true;
    } else if (password !== confirmPassword) {
      setFieldError(confirmInput, "Passwords do not match.");
      hasErrors = true;
    }

    if (hasErrors) {
      showMessage("registerMessage", "Please fix the errors below.", false);
      return;
    }

    const btn = document.getElementById("registerBtn");
    startSubmitting(form, btn, "Creating...");

    try {
      await AuthService.register({
        name: name,
        lastname: lastname,
        email: email,
        password: password,
        role: "user"
      });
      showMessage("registerMessage", "Success! Please login.", true);
      setTimeout(() => {
        window.location.hash = "#login";
      }, 800);
      form.reset();
    } catch (err) {
      showMessage("registerMessage", err.message || "Registration failed.", false);
      if (err.fields) {
        Object.keys(err.fields).forEach((fieldKey) => {
          const inputEl = document.querySelector(`[name="${fieldKey}"]`);
          if (inputEl) setFieldError(inputEl, err.fields[fieldKey]);
        });
      }
    } finally {
      stopSubmitting(form, btn);
    }
  }

  if (e.target && e.target.id === "contactForm") {
    e.preventDefault();
    const form = e.target;
    if (form.dataset.submitting === "true") return;

    clearFormErrors(form);
    showMessage("contactMessage", "", false);

    const nameInput = document.getElementById("contactName");
    const phoneInput = document.getElementById("contactPhone");
    const emailInput = document.getElementById("contactEmail");
    const serviceInput = document.getElementById("contactService");
    const messageInput = document.getElementById("contactMessageField");

    const name = nameInput.value.trim();
    const phone = normalizePhone(phoneInput.value.trim());
    const email = emailInput.value.trim();
    const service = serviceInput.value.trim();
    const message = messageInput.value.trim();

    let hasErrors = false;

    if (!name) {
      setFieldError(nameInput, "Full name is required.");
      hasErrors = true;
    }
    if (!phone) {
      setFieldError(phoneInput, "Phone is required.");
      hasErrors = true;
    } else if (!isValidPhone(phone)) {
      setFieldError(phoneInput, "Enter a valid phone number.");
      hasErrors = true;
    }
    if (!email) {
      setFieldError(emailInput, "Email is required.");
      hasErrors = true;
    } else if (!EMAIL_REGEX.test(email)) {
      setFieldError(emailInput, "Enter a valid email.");
      hasErrors = true;
    }
    if (!service) {
      setFieldError(serviceInput, "Please select a service.");
      hasErrors = true;
    }
    if (!message) {
      setFieldError(messageInput, "Message is required.");
      hasErrors = true;
    }

    if (hasErrors) {
      showMessage("contactMessage", "Please fix the errors below.", false);
      return;
    }

    const btn = document.getElementById("contactBtn");
    startSubmitting(form, btn, "Sending...");

    try {
      await ContactService.submit({
        name: name,
        phone: phone,
        email: email,
        service: service,
        message: message
      });
      showMessage("contactMessage", "Thanks! We'll contact you shortly.", true);
      form.reset();
    } catch (err) {
      showMessage("contactMessage", err.message || "Message failed to send.", false);
      if (err.fields) {
        Object.keys(err.fields).forEach((fieldKey) => {
          const inputEl = document.querySelector(`[name="${fieldKey}"]`);
          if (inputEl) setFieldError(inputEl, err.fields[fieldKey]);
        });
      }
    } finally {
      stopSubmitting(form, btn);
    }
  }
});
