<?php

/**
 * WHMCS Porkbun Registrar Module
 *
 * This module allows WHMCS to interact with the Porkbun domain registrar API.
 *
 * @see https://porkbun.com/api/json/v3/documentation
 */

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

use WHMCS\Domains\DomainLookup\ResultsList;
use WHMCS\Domains\DomainLookup\SearchResult;

/**
 * Define module configuration parameters
 *
 * @return array
 */
function porkbun_getConfigArray()
{
    return array(
        'FriendlyName' => array(
            'Type' => 'System',
            'Value' => 'Porkbun',
        ),
        'Description' => array(
            'Type' => 'System',
            'Value' => 'Porkbun domain registrar integration for WHMCS',
        ),
        'ApiKey' => array(
            'Type' => 'text',
            'Size' => '40',
            'Default' => '',
            'Description' => 'Enter your Porkbun API Key here (get it from porkbun.com/account/api)',
        ),
        'SecretApiKey' => array(
            'Type' => 'text',
            'Size' => '40',
            'Default' => '',
            'Description' => 'Enter your Porkbun Secret API Key here',
        ),
    );
}

/**
 * Get API instance
 *
 * @param array $params
 * @return PorkbunApi
 */
function porkbun_getApi($params)
{
    require_once __DIR__ . '/porkbunapi.php';
    return new PorkbunApi($params['ApiKey'], $params['SecretApiKey']);
}

/**
 * Check domain availability
 *
 * @param array $params
 * @return ResultsList
 */
function porkbun_CheckAvailability($params)
{
    $results = new ResultsList();

    try {
        $api = porkbun_getApi($params);
        $searchTerm = $params['searchTerm'];
        $tldsToInclude = $params['tldsToInclude'];
        $isIdnDomain = (bool) $params['isIdnDomain'];
        $premiumEnabled = (bool) $params['premiumEnabled'];

        foreach ($tldsToInclude as $tld) {
            $domain = $searchTerm . $tld;
            $searchResult = new SearchResult($searchTerm, $tld);

            try {
                // Porkbun doesn't have a direct availability check endpoint
                // We need to try to get domain info or use another method
                // For now, we'll mark as unknown status
                // In production, you might want to implement additional logic
                $searchResult->setStatus(SearchResult::STATUS_UNKNOWN);
            } catch (Exception $e) {
                $searchResult->setStatus(SearchResult::STATUS_UNKNOWN);
            }

            $results->append($searchResult);
        }

    } catch (Exception $e) {
        // Log the error
        logModuleCall(
            'porkbun',
            'CheckAvailability',
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );
    }

    return $results;
}

/**
 * Get nameservers for a domain
 *
 * @param array $params
 * @return array
 */
function porkbun_GetNameservers($params)
{
    try {
        $api = porkbun_getApi($params);
        $domain = $params['sld'] . '.' . $params['tld'];

        $result = $api->getNameservers($domain);

        $values = array();
        if (isset($result['ns']) && is_array($result['ns'])) {
            for ($i = 0; $i < count($result['ns']) && $i < 5; $i++) {
                $values['ns' . ($i + 1)] = $result['ns'][$i];
            }
        }

        return $values;

    } catch (Exception $e) {
        logModuleCall(
            'porkbun',
            'GetNameservers',
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );
        return array('error' => $e->getMessage());
    }
}

/**
 * Save nameservers for a domain
 *
 * @param array $params
 * @return array
 */
function porkbun_SaveNameservers($params)
{
    try {
        $api = porkbun_getApi($params);
        $domain = $params['sld'] . '.' . $params['tld'];

        $nameservers = array();
        for ($i = 1; $i <= 5; $i++) {
            if (!empty($params['ns' . $i])) {
                $nameservers[] = $params['ns' . $i];
            }
        }

        if (empty($nameservers)) {
            return array('error' => 'At least one nameserver is required');
        }

        $result = $api->updateNameservers($domain, $nameservers);

        if (isset($result['status']) && $result['status'] === 'SUCCESS') {
            return array('success' => true);
        }

        return array('error' => 'Failed to update nameservers');

    } catch (Exception $e) {
        logModuleCall(
            'porkbun',
            'SaveNameservers',
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );
        return array('error' => $e->getMessage());
    }
}

