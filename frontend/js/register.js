
document.getElementById("registerForm").addEventListener("submit", async (e) => {
  e.preventDefault();

  const msg = document.getElementById("registerMessage");
  msg.className = "alert d-none";
  msg.textContent = "";

  const data = Object.fromEntries(new FormData(e.target).entries());

  if (data.password !== data.confirm_password) {
    msg.className = "alert alert-danger";
    msg.textContent = "Passwords do not match.";
    msg.classList.remove("d-none");
    return;
  }

  delete data.confirm_password;

  const res = await fetch("../../backend/rest/routes/AuthRoutes.php", {
    method: "POST",
    headers: {"Content-Type": "application/json"},
    body: JSON.stringify(data)
  });

  const result = await res.json();

  if (result.success) {
    msg.className = "alert alert-success";
    msg.textContent = "Success! Redirecting to login...";
    msg.classList.remove("d-none");
    setTimeout(() => window.location.hash = "#login", 1200);
  } else {
    msg.className = "alert alert-danger";
    msg.textContent = result.error || "Registration failed.";
    msg.classList.remove("d-none");
  }
});
