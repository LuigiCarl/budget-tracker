# Budget Tracker — ERD

Below is an Entity-Relationship Diagram (Mermaid) and a concise listing of entities and relationships inferred from the Eloquent models in this repository.

```mermaid
erDiagram
    USERS {
        int id PK
        string name
        string email
        string password
        string role
        string status
        datetime email_verified_at
        datetime created_at
        datetime updated_at
    }

    ACCOUNTS {
        int id PK
        int user_id FK
        string name
        string type
        decimal balance
        text description
        datetime created_at
        datetime updated_at
    }

    CATEGORIES {
        int id PK
        int user_id FK
        string name
        string type
        text description
        string color
        boolean is_default
        datetime created_at
        datetime updated_at
    }

    TRANSACTIONS {
        int id PK
        int user_id FK
        int account_id FK
        int category_id FK
        decimal amount
        string type
        date date
        text description
        datetime created_at
        datetime updated_at
    }

    BUDGETS {
        int id PK
        int user_id FK
        int category_id FK
        decimal amount
        date start_date
        date end_date
        string name
        text description
        boolean is_limiter
        datetime created_at
        datetime updated_at
    }

    FEEDBACK {
        int id PK
        int user_id FK
        string subject
        text message
        int rating
        string status
        int reviewed_by FK
        datetime reviewed_at
        datetime created_at
        datetime updated_at
    }

    NOTIFICATIONS {
        int id PK
        string title
        text description
        string type
        int created_by FK
        int user_id FK
        datetime sent_at
        datetime created_at
        datetime updated_at
    }

    USERS ||--o{ ACCOUNTS : "has"
    USERS ||--o{ CATEGORIES : "has"
    USERS ||--o{ TRANSACTIONS : "has"
    USERS ||--o{ BUDGETS : "has"

    ACCOUNTS ||--o{ TRANSACTIONS : "contains"
    CATEGORIES ||--o{ TRANSACTIONS : "categorizes"
    CATEGORIES ||--o{ BUDGETS : "has"

    FEEDBACK }o--|| USERS : "submitted_by"
    FEEDBACK }o--|| USERS : "reviewed_by"

    NOTIFICATIONS }o--|| USERS : "created_by"
    NOTIFICATIONS }o--o{ USERS : "target_user (nullable)"

    %% Notes: Budgets are associated to Categories and Users; spent amounts computed from Transactions within a budget's date range.
```

**Entities & important fields**

- **User**: id, name, email, password, role, status
- **Account**: id, user_id (FK), name, type, balance, description
- **Category**: id, user_id (FK), name, type (income|expense), color, is_default
- **Transaction**: id, user_id (FK), account_id (FK), category_id (FK), amount, type (income|expense), date, description
- **Budget**: id, user_id (FK), category_id (FK), amount, start_date, end_date, is_limiter
- **Feedback**: id, user_id (FK), subject, message, rating, status, reviewed_by (FK)
- **Notification**: id, title, description, type, created_by (FK), user_id (FK nullable), sent_at

**Relationship summary**

- `User` 1 — * `Account` (user owns many accounts)
- `User` 1 — * `Category` (user's categories)
- `User` 1 — * `Transaction` (user's transactions)
- `User` 1 — * `Budget` (user's budgets)
- `Account` 1 — * `Transaction` (account transactions)
- `Category` 1 — * `Transaction` (transactions assigned to a category)
- `Category` 1 — * `Budget` (category budgets)
- `Feedback` belongs to `User` (submitted_by) and optionally references a reviewer (`reviewed_by`)
- `Notification` created_by -> `User`; `Notification.user_id` nullable = targeted user; null = broadcast

If you'd like, I can:

- Render this Mermaid diagram to PNG/SVG and save to the repo.
- Generate a PlantUML or DOT version instead.
