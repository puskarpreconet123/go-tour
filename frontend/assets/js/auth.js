// Authentication Helper Module for Go Tour
const AUTH_API_BASE_URL = 'https://go-tour-backend.onrender.com/api/v1';

// Token operations
function getAuthToken() {
    return localStorage.getItem('api_token');
}

function getAuthUser() {
    try {
        return JSON.parse(localStorage.getItem('user_data'));
    } catch (e) {
        return null;
    }
}

function isAuthenticated() {
    return !!getAuthToken();
}

// Perform Login request
async function loginUser(email, password) {
    try {
        const response = await fetch(`${AUTH_API_BASE_URL}/auth/login`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ email, password })
        });
        
        const data = await response.json();
        
        if (!response.ok) {
            // Retrieve validation or login error message
            const errorMsg = data.errors 
                ? Object.values(data.errors).flat().join(' ') 
                : (data.message || 'Invalid credentials');
            throw new Error(errorMsg);
        }
        
        // Save token and user details to localStorage
        localStorage.setItem('api_token', data.token);
        localStorage.setItem('user_data', JSON.stringify(data.data));
        return { success: true, message: 'Success!' };
    } catch (error) {
        console.error('Login error:', error);
        return { success: false, error: error.message };
    }
}

// Perform Registration request
async function registerUser(name, email, password) {
    try {
        const response = await fetch(`${AUTH_API_BASE_URL}/auth/register`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ name, email, password })
        });
        
        const data = await response.json();
        
        if (!response.ok) {
            const errorMsg = data.errors 
                ? Object.values(data.errors).flat().join(' ') 
                : (data.message || 'Registration failed');
            throw new Error(errorMsg);
        }
        
        // Log user in automatically by saving the token and user data
        localStorage.setItem('api_token', data.token);
        localStorage.setItem('user_data', JSON.stringify(data.data));
        return { success: true };
    } catch (error) {
        console.error('Registration error:', error);
        return { success: false, error: error.message };
    }
}

// Logout
function logoutUser() {
    localStorage.removeItem('api_token');
    localStorage.removeItem('user_data');
    window.location.href = 'login';
}

// Protect pages from unauthenticated guests
function checkPageAuthentication() {
    const protectedPages = ['booking', 'confirmation'];
    const currentPath = window.location.pathname;
    const isProtected = protectedPages.some(page => currentPath.endsWith(page) || currentPath.endsWith(page + '.html'));
    
    if (isProtected && !isAuthenticated()) {
        const redirectParam = encodeURIComponent(window.location.search ? currentPath + window.location.search : currentPath);
        window.location.href = `login?redirect=${redirectParam}`;
    }
}

// Auto run route guard on script load
checkPageAuthentication();
