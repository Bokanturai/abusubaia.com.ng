<?php

namespace App\Helpers;

class signatureHelper
{
    /**
     * Generate the signature
     *
     * @param  array  $data  The request body as an array
     * @param string private_key The RSA private key
     * @return string The base64-encoded signature
     */
    public static function generate_signature(array $data, string $private_key)
    {
        // Create an MD5 hash of the sorted parameters and convert it to uppercase
        $encry_data = strtoupper(md5(self::params_sort($data)));

        // Sign the hashed data using the private key with SHA-1 RSA
        $signature = self::sha1_with_rsa($encry_data, $private_key);

        return $signature;
    }
    

    /**
     * Sorts the given array of data by keys in ascending order and construcs a query string
     *
     * @param  array  $param  The array to be processed
     * @return string The resulting query string.
     */
    public static function params_sort(array $data): string
    {
        // Filter empty string from the array
        $filtered_data = array_filter($data, function ($value) {
            return $value !== '';
        });

        // Sort the array by its keys in ascending order
        ksort($filtered_data);

        // Remove the sign key if it exists
        unset($filtered_data['sign']);

        // Build and return the query string
        return urldecode(http_build_query($filtered_data));
    }

    /**
     * Sign encrypted data using SHA-1 with RSA encryption and a given private key.
     *
     * @param  string  $encry_data  The data to be signed.
     * @param  string  $private_key  The RSA private key.
     * @return string The base64-encoded signature.
     */
    public static function sha1_with_rsa(string $encry_data, string $private_key): string
    {
        // Retrieve the private key resource
        $privateKey = self::validate_rsa_key($private_key, 'private');
        // Sign the data using the private key and SHA-1 algorithm
        openssl_sign($encry_data, $signature, $privateKey, OPENSSL_ALGO_SHA1);

        //encode the signature in base64 and return it
        return base64_encode($signature);
    }

    /**
     * Verifies the callback signature against the provided plain text using the public key.
     *
     * @param  array  $data  Notification payload as an array
     * @param  string  $signature  The signature to be verified.
     * @param  string  $public_key  The RSA public key
     * @return bool Whether the signature is verified (true) or not (false).
     */
    public static function verify_callback_signature(array $data, string $signature, string $public_key)
    {
        // Retrieve the public key resource
        $publicKey = self::validate_rsa_key($public_key, 'public');
        // Calculate the MD5 of the notification payload without the sign field. The param_sort function removes the sign field.
        $md5 = strtoupper(md5(self::params_sort($data)));
        
        $rawSignature = urldecode($signature);
        // If urldecode or prior decoding turned '+' into ' ', convert it back to '+'
        $base64 = str_replace(' ', '+', $rawSignature);
        $decodedSignature = base64_decode($base64);

        // Verify the signature using the public key and SHA-1 algorithm
        $is_verified = openssl_verify($md5, $decodedSignature, $publicKey, OPENSSL_ALGO_SHA1);

        return $is_verified;
    }

    /**
     * Validates and formats an RSA key (private or public) in PEM format.
     *
     * @param  string  $value  The raw RSA key value.
     * @param  string  $key_type  The type of the RSA key ('private' for private key, 'public' for public key).
     * @return resource|false The OpenSSL key resource if the key is valid, or false if the key is invalid.
     */
    public static function validate_rsa_key($value, $key_type)
    {
        // Remove all whitespace (spaces, newlines, tabs) from the raw key string
        $formatted_key = preg_replace('/\s+/', '', $value);

        // Split into 64-character chunks with newline breaks (standard PEM line length)
        $formatted_key = chunk_split($formatted_key, 64, "\n");

        if ($key_type === 'private') {
            // Try PKCS#8 format first ("BEGIN PRIVATE KEY") — used when the raw key
            // base64 decodes to a PKCS#8 DER structure (starts with MIICd, MIIEv, etc.)
            $pkcs8_pem = "-----BEGIN PRIVATE KEY-----\n{$formatted_key}-----END PRIVATE KEY-----\n";
            $key_resource = openssl_pkey_get_private($pkcs8_pem);

            if (!$key_resource) {
                // Fall back to PKCS#1 format ("BEGIN RSA PRIVATE KEY")
                $pkcs1_pem = "-----BEGIN RSA PRIVATE KEY-----\n{$formatted_key}-----END RSA PRIVATE KEY-----\n";
                $key_resource = openssl_pkey_get_private($pkcs1_pem);
            }

            if (!$key_resource) {
                \Illuminate\Support\Facades\Log::error('signatureHelper: Failed to load private key. Check that config/keys.php contains a valid PKCS#8 or PKCS#1 private key.');
            }
        } else {
            $pem_formatted_key = "-----BEGIN PUBLIC KEY-----\n{$formatted_key}-----END PUBLIC KEY-----\n";
            $key_resource = openssl_pkey_get_public($pem_formatted_key);

            if (!$key_resource) {
                \Illuminate\Support\Facades\Log::error('signatureHelper: Failed to load public key. Check that config/keys.php contains a valid public key.');
            }
        }

        return $key_resource;
    }
}
