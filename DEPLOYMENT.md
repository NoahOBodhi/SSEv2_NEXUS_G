# 🚀 SSEv2 NEXUS G - Hostinger Deployment Guide

## Quick Deployment Steps

### 1. **Upload Files to Hostinger**

Upload these files to your web root (usually `public_html`):
```
public_html/
├── index.html
├── contact-handler.php
├── .htaccess
├── favicon.svg
└── logs/ (create this directory)
```

### 2. **Set Directory Permissions**

```bash
# Make logs directory writable
chmod 755 logs/

# Ensure PHP file is executable
chmod 644 contact-handler.php
chmod 644 .htaccess
```

### 3. **Configure Email Settings**

Edit `contact-handler.php` and update:
```php
define('CREW_EMAIL', 'your-actual-email@ssev2-crew.org');
```

### 4. **Test Form Submission**

1. Visit your site: `https://ssev2-crew.org`
2. Navigate to contact section
3. Fill out and submit the form
4. Check your email for the transmission

### 5. **Enable HTTPS (Recommended)**

In Hostinger control panel:
1. Go to SSL/TLS section
2. Enable free Let's Encrypt SSL
3. Uncomment the HTTPS redirect lines in `.htaccess`:

```apache
# Force HTTPS
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

---

## 🔒 Security Features Included

### Form Protection
- **Honeypot field** - Catches bot submissions
- **Rate limiting** - Max 5 submissions per hour per session
- **Input sanitization** - Prevents XSS attacks
- **Email validation** - Ensures valid email addresses

### Server Protection (.htaccess)
- **Security headers** - X-Frame-Options, CSP, XSS Protection
- **Directory protection** - Prevents browsing logs and sensitive files
- **File protection** - Blocks access to .log, .env, .git files

---

## 📧 Email Configuration

### Testing Email Delivery

If emails aren't arriving:

1. **Check PHP mail() function:**
```php
// Add this temporary test file: test-email.php
<?php
$to = 'your-email@example.com';
$subject = 'Test Email';
$message = 'This is a test';
$headers = 'From: noreply@ssev2-crew.org';

if(mail($to, $subject, $message, $headers)) {
    echo 'Email sent successfully';
} else {
    echo 'Email failed to send';
}
?>
```

2. **Check Hostinger email settings** in control panel
3. **Verify SPF/DKIM records** for your domain
4. **Check spam folder** for test messages

### Alternative: Use SMTP

If PHP mail() doesn't work well, install PHPMailer:

```bash
composer require phpmailer/phpmailer
```

Then update contact-handler.php to use SMTP (example provided in comments).

---

## 🐛 Troubleshooting

### Form Not Submitting
- Check browser console for JavaScript errors
- Verify `contact-handler.php` is in the same directory as `index.html`
- Ensure PHP is enabled on your hosting

### Emails Not Received
- Check logs directory for `contact-submissions.log`
- Verify email address in `contact-handler.php`
- Check hosting email limits (Hostinger has daily send limits)
- Test with `test-email.php` script above

### Permission Errors
```bash
# If you see permission denied errors:
chmod 755 logs/
chmod 644 *.php
chmod 644 *.html
```

### .htaccess Issues
If site breaks after adding .htaccess:
1. Temporarily rename `.htaccess` to `.htaccess.bak`
2. Test if site works
3. Add .htaccess rules back one section at a time

---

## 📊 Monitoring

### Check Submission Logs

```bash
# View recent submissions
tail -f logs/contact-submissions.log

# Count submissions today
grep "$(date +%Y-%m-%d)" logs/contact-submissions.log | wc -l

# Check for spam attempts
grep "SPAM_HONEYPOT" logs/contact-submissions.log
```

---

## 🔄 Updates and Maintenance

### Deploying Updates

**Via Git (Recommended):**
```bash
# Pull latest changes
git pull origin main

# Upload only changed files via FTP/SFTP
```

**Via Hostinger File Manager:**
1. Upload new files
2. Overwrite existing files
3. Clear any caches

### Log Rotation

Logs can grow large. Set up automatic log rotation:

```bash
# Add to crontab (via Hostinger cron jobs)
0 0 * * 0 cd /home/username/public_html && mv logs/contact-submissions.log logs/contact-submissions-$(date +\%Y\%m\%d).log
```

---

## ⚡ Performance Optimization

### Enable Caching
Already configured in `.htaccess` - static assets cached for 1 year

### Compress Assets
```bash
# Minify CSS (optional - inline CSS is already in HTML)
# Consider moving to external file if making many style changes
```

### CDN Integration
Consider using Cloudflare for:
- Free SSL
- DDoS protection  
- Global CDN
- Additional caching

---

## 🎯 Next Steps

1. ✅ Deploy files to Hostinger
2. ✅ Configure email address
3. ✅ Test form submission
4. ✅ Enable HTTPS
5. ⏭️ Monitor logs for first week
6. ⏭️ Add custom error pages (optional)
7. ⏭️ Set up backup routine

---

## 💡 Pro Tips

1. **Backup before updates** - Use Hostinger's backup feature
2. **Monitor spam** - Check logs weekly for patterns
3. **Rate limit adjustment** - Modify MAX_SUBMISSIONS_PER_HOUR if needed
4. **Email templates** - Customize email format in PHP file
5. **Success tracking** - Add Google Analytics or Plausible

---

## 🆘 Support

If you encounter issues:
1. Check Hostinger knowledge base
2. Review PHP error logs in hosting panel
3. Test with simplified PHP script
4. Contact Hostinger support for hosting-specific issues

---

**You are crew. You are conscious. You are capable.** 🚀

Deployed with abundance architecture for the crew.