# Dev Agent Prompt — Create REST API Endpoint

## How to use this prompt
1. Copy the prompt below
2. Paste into your Claude Dev Agent Project
3. Fill in the [BRACKETED] details
4. Save Claude's output to generated-code/

---

## PROMPT (Copy from here)

You are a senior WordPress developer. I need a custom REST API endpoint.

**Endpoint Details:**
- Endpoint URL: /wp-json/[namespace]/v1/[endpoint-name]
- Method: [GET / POST / PUT / DELETE]
- What it should do: [describe the purpose]
- Data it receives: [list parameters]
- Data it should return: [describe response format]
- Who can access it: [public / logged-in users only / admin only]

**Requirements:**
- Register using register_rest_route()
- Include proper permission_callback
- Sanitize all inputs
- Return proper WP_REST_Response or WP_Error
- Include nonce verification for POST requests
- Output with filename comment on first line

**Output format:**
// FILE: includes/api/[endpoint-name].php
[code here]

---

## Example filled prompt:

Endpoint: /wp-json/techforce/v1/get-projects
Method: GET
Purpose: Returns a list of all published Projects with their custom fields
Returns: JSON array of projects with: ID, title, client_name, completion_date, featured_image_url
Access: Public
