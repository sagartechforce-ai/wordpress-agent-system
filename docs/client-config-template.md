# Client Configuration Template
## Fill this out for each new client project

---

## Client Details

| Field | Value |
|---|---|
| Client Name | [e.g. Techforce / ABC Company] |
| Project Start Date | [DD/MM/YYYY] |
| WordPress Site URL | [https://example.com] |
| Staging URL | [https://staging.example.com] |
| WordPress Version | [e.g. 6.5] |
| PHP Version | [e.g. 8.1] |
| Theme Name | [e.g. Astra / Divi / Custom] |
| Page Builder | [Elementor / Gutenberg / None] |

---

## Installed Plugins (Key ones)

| Plugin | Version | Purpose |
|---|---|---|
| WooCommerce | | E-commerce |
| ACF Pro | | Custom fields |
| [Add more] | | |

---

## Code Prefix for This Project

All custom functions must use this prefix: `[clientshortname]_`
Example for Techforce: `techforce_`
Example for ABC Company: `abc_`

---

## Git Repository

- GitHub Repo URL: [https://github.com/your-org/client-project]
- Main branch (production): `main`
- Staging branch: `staging`
- Feature branches: `feature/description-of-feature`

---

## Server Details (Store securely — NOT in this file)

Keep FTP/SSH credentials in GitHub Secrets only:
- `STAGING_FTP_SERVER`
- `STAGING_FTP_USERNAME`  
- `STAGING_FTP_PASSWORD`
- `STAGING_FTP_PATH`
- `PROD_FTP_SERVER`
- `PROD_FTP_USERNAME`
- `PROD_FTP_PASSWORD`
- `PROD_FTP_PATH`

---

## Notes

[Any client-specific notes, special requirements, or things to be aware of]
