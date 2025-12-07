@extends('layouts.docs')

@section('title', 'API Authentication')

@section('sidebar')
    <x-docs.navigation />
@endsection

@section('toc')
    <!-- TOC is auto-generated from headings -->
@endsection

@section('content')
<div class="mb-8">
    <div class="mb-2 inline-block px-3 py-1 rounded-full bg-[#10B981]/10 text-[#10B981] text-xs font-semibold">API Reference</div>
    <h1 class="text-4xl font-bold tracking-tight mb-3">API Authentication</h1>
    <p class="text-lg text-muted-foreground">Secure your API endpoints with Laravel Sanctum token-based authentication.</p>
</div>

## Overview

Our API uses Laravel Sanctum for authentication, which provides a lightweight authentication system for SPAs, mobile applications, and simple token-based APIs.

<x-docs.callout type="info" title="What is Sanctum?">
    Laravel Sanctum provides a featherweight authentication system for SPAs and mobile applications. It allows each user of your application to generate multiple API tokens for their account.
</x-docs.callout>

## Getting Started

### 1. Register a New User

First, register a new user account:

<x-docs.code language="bash" title="Register User">
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
</x-docs.code>

**Response:**

<x-docs.code language="json" title="Registration Response">
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "email_verified_at": null,
    "created_at": "2024-01-15T10:30:00.000000Z",
    "updated_at": "2024-01-15T10:30:00.000000Z"
  },
  "token": "1|abcdef123456789..."
}
</x-docs.code>

### 2. Login with Existing User

For existing users, use the login endpoint:

<x-docs.code language="bash" title="Login User">
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "password123"
  }'
</x-docs.code>

## Using Your Token

Once you have a token, include it in the `Authorization` header for all authenticated requests:

<x-docs.code language="bash" title="Authenticated Request">
curl -X GET http://localhost:8000/api/user \
  -H "Authorization: Bearer 1|abcdef123456789..." \
  -H "Accept: application/json"
</x-docs.code>

## Token Management

### Creating Tokens

You can create tokens programmatically in your controllers:

<x-docs.code language="php" title="Creating Tokens">
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $request->authenticate();
        
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;
        
        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }
}
</x-docs.code>

### Revoking Tokens

Users can revoke their current token:

<x-docs.code language="bash" title="Logout (Revoke Token)">
curl -X POST http://localhost:8000/api/logout \
  -H "Authorization: Bearer 1|abcdef123456789..." \
  -H "Accept: application/json"
</x-docs.code>

Or revoke all tokens:

<x-docs.code language="php" title="Revoke All Tokens">
// Revoke all tokens for the user
$request->user()->tokens()->delete();

// Revoke only the current token
$request->user()->currentAccessToken()->delete();
</x-docs.code>

## Protecting Routes

Use the `auth:sanctum` middleware to protect your API routes:

<x-docs.code language="php" filename="routes/api.php">
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::put('/user/profile', [ProfileController::class, 'update']);
    Route::put('/user/password', [ProfileController::class, 'updatePassword']);
});
</x-docs.code>

## Error Handling

### Unauthenticated Requests

When a request is made without a valid token:

<x-docs.code language="json" title="401 Unauthorized">
{
  "message": "Unauthenticated."
}
</x-docs.code>

### Invalid Token

When using an invalid or expired token:

<x-docs.code language="json" title="401 Unauthorized">
{
  "message": "Unauthenticated."
}
</x-docs.code>

### Validation Errors

When registration or login data is invalid:

<x-docs.code language="json" title="422 Validation Error">
{
  "message": "The given data was invalid.",
  "errors": {
    "email": [
      "The email field is required."
    ],
    "password": [
      "The password field is required."
    ]
  }
}
</x-docs.code>

## Security Best Practices

<x-docs.callout type="warning" title="Security Recommendations">
    Follow these security best practices when working with API tokens:
</x-docs.callout>

### 1. Token Storage

- **Never store tokens in localStorage** - Use secure HTTP-only cookies when possible
- **Use environment variables** for sensitive configuration
- **Implement token rotation** for long-lived applications

### 2. Token Expiration

Configure token expiration in `config/sanctum.php`:

<x-docs.code language="php" filename="config/sanctum.php">
'expiration' => 525600, // 1 year in minutes
</x-docs.code>

### 3. Rate Limiting

Apply rate limiting to authentication endpoints:

<x-docs.code language="php" filename="routes/api.php">
Route::middleware(['throttle:5,1'])->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});
</x-docs.code>

## Testing Authentication

### Feature Tests

<x-docs.code language="php" title="Authentication Tests">
use Laravel\Sanctum\Sanctum;

public function test_authenticated_user_can_access_profile()
{
    $user = User::factory()->create();
    
    Sanctum::actingAs($user);
    
    $response = $this->getJson('/api/user');
    
    $response->assertOk()
            ->assertJson($user->toArray());
}

public function test_unauthenticated_user_cannot_access_profile()
{
    $response = $this->getJson('/api/user');
    
    $response->assertUnauthorized();
}
</x-docs.code>

## Frontend Integration

### JavaScript/Axios Example

<x-docs.code language="javascript" title="Frontend Integration">
// Store the token
const token = 'your-api-token-here';

// Configure axios defaults
axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

// Make authenticated requests
const response = await axios.get('/api/user');
console.log(response.data);
</x-docs.code>

### SPA Authentication

For Single Page Applications:

<x-docs.code language="javascript" title="SPA Authentication">
// Login and store token
const login = async (email, password) => {
    const response = await axios.post('/api/login', { email, password });
    const { token, user } = response.data;
    
    // Store token securely (consider using secure cookies)
    localStorage.setItem('auth_token', token);
    
    // Set default header
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    
    return user;
};

// Logout
const logout = async () => {
    await axios.post('/api/logout');
    localStorage.removeItem('auth_token');
    delete axios.defaults.headers.common['Authorization'];
};
</x-docs.code>

<x-docs.callout type="success" title="Ready to Build">
    You now have everything you need to implement secure API authentication. Check out our [API endpoints documentation](/docs/api/endpoints) to see what's available.
</x-docs.callout>
@endsection