# WordPress Agentic Development Environment (Claude-Based)

A fully automated WordPress development system using Claude AI agents.
Built for Techforce — replicable for any client project.

---

## 🤖 Three Agents

| Agent | Folder | What it does |
|---|---|---|
| Dev Agent | `prompts/dev/` | Generates WordPress code |
| QA Agent | `prompts/qa/` | Reviews & tests code quality |
| Deploy Agent | `prompts/deploy/` | Handles safe Git deployment |

---

## 📁 Folder Structure

```
wordpress-agent-system/
├── prompts/
│   ├── dev/          ← Dev Agent prompt templates
│   ├── qa/           ← QA Agent prompt templates
│   └── deploy/       ← Deployment prompt templates
├── generated-code/   ← All AI-generated WordPress code goes here
├── tests/            ← PHPUnit test files
├── docs/             ← Project documentation
├── .github/
│   └── workflows/    ← GitHub Actions (auto deployment)
└── README.md
```

---

## 🚀 How to Use (Step by Step)

### Step 1 — Generate Code (Dev Agent)
1. Open Claude.ai → Go to your **Dev Agent Project**
2. Open the relevant prompt from `prompts/dev/`
3. Fill in your feature details and send to Claude
4. Save the output code into `generated-code/` folder

### Step 2 — Review Code (QA Agent)
1. Open Claude.ai → Go to your **QA Agent Project**
2. Open `prompts/qa/security-review.md`
3. Paste the generated code and send to Claude
4. Fix any issues Claude flags, then re-check

### Step 3 — Deploy (Deploy Agent)
1. Open `prompts/deploy/deployment-checklist.md`
2. Follow the checklist with Claude
3. Push to `staging` branch first
4. After testing, merge to `main` for production

---

## 🔁 Replicating for a New Client

1. Copy this entire repo
2. Rename the project in README
3. Update `docs/client-config.md` with new client's WP details
4. Set up new GitHub repo for the client
5. Done — all prompts and workflows are reusable


