# Supabase + Render Setup Guide

This guide explains how to connect your Laravel app on Render to Supabase PostgreSQL database.

## Step 1: Get Supabase Database Credentials

1. Go to your Supabase project dashboard
2. Click **Settings** (gear icon in sidebar)
3. Click **Database** in the settings menu
4. Scroll to **Connection Info** section

You'll need these values:
- **Host**: `db.xxxxxxxxxxxxx.supabase.co`
- **Database name**: Usually `postgres`
- **User**: Usually `postgres`
- **Password**: Your database password (set when creating project)
- **Port**: `5432`

## Step 2: Configure Render Environment Variables

1. Go to your Render dashboard: https://dashboard.render.com
2. Select your `budget-tracker` web service
3. Click **Environment** tab
4. Add/Update these environment variables with your Supabase credentials:

```
DB_CONNECTION=pgsql
DB_HOST=db.xxxxxxxxxxxxx.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=your_supabase_password
DB_SSLMODE=require
```

⚠️ **Important**: Make sure to use the exact values from your Supabase connection info.

## Step 3: Import Database Schema to Supabase

You have two options:

### Option A: Use the SQL file (Quick)

1. In Supabase dashboard, go to **SQL Editor**
2. Click **New query**
3. Copy the contents of `database/budget_tracker_postgresql.sql`
4. Paste into the SQL editor
5. Click **Run** to create all tables

### Option B: Use Laravel Migrations (Recommended)

The migrations will run automatically when your Render app deploys. Or you can run manually:

1. SSH into your Render service (if needed)
2. Run: `php artisan migrate --force`

## Step 4: Deploy/Redeploy on Render

1. Commit and push the updated `render.yaml`:
   ```bash
   git add render.yaml
   git commit -m "Configure Supabase database connection"
   git push origin main
   ```

2. Render will automatically redeploy with new environment variables

3. Check the deployment logs to ensure migrations run successfully

## Step 5: Verify Connection

After deployment completes:

1. Visit your Render app URL
2. Try registering a new user or logging in
3. Check Supabase dashboard → **Table Editor** to see if data is being saved

## Troubleshooting

### Connection timeout errors
- Check that **DB_SSLMODE=require** is set
- Verify Supabase host URL is correct (no http:// or https://)
- Ensure your Supabase project is not paused

### SSL certificate errors
- Make sure `DB_SSLMODE=require` is set in Render environment
- Supabase requires SSL connections

### Migration errors
- Check Render logs: Dashboard → Your Service → Logs
- Look for database connection errors during startup
- Verify all DB_ credentials are correct

### "Too many connections" error
- Supabase free tier has connection limits
- Use connection pooling (Supabase provides this automatically)
- Set `DB_HOST` to the **pooler** connection string if available

## Connection Pooling (Optional but Recommended)

Supabase provides connection pooling which is better for serverless/container deployments:

1. In Supabase → Settings → Database
2. Look for **Connection Pooling** section
3. Use the **Pooler** host instead of direct connection:
   - Format: `aws-0-us-east-1.pooler.supabase.com`
   - Port: `6543` (note: different from direct connection)

Update Render environment:
```
DB_HOST=aws-0-us-east-1.pooler.supabase.com
DB_PORT=6543
```

## Benefits of Supabase + Render Setup

✅ **Separate concerns**: Database and app are independent  
✅ **Better scaling**: Supabase handles database scaling  
✅ **Built-in features**: Real-time, auth, storage from Supabase  
✅ **Cost effective**: Supabase free tier + Render free tier  
✅ **Easy backups**: Supabase automatic backups  

## Next Steps

After successful setup:

1. **Enable Supabase features** (optional):
   - Row Level Security (RLS) for additional security
   - Real-time subscriptions for live updates
   - Supabase Auth (can replace Laravel auth)

2. **Monitor performance**:
   - Check query performance in Supabase dashboard
   - Monitor connection counts
   - Set up alerts for database issues

3. **Backup strategy**:
   - Supabase handles automatic backups
   - Consider periodic SQL dumps for extra safety
   - Test restore procedures

## Support

- **Supabase Docs**: https://supabase.com/docs
- **Render Docs**: https://render.com/docs
- **Laravel Database**: https://laravel.com/docs/database
