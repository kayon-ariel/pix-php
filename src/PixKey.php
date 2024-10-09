<?php

namespace PixPhp;

class PixKey
{
    public static function validateKey($key)
    {
        // Trim spaces and special characters
        $key = trim($key);

        // Check if the key is a CPF
        if (preg_match('/^\d{3}\.\d{3}\.\d{3}-\d{2}$/', $key)) {
            return 'CPF';
        }

        // Check if the key is a CNPJ
        if (preg_match('/^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/', $key)) {
            return 'CNPJ';
        }

        // Check if the key is an email
        if (filter_var($key, FILTER_VALIDATE_EMAIL)) {
            return 'EMAIL';
        }

        // Check if the key is a phone number
        if (preg_match('/^\+55 \d{2} \d{5}-\d{4}$/', $key)) {
            return 'PHONE';
        }

        // Check if the key is a random key
        if (preg_match('/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i', $key)) {
            return 'RANDOM';
        }

        // If the key does not match any known format
        throw new \InvalidArgumentException('Invalid PIX key.');
    }

    public static function formatKey($key)
    {
        $type = self::validateKey($key);

        // Format the key according to its type
        switch ($type) {
            case 'CPF':
                return preg_replace('/[^\d]/', '', $key);
            case 'CNPJ':
                return preg_replace('/[^\d]/', '', $key);
            case 'EMAIL':
                return strtolower(trim($key));
            case 'PHONE':
                return preg_replace('/[^+\d]/', '', $key);
            case 'RANDOM':
                return trim($key);
            default:
                throw new \InvalidArgumentException('Invalid PIX key.');
        }
    }
}
