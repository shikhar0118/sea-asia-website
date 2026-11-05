# Sea Asia Shipping Services LLP

Responsive company website and project source.

## Deploy to GoDaddy Web Hosting (cPanel)

This site uses static HTML, CSS, JavaScript, and a PHP contact-form endpoint. Use GoDaddy Linux Web Hosting with cPanel (or another GoDaddy plan that supports PHP).

1. In GoDaddy, open your hosting plan's File Manager and open the document root for the domain. For the primary domain, this is usually `public_html`.
2. Upload the contents of this project to that folder, preserving the `api`, `assets`, `pages`, and `php` folders. The `index.html` file should be directly inside the document root.
3. Select a current PHP version in the hosting settings (PHP 8.2 or later is recommended).
4. Create `sea-asia-config.php` in the hosting account's home folder, one level above `public_html`. Do not put it inside the public document root or commit it to Git. Use this format:

   ```php
   <?php
   return [
       'RESEND_API_KEY' => 'your_private_resend_api_key',
       'CONTACT_TO_EMAIL' => 'info@seaasiashipping.com',
       'CONTACT_FROM_EMAIL' => 'Sea Asia Website <website@notify.seaasiashipping.com>',
   ];
   ```

5. In Resend, verify the sending domain used by `CONTACT_FROM_EMAIL`. Add the DNS records Resend provides in GoDaddy DNS. Keep existing MX records if you use GoDaddy for email.
6. Visit the domain over HTTPS and submit a contact-form enquiry to confirm delivery.

The PHP handler reads credentials from hosting environment variables first, then from the private `sea-asia-config.php` file. The recipient and sender can be changed there without editing website code.

GoDaddy's help pages: [upload files with cPanel File Manager](https://www.godaddy.com/en-in/help/upload-files-using-my-web-hosting-cpanel-file-manager-3239), [find the website root directory](https://www.godaddy.com/en-ph/help/what-is-my-websites-root-directory-in-my-web-hosting-cpanel-account-16187), and [change the PHP version](https://www.godaddy.com/en-in/help/view-or-change-the-php-version-for-my-web-hosting-cpanel-16090).
