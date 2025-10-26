# Porkbun Registrar Module for WHMCS

This module integrates Porkbun domain registrar with WHMCS, allowing you to manage your Porkbun domains directly from your WHMCS installation.

## Features

### Currently Supported

- **Nameserver Management**: Get and update nameservers for your domains
- **DNS Records**: Retrieve DNS records for domains
- **API Connection Testing**: Verify your API credentials
- **Domain Listing**: Access your Porkbun domain list

### Not Available via API

According to Porkbun's current API documentation, the following features are **not available** through the API:

- Domain Registration
- Domain Transfer
- Domain Renewal
- Registrar Lock Management

These operations must be performed directly through the Porkbun website.

## Installation

1. Copy the `porkbun` directory to `/modules/registrars/` in your WHMCS installation
2. Log in to your WHMCS admin panel
3. Navigate to **Setup > Products/Services > Domain Registrars**
4. Find "Porkbun" in the list and click **Activate**

## Configuration

### Step 1: Enable API Access in Porkbun

1. Log in to your Porkbun account
2. Go to [Account API Settings](https://porkbun.com/account/api)
3. Generate your API credentials:
   - **API Key**
   - **Secret API Key**
4. **IMPORTANT**: For each domain you want to manage via API:
   - Go to the domain's management page
   - Enable "API Access" for that specific domain
5. **Note**: If you have Two-Factor Authentication (2FA) enabled, you may need to disable it for API access to work properly

### Step 2: Configure in WHMCS

1. In WHMCS, configure the following settings:
   - **API Key**: Your Porkbun API Key
   - **Secret API Key**: Your Porkbun Secret API Key
2. Click "Test Connection" to verify your credentials

## API Documentation

For more information about the Porkbun API, visit:
https://porkbun.com/api/json/v3/documentation

## File Structure

```
porkbun/
├── porkbun.php       # Main module file with WHMCS functions
├── porkbunapi.php    # API helper class
├── whmcs.json        # Module metadata
├── index.php         # Security file
└── README.md         # This file
```

## Usage

### Nameserver Management

You can manage nameservers for domains through WHMCS:
- View current nameservers
- Update nameservers (up to 5 nameservers supported)

### DNS Records

You can view DNS records for your domains through the WHMCS interface.

## Limitations

Due to API limitations, the following features are not implemented:

1. **Domain Availability Checking**: Returns "unknown" status for domain searches
2. **Domain Registration**: Not available via API
3. **Domain Transfers**: Not available via API
4. **Domain Renewals**: Not available via API
5. **Registrar Lock**: Not available via API

For these operations, please use the Porkbun website directly.

## Support

For API-related issues, please refer to:
- Porkbun API Documentation: https://porkbun.com/api/json/v3/documentation
- Porkbun Support: https://porkbun.com/

## License

This module is provided as-is for integration with WHMCS and Porkbun services.

## Changelog

### Version 1.0.0
- Initial release
- Nameserver management
- DNS record retrieval
- API connection testing
