# Frontend Integration Guide

This guide explains how to connect a frontend application to the Budget Tracker Laravel backend API.

## Backend Configuration

### 1. CORS Setup

The backend is configured to accept requests from allowed origins. Update your environment variables:

```env
FRONTEND_URL=http://localhost:3000
APP_URL=https://budget-tracker-xpoz.onrender.com
```

**For production (Vercel):** Update `FRONTEND_URL` to your deployed frontend URL after deployment.

### 2. API Endpoints

**Base URL (Production):** `https://budget-tracker-xpoz.onrender.com`  
**Base URL (Local):** `http://localhost:8000`

#### Authentication Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/register` | Register new user |
| POST | `/api/login` | Login and get bearer token |
| POST | `/api/logout` | Logout (requires auth) |
| GET | `/api/user` | Get authenticated user |

#### Dashboard Endpoints (Session-based for web, Token-based for API)

| Method | Endpoint | Description | Parameters |
|--------|----------|-------------|------------|
| GET | `/api/web/dashboard/stats` | Get dashboard statistics | `period` (current_month, current_week, current_quarter, current_year, last_30_days, last_90_days, all_time) |
| GET | `/api/web/dashboard/recent-transactions` | Get recent transactions | `limit` (1-50, default: 5) |
| GET | `/api/web/dashboard/monthly-analytics` | Get monthly income/expense trends | `months` (3-12, default: 6), `auto_detect` (true/false) |
| GET | `/api/web/dashboard/budget-progress` | Get active budgets with progress | - |

## Frontend Setup

### 1. Environment Variables

Create a `.env.local` file in your frontend project:

```env
# For local development
NEXT_PUBLIC_API_URL=http://localhost:8000

# For production (update after deploying backend)
# NEXT_PUBLIC_API_URL=https://budget-tracker-xpoz.onrender.com
```

### 2. API Client Setup

Create an API client with authentication handling:

**`app/lib/api.ts`** (Next.js example)

```typescript
import axios from 'axios';

const api = axios.create({
  baseURL: process.env.NEXT_PUBLIC_API_URL,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
  withCredentials: true, // Important for session/cookie handling
});

// Request interceptor - Add bearer token
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('auth_token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => Promise.reject(error)
);

// Response interceptor - Handle 401 errors
api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      localStorage.removeItem('auth_token');
      localStorage.removeItem('user');
      window.location.href = '/auth';
    }
    return Promise.reject(error);
  }
);

export default api;
```

### 3. Authentication Flow

#### Login Example

```typescript
import api from './lib/api';

async function login(email: string, password: string) {
  try {
    const response = await api.post('/api/login', { email, password });
    
    // Store token
    localStorage.setItem('auth_token', response.data.token);
    localStorage.setItem('user', JSON.stringify(response.data.user));
    
    // Redirect to dashboard
    window.location.href = '/dashboard';
  } catch (error) {
    console.error('Login failed:', error);
  }
}
```

#### Register Example

```typescript
async function register(name: string, email: string, password: string) {
  try {
    const response = await api.post('/api/register', {
      name,
      email,
      password,
      password_confirmation: password
    });
    
    // Auto-login after registration
    localStorage.setItem('auth_token', response.data.token);
    localStorage.setItem('user', JSON.stringify(response.data.user));
    
    window.location.href = '/dashboard';
  } catch (error) {
    console.error('Registration failed:', error);
  }
}
```

### 4. Dashboard API Usage

#### Get Dashboard Statistics

```typescript
async function getDashboardStats(period = 'current_month') {
  try {
    const response = await api.get(`/api/web/dashboard/stats?period=${period}`);
    return response.data;
    // Returns: { total_balance, income, expenses, category_spending[], period, updated_at }
  } catch (error) {
    console.error('Failed to load stats:', error);
  }
}
```

#### Get Recent Transactions

```typescript
async function getRecentTransactions(limit = 10) {
  try {
    const response = await api.get(`/api/web/dashboard/recent-transactions?limit=${limit}`);
    return response.data;
    // Returns: { transactions: [], total_count, period }
  } catch (error) {
    console.error('Failed to load transactions:', error);
  }
}
```

#### Get Monthly Analytics

```typescript
async function getMonthlyAnalytics(months = 6, autoDetect = true) {
  try {
    const response = await api.get(
      `/api/web/dashboard/monthly-analytics?months=${months}&auto_detect=${autoDetect}`
    );
    return response.data;
    // Returns: { period, date_range, auto_detected, data: [] }
  } catch (error) {
    console.error('Failed to load analytics:', error);
  }
}
```

