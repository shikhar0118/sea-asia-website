# Sea Asia Shipping Services LLP

Responsive company website and project source.

## Enquiry backend

The Contact page sends enquiries to `api/contact-submit.php`. The PHP handler validates each request and stores accepted enquiries in the MySQL `contact_enquiries` table.

### Database setup

1. Create a MySQL database and run [`database/schema.sql`](database/schema.sql).
2. Copy `.env.example` to `.env` for a local PHP server and enter the database connection values. Do not commit `.env` or share its password.
3. In Vercel, add `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, and `DB_PASSWORD` under the project environment variables for each deployment environment you use. Redeploy after changing those values.

The public Contact page needs the PHP function runtime and the database environment variables to be configured. If the backend is unavailable, the page displays an error and keeps the contact phone and email visible as alternatives.
