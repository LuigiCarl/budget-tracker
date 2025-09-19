<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .endpoint-card {
            transition: all 0.3s ease;
        }
        .endpoint-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        .method-badge {
            font-weight: bold;
            padding: 0.25rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            text-transform: uppercase;
        }
        .method-get { background-color: #10b981; color: white; }
        .method-post { background-color: #3b82f6; color: white; }
        .method-put { background-color: #f59e0b; color: white; }
        .method-delete { background-color: #ef4444; color: white; }
        pre {
            background-color: #1f2937;
            color: #f3f4f6;
            padding: 1rem;
            border-radius: 0.375rem;
            overflow-x: auto;
            white-space: pre-wrap;
        }
        .response-container {
            max-height: 300px;
            overflow-y: auto;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">API Documentation</h1>
            <p class="text-gray-600">Interactive documentation and testing for your Laravel API endpoints</p>
        </div>

        <!-- Global Token Input -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">🔑 Authentication</h2>
            <p class="text-gray-600 mb-4">Enter your Sanctum bearer token here to authenticate API requests:</p>
            <div class="flex gap-4">
                <input 
                    type="text" 
                    id="globalToken" 
                    placeholder="Bearer token (e.g., 1|abcd...)" 
                    class="flex-1 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <button 
                    onclick="setGlobalToken()" 
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors"
                >
                    Set Token
                </button>
                <button 
                    onclick="clearGlobalToken()" 
                    class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors"
                >
                    Clear
                </button>
            </div>
            <div id="tokenStatus" class="mt-2 text-sm"></div>
        </div>

        <!-- API Endpoints -->
        <div class="space-y-6">
            
            <!-- User Registration Endpoint -->
            <div class="endpoint-card bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <span class="method-badge method-post">POST</span>
                        <span class="font-mono text-lg">/api/register</span>
                    </div>
                    <span class="text-sm text-gray-500">Authentication: None</span>
                </div>
                
                <p class="text-gray-600 mb-4">Register a new user account</p>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Parameters -->
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-2">Request Parameters</h4>
                        <ul class="text-sm text-gray-600 space-y-1 mb-4">
                            <li><code class="bg-gray-100 px-2 py-1 rounded">name</code> (string, required) - User's full name</li>
                            <li><code class="bg-gray-100 px-2 py-1 rounded">email</code> (string, required) - User's email address</li>
                            <li><code class="bg-gray-100 px-2 py-1 rounded">password</code> (string, required) - Minimum 8 characters</li>
                            <li><code class="bg-gray-100 px-2 py-1 rounded">password_confirmation</code> (string, required) - Must match password</li>
                        </ul>
                        
                        <!-- Test Form -->
                        <div class="bg-gray-50 p-4 rounded-md">
                            <h5 class="font-medium text-gray-800 mb-3">Test this endpoint</h5>
                            <form onsubmit="testEndpoint(event, 'register')" class="space-y-2">
                                <input name="name" placeholder="Full Name" class="w-full border border-gray-300 rounded px-3 py-2 text-sm" required>
                                <input name="email" type="email" placeholder="Email" class="w-full border border-gray-300 rounded px-3 py-2 text-sm" required>
                                <input name="password" type="password" placeholder="Password" class="w-full border border-gray-300 rounded px-3 py-2 text-sm" required>
                                <input name="password_confirmation" type="password" placeholder="Confirm Password" class="w-full border border-gray-300 rounded px-3 py-2 text-sm" required>
                                <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition-colors">
                                    Send Request
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Example Response -->
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-2">Example Response</h4>
                        <pre class="text-xs">{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "email_verified_at": null,
    "created_at": "2024-01-15T10:30:00.000000Z",
    "updated_at": "2024-01-15T10:30:00.000000Z"
  },
  "token": "1|abcdef123456..."
}</pre>
                    </div>
                </div>
                
                <!-- Response Container -->
                <div id="response-register" class="mt-4 hidden">
                    <h4 class="font-semibold text-gray-800 mb-2">Response</h4>
                    <div class="response-container">
                        <pre id="response-content-register"></pre>
                    </div>
                </div>
            </div>

            <!-- User Login Endpoint -->
            <div class="endpoint-card bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <span class="method-badge method-post">POST</span>
                        <span class="font-mono text-lg">/api/login</span>
                    </div>
                    <span class="text-sm text-gray-500">Authentication: None</span>
                </div>
                
                <p class="text-gray-600 mb-4">Authenticate a user and get access token</p>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Parameters -->
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-2">Request Parameters</h4>
                        <ul class="text-sm text-gray-600 space-y-1 mb-4">
                            <li><code class="bg-gray-100 px-2 py-1 rounded">email</code> (string, required) - User's email address</li>
                            <li><code class="bg-gray-100 px-2 py-1 rounded">password</code> (string, required) - User's password</li>
                        </ul>
                        
                        <!-- Test Form -->
                        <div class="bg-gray-50 p-4 rounded-md">
                            <h5 class="font-medium text-gray-800 mb-3">Test this endpoint</h5>
                            <form onsubmit="testEndpoint(event, 'login')" class="space-y-2">
                                <input name="email" type="email" placeholder="Email" class="w-full border border-gray-300 rounded px-3 py-2 text-sm" required>
                                <input name="password" type="password" placeholder="Password" class="w-full border border-gray-300 rounded px-3 py-2 text-sm" required>
                                <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition-colors">
                                    Send Request
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Example Response -->
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-2">Example Response</h4>
                        <pre class="text-xs">{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "email_verified_at": "2024-01-15T10:30:00.000000Z",
    "created_at": "2024-01-15T10:30:00.000000Z",
    "updated_at": "2024-01-15T10:30:00.000000Z"
  },
  "token": "2|xyz789def456..."
}</pre>
                    </div>
                </div>
                
                <!-- Response Container -->
                <div id="response-login" class="mt-4 hidden">
                    <h4 class="font-semibold text-gray-800 mb-2">Response</h4>
                    <div class="response-container">
                        <pre id="response-content-login"></pre>
                    </div>
                </div>
            </div>

            <!-- Get User Endpoint -->
            <div class="endpoint-card bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <span class="method-badge method-get">GET</span>
                        <span class="font-mono text-lg">/api/user</span>
                    </div>
                    <span class="text-sm text-red-500">Authentication: Required</span>
                </div>
                
                <p class="text-gray-600 mb-4">Get the authenticated user's profile information</p>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Parameters -->
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-2">Request Parameters</h4>
                        <p class="text-sm text-gray-600 mb-4">No parameters required. Requires Bearer token in Authorization header.</p>
                        
                        <!-- Test Form -->
                        <div class="bg-gray-50 p-4 rounded-md">
                            <h5 class="font-medium text-gray-800 mb-3">Test this endpoint</h5>
                            <form onsubmit="testEndpoint(event, 'user')" class="space-y-2">
                                <button type="submit" class="w-full bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 transition-colors">
                                    Send Request
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Example Response -->
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-2">Example Response</h4>
                        <pre class="text-xs">{
  "id": 1,
  "name": "John Doe",
  "email": "john@example.com",
  "email_verified_at": "2024-01-15T10:30:00.000000Z",
  "created_at": "2024-01-15T10:30:00.000000Z",
  "updated_at": "2024-01-15T10:30:00.000000Z"
}</pre>
                    </div>
                </div>
                
                <!-- Response Container -->
                <div id="response-user" class="mt-4 hidden">
                    <h4 class="font-semibold text-gray-800 mb-2">Response</h4>
                    <div class="response-container">
                        <pre id="response-content-user"></pre>
                    </div>
                </div>
            </div>

            <!-- Update Profile Information Endpoint -->
            <div class="endpoint-card bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <span class="method-badge method-put">PUT</span>
                        <span class="font-mono text-lg">/api/user/profile-information</span>
                    </div>
                    <span class="text-sm text-red-500">Authentication: Required</span>
                </div>
                
                <p class="text-gray-600 mb-4">Update the authenticated user's profile information (name and email)</p>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Parameters -->
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-2">Request Parameters</h4>
                        <ul class="text-sm text-gray-600 space-y-1 mb-4">
                            <li><code class="bg-gray-100 px-2 py-1 rounded">name</code> (string, required) - User's full name</li>
                            <li><code class="bg-gray-100 px-2 py-1 rounded">email</code> (string, required) - User's email address</li>
                        </ul>
                        
                        <!-- Test Form -->
                        <div class="bg-gray-50 p-4 rounded-md">
                            <h5 class="font-medium text-gray-800 mb-3">Test this endpoint</h5>
                            <form onsubmit="testEndpoint(event, 'updateProfile')" class="space-y-2">
                                <input name="name" placeholder="Full Name" class="w-full border border-gray-300 rounded px-3 py-2 text-sm" required>
                                <input name="email" type="email" placeholder="Email" class="w-full border border-gray-300 rounded px-3 py-2 text-sm" required>
                                <button type="submit" class="w-full bg-orange-500 text-white py-2 px-4 rounded hover:bg-orange-600 transition-colors">
                                    Send Request
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Example Response -->
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-2">Example Response</h4>
                        <pre class="text-xs">{
  "message": "Profile updated successfully",
  "user": {
    "id": 1,
    "name": "Jane Smith",
    "email": "jane@example.com",
    "email_verified_at": null,
    "created_at": "2024-01-15T10:30:00.000000Z",
    "updated_at": "2024-01-15T11:45:00.000000Z"
  }
}</pre>
                    </div>
                </div>
                
                <!-- Response Container -->
                <div id="response-updateProfile" class="mt-4 hidden">
                    <h4 class="font-semibold text-gray-800 mb-2">Response</h4>
                    <div class="response-container">
                        <pre id="response-content-updateProfile"></pre>
                    </div>
                </div>
            </div>

            <!-- Update Password Endpoint -->
            <div class="endpoint-card bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <span class="method-badge method-put">PUT</span>
                        <span class="font-mono text-lg">/api/user/password</span>
                    </div>
                    <span class="text-sm text-red-500">Authentication: Required</span>
                </div>
                
                <p class="text-gray-600 mb-4">Update the authenticated user's password</p>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Parameters -->
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-2">Request Parameters</h4>
                        <ul class="text-sm text-gray-600 space-y-1 mb-4">
                            <li><code class="bg-gray-100 px-2 py-1 rounded">current_password</code> (string, required) - Current password</li>
                            <li><code class="bg-gray-100 px-2 py-1 rounded">password</code> (string, required) - New password (minimum 8 characters)</li>
                            <li><code class="bg-gray-100 px-2 py-1 rounded">password_confirmation</code> (string, required) - Confirm new password</li>
                        </ul>
                        
                        <!-- Test Form -->
                        <div class="bg-gray-50 p-4 rounded-md">
                            <h5 class="font-medium text-gray-800 mb-3">Test this endpoint</h5>
                            <form onsubmit="testEndpoint(event, 'updatePassword')" class="space-y-2">
                                <input name="current_password" type="password" placeholder="Current Password" class="w-full border border-gray-300 rounded px-3 py-2 text-sm" required>
                                <input name="password" type="password" placeholder="New Password" class="w-full border border-gray-300 rounded px-3 py-2 text-sm" required>
                                <input name="password_confirmation" type="password" placeholder="Confirm New Password" class="w-full border border-gray-300 rounded px-3 py-2 text-sm" required>
                                <button type="submit" class="w-full bg-purple-500 text-white py-2 px-4 rounded hover:bg-purple-600 transition-colors">
                                    Send Request
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Example Response -->
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-2">Example Response</h4>
                        <pre class="text-xs">{
  "message": "Password updated successfully"
}</pre>
                    </div>
                </div>
                
                <!-- Response Container -->
                <div id="response-updatePassword" class="mt-4 hidden">
                    <h4 class="font-semibold text-gray-800 mb-2">Response</h4>
                    <div class="response-container">
                        <pre id="response-content-updatePassword"></pre>
                    </div>
                </div>
            </div>

            <!-- Logout Endpoint -->
            <div class="endpoint-card bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <span class="method-badge method-post">POST</span>
                        <span class="font-mono text-lg">/api/logout</span>
                    </div>
                    <span class="text-sm text-red-500">Authentication: Required</span>
                </div>
                
                <p class="text-gray-600 mb-4">Logout the authenticated user and revoke their access token</p>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Parameters -->
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-2">Request Parameters</h4>
                        <p class="text-sm text-gray-600 mb-4">No parameters required. Requires Bearer token in Authorization header.</p>
                        
                        <!-- Test Form -->
                        <div class="bg-gray-50 p-4 rounded-md">
                            <h5 class="font-medium text-gray-800 mb-3">Test this endpoint</h5>
                            <form onsubmit="testEndpoint(event, 'logout')" class="space-y-2">
                                <button type="submit" class="w-full bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600 transition-colors">
                                    Send Request
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Example Response -->
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-2">Example Response</h4>
                        <pre class="text-xs">{
  "message": "Logged out successfully"
}</pre>
                    </div>
                </div>
                
                <!-- Response Container -->
                <div id="response-logout" class="mt-4 hidden">
                    <h4 class="font-semibold text-gray-800 mb-2">Response</h4>
                    <div class="response-container">
                        <pre id="response-content-logout"></pre>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="text-center mt-12 text-gray-500">
            <p>Built with Laravel Breeze + Sanctum API</p>
        </div>
    </div>

    <script>
        let globalToken = '';
        
        // API Endpoint configurations
        const endpoints = {
            register: {
                method: 'POST',
                url: '/api/register',
                requiresAuth: false
            },
            login: {
                method: 'POST',
                url: '/api/login',
                requiresAuth: false
            },
            user: {
                method: 'GET',
                url: '/api/user',
                requiresAuth: true
            },
            updateProfile: {
                method: 'PUT',
                url: '/api/user/profile-information',
                requiresAuth: true
            },
            updatePassword: {
                method: 'PUT',
                url: '/api/user/password',
                requiresAuth: true
            },
            logout: {
                method: 'POST',
                url: '/api/logout',
                requiresAuth: true
            }
        };

        function setGlobalToken() {
            const tokenInput = document.getElementById('globalToken');
            globalToken = tokenInput.value.trim();
            
            const statusDiv = document.getElementById('tokenStatus');
            if (globalToken) {
                statusDiv.innerHTML = '<span class="text-green-600">✓ Token set successfully</span>';
                statusDiv.className = 'mt-2 text-sm';
            } else {
                statusDiv.innerHTML = '<span class="text-red-600">✗ Please enter a valid token</span>';
                statusDiv.className = 'mt-2 text-sm';
            }
        }

        function clearGlobalToken() {
            globalToken = '';
            document.getElementById('globalToken').value = '';
            document.getElementById('tokenStatus').innerHTML = '<span class="text-gray-500">Token cleared</span>';
        }

        async function testEndpoint(event, endpointName) {
            event.preventDefault();
            
            const endpoint = endpoints[endpointName];
            const form = event.target;
            const formData = new FormData(form);
            
            // Show response container
            const responseContainer = document.getElementById(`response-${endpointName}`);
            const responseContent = document.getElementById(`response-content-${endpointName}`);
            
            responseContainer.classList.remove('hidden');
            responseContent.textContent = 'Loading...';

            try {
                // Prepare request headers
                const headers = {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                };

                // Add authorization header if required and token is available
                if (endpoint.requiresAuth) {
                    if (!globalToken) {
                        throw new Error('This endpoint requires authentication. Please set your bearer token first.');
                    }
                    headers['Authorization'] = `Bearer ${globalToken}`;
                }

                // Prepare request body for POST and PUT requests
                let requestOptions = {
                    method: endpoint.method,
                    headers: headers
                };

                if ((endpoint.method === 'POST' || endpoint.method === 'PUT') && formData.entries().next().value) {
                    const data = {};
                    for (let [key, value] of formData.entries()) {
                        data[key] = value;
                    }
                    requestOptions.body = JSON.stringify(data);
                }

                // Make the API request
                const response = await fetch(endpoint.url, requestOptions);
                
                // Get response text
                const responseText = await response.text();
                
                // Try to parse as JSON
                let responseData;
                try {
                    responseData = JSON.parse(responseText);
                } catch (e) {
                    responseData = { raw_response: responseText };
                }

                // Display the response
                const formattedResponse = {
                    status: response.status,
                    statusText: response.statusText,
                    headers: Object.fromEntries(response.headers.entries()),
                    data: responseData
                };

                responseContent.textContent = JSON.stringify(formattedResponse, null, 2);
                
                // Auto-set token if this was a successful login/register
                if ((endpointName === 'login' || endpointName === 'register') && 
                    response.ok && responseData.token) {
                    globalToken = responseData.token;
                    document.getElementById('globalToken').value = responseData.token;
                    document.getElementById('tokenStatus').innerHTML = '<span class="text-green-600">✓ Token automatically set from login response</span>';
                }

            } catch (error) {
                responseContent.textContent = JSON.stringify({
                    error: error.message,
                    type: 'Request Error'
                }, null, 2);
            }
        }

        // Add some helpful keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl+K to focus token input
            if (e.ctrlKey && e.key === 'k') {
                e.preventDefault();
                document.getElementById('globalToken').focus();
            }
        });

        // Auto-clear old responses when typing in forms
        document.addEventListener('input', function(e) {
            if (e.target.tagName === 'INPUT' && e.target.closest('form')) {
                const form = e.target.closest('form');
                const endpointName = form.onsubmit.toString().match(/testEndpoint\(event, '(\w+)'\)/)?.[1];
                if (endpointName) {
                    const responseContainer = document.getElementById(`response-${endpointName}`);
                    if (responseContainer && !responseContainer.classList.contains('hidden')) {
                        responseContainer.classList.add('hidden');
                    }
                }
            }
        });
    </script>
</body>
</html>