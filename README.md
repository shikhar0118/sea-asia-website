# Sea Asia Shipping Services LLP

Responsive company website and project source.

## Enquiry backend

The Contact page sends enquiries to `api/contact-submit.php`. The PHP handler validates each request and emails accepted enquiries to the configured recipient using Resend.

### Email setup

1. Create a Resend account, add a sending domain (a subdomain such as `notify.example.com` avoids changing existing mail records), and add the DNS records Resend provides at the domain's DNS host.
2. Create a Resend API key. Keep it private.
3. In Vercel, add `RESEND_API_KEY`, `CONTACT_TO_EMAIL`, and `CONTACT_FROM_EMAIL` under Project Settings → Environment Variables for each deployment environment you use. `CONTACT_FROM_EMAIL` must use the verified sending domain.
4. Redeploy after changing the environment variables.

The public Contact page needs the PHP function runtime and email environment variables to be configured. If the email service is unavailable, the page displays an error and keeps the contact phone and email visible as alternatives. The recipient can be changed with `CONTACT_TO_EMAIL` without changing the code.
