# Deploy Agent Prompt — Pre-Deployment Checklist

## How to use this prompt
Before pushing ANY code to staging or production, run this checklist with Claude.

---

## PROMPT (Copy from here)

You are a WordPress deployment expert. I am about to deploy the following feature to [STAGING / PRODUCTION].

**Feature being deployed:**
[Describe what you built]

**Files changed:**
[List all files that were added or modified]

**Plugins added or updated:**
[List any plugins, or write "None"]

**Database changes:**
[Describe any new tables, columns, or data changes. Or write "None"]

**Environment:**
- Deploying to: [Staging / Production]
- WordPress version: [e.g. 6.5]
- PHP version: [e.g. 8.1]

Please run through this checklist and tell me YES/NO/WARNING for each item:

**Pre-Deployment Checklist:**
1. All QA checks passed (security + code standards + performance)?
2. Code tested on local environment successfully?
3. No hardcoded URLs (like http://localhost or staging URLs) in the code?
4. No debug code left in (var_dump, console.log, error_log for sensitive data)?
5. Environment-specific config in wp-config.php only (no secrets in code files)?
6. Database backup taken before deployment?
7. If DB changes: migration script ready?
8. Rollback plan prepared (what git command reverts this)?
9. Someone to test immediately after deployment?
10. Deployment happening during low-traffic hours?

**Output:**
For each item: ✅ YES / ❌ NO (BLOCKER) / ⚠️ WARNING
Then: GO / NO-GO for deployment

---

## After deployment — use this:

Verify these after pushing to staging:
- [ ] Site loads without errors
- [ ] New feature works as expected  
- [ ] Existing features not broken (quick smoke test)
- [ ] No PHP errors in debug log
- [ ] Admin dashboard accessible
