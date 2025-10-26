# Porkbun Module Setup Checklist

Use this checklist to ensure proper setup of the Porkbun registrar module.

## Pre-Installation Checklist

- [ ] WHMCS is installed and accessible
- [ ] You have admin access to WHMCS
- [ ] PHP version 7.2+ is installed (7.4+ recommended)
- [ ] PHP cURL extension is enabled
- [ ] PHP JSON extension is enabled
- [ ] Server can make outbound HTTPS connections

## Porkbun Account Setup

- [ ] You have an active Porkbun account
- [ ] You have at least one domain in your Porkbun account
- [ ] You've visited https://porkbun.com/account/api
- [ ] You've generated your API Key
- [ ] You've generated your Secret API Key
- [ ] You've saved both keys securely

## Module Installation

- [ ] Module files are in `/modules/registrars/porkbun/` directory
- [ ] File permissions are set correctly (644 for files, 755 for directory)
- [ ] All required files are present:
  - [ ] porkbun.php (main module)
  - [ ] porkbunapi.php (API helper)
  - [ ] whmcs.json (metadata)
  - [ ] index.php (security)
- [ ] PHP syntax check passed for all PHP files

## Testing (Optional but Recommended)

- [ ] Edited `test_connection.php` with your API credentials
- [ ] Accessed the test script in your browser
- [ ] Connection test passed successfully
- [ ] Ping test showed your IP address
- [ ] Pricing data was retrieved
- [ ] Domain list was retrieved (if you have domains)
- [ ] **DELETED test_connection.php after testing** ⚠️ IMPORTANT!

## WHMCS Configuration

- [ ] Logged into WHMCS Admin Panel
- [ ] Navigated to Setup > Products/Services > Domain Registrars
- [ ] Found "Porkbun" in the registrars list
- [ ] Clicked "Activate" button
- [ ] Entered API Key in configuration
- [ ] Entered Secret API Key in configuration
- [ ] Clicked "Save Changes"
- [ ] Clicked "Test Connection" button
- [ ] Received success message with IP address

## Domain Configuration (Optional)

- [ ] Navigated to Setup > Products/Services > Domain Pricing
- [ ] Configured pricing for desired TLDs
- [ ] Set Porkbun as registrar for specific TLDs
- [ ] Set up auto-registration settings (if needed)
- [ ] Configured nameserver defaults (if needed)

## Functionality Testing

### Nameserver Management
- [ ] Selected a test domain in WHMCS
- [ ] Navigated to Nameservers tab
- [ ] Retrieved current nameservers successfully
- [ ] Updated nameservers
- [ ] Verified changes were saved
- [ ] Checked WHMCS module log for any errors

### DNS Records
- [ ] Accessed DNS Management for a domain
- [ ] Successfully retrieved DNS records
- [ ] Verified record data is correct

## Security Checklist

- [ ] Test connection file deleted (test_connection.php)
- [ ] API credentials are not visible in any log files
- [ ] Module log is not publicly accessible
- [ ] File permissions are secure (644 for files)
- [ ] No sensitive data in version control (if using Git)

## Documentation Review

- [ ] Read README.md for feature overview
- [ ] Read INSTALLATION.md for detailed setup
- [ ] Read SUMMARY.md for technical details
- [ ] Understood API limitations (no registration, transfer, renewal)
- [ ] Know where to find module logs (Utilities > Logs > Module Log)

## Troubleshooting Preparation

- [ ] Know how to access WHMCS module logs
- [ ] Know how to access PHP error logs
- [ ] Have Porkbun API documentation bookmarked
- [ ] Have Porkbun support contact information

## Post-Installation

- [ ] Module is working correctly
- [ ] No errors in WHMCS error log
- [ ] No errors in PHP error log
- [ ] Documented any custom configurations
- [ ] Informed relevant team members
- [ ] Created backup of working configuration

## Ongoing Maintenance

- [ ] Regularly check module logs for errors
- [ ] Monitor API connectivity
- [ ] Keep WHMCS updated
- [ ] Review Porkbun API documentation for new features
- [ ] Test functionality after WHMCS updates

## Known Limitations (Acknowledge)

- [ ] Understand domain registration must be done via Porkbun website
- [ ] Understand domain transfers must be done via Porkbun website
- [ ] Understand domain renewals must be done via Porkbun website
- [ ] Understand registrar lock not available via API
- [ ] Understand domain availability checking returns "unknown" status

## Support Resources

**For Module Issues:**
- WHMCS Module Log: Utilities > Logs > Module Log
- PHP Error Log: Check server error logs
- Module Documentation: README.md, INSTALLATION.md, SUMMARY.md

**For API Issues:**
- Porkbun API Docs: https://porkbun.com/api/json/v3/documentation
- Porkbun Support: https://porkbun.com/

**For WHMCS Issues:**
- WHMCS Documentation: https://docs.whmcs.com/
- WHMCS Support: https://www.whmcs.com/support/

---

## Quick Reference Commands

### Check PHP Version
```bash
php -v
```

### Check PHP Extensions
```bash
php -m | grep -E "curl|json"
```

### Check File Permissions
```bash
ls -lh /home/panelwebdata/public_html/modules/registrars/porkbun/
```

### Set Correct Permissions
```bash
chmod 644 /home/panelwebdata/public_html/modules/registrars/porkbun/*.php
chmod 644 /home/panelwebdata/public_html/modules/registrars/porkbun/*.json
chmod 755 /home/panelwebdata/public_html/modules/registrars/porkbun/
```

### Delete Test File (IMPORTANT!)
```bash
rm /home/panelwebdata/public_html/modules/registrars/porkbun/test_connection.php
```

### View Module Logs
WHMCS Admin → Utilities → Logs → Module Log → Filter: "porkbun"

---

**Setup Date:** _______________

**Configured By:** _______________

**Notes:**
_____________________________________________________________________________
_____________________________________________________________________________
_____________________________________________________________________________
