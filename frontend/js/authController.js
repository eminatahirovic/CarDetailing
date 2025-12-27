document.addEventListener("DOMContentLoaded", function () {

  /* =====================
     LOGIN
  ====================== */
  const loginForm = document.getElementById("login-form");

  if (loginForm) {
    loginForm.addEventListener("submit", function (e) {
      e.preventDefault();

      const email = document.getElementById("login-email").value;
      const password = document.getElementById("login-password").value;

      AuthService.login({
        email: email,
        password: password
      })
        .then(function (response) {
          localStorage.setItem("user", JSON.stringify(response));
          alert("Login successful");
          window.location.href = "dashboard.html"; // adjust if needed
        })
        .catch(function (error) {
          alert("Login failed");
          console.error(error);
        });
    });
  }

  /* =====================
     REGISTER
  ====================== */
  const registerForm = document.getElementById("register-form");

  if (registerForm) {
    registerForm.addEventListener("submit", function (e) {
      e.preventDefault();

      const name = document.getElementById("register-name").value;
      const email = document.getElementById("register-email").value;
      const password = document.getElementById("register-password").value;

      AuthService.register({
        name: name,
        email: email,
        password: password
      })
        .then(function () {
          alert("Registration successful. You can now log in.");
          window.location.href = "index.html";
        })
        .catch(function (error) {
          alert("Registration failed");
          console.error(error);
        });
    });
  }

});
