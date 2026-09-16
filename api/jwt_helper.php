<?php
/**
 * JWT Helper minimalista y seguro (HMAC-SHA256)
 * No requiere Composer ni dependencias externas.
 * 
 * Autor: Ing. Daniel Méndez Amutari
 */

class SimpleJWT {
    private static $secret = 'joker_billar_ribersoft_secret_key_2026_x99';

    public static function encode($payload) {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $base64UrlHeader = self::base64UrlEncode($header);
        $base64UrlPayload = self::base64UrlEncode(json_encode($payload));
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, self::$secret, true);
        $base64UrlSignature = self::base64UrlEncode($signature);
        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

    public static function decode($jwt) {
        if (empty($jwt)) return null;
        $tokenParts = explode('.', $jwt);
        if (count($tokenParts) != 3) return null;

        $header = base64_decode(self::base64UrlDecode($tokenParts[0]));
        $payload = base64_decode(self::base64UrlDecode($tokenParts[1]));
        $signatureProvided = $tokenParts[2];

        // Verificar firma
        $base64UrlHeader = self::base64UrlEncode($header);
        $base64UrlPayload = self::base64UrlEncode($payload);
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, self::$secret, true);
        $base64UrlSignature = self::base64UrlEncode($signature);

        if ($base64UrlSignature !== $signatureProvided) {
            return null; // Firma inválida
        }

        return json_decode($payload, true);
    }

    public static function getBearerToken() {
        $debug = [
            'time' => date('Y-m-d H:i:s'),
            'REMOTE_ADDR' => $_SERVER['REMOTE_ADDR'] ?? '',
            'HTTP_AUTHORIZATION' => $_SERVER['HTTP_AUTHORIZATION'] ?? null,
            'REDIRECT_HTTP_AUTHORIZATION' => $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? null,
            'Authorization' => $_SERVER['Authorization'] ?? null,
            'apache_headers' => function_exists('apache_request_headers') ? apache_request_headers() : null,
            'all_headers' => getallheaders(),
            'GET' => $_GET,
        ];
        @file_put_contents(__DIR__ . '/../../scratch/auth_debug.log', json_encode($debug, JSON_PRETTY_PRINT) . "\n---\n", FILE_APPEND);

        $headers = '';
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $headers = trim($_SERVER['HTTP_AUTHORIZATION']);
        } elseif (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
            $headers = trim($_SERVER['REDIRECT_HTTP_AUTHORIZATION']);
        } elseif (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER['Authorization']);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            foreach ($requestHeaders as $key => $value) {
                if (strtolower($key) === 'authorization') {
                    $headers = trim($value);
                    break;
                }
            }
        }
        if (empty($headers) && isset($_SERVER['HTTP_X_AUTHORIZATION'])) {
            $headers = trim($_SERVER['HTTP_X_AUTHORIZATION']);
        }
        if (empty($headers) && isset($_SERVER['HTTP_X_TOKEN'])) {
            return trim($_SERVER['HTTP_X_TOKEN']);
        }
        if (empty($headers) && !empty($_GET['token'])) {
            return trim($_GET['token']);
        }

        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/i', $headers, $matches)) {
                return $matches[1];
            }
            // In case token was sent without "Bearer "
            if (strpos($headers, '.') !== false) {
                return $headers;
            }
        }
        return null;
    }

    private static function base64UrlEncode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private static function base64UrlDecode($data) {
        return str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT);
    }
}
