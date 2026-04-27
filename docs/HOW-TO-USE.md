# How to Use This System (Simple Guide)
## Written for non-technical users

---

## The Big Picture

Think of this as a factory with 3 workers:

```
You describe what you want
       ↓
🔵 Dev Agent (Claude) → Writes the code
       ↓
🟢 QA Agent (Claude) → Checks the code for problems
       ↓
🟠 Deploy Agent (Claude) → Helps you put it live safely
```

---

## Daily Workflow (Step by Step)

### 🔵 STEP 1 — Build Something (Dev Agent)

1. Open [claude.ai](https://claude.ai)
2. Go to your **"WordPress Dev Agent – Techforce"** Project
3. Open the right prompt file from `prompts/dev/` folder
   - Building a new page/section? → use `general-feature-request.md`
   - Building a new content type? → use `create-custom-post-type.md`
   - Building a WooCommerce feature? → use `woocommerce-customization.md`
4. Copy the prompt, fill in the blanks, send to Claude
5. Claude gives you code → Copy it → Save in `generated-code/` folder

---

### 🟢 STEP 2 — Check the Code (QA Agent)

**Always do this before touching your website.**

1. Go to your **"WordPress QA Agent – Techforce"** Project
2. Open `prompts/qa/security-review.md`
3. Copy the prompt, paste your code where it says [PASTE CODE HERE]
4. Send to Claude
5. Look at the result:
   - ✅ "SAFE TO DEPLOY" → Move to Step 3
   - ❌ "NEEDS FIXES" → Go back to Dev Agent with Claude's feedback
   - 🚨 "DO NOT USE" → Stop. Fix all issues first.

---

### 🟠 STEP 3 — Deploy (Put it live)

**Always test on staging first!**

1. Open `prompts/deploy/pre-deployment-checklist.md`
2. Fill it in and send to Claude
3. Claude will say GO or NO-GO
4. If GO:
   - Push code to **staging branch** first
   - Test everything on staging site
   - If staging is good → Push to **main branch** for production
5. After going live, verify the site works

---

## When Something Goes Wrong

If the site breaks after deployment:
1. Open `prompts/deploy/rollback-plan.md`
2. Describe what broke
3. Claude gives you exact steps to undo it

---

## Setting Up a New Client Project

1. Copy this entire folder
2. Rename it to the client's name
3. Fill in `docs/client-config-template.md` with client details
4. Create a new GitHub repo for the client
5. Create new Claude Projects for Dev + QA agents
6. Change the prefix in the Dev Agent system prompt to match the client

---

## Golden Rules

✅ Always QA before deploying
✅ Always deploy to staging first
✅ Always take a backup before production deployment
✅ Never put passwords or API keys in code files
✅ If unsure → ask Claude
