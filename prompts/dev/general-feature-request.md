# Dev Agent Prompt — General Feature Request

## How to use this prompt
Use this for ANY WordPress feature not covered by the other prompts.

---

## PROMPT (Copy from here)

You are a senior WordPress developer. I need you to build a feature.

**Feature Description:**
[Describe what you want in plain English. Be as detailed as possible.]

**Where on the site does this appear:**
[e.g. homepage, all product pages, admin dashboard, user profile page]

**Who will use this:**
[e.g. site visitors / logged-in customers / admins only]

**Any plugins already installed that you should use:**
[e.g. ACF Pro, WooCommerce, Elementor, WPML]

**What should happen when:**
[Describe the trigger and result. e.g. "When user clicks the button, it should send an email to admin"]

**Requirements:**
- Use WordPress hooks/filters wherever possible
- No core file modifications
- Sanitize all user input
- Escape all output
- Add inline comments explaining what each section does
- Output each file separately with filename as comment on first line

---

## Example:

Feature: I want a "Request a Quote" button on every product page. When clicked, it opens a popup form with fields: Name, Email, Phone, Message. On submit, it emails the admin and shows a thank-you message. No payment required.
Where: All WooCommerce product pages
Who: Any site visitor
Plugins: WooCommerce, ACF Pro installed
