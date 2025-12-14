// Configuration - CHANGE THIS TO YOUR BACKEND URL
const API_BASE_URL = 'http://localhost/CarDetailing/backend'; // Changed to correct path

// Helper function to show messages
function showMessage(elementId, message, isSuccess) {
    const msgElement = document.getElementById(elementId);
    console.log('showMessage called:', elementId, message, isSuccess);
    
    if (!msgElement) {
        console.error('Message element not found:', elementId);
        alert(message);
        return;
    }
    msgElement.textContent = message;
    msgElement.className = isSuccess ? 'alert alert-success' : 'alert alert-danger';
    msgElement.style.display = 'block';
    
    console.log(`${isSuccess ? '✓' : '✗'} ${elementId}:`, message);
    
    if (isSuccess) {
        setTimeout(() => {
            msgElement.style.display = 'none';
        }, 3000);
    }
}

// Login Handler
const loginForm = document.getElementById('loginForm');
console.log('loginForm found:', !!loginForm);

if (loginForm) {
    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        console.log('=== LOGIN FORM SUBMITTED ===');
        
        const email = document.getElementById('loginEmail')?.value;
        const password = document.getElementById('loginPassword')?.value;
        const rememberMe = document.getElementById('remember')?.checked;
        
        console.log('Login values:', { email, password: '***', rememberMe });
        
        if (!email || !password) {
            showMessage('loginMessage', 'Email and password are required', false);
            return;
        }
        
        const loginBtn = document.getElementById('loginBtn');
        loginBtn.disabled = true;
        loginBtn.textContent = 'Logging in...';
        
        try {
            console.log('Sending login request to:', `${API_BASE_URL}/auth/login`);
            
            const response = await fetch(`${API_BASE_URL}/auth/login`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    email: email,
                    password: password
                })
            });
            
            console.log('Login response status:', response.status);
            const data = await response.json();
            console.log('Login response data:', data);
            console.log('data.data exists:', !!data.data);
            
            if (response.ok) {
                console.log('✓ Response is OK');
                
                // Save token and user info from data object
                if (data.data) {
                    console.log('✓ data.data found, saving to localStorage');
                    localStorage.setItem('token', data.data.token);
                    localStorage.setItem('user', JSON.stringify(data.data));
                    console.log('✓ Token saved:', localStorage.getItem('token') ? 'YES' : 'NO');
                    console.log('✓ User saved:', localStorage.getItem('user') ? 'YES' : 'NO');
                    
                    if (rememberMe) {
                        localStorage.setItem('rememberMe', 'true');
                        localStorage.setItem('rememberedEmail', email);
                    }
                    
                    showMessage('loginMessage', data.message || 'Login successful! Redirecting...', true);
                    
                    // Redirect after success
                    console.log('Will redirect in 500ms');
                    setTimeout(() => {
                        console.log('✓ Redirecting to #dashboard');
                        window.location.hash = '#dashboard';
                        
                        // Trigger dashboard initialization
                        if (window.initDashboard) {
                            console.log('✓ Calling initDashboard');
                            window.initDashboard();
                        } else {
                            console.warn('⚠ initDashboard function not found');
                        }
                    }, 500);
                } else {
                    console.error('✗ data.data is missing');
                    showMessage('loginMessage', 'Login response missing user data', false);
                }
            } else {
                console.log('✗ Response not OK, status:', response.status);
                showMessage('loginMessage', data.message || 'Login failed', false);
            }
        } catch (error) {
            console.error('✗ Login error:', error);
            showMessage('loginMessage', 'Network error: ' + error.message, false);
        } finally {
            loginBtn.disabled = false;
            loginBtn.textContent = 'Login';
        }
    });
} else {
    console.warn('loginForm not found in DOM');
}

// Register Handler
const registerForm = document.getElementById('registerForm');
console.log('registerForm found:', !!registerForm);

if (registerForm) {
    registerForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        console.log('=== REGISTER FORM SUBMITTED ===');
        
        const firstName = document.getElementById('registerFirstName')?.value;
        const lastName = document.getElementById('registerLastName')?.value;
        const email = document.getElementById('registerEmail')?.value;
        const password = document.getElementById('registerPassword')?.value;
        const confirmPassword = document.getElementById('registerConfirmPassword')?.value;
        
        console.log('Register values:', { firstName, lastName, email, password: '***', confirmPassword: '***' });
        
        if (!firstName || !lastName || !email || !password || !confirmPassword) {
            showMessage('registerMessage', 'All fields are required', false);
            return;
        }
        
        // Validate passwords match
        if (password !== confirmPassword) {
            showMessage('registerMessage', 'Passwords do not match', false);
            return;
        }
        
        // Validate password length
        if (password.length < 6) {
            showMessage('registerMessage', 'Password must be at least 6 characters', false);
            return;
        }
        
        const registerBtn = document.getElementById('registerBtn');
        registerBtn.disabled = true;
        registerBtn.textContent = 'Creating account...';
        
        try {
            console.log('Sending register request to:', `${API_BASE_URL}/auth/register`);
            
            const response = await fetch(`${API_BASE_URL}/auth/register`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    name: firstName,
                    lastname: lastName,
                    email: email,
                    password: password
                })
            });
            
            console.log('Register response status:', response.status);
            const data = await response.json();
            console.log('Register response data:', data);
            
            if (response.ok && data.data) {
                console.log('✓ Registration successful');
                showMessage('registerMessage', data.message || 'Registration successful! Redirecting to login...', true);
                
                // Clear form
                registerForm.reset();
                
                // Redirect to login
                setTimeout(() => {
                    console.log('✓ Redirecting to #login');
                    window.location.hash = '#login';
                }, 1000);
            } else {
                console.log('✗ Registration failed');
                showMessage('registerMessage', data.message || 'Registration failed', false);
            }
        } catch (error) {
            console.error('✗ Register error:', error);
            showMessage('registerMessage', 'Network error: ' + error.message, false);
        } finally {
            registerBtn.disabled = false;
            registerBtn.textContent = 'Create account';
        }
    });
} else {
    console.warn('registerForm not found in DOM');
}

// Auto-populate email if "Remember me" was checked
window.addEventListener('load', () => {
    console.log('Page loaded, checking for remembered email');
    if (localStorage.getItem('rememberMe')) {
        const rememberedEmail = localStorage.getItem('rememberedEmail');
        const loginEmailInput = document.getElementById('loginEmail');
        if (rememberedEmail && loginEmailInput) {
            loginEmailInput.value = rememberedEmail;
            console.log('Populated email:', rememberedEmail);
        }
    }
});

// Helper function to get token from localStorage
function getAuthToken() {
    return localStorage.getItem('token');
}

// Helper function to get current user
function getCurrentUser() {
    const userStr = localStorage.getItem('user');
    return userStr ? JSON.parse(userStr) : null;
}

// Helper function to logout
function logout() {
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    localStorage.removeItem('rememberMe');
    localStorage.removeItem('rememberedEmail');
    window.location.hash = '#login';
}
