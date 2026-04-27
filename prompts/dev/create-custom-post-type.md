# Dev Agent Prompt — Create Custom Post Type

## How to use this prompt
1. Copy everything inside the box below
2. Paste it into your Claude Dev Agent Project
3. Replace the [BRACKETED] parts with your actual requirements
4. Send to Claude and save the output to generated-code/

---

## PROMPT (Copy from here)

You are a senior WordPress developer. I need you to create a Custom Post Type.

**Details:**
- Post Type Name: [e.g. Projects]
- Slug: [e.g. projects]
- Fields needed: [e.g. client name, completion date, featured image, description]
- Should have its own archive page: [Yes / No]
- Should appear in the WordPress admin menu: [Yes / No]
- Any taxonomies (categories/tags) needed: [e.g. Project Category, Project Tags]

**Requirements:**
- Follow WordPress Coding Standards
- Use register_post_type() properly
- Add all fields using ACF (Advanced Custom Fields) if available, otherwise use custom meta boxes
- Include sanitization on save
- Output each file separately with the filename as a comment on the first line
- Do NOT modify any core WordPress files

**Output format:**
Provide the complete code in labeled blocks like:
// FILE: includes/cpt-[name].php
[code here]

---

## Example filled prompt:

Post Type Name: Projects
Slug: projects  
Fields: Client Name (text), Completion Date (date), Budget (number), Featured Image
Archive page: Yes
Admin menu: Yes
Taxonomies: Project Category
