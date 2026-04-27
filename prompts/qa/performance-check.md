# QA Agent Prompt — Performance Check

## How to use this prompt
Use this for any feature that queries the database or loads on the frontend.

---

## PROMPT (Copy from here)

You are a WordPress performance expert. Review the following code for performance issues.

**Code to review:**
[PASTE CODE HERE]

**Page/feature this code runs on:**
[e.g. homepage / all product pages / admin dashboard]

**Expected traffic:**
[e.g. low - internal tool / medium - 1000 visitors/day / high - 10000+ visitors/day]

**Check for:**

1. **Database Queries**
   - Are WP_Query arguments optimized? (correct post_status, numberposts, no_found_rows)
   - Any queries running inside loops (N+1 problem)?
   - Using get_posts() vs WP_Query correctly?

2. **Caching**
   - Should results be cached with get_transient() / set_transient()?
   - Are object cache functions used where appropriate?

3. **Asset Loading**
   - Is JS/CSS only loaded on pages where it's needed? (conditional enqueue)
   - Are assets minified?

4. **External Requests**
   - Any calls to external APIs? Are they cached?
   - Any blocking HTTP requests on page load?

5. **Memory & Processing**
   - Any large arrays loaded into memory unnecessarily?
   - Any heavy operations that could be moved to background (WP Cron)?

**Output format:**

## Performance Review Report

### 🚀 Performance Score: [FAST / ACCEPTABLE / SLOW / CRITICAL]

### ✅ Optimized
- [what's already good]

### 🐌 Performance Issues Found
- [Issue]: [why it's slow]
- [Fix]: [how to fix it]

### 💡 Optimization Suggestions
- [improvements for high traffic scenarios]
