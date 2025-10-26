<?php

/**
 * PorkbunApi - API Helper Class for Porkbun Domain Registrar
 */
if (!class_exists('PorkbunApi')) {
    class PorkbunApi
    {
        private $apiKey;
        private $secretApiKey;
        private $apiUrl = "https://api.porkbun.com/api/json/v3/";

        /**
         * Constructor
         *
         * @param string $apiKey API Key
         * @param string $secretApiKey Secret API Key
         */
        public function __construct($apiKey, $secretApiKey)
        {
            $this->apiKey = $apiKey;
            $this->secretApiKey = $secretApiKey;
        }

        /**
         * Make an API request
         *
         * @param string $endpoint API endpoint (e.g., "ping", "domain/create")
         * @param array $params Additional parameters
         * @return array Response data
         * @throws PorkbunApiException
         */
        public function request($endpoint, $params = array())
        {
            $url = $this->apiUrl . $endpoint;

            // Add authentication credentials to all requests
            $postData = array_merge(
                array(
                    'apikey' => $this->apiKey,
                    'secretapikey' => $this->secretApiKey
                ),
                $params
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json'
            ));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error) {
                throw new PorkbunApiException("CURL Error: " . $error);
            }

            if (empty($response)) {
                throw new PorkbunApiException("Empty response from API");
            }

            $result = json_decode($response, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                // Include the raw response in the error for debugging
                $preview = substr($response, 0, 500);
                throw new PorkbunApiException(
                    "Invalid JSON response: " . json_last_error_msg() .
                    "\nHTTP Code: " . $httpCode .
                    "\nRaw response preview: " . $preview
                );
            }

            // Check for API errors
            if ($httpCode !== 200) {
                $message = isset($result['message']) ? $result['message'] : "HTTP Error: " . $httpCode;
                throw new PorkbunApiException($message, $httpCode);
            }

            if (isset($result['status']) && $result['status'] === 'ERROR') {
                $message = isset($result['message']) ? $result['message'] : "Unknown API error";
                throw new PorkbunApiException($message);
            }

            return $result;
        }

        /**
         * Test API connectivity and authentication
         *
         * @return array Response with IP address
         */
        public function ping()
        {
            return $this->request('ping');
        }

        /**
         * Get pricing information
         *
         * @return array Pricing data
         */
        public function getPricing()
        {
            return $this->request('pricing/get');
        }

        /**
         * List all domains in account
         *
         * @return array List of domains
         */
        public function listDomains()
        {
            return $this->request('domain/listAll');
        }

        /**
         * Get nameservers for a domain
         *
         * @param string $domain Domain name
         * @return array Nameserver data
         */
        public function getNameservers($domain)
        {
            return $this->request('domain/getNs/' . $domain);
        }

        /**
         * Update nameservers for a domain
         *
         * @param string $domain Domain name
         * @param array $nameservers Array of nameserver hostnames
         * @return array Response data
         */
        public function updateNameservers($domain, $nameservers)
        {
            return $this->request('domain/updateNs/' . $domain, array(
                'ns' => array_values(array_filter($nameservers))
            ));
        }

        /**
         * Get DNS records for a domain
         *
         * @param string $domain Domain name
         * @return array DNS records
         */
        public function getDnsRecords($domain)
        {
            return $this->request('dns/retrieve/' . $domain);
        }

        /**
         * Create a DNS record
         *
         * @param string $domain Domain name
         * @param array $record Record data (type, name, content, ttl, prio)
         * @return array Response data
         */
        public function createDnsRecord($domain, $record)
        {
            return $this->request('dns/create/' . $domain, $record);
        }

        /**
         * Delete a DNS record
         *
         * @param string $domain Domain name
         * @param string $recordId Record ID
         * @return array Response data
         */
        public function deleteDnsRecord($domain, $recordId)
        {
            return $this->request('dns/delete/' . $domain . '/' . $recordId);
        }

        /**
         * Get domain information
         *
         * @param string $domain Domain name
         * @return array Domain information
         */
        public function getDomainInfo($domain)
        {
            // Note: Porkbun doesn't have a direct "get domain info" endpoint
            // We'll use listAll and filter
            $result = $this->listDomains();

            if (isset($result['domains']) && is_array($result['domains'])) {
                foreach ($result['domains'] as $domainData) {
                    if (isset($domainData['domain']) && $domainData['domain'] === $domain) {
                        return $domainData;
                    }
                }
            }

            throw new PorkbunApiException("Domain not found: " . $domain);
        }
    }
}

/**
 * PorkbunApiException - Custom exception for API errors
 */
if (!class_exists('PorkbunApiException')) {
    class PorkbunApiException extends Exception
    {
        public function __construct($message, $code = 0)
        {
            parent::__construct($message, $code);
        }
    }
}
