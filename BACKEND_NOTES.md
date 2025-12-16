# Backend Implementation Requirements

## Critical Issues to Fix

### 1. Admin Test Account Creation
**URGENT**: Create admin account for testing
- **Email**: test@example.com
- **Password**: password123
- **Role**: admin
- **Status**: This account does not exist on localhost and is required for admin panel testing

### 2. Notification System Architecture
The frontend now implements a comprehensive notification direction system that requires backend coordination:

#### Notification Interface (Updated)
```typescript
interface Notification {
  id: number;
  title: string;
  description: string;
  date: string;
  type: "success" | "error" | "warning" | "info";
  read: boolean;
  direction: "sent" | "received";  // NEW FIELD
  source: "user" | "admin";        // NEW FIELD
  created_by?: number;             // User ID who created the notification
}
```

#### Notification Routing Logic (Frontend Implementation)
The frontend now categorizes notifications as follows:

**For Admin Users:**
- Feedback notifications → "received" (from users)
- Admin broadcast notifications → "sent" (by admin)

**For Regular Users:**
- Their own feedback notifications → "sent" (by user)
- Admin broadcast notifications → "received" (from admin)

#### Backend API Requirements

##### 1. Feedback Submission Endpoint
When users submit feedback, the notification should be:
- **Sent TO**: All admin users (not the submitting user)
- **Title**: "New Feedback Received"
- **Type**: "info"
- **created_by**: ID of user who submitted feedback

##### 2. Admin Broadcast Endpoint
When admins broadcast notifications:
- **Sent TO**: All users (except the admin sending it)
- **Title**: As specified by admin
- **Type**: As specified by admin
- **created_by**: ID of admin who sent broadcast

##### 3. Notification Fetching Endpoint
Current API should return notifications with:
- Standard fields (id, title, description, sent_at/created_at, type)
- **created_by**: User ID who created the notification
- Frontend handles direction/source categorization based on user role

### 3. Current Issues Confirmed Through Testing

#### Feedback Notification Routing
- ❌ **ISSUE**: When users submit feedback, notification goes to the user instead of admins
- ✅ **EXPECTED**: Feedback notifications should go to admin users only
- 🔧 **SOLUTION**: Update feedback submission to create notifications for admin role users

#### Admin Account Access
- ❌ **ISSUE**: test@example.com admin account doesn't exist
- ✅ **EXPECTED**: Admin account should exist for testing admin panel functionality
- 🔧 **SOLUTION**: Create admin user with specified credentials

### 4. API Endpoints Status

#### Working Endpoints:
- User feedback submission (but notification routing is wrong)
- User notification fetching
- Admin panel display functionality

#### Needs Implementation/Fix:
- Admin account creation
- Proper feedback notification routing (to admins, not users)
- Admin broadcast notification system

### 5. Testing Checklist

Once backend fixes are implemented, test:
1. ✅ User can submit feedback
2. ✅ Admin receives "New Feedback Received" notification (not user)
3. ✅ Admin can log in with test@example.com / password123
4. ✅ Admin can broadcast notifications to all users
5. ✅ Users receive admin broadcast notifications
6. ✅ Notification direction badges show correctly (Sent/Received)

### 6. Frontend Implementation Status
✅ **COMPLETE**: 
- Notification direction system with role-based filtering
- Visual direction badges (Sent/Received with icons)
- Admin panel UI fully functional
- Role-based notification categorization
- Real-time notification updates

❌ **PENDING BACKEND**:
- Admin test account creation
- Proper feedback notification routing
- Admin broadcast functionality

## Notes for Backend Team
- Frontend notification system is now comprehensive and handles direction/source automatically
- No backend changes needed for notification interface - frontend manages categorization
- Focus on fixing notification routing (feedback → admins) and creating admin test account
- All notification filtering and display logic is handled client-side based on user role