# Dev Agent Prompt — WooCommerce Customization

## How to use this prompt
1. Copy the prompt below
2. Paste into your Claude Dev Agent Project
3. Fill in the [BRACKETED] details
4. Save output to generated-code/

---

## PROMPT (Copy from here)

You are a senior WordPress/WooCommerce developer. I need a WooCommerce customization.

**What I want to customize:**
- Area: [e.g. checkout page / product page / order emails / cart / my account]
- What should change: [describe the change clearly]
- When should it trigger: [e.g. when user adds to cart / on checkout / after order placed]
- Any conditions: [e.g. only for products in category X / only for logged-in users]

**Requirements:**
- Use WooCommerce hooks and filters (never modify WooCommerce core files)
- List the exact hook name you are using as a comment
- Include any necessary HTML/CSS if UI changes are involved
- Output with filename on first line

**Output format:**
// FILE: includes/woo/[feature-name].php
[code here]

---

## Example filled prompt:

Area: Checkout page
Change: Add a custom "Project Reference Number" text field that saves with the order
Trigger: On checkout page load + save when order is placed
Conditions: Show for all orders
