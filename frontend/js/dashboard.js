// Dashboard JavaScript - Updated for spapp
// Note: API_BASE_URL is already defined in auth.js, no need to redeclare it

// Initialize dashboard when DOM is ready and hash changes
document.addEventListener('DOMContentLoaded', () => {
    if (window.location.hash === '#dashboard') {
        setTimeout(initDashboard, 100);
    }
});

window.addEventListener('hashchange', () => {
    if (window.location.hash === '#dashboard') {
        setTimeout(initDashboard, 100);
    }
});

function initDashboard() {
    console.log('Initializing dashboard...');
    
    const token = getAuthToken();
    const user = getCurrentUser();
    
    console.log('Dashboard init. Token:', token ? 'exists' : 'missing');
    console.log('User:', user);
    
    if (!token || !user) {
        console.log('No token/user, redirecting to login');
        window.location.hash = '#login';
        return;
    }
    
    // Display user name
    const userNameEl = document.getElementById('dashboardUserName');
    if (userNameEl) {
        userNameEl.textContent = user.name || 'User';
    }
    
    // Load bookings
    loadBookings(user.user_id);
    
    // Load notices
    loadNotices();
    
    // Setup button listeners
    setupDashboardListeners();
}

function setupDashboardListeners() {
    const logoutBtn = document.getElementById('logoutBtn');
    if (logoutBtn && !logoutBtn.hasListener) {
        logoutBtn.addEventListener('click', () => {
            if (confirm('Are you sure you want to logout?')) {
                logout();
            }
        });
        logoutBtn.hasListener = true;
    }
    
    const bookNewBtn = document.getElementById('bookNewBtn');
    if (bookNewBtn && !bookNewBtn.hasListener) {
        bookNewBtn.addEventListener('click', () => {
            window.location.hash = '#services';
        });
        bookNewBtn.hasListener = true;
    }
}

// Load user's bookings
async function loadBookings(userId) {
    try {
        const token = getAuthToken();
        const response = await fetch(`${API_BASE_URL}/bookings/user/${userId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        });
        
        console.log('Bookings response status:', response.status);
        const data = await response.json();
        console.log('Bookings data:', data);
        
        const bookingsContainer = document.getElementById('bookingsContainer');
        if (!bookingsContainer) {
            console.error('bookingsContainer not found');
            return;
        }
        
        if (response.ok && data.data) {
            const bookings = Array.isArray(data.data) ? data.data : [data.data];
            displayBookings(bookings);
            updateBookingStats(bookings);
        } else {
            bookingsContainer.innerHTML = `
                <div class="alert alert-warning">
                    <p>No bookings yet. <a href="#services">Book a service now!</a></p>
                </div>
            `;
        }
    } catch (error) {
        console.error('Error loading bookings:', error);
        const bookingsContainer = document.getElementById('bookingsContainer');
        if (bookingsContainer) {
            bookingsContainer.innerHTML = `
                <div class="alert alert-danger">
                    <p>Error loading bookings: ${error.message}</p>
                </div>
            `;
        }
    }
}

// Display bookings in a nice format
function displayBookings(bookings) {
    const bookingsContainer = document.getElementById('bookingsContainer');
    if (!bookingsContainer) return;
    
    if (!bookings || bookings.length === 0) {
        bookingsContainer.innerHTML = `
            <div class="alert alert-info">
                <p>No bookings found. <a href="#services">Book a service now!</a></p>
            </div>
        `;
        return;
    }
    
    let bookingsHTML = '<div class="row g-3">';
    
    bookings.forEach(booking => {
        const bookingDate = new Date(booking.booking_date);
        const isUpcoming = bookingDate > new Date();
        const statusBadge = isUpcoming ? 
            '<span class="badge bg-success">Upcoming</span>' : 
            '<span class="badge bg-secondary">Completed</span>';
        
        bookingsHTML += `
            <div class="col-12 col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0">Booking #${booking.booking_id}</h5>
                            ${statusBadge}
                        </div>
                        <p class="mb-2">
                            <strong>Service:</strong> Service #${booking.service_id}
                        </p>
                        <p class="mb-2">
                            <strong>Date:</strong> ${bookingDate.toLocaleDateString()} ${bookingDate.toLocaleTimeString()}
                        </p>
                        <p class="mb-0 text-muted">
                            <strong>Team:</strong> ${booking.team_id ? 'Assigned' : 'Not assigned yet'}
                        </p>
                        <button class="btn btn-sm btn-outline-primary mt-3" onclick="viewBookingDetails(${booking.booking_id})">
                            View Details
                        </button>
                    </div>
                </div>
            </div>
        `;
    });
    
    bookingsHTML += '</div>';
    bookingsContainer.innerHTML = bookingsHTML;
}

// Update booking statistics
function updateBookingStats(bookings) {
    const now = new Date();
    let upcoming = 0;
    let completed = 0;
    
    bookings.forEach(booking => {
        const bookingDate = new Date(booking.booking_date);
        if (bookingDate > now) {
            upcoming++;
        } else {
            completed++;
        }
    });
    
    const totalEl = document.getElementById('totalBookings');
    const upcomingEl = document.getElementById('upcomingBookings');
    const completedEl = document.getElementById('completedBookings');
    
    if (totalEl) totalEl.textContent = bookings.length;
    if (upcomingEl) upcomingEl.textContent = upcoming;
    if (completedEl) completedEl.textContent = completed;
}

// Load notices
function loadNotices() {
    const noticesContainer = document.getElementById('noticesContainer');
    if (!noticesContainer) return;
    
    const notices = [
        {
            title: '✨ New Premium Package',
            message: 'Check out our new premium detailing package with special discounts!'
        },
        {
            title: '🎉 Loyalty Rewards',
            message: 'Earn points on every booking and redeem them for discounts!'
        },
        {
            title: '📍 Service Area Expanded',
            message: 'We now serve additional areas! Check if your location is covered.'
        }
    ];
    
    let noticesHTML = '';
    notices.forEach(notice => {
        noticesHTML += `
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>${notice.title}</strong><br>
                ${notice.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
    });
    
    noticesContainer.innerHTML = noticesHTML;
}

// View booking details
function viewBookingDetails(bookingId) {
    alert(`Viewing details for booking #${bookingId}\n\nThis feature will be implemented soon!`);
}

// Helper functions (already defined in auth.js, but safe to redefine)
function getAuthToken() {
    return localStorage.getItem('token');
}

function getCurrentUser() {
    const userStr = localStorage.getItem('user');
    return userStr ? JSON.parse(userStr) : null;
}

function logout() {
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    localStorage.removeItem('rememberMe');
    localStorage.removeItem('rememberedEmail');
    window.location.hash = '#login';
}