/**
 * Register a domain
 *
 * Note: As of the current API documentation, Porkbun doesn't provide
 * domain registration through the API. This function returns an error.
 *
 * @param array $params
 * @return array
 */
function porkbun_RegisterDomain($params)
{
    return array('error' => 'Domain registration is not available through the Porkbun API. Please register domains through the Porkbun website.');
}

/**
 * Transfer a domain
 *
 * Note: As of the current API documentation, Porkbun doesn't provide
 * domain transfer through the API. This function returns an error.
 *
 * @param array $params
 * @return array
 */
function porkbun_TransferDomain($params)
{
    return array('error' => 'Domain transfer is not available through the Porkbun API. Please transfer domains through the Porkbun website.');
}

/**
 * Renew a domain
 *
 * Note: As of the current API documentation, Porkbun doesn't provide
 * domain renewal through the API. This function returns an error.
 *
 * @param array $params
 * @return array
 */
function porkbun_RenewDomain($params)
{
    return array('error' => 'Domain renewal is not available through the Porkbun API. Please renew domains through the Porkbun website.');
}

/**
 * Get registrar lock status
 *
 * Note: Porkbun API doesn't provide registrar lock functionality.
 *
 * @param array $params
 * @return string
 */
function porkbun_GetRegistrarLock($params)
{
    // Return locked by default as Porkbun doesn't support this via API
    return 'locked';
}

/**
 * Set registrar lock status
 *
 * Note: Porkbun API doesn't provide registrar lock functionality.
 *
 * @param array $params
 * @return array
 */
function porkbun_SaveRegistrarLock($params)
{
    return array('error' => 'Registrar lock management is not available through the Porkbun API.');
}

/**
 * Get DNS records (if supported)
 *
 * @param array $params
 * @return array
 */
function porkbun_GetDNS($params)
{
    try {
        $api = porkbun_getApi($params);
        $domain = $params['sld'] . '.' . $params['tld'];

        $result = $api->getDnsRecords($domain);
        $hostRecords = array();

        if (isset($result['records']) && is_array($result['records'])) {
            foreach ($result['records'] as $record) {
                $hostRecords[] = array(
                    'hostname' => $record['name'],
                    'type' => $record['type'],
                    'address' => $record['content'],
                    'priority' => isset($record['prio']) ? $record['prio'] : '',
                    'ttl' => isset($record['ttl']) ? $record['ttl'] : '',
                );
            }
        }

        return $hostRecords;

    } catch (Exception $e) {
        logModuleCall(
            'porkbun',
            'GetDNS',
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );
        return array('error' => $e->getMessage());
    }
}

/**
 * Save DNS records
 *
 * @param array $params
 * @return array
 */
function porkbun_SaveDNS($params)
{
    try {
        $api = porkbun_getApi($params);
        $domain = $params['sld'] . '.' . $params['tld'];

        // Note: Full DNS record management would require more complex logic
        // to handle creating, updating, and deleting records
        // This is a simplified implementation

        return array('error' => 'DNS record management requires manual implementation through Porkbun interface or custom integration.');

    } catch (Exception $e) {
        logModuleCall(
            'porkbun',
            'SaveDNS',
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );
        return array('error' => $e->getMessage());
    }
}

/**
 * Test API connection
 *
 * @param array $params
 * @return array
 */
function porkbun_TestConnection($params)
{
    try {
        $api = porkbun_getApi($params);
        $result = $api->ping();

        if (isset($result['status']) && $result['status'] === 'SUCCESS') {
            return array(
                'success' => true,
                'message' => 'Connection successful! Your IP: ' . (isset($result['yourIp']) ? $result['yourIp'] : 'Unknown'),
            );
        }

        return array('error' => 'Connection failed');

    } catch (Exception $e) {
        return array('error' => $e->getMessage());
    }
}
