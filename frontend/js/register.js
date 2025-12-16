


const API_BASE_URL = "http://localhost/CarDetailing/backend";

function showMessage(elementId, message, isSuccess) {
    const msgElement = document.getElementById(elementId);
    if (!msgElement) { alert(message); return; }
    msgElement.textContent = message;
    msgElement.className = isSuccess ? 'alert alert-success' : 'alert alert-danger';
    msgElement.style.display = 'block';
    if (isSuccess) setTimeout(() => { msgElement.style.display = 'none'; }, 3000);
}

document.addEventListener('submit', function (e) {

    /* ================= LOGIN ================= */
    if (e.target && e.target.id === 'loginForm') {
        e.preventDefault();

        const email = $('#loginEmail').val();
        const password = $('#loginPassword').val();
        const btn = $('#loginBtn');

        const originalText = btn.text();
        btn.prop('disabled', true).text('Logging in...');

        $.ajax({
            url: API_BASE_URL + "/auth/login",
            type: "POST",
            data: JSON.stringify({ email, password }),
            contentType: "application/json",
            dataType: "json",
            success: function (data) {
                let token = data.token;
                if (data.data && data.data.token) token = data.data.token;

                if (token) {
                    localStorage.setItem('token', token);
                    localStorage.setItem('user', JSON.stringify(data.data || data));

                    showMessage('loginMessage', 'Login successful!', true);

                    $('#nav-login, #nav-register').addClass('d-none');
                    $('#nav-dashboard, #nav-profile, #nav-logout').removeClass('d-none');

                    setTimeout(() => { window.location.hash = '#dashboard'; }, 500);
                } else {
                    showMessage('loginMessage', 'Login OK but no token?', false);
                }
            },
            error: function (xhr) {
                const msg = xhr.responseJSON?.message || xhr.responseText || 'Login failed';
                showMessage('loginMessage', msg, false);
            },
            complete: function () {
                btn.prop('disabled', false).text(originalText);
            }
        });
    }

    /* ================= REGISTER ================= */
    if (e.target && e.target.id === 'registerForm') {
        e.preventDefault();

        const btn = $('#registerBtn');
        const originalText = btn.text();

        btn.prop('disabled', true).text('Creating...');

        const entity = {
            name: $('#registerName').val(),
            lastname: $('#registerLastName').val(),
            email: $('#registerEmail').val(),
            password: $('#registerPassword').val(),
            role: 'user'
        };

        $.ajax({
            url: API_BASE_URL + "/auth/register",
            type: "POST",
            data: JSON.stringify(entity),
            contentType: "application/json",
            dataType: "json",
            success: function () {
                showMessage('registerMessage', 'Success! Please login.', true);
                setTimeout(() => { window.location.hash = '#login'; }, 1000);
            },
            error: function (xhr) {
                const msg = xhr.responseJSON?.message || xhr.responseText || 'Registration failed';
                showMessage('registerMessage', msg, false);
            },
            complete: function () {
                btn.prop('disabled', false).text(originalText);
            }
        });
    }
});
