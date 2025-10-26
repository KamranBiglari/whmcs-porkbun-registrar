# Porkbun WHMCS Registrar Module

A comprehensive WHMCS registrar module for [Porkbun.com](https://porkbun.com/) domain registrar, allowing you to manage your Porkbun domains directly from WHMCS.

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![WHMCS](https://img.shields.io/badge/WHMCS-7.0%2B-blue.svg)](https://www.whmcs.com/)
[![PHP](https://img.shields.io/badge/PHP-7.2%2B-purple.svg)](https://www.php.net/)

## Features

### ✅ Supported Features

- **Nameserver Management** - Get and update nameservers for your domains (supports up to 5 nameservers)
- **DNS Record Management** - Retrieve and view DNS records for domains
- **API Connection Testing** - Verify API credentials and connectivity
- **Domain Listing** - Access all domains in your Porkbun account
- **Comprehensive Error Handling** - Detailed logging and error messages
- **Secure API Communication** - HTTPS with SSL verification

### ⚠️ API Limitations

The following features are **not available** through the Porkbun API (as per their official documentation):

- Domain Registration
- Domain Transfer
- Domain Renewal
- Registrar Lock Management
- Real-time Domain Availability Checking

These operations must be performed directly through the Porkbun website.

## Requirements

- WHMCS 7.0 or higher
- PHP 7.2 or higher (7.4+ recommended)
- PHP cURL extension
- PHP JSON extension
- Active Porkbun account with API access enabled

## Installation

### 1. Download & Install

```bash
cd /path/to/whmcs/modules/registrars/
git clone https://github.com/KamranBiglari/whmcs-porkbun-registrar.git porkbun
```

Or download and extract manually to: `/modules/registrars/porkbun/`

### 2. Get API Credentials

1. Log in to your [Porkbun account](https://porkbun.com/)
2. Navigate to [API Settings](https://porkbun.com/account/api)
3. Generate your API credentials:
   - **API Key**
   - **Secret API Key**
4. Save these credentials securely

### 3. Enable API Access for Domains

**IMPORTANT:** For each domain you want to manage via the API:

1. Go to the domain's management page in Porkbun
2. Find the "API Access" setting
3. **Enable API Access** for that domain

> **Note:** If you have Two-Factor Authentication (2FA) enabled on your Porkbun account, the API may return 403 errors. You may need to disable 2FA for API access to work.

### 4. Activate in WHMCS

1. Log in to your **WHMCS Admin Panel**
2. Navigate to: **Setup → Products/Services → Domain Registrars**
3. Find **Porkbun** in the list
4. Click **Activate**
5. Enter your API credentials:
   - **API Key**: Your Porkbun API Key
   - **Secret API Key**: Your Porkbun Secret API Key
6. Click **Save Changes**
7. Click **Test Connection** to verify

## Configuration

### Basic Setup

After activation, configure the module in WHMCS:

1. API credentials (required)
2. Domain pricing (optional)
3. Default nameservers (optional)

See [INSTALLATION.md](INSTALLATION.md) for detailed setup instructions.

## Usage

### Managing Nameservers

1. Navigate to a domain in WHMCS admin
2. Go to the **Nameservers** tab
3. Update nameservers as needed
4. Click **Save Changes**

### Viewing DNS Records

1. Navigate to a domain in WHMCS admin
2. Go to the **DNS Management** tab
3. View current DNS records

## Documentation

- [README.md](README.md) - Module documentation and feature overview
- [INSTALLATION.md](INSTALLATION.md) - Detailed installation guide
- [SUMMARY.md](SUMMARY.md) - Technical details and API reference
- [SETUP_CHECKLIST.md](SETUP_CHECKLIST.md) - Step-by-step setup checklist

## File Structure

```
porkbun/
├── porkbun.php           # Main WHMCS module file
├── porkbunapi.php        # API helper class
├── whmcs.json            # Module metadata
├── index.php             # Security file
├── .gitignore            # Git ignore rules
├── README.md             # Module documentation
├── INSTALLATION.md       # Installation guide
├── SUMMARY.md            # Technical summary
└── SETUP_CHECKLIST.md    # Setup checklist
```

## API Reference

This module uses the Porkbun API v3:

- **Endpoint:** `https://api.porkbun.com/api/json/v3/`
- **Authentication:** API Key + Secret API Key (sent as JSON POST)
- **Documentation:** [Porkbun API Docs](https://porkbun.com/api/json/v3/documentation)

### Implemented API Endpoints

| Endpoint | Purpose | Status |
|----------|---------|--------|
| `/ping` | Test connection | ✅ Working |
| `/pricing/get` | Get TLD pricing | ✅ Working |
| `/domain/listAll` | List all domains | ✅ Working |
| `/domain/getNs/{domain}` | Get nameservers | ✅ Working |
| `/domain/updateNs/{domain}` | Update nameservers | ✅ Working |
| `/dns/retrieve/{domain}` | Get DNS records | ✅ Working |

## Troubleshooting

### Connection Test Fails (403 Forbidden)

**Solution:**
- Verify API credentials are correct (no extra spaces)
- Ensure API access is enabled for your domains in Porkbun
- Check if 2FA is enabled (may need to disable it)
- Verify server can make outbound HTTPS connections to api.porkbun.com

### Nameservers Not Updating

**Solution:**
- Verify the domain is registered in your Porkbun account
- Ensure API access is enabled for the specific domain
- Check WHMCS module logs: **Utilities → Logs → Module Log**
- Verify at least one nameserver is provided

### Module Not Appearing

**Solution:**
- Clear WHMCS cache: **Utilities → System → Clear Cache**
- Check file permissions (644 for files, 755 for directory)
- Verify all required files are present
- Check PHP error logs

### Debug Logging

View detailed API logs in WHMCS:

1. Navigate to: **Utilities → Logs → Module Log**
2. Filter by: **porkbun**
3. Review request/response data

## Security

- API credentials are stored encrypted by WHMCS
- All API requests use HTTPS with SSL verification
- Test connection script excluded from Git (.gitignore)
- Directory access protected (index.php)
- No sensitive data logged in module logs

## Development

### Testing

A test connection script is included for development:

1. Copy `test_connection.php.example` to `test_connection.php` (if available)
2. Add your API credentials
3. Access via browser to test connectivity
4. **Delete the file** after testing

### Contributing

Contributions are welcome! Please:

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a pull request

## Support

- **Issues:** [GitHub Issues](https://github.com/KamranBiglari/whmcs-porkbun-registrar/issues)
- **Porkbun API:** [API Documentation](https://porkbun.com/api/json/v3/documentation)
- **Porkbun Support:** [porkbun.com](https://porkbun.com/)

## License

This project is open source and available under the MIT License.

## Credits

- **Developer:** Kamran Biglari ([@KamranBiglari](https://github.com/KamranBiglari))
- **API Provider:** [Porkbun](https://porkbun.com/)
- **Platform:** [WHMCS](https://www.whmcs.com/)

## Changelog

### Version 1.0.0 (2025)

- Initial release
- Nameserver management (get/update)
- DNS record retrieval
- API connection testing
- Domain listing
- Comprehensive documentation
- Error handling and logging

## Roadmap

Future enhancements (pending Porkbun API support):

- [ ] Domain registration (when API supports it)
- [ ] Domain transfer (when API supports it)
- [ ] Domain renewal automation (when API supports it)
- [ ] Registrar lock management (when API supports it)
- [ ] Real-time availability checking (when API supports it)
- [ ] WHOIS management
- [ ] Contact information updates
- [ ] Auto-renewal settings

## Disclaimer

This is an unofficial third-party module for WHMCS and Porkbun. It is not affiliated with, endorsed by, or supported by Porkbun or WHMCS. Use at your own risk.

---

**Star this repository** if you find it useful! ⭐

For questions, issues, or contributions, please visit the [GitHub repository](https://github.com/KamranBiglari/whmcs-porkbun-registrar).