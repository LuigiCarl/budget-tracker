# Budget Tracker API Documentation

## Overview

The Budget Tracker API provides comprehensive personal finance management capabilities including account management, transaction tracking, budgeting, and financial analytics. Built with Laravel 12 and Laravel Sanctum for API authentication.

**Base URL**: `http://localhost:8000/api`  
**Authentication**: Bearer Token (Laravel Sanctum)  
**Content Type**: `application/json`

---

## Table of Contents

1. [Authentication](#authentication)
2. [User Management](#user-management)
3. [Dashboard & Analytics](#dashboard--analytics)
4. [Account Management](#account-management)
5. [Category Management](#category-management)
6. [Transaction Management](#transaction-management)
7. [Budget Management](#budget-management)
8. [Error Responses](#error-responses)
9. [Rate Limiting](#rate-limiting)

---

## Authentication

### Register User
Create a new user account.

**POST** `/api/register`

```json
{
  "name": "John Doe",
  "email": "john@example.com", 
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Response**: `201 Created`
```json
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "email_verified_at": null,
    "created_at": "2025-09-28T12:00:00.000000Z",
    "updated_at": "2025-09-28T12:00:00.000000Z"
  },
  "token": "1|abcdef123456...",
  "message": "Registration successful"
}
```

### Login
Authenticate user and receive access token.

**POST** `/api/login`

```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

**Response**: `200 OK`
```json
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  },
  "token": "2|ghijkl789012...",
  "message": "Login successful"
}
```

### Create API Token
Generate a new API token for the authenticated user.

**POST** `/api/tokens`
**Headers**: `Authorization: Bearer {token}`

```json
{
  "name": "Mobile App Token"
}
```

**Response**: `201 Created`
```json
{
  "token": "3|mnopqr345678...",
  "name": "Mobile App Token"
}
```

### Logout
Revoke current access token.

**POST** `/api/logout`  
**Headers**: `Authorization: Bearer {token}`

**Response**: `200 OK`
```json
{
  "message": "Logged out successfully"
}
```

---

## User Management

### Get Current User
Retrieve authenticated user information.

**GET** `/api/user`  
**Headers**: `Authorization: Bearer {token}`

**Response**: `200 OK`
```json
{
  "id": 1,
  "name": "John Doe",
  "email": "john@example.com",
  "email_verified_at": null,
  "created_at": "2025-09-28T12:00:00.000000Z",
  "updated_at": "2025-09-28T12:00:00.000000Z"
}
```

### Update Profile
Update user profile information.

**PUT** `/api/profile`  
**Headers**: `Authorization: Bearer {token}`

```json
{
  "name": "John Smith",
  "email": "johnsmith@example.com"
}
```

**Response**: `200 OK`
```json
{
  "message": "Profile updated successfully",
  "user": {
    "id": 1,
    "name": "John Smith",
    "email": "johnsmith@example.com",
    "updated_at": "2025-09-28T12:30:00.000000Z"
  }
}
```

### Update Password
Change user password.

**PUT** `/api/password`  
**Headers**: `Authorization: Bearer {token}`

```json
{
  "current_password": "password123",
  "password": "newpassword456",
  "password_confirmation": "newpassword456"
}
```

**Response**: `200 OK`
```json
{
  "message": "Password updated successfully"
}
```

---

## Dashboard & Analytics

### Get Dashboard Data
Retrieve comprehensive financial analytics and summary data.

**GET** `/api/dashboard`  
**Headers**: `Authorization: Bearer {token}`

**Response**: `200 OK`
```json
{
  "summary": {
    "total_income": 5000.00,
    "total_expenses": 3200.50,
    "net_income": 1799.50,
    "current_month": "2025-09"
  },
  "accounts": [
    {
      "id": 1,
      "name": "Checking Account",
      "type": "bank",
      "balance": 2500.00,
      "transactions_count": 25
    }
  ],
  "recent_transactions": [
    {
      "id": 1,
      "description": "Grocery Shopping",
      "amount": 85.50,
      "type": "expense",
      "date": "2025-09-28",
      "account": {
        "id": 1,
        "name": "Checking Account"
      },
      "category": {
        "id": 2,
        "name": "Groceries",
        "color": "#22c55e"
      }
    }
  ],
  "expenses_by_category": [
    {
      "category": "Groceries",
      "amount": 450.00,
      "color": "#22c55e"
    }
  ],
  "active_budgets": [
    {
      "id": 1,
      "amount": 500.00,
      "spent": 450.00,
      "percentage_used": 90.0,
      "is_exceeded": false,
      "category": {
        "id": 2,
        "name": "Groceries"
      }
    }
  ]
}
```

---

## Account Management

### List Accounts
Get all accounts for the authenticated user.

**GET** `/api/accounts`  
**Headers**: `Authorization: Bearer {token}`

**Query Parameters**:
- `page` (optional): Page number for pagination
- `per_page` (optional): Items per page (default: 15)

**Response**: `200 OK`
```json
{
  "data": [
    {
      "id": 1,
      "name": "Checking Account",
      "type": "bank",
      "balance": 2500.00,
      "description": "Primary checking account",
      "created_at": "2025-09-28T12:00:00.000000Z",
      "updated_at": "2025-09-28T12:00:00.000000Z"
    }
  ],
  "meta": {
    "current_page": 1,
    "total": 5,
    "per_page": 15,
    "last_page": 1
  }
}
```

### Create Account
Create a new financial account.

**POST** `/api/accounts`  
**Headers**: `Authorization: Bearer {token}`

```json
{
  "name": "Savings Account",
  "type": "bank",
  "balance": 1000.00,
  "description": "Emergency fund savings"
}
```

**Validation Rules**:
- `name`: required, string, max 255 chars
- `type`: required, enum (`cash`, `bank`, `credit_card`)
- `balance`: required, numeric, min 0
- `description`: optional, string, max 500 chars

**Response**: `201 Created`
```json
{
  "id": 2,
  "name": "Savings Account",
  "type": "bank",
  "balance": 1000.00,
  "description": "Emergency fund savings",
  "user_id": 1,
  "created_at": "2025-09-28T12:00:00.000000Z",
  "updated_at": "2025-09-28T12:00:00.000000Z"
}
```

### Get Account
Retrieve a specific account with transaction history.

**GET** `/api/accounts/{id}`  
**Headers**: `Authorization: Bearer {token}`

**Response**: `200 OK`
```json
{
  "id": 1,
  "name": "Checking Account",
  "type": "bank", 
  "balance": 2500.00,
  "description": "Primary checking account",
  "created_at": "2025-09-28T12:00:00.000000Z",
  "updated_at": "2025-09-28T12:00:00.000000Z",
  "transactions": {
    "data": [
      {
        "id": 1,
        "description": "Grocery Shopping",
        "amount": 85.50,
        "type": "expense",
        "date": "2025-09-28",
        "category": {
          "id": 2,
          "name": "Groceries",
          "color": "#22c55e"
        }
      }
    ],
    "meta": {
      "current_page": 1,
      "total": 25,
      "per_page": 20
    }
  }
}
```

### Update Account
Modify an existing account.

**PUT** `/api/accounts/{id}`  
**Headers**: `Authorization: Bearer {token}`

```json
{
  "name": "Updated Checking Account",
  "type": "bank",
  "balance": 2750.00,
  "description": "Updated description"
}
```

**Response**: `200 OK`
```json
{
  "id": 1,
  "name": "Updated Checking Account",
  "type": "bank",
  "balance": 2750.00,
  "description": "Updated description",
  "updated_at": "2025-09-28T12:30:00.000000Z"
}
```

### Delete Account
Remove an account and all associated transactions.

**DELETE** `/api/accounts/{id}`  
**Headers**: `Authorization: Bearer {token}`

**Response**: `204 No Content`

---

## Category Management

### List Categories
Get all categories for the authenticated user.

**GET** `/api/categories`  
**Headers**: `Authorization: Bearer {token}`

**Query Parameters**:
- `type` (optional): Filter by type (`income` or `expense`)
- `page` (optional): Page number
- `per_page` (optional): Items per page

**Response**: `200 OK`
```json
{
  "data": [
    {
      "id": 1,
      "name": "Groceries",
      "type": "expense",
      "color": "#22c55e",
      "description": "Food and household items",
      "transactions_count": 15,
      "total_amount": 450.00,
      "created_at": "2025-09-28T12:00:00.000000Z"
    }
  ],
  "meta": {
    "current_page": 1,
    "total": 8,
    "per_page": 15
  }
}
```

### Create Category
Create a new transaction category.

**POST** `/api/categories`  
**Headers**: `Authorization: Bearer {token}`

```json
{
  "name": "Entertainment",
  "type": "expense",
  "color": "#8b5cf6",
  "description": "Movies, games, entertainment"
}
```

**Validation Rules**:
- `name`: required, string, max 255 chars
- `type`: required, enum (`income`, `expense`)
- `color`: required, valid hex color (with or without #)
- `description`: optional, string, max 500 chars

**Response**: `201 Created`
```json
{
  "id": 3,
  "name": "Entertainment",
  "type": "expense",
  "color": "#8b5cf6",
  "description": "Movies, games, entertainment",
  "user_id": 1,
  "created_at": "2025-09-28T12:00:00.000000Z",
  "updated_at": "2025-09-28T12:00:00.000000Z"
}
```

### Get Category
Retrieve a specific category with transaction statistics.

**GET** `/api/categories/{id}`  
**Headers**: `Authorization: Bearer {token}`

**Response**: `200 OK`
```json
{
  "id": 1,
  "name": "Groceries",
  "type": "expense",
  "color": "#22c55e",
  "description": "Food and household items",
  "created_at": "2025-09-28T12:00:00.000000Z",
  "updated_at": "2025-09-28T12:00:00.000000Z",
  "statistics": {
    "total_transactions": 15,
    "total_amount": 450.00,
    "average_amount": 30.00,
    "this_month_amount": 120.00
  },
  "recent_transactions": [
    {
      "id": 1,
      "description": "Weekly groceries",
      "amount": 85.50,
      "date": "2025-09-28",
      "account": {
        "id": 1,
        "name": "Checking Account"
      }
    }
  ]
}
```

### Update Category
Modify an existing category.

**PUT** `/api/categories/{id}`  
**Headers**: `Authorization: Bearer {token}`

```json
{
  "name": "Food & Groceries",
  "type": "expense",
  "color": "#10b981",
  "description": "Updated description for food category"
}
```

**Response**: `200 OK`
```json
{
  "id": 1,
  "name": "Food & Groceries",
  "type": "expense", 
  "color": "#10b981",
  "description": "Updated description for food category",
  "updated_at": "2025-09-28T12:30:00.000000Z"
}
```

### Delete Category
Remove a category. Transactions will be unassigned.

**DELETE** `/api/categories/{id}`  
**Headers**: `Authorization: Bearer {token}`

**Response**: `204 No Content`

---

## Transaction Management

### List Transactions
Get all transactions for the authenticated user.

**GET** `/api/transactions`  
**Headers**: `Authorization: Bearer {token}`

**Query Parameters**:
- `type` (optional): Filter by type (`income` or `expense`)
- `account_id` (optional): Filter by account
- `category_id` (optional): Filter by category
- `date_from` (optional): Start date (YYYY-MM-DD)
- `date_to` (optional): End date (YYYY-MM-DD)
- `page` (optional): Page number
- `per_page` (optional): Items per page

**Response**: `200 OK`
```json
{
  "data": [
    {
      "id": 1,
      "description": "Grocery Shopping",
      "amount": 85.50,
      "type": "expense",
      "date": "2025-09-28",
      "created_at": "2025-09-28T12:00:00.000000Z",
      "account": {
        "id": 1,
        "name": "Checking Account",
        "type": "bank"
      },
      "category": {
        "id": 2,
        "name": "Groceries",
        "color": "#22c55e"
      }
    }
  ],
  "meta": {
    "current_page": 1,
    "total": 50,
    "per_page": 15,
    "total_income": 5000.00,
    "total_expenses": 3200.50,
    "net_amount": 1799.50
  }
}
```

### Create Transaction
Record a new financial transaction.

**POST** `/api/transactions`  
**Headers**: `Authorization: Bearer {token}`

```json
{
  "description": "Coffee Shop",
  "amount": 4.50,
  "type": "expense",
  "date": "2025-09-28",
  "account_id": 1,
  "category_id": 5
}
```

**Validation Rules**:
- `description`: required, string, max 255 chars
- `amount`: required, numeric, min 0.01
- `type`: required, enum (`income`, `expense`)
- `date`: required, valid date
- `account_id`: required, valid account belonging to user
- `category_id`: required, valid category belonging to user

**Response**: `201 Created`
```json
{
  "id": 2,
  "description": "Coffee Shop",
  "amount": 4.50,
  "type": "expense",
  "date": "2025-09-28",
  "account_id": 1,
  "category_id": 5,
  "user_id": 1,
  "created_at": "2025-09-28T12:00:00.000000Z",
  "updated_at": "2025-09-28T12:00:00.000000Z",
  "account": {
    "id": 1,
    "name": "Checking Account"
  },
  "category": {
    "id": 5,
    "name": "Dining Out"
  }
}
```

### Get Transaction
Retrieve a specific transaction.

**GET** `/api/transactions/{id}`  
**Headers**: `Authorization: Bearer {token}`

**Response**: `200 OK`
```json
{
  "id": 1,
  "description": "Grocery Shopping",
  "amount": 85.50,
  "type": "expense",
  "date": "2025-09-28",
  "created_at": "2025-09-28T12:00:00.000000Z",
  "updated_at": "2025-09-28T12:00:00.000000Z",
  "account": {
    "id": 1,
    "name": "Checking Account",
    "type": "bank"
  },
  "category": {
    "id": 2,
    "name": "Groceries",
    "color": "#22c55e",
    "type": "expense"
  }
}
```

### Update Transaction
Modify an existing transaction.

**PUT** `/api/transactions/{id}`  
**Headers**: `Authorization: Bearer {token}`

```json
{
  "description": "Updated grocery shopping",
  "amount": 92.75,
  "type": "expense", 
  "date": "2025-09-28",
  "account_id": 1,
  "category_id": 2
}
```

**Response**: `200 OK`
```json
{
  "id": 1,
  "description": "Updated grocery shopping",
  "amount": 92.75,
  "type": "expense",
  "date": "2025-09-28",
  "updated_at": "2025-09-28T12:30:00.000000Z"
}
```

### Delete Transaction
Remove a transaction.

**DELETE** `/api/transactions/{id}`  
**Headers**: `Authorization: Bearer {token}`

**Response**: `204 No Content`

---

## Budget Management

### List Budgets
Get all budgets for the authenticated user.

**GET** `/api/budgets`  
**Headers**: `Authorization: Bearer {token}`

**Query Parameters**:
- `status` (optional): Filter by status (`active`, `expired`, `upcoming`)
- `category_id` (optional): Filter by category
- `page` (optional): Page number

**Response**: `200 OK`
```json
{
  "data": [
    {
      "id": 1,
      "amount": 500.00,
      "spent": 450.00,
      "remaining": 50.00,
      "percentage_used": 90.0,
      "is_exceeded": false,
      "start_date": "2025-09-01",
      "end_date": "2025-09-30",
      "status": "active",
      "category": {
        "id": 2,
        "name": "Groceries",
        "color": "#22c55e"
      },
      "created_at": "2025-09-01T00:00:00.000000Z"
    }
  ],
  "meta": {
    "current_page": 1,
    "total": 3,
    "per_page": 15
  }
}
```

### Create Budget
Set up a new budget for a category.

**POST** `/api/budgets`  
**Headers**: `Authorization: Bearer {token}`

```json
{
  "category_id": 3,
  "amount": 200.00,
  "start_date": "2025-10-01",
  "end_date": "2025-10-31"
}
```

**Validation Rules**:
- `category_id`: required, valid expense category belonging to user
- `amount`: required, numeric, min 0.01
- `start_date`: required, valid date
- `end_date`: required, valid date, after start_date

**Response**: `201 Created`
```json
{
  "id": 2,
  "amount": 200.00,
  "spent": 0.00,
  "remaining": 200.00,
  "percentage_used": 0.0,
  "is_exceeded": false,
  "start_date": "2025-10-01",
  "end_date": "2025-10-31",
  "status": "upcoming",
  "category_id": 3,
  "user_id": 1,
  "created_at": "2025-09-28T12:00:00.000000Z",
  "updated_at": "2025-09-28T12:00:00.000000Z",
  "category": {
    "id": 3,
    "name": "Entertainment",
    "color": "#8b5cf6"
  }
}
```

### Get Budget
Retrieve a specific budget with spending details.

**GET** `/api/budgets/{id}`  
**Headers**: `Authorization: Bearer {token}`

**Response**: `200 OK`
```json
{
  "id": 1,
  "amount": 500.00,
  "spent": 450.00,
  "remaining": 50.00,
  "percentage_used": 90.0,
  "is_exceeded": false,
  "start_date": "2025-09-01",
  "end_date": "2025-09-30",
  "status": "active",
  "created_at": "2025-09-01T00:00:00.000000Z",
  "updated_at": "2025-09-28T12:00:00.000000Z",
  "category": {
    "id": 2,
    "name": "Groceries",
    "color": "#22c55e",
    "type": "expense"
  },
  "transactions": [
    {
      "id": 1,
      "description": "Weekly groceries",
      "amount": 85.50,
      "date": "2025-09-28",
      "account": {
        "id": 1,
        "name": "Checking Account"
      }
    }
  ],
  "daily_spending": [
    {
      "date": "2025-09-28",
      "amount": 85.50,
      "transactions_count": 1
    }
  ]
}
```

### Update Budget
Modify an existing budget.

**PUT** `/api/budgets/{id}`  
**Headers**: `Authorization: Bearer {token}`

```json
{
  "amount": 600.00,
  "start_date": "2025-09-01",
  "end_date": "2025-09-30"
}
```

**Response**: `200 OK`
```json
{
  "id": 1,
  "amount": 600.00,
  "spent": 450.00,
  "remaining": 150.00,
  "percentage_used": 75.0,
  "is_exceeded": false,
  "updated_at": "2025-09-28T12:30:00.000000Z"
}
```

### Delete Budget
Remove a budget.

**DELETE** `/api/budgets/{id}`  
**Headers**: `Authorization: Bearer {token}`

**Response**: `204 No Content`

---

## Error Responses

### Common HTTP Status Codes

**400 Bad Request**
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "email": ["The email field is required."],
    "password": ["The password must be at least 8 characters."]
  }
}
```

**401 Unauthorized**
```json
{
  "message": "Unauthenticated."
}
```

**403 Forbidden**
```json
{
  "message": "This action is unauthorized."
}
```

**404 Not Found**
```json
{
  "message": "No query results for model [App\\Models\\Account] 999"
}
```

**422 Unprocessable Entity**
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "amount": ["The amount must be greater than 0."],
    "category_id": ["The selected category id is invalid."]
  }
}
```

**500 Internal Server Error**
```json
{
  "message": "Server Error"
}
```

---

## Rate Limiting

The API implements rate limiting to prevent abuse:

- **Authentication routes** (`/register`, `/login`): 5 requests per minute per IP
- **General API routes**: 60 requests per minute per authenticated user
- **Heavy operations** (bulk imports, reports): 10 requests per minute per user

Rate limit headers are included in responses:
- `X-RateLimit-Limit`: Maximum requests allowed
- `X-RateLimit-Remaining`: Requests remaining in current window  
- `X-RateLimit-Reset`: Unix timestamp when limit resets

---

## Data Models

### User
```json
{
  "id": 1,
  "name": "John Doe", 
  "email": "john@example.com",
  "email_verified_at": "2025-09-28T12:00:00.000000Z",
  "created_at": "2025-09-28T12:00:00.000000Z",
  "updated_at": "2025-09-28T12:00:00.000000Z"
}
```

### Account
```json
{
  "id": 1,
  "name": "Checking Account",
  "type": "bank", // cash, bank, credit_card
  "balance": 2500.00,
  "description": "Primary checking account",
  "user_id": 1,
  "created_at": "2025-09-28T12:00:00.000000Z",
  "updated_at": "2025-09-28T12:00:00.000000Z"
}
```

### Category  
```json
{
  "id": 1,
  "name": "Groceries",
  "type": "expense", // income, expense
  "color": "#22c55e",
  "description": "Food and household items",
  "user_id": 1,
  "created_at": "2025-09-28T12:00:00.000000Z",
  "updated_at": "2025-09-28T12:00:00.000000Z"
}
```

### Transaction
```json
{
  "id": 1,
  "description": "Grocery Shopping",
  "amount": 85.50,
  "type": "expense", // income, expense  
  "date": "2025-09-28",
  "account_id": 1,
  "category_id": 2,
  "user_id": 1,
  "created_at": "2025-09-28T12:00:00.000000Z",
  "updated_at": "2025-09-28T12:00:00.000000Z"
}
```

### Budget
```json
{
  "id": 1,
  "amount": 500.00,
  "start_date": "2025-09-01",
  "end_date": "2025-09-30", 
  "category_id": 2,
  "user_id": 1,
  "created_at": "2025-09-28T12:00:00.000000Z",
  "updated_at": "2025-09-28T12:00:00.000000Z"
}
```

---

## Recent Updates & New Features

### ✅ CRUD Operations Optimization (v1.2)
- **Fixed 403 Authorization Errors**: Eliminated problematic `Auth::user()->relationship()` calls
- **Consistent User Scoping**: All controllers now use `where('user_id', Auth::id())` pattern
- **Improved Security**: Database-level user isolation for all operations
- **Enhanced Performance**: Direct model queries instead of relationship traversal

### ✅ Account Management Enhancements (v1.2)
- **Fixed Field Mapping**: Resolved `balance` vs `initial_balance` inconsistencies
- **Improved Validation**: Consistent validation rules across all forms
- **Better UX**: Account details view with transaction history
- **Responsive Design**: Mobile-friendly account management interface

### ✅ Category Color System (v1.2)  
- **Flexible Color Input**: Accepts hex colors with or without `#` prefix
- **Enhanced Validation**: Improved color validation regex pattern
- **Visual Consistency**: Proper color normalization and display
- **Custom Colors**: Support for custom color picker alongside presets

### ✅ Dashboard Analytics (v1.1)
- **Real-time Statistics**: Current month income, expenses, and net income
- **Account Overview**: Balance summaries with transaction counts
- **Category Insights**: Pie chart visualization of expenses by category  
- **Budget Tracking**: Active budget progress with percentage calculations
- **Recent Activity**: Latest transactions across all accounts

### ✅ Advanced Budget Management (v1.1)
- **Period-based Budgets**: Flexible start and end date configuration
- **Spending Tracking**: Real-time spent amount calculation
- **Progress Indicators**: Visual progress bars with percentage completion
- **Budget Status**: Automatic status calculation (active, expired, upcoming)
- **Overlap Prevention**: Validation to prevent overlapping budgets

---

*Last Updated: September 28, 2025*  
*API Version: 1.2*  
*Laravel Version: 12.0*