#### Get Budget Progress

```typescript
async function getBudgetProgress() {
  try {
    const response = await api.get('/api/web/dashboard/budget-progress');
    return response.data;
    // Returns: { active_budgets: [], total_budgets, exceeded_count }
  } catch (error) {
    console.error('Failed to load budgets:', error);
  }
}
```

## Response Formats

### Dashboard Stats Response

```json
{
  "total_balance": 15000.00,
  "income": 50000.00,
  "expenses": 35000.00,
  "category_spending": [
    {
      "name": "Food",
      "value": 5000.00,
      "color": "#ef4444",
      "budget_limit": 6000.00,
      "percentage_used": 83.3
    }
  ],
  "period": "current_month",
  "updated_at": "2025-11-29T10:30:00.000000Z"
}
```

### Recent Transactions Response

```json
{
  "transactions": [
    {
      "id": 1,
      "name": "Grocery Shopping",
      "date": "2025-11-28",
      "amount": -150.00,
      "type": "expense",
      "category": "Food",
      "account": "Cash"
    }
  ],
  "total_count": 50,
  "period": "all_time"
}
```

### Monthly Analytics Response

```json
{
  "period": "last_6_months",
  "date_range": {
    "start": "2025-06-01",
    "end": "2025-11-30"
  },
  "auto_detected": true,
  "data": [
    {
      "month": "November 2025",
      "month_short": "Nov 2025",
      "income": 8000.00,
      "expenses": 6000.00,
      "net": 2000.00
    }
  ]
}
```

### Budget Progress Response

```json
{
  "active_budgets": [
    {
      "id": 1,
      "name": "Monthly Food Budget",
      "category": "Food",
      "color": "#ef4444",
      "amount": 6000.00,
      "spent": 4500.00,
      "remaining": 1500.00,
      "percentage": 75.0,
      "is_exceeded": false,
      "is_limiter": true,
      "days_remaining": 2
    }
  ],
  "total_budgets": 5,
  "exceeded_count": 1
}
```

## Deployment

### Frontend Deployment (Vercel)

1. Create `vercel.json`:

```json
{
  "rewrites": [
    {
      "source": "/(.*)",
      "destination": "/"
    }
  ],
  "headers": [
    {
      "source": "/api/(.*)",
      "headers": [
        { "key": "Access-Control-Allow-Credentials", "value": "true" },
        { "key": "Access-Control-Allow-Origin", "value": "*" },
        { "key": "Access-Control-Allow-Methods", "value": "GET,POST,PUT,DELETE,OPTIONS" },
        { "key": "Access-Control-Allow-Headers", "value": "X-CSRF-Token, X-Requested-With, Accept, Accept-Version, Content-Length, Content-MD5, Content-Type, Date, X-Api-Version, Authorization" }
      ]
    }
  ]
}
```

2. Deploy to Vercel:

```bash
cd Frontend-Budget_Tracker
vercel login
vercel
```

3. Update backend environment:

```env
FRONTEND_URL=https://your-frontend.vercel.app
```

4. Redeploy backend on Render

### Testing the Connection

#### Local Testing

```bash
# Terminal 1 - Backend
cd C:\xampp\htdocs\budget-tracker
php artisan serve

# Terminal 2 - Frontend
cd Frontend-Budget_Tracker
npm run dev
```

Visit `http://localhost:3000` and test login/dashboard

#### Production Testing

1. Deploy backend to Render (already done)
2. Deploy frontend to Vercel
3. Update `FRONTEND_URL` in Render
4. Test authentication flow
5. Test dashboard API calls

## Troubleshooting

### CORS Errors

If you see CORS errors in the browser console:

1. Verify `FRONTEND_URL` is set correctly in backend `.env`
2. Check `config/cors.php` includes your frontend URL
3. Ensure `withCredentials: true` in axios config
4. Redeploy backend after env changes

### 401 Unauthorized Errors

1. Check token is stored in localStorage
2. Verify token is being sent in Authorization header
3. Check token hasn't expired
4. Ensure API endpoint requires authentication

### API Not Responding

1. Verify backend is running (local) or deployed (production)
2. Check `NEXT_PUBLIC_API_URL` is correct
3. Test backend directly with Postman/curl
4. Check browser network tab for request details

## Additional Resources

- Backend Repository: https://github.com/LuigiCarl/budget-tracker
- Backend API (Production): https://budget-tracker-xpoz.onrender.com
- Laravel Sanctum Docs: https://laravel.com/docs/sanctum
- Next.js Docs: https://nextjs.org/docs
