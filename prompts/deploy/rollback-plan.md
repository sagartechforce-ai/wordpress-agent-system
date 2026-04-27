# Deploy Agent Prompt — Rollback Plan

## How to use this prompt
If something breaks after deployment, use this to get rollback instructions.

---

## PROMPT (Copy from here)

You are a WordPress deployment expert. Something went wrong after deployment and I need to rollback.

**What broke:**
[Describe the problem — e.g. "White screen on homepage" / "Checkout not working" / "Admin login broken"]

**What was deployed:**
[Describe the feature/files that were just pushed]

**Git branch deployed from:**
[e.g. staging / main]

**Last known working commit (if you know it):**
[Paste the commit hash, e.g. a3f9c21 — or write "Unknown"]

**Was there a database change?**
[Yes / No — if yes, describe what changed]

Please provide:
1. Exact Git commands to revert the code
2. Steps to restore the database if needed
3. How to verify the rollback worked
4. What to check to understand what caused the issue

Output as a numbered step-by-step guide I can follow immediately.
