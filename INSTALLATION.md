# Installation Guide - Porkbun Registrar Module for WHMCS

## Prerequisites

- WHMCS installation (version 7.0 or higher recommended)
- Active Porkbun account
- Porkbun API credentials (API Key and Secret API Key)

## Step 1: Get Your API Credentials

1. Log in to your Porkbun account
2. Navigate to https://porkbun.com/account/api
3. Generate your API credentials:
   - **API Key**
   - **Secret API Key**
4. Save these credentials securely - you'll need them for configuration

**IMPORTANT - Enable API Access for Domains:**
5. For EACH domain you want to manage via the API:
   - Go to the domain's management page in Porkbun
   - Look for "API Access" setting
   - **Enable API Access** for that domain
6. **Note about 2FA**: If you have Two-Factor Authentication enabled on your Porkbun account, the API may return 403 errors. You may need to disable 2FA for API access to work properly.

## Step 2: Install the Module

The module files should already be in place at:
```
/home/panelwebdata/public_html/modules/registrars/porkbun/
```

Files included:
- `porkbun.php` - Main module file
- `porkbunapi.php` - API helper class
- `whmcs.json` - Module metadata
- `index.php` - Security file
- `README.md` - Documentation
- `INSTALLATION.md` - This file

## Step 3: Activate the Module in WHMCS

1. Log in to your **WHMCS Admin Panel**
2. Navigate to: **Setup > Products/Services > Domain Registrars**
3. Scroll down to find **Porkbun** in the list
4. Click the **Activate** button next to Porkbun

## Step 4: Configure API Credentials

1. After activation, you'll see the Porkbun configuration section
2. Enter your credentials:
   - **API Key**: Paste your Porkbun API Key
   - **Secret API Key**: Paste your Porkbun Secret API Key
3. Click **Save Changes**

## Step 5: Test the Connection

1. After saving, click the **Test Connection** button
2. You should see a success message with your IP address
3. If you see an error:
   - Verify your API credentials are correct
   - Ensure your server can make outbound HTTPS connections
   - Check that your Porkbun API access is enabled

## Step 6: Configure Domain Settings (Optional)

1. Navigate to: **Setup > Products/Services > Domain Pricing**
2. Configure pricing for TLDs you want to offer
3. Set Porkbun as the registrar for specific TLDs

## Supported Features

✅ **Available via API:**
- Nameserver management (get/update)
- DNS record retrieval
- Domain listing
- API connection testing

❌ **NOT Available via API (must be done on Porkbun website):**
- Domain registration
- Domain transfer
- Domain renewal
- Registrar lock management

## Troubleshooting

### Connection Test Fails

**Problem**: "Connection failed" or timeout errors

**Solutions**:
- Verify API credentials are correct (no extra spaces)
- Check that your server's firewall allows outbound HTTPS (port 443)
- Ensure `curl` PHP extension is installed and enabled
- Check PHP error logs for detailed error messages

### Nameservers Not Updating

**Problem**: Changes to nameservers don't save

**Solutions**:
- Verify the domain is already registered in your Porkbun account
- Ensure you're providing valid nameserver hostnames
- Check that at least one nameserver is provided
- Review WHMCS module logs: **Utilities > Logs > Module Log**

### Module Not Appearing

**Problem**: Porkbun doesn't show in the registrars list

**Solutions**:
- Verify all module files are in the correct directory
- Check file permissions (should be readable by web server)
- Clear WHMCS cache: **Utilities > System > Clear Cache**
- Verify PHP version compatibility (7.4+ recommended)

## Module Logs

To view detailed API logs:
1. Navigate to: **Utilities > Logs > Module Log**
2. Filter by module: **porkbun**
3. Review request/response data for debugging

## Security Notes

- Keep your API credentials secure
- Use WHMCS's encryption for storing sensitive data
- Regularly review module logs for suspicious activity
- API credentials are stored in WHMCS configuration (encrypted)

## Next Steps

After successful installation:
1. Test nameserver management with a domain
2. Review DNS records for your domains
3. Configure automatic nameserver assignment if desired
4. Set up domain pricing in WHMCS

## Support

For module issues:
- Check WHMCS module logs
- Review PHP error logs
- Consult Porkbun API documentation: https://porkbun.com/api/json/v3/documentation

For Porkbun account issues:
- Contact Porkbun support directly
- Visit: https://porkbun.com/

## File Permissions

Recommended permissions:
```bash
chmod 644 porkbun/*.php
chmod 644 porkbun/*.json
chmod 644 porkbun/*.md
```

The web server user needs read access to all module files.
