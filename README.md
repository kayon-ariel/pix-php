# PixPhp

A PHP library to generate static PIX codes, facilitating online payments with PIX copy and paste.

![PHP Version](https://img.shields.io/badge/php-%3E%3D8.2-brightgreen) ![License](https://img.shields.io/badge/license-MIT-blue)

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [Accepted Key Types](#accepted-key-types)
- [Example Usage](#example-usage)

## Installation

You can install the library via Composer. Run the following command:

```bash
composer require kayon-ariel/pix-php
```

## Usage

### Step 1: Include the Autoloader

Once installed, include the Composer autoloader in your PHP script:

```php
require 'vendor/autoload.php';
```

### Step 2: Import the Namespace

Import the PixPhp namespace at the beginning of your PHP file:

```php
use PixPhp\StaticPix;
```

### Step 3: Generate a PIX Code

You can generate a PIX code using the generatePix method. Here's a basic example:

```php
// Generate a PIX code
$pixCode = StaticPix::generatePix('your-pix-key', 'Transaction-ID', 100.00, 'Payment description');

// Display the generated PIX code
echo $pixCode;
```

## Accepted Key Types

In the `PixPhp` library, the following types of keys are accepted for generating PIX codes:

1. **CPF (Cadastro de Pessoas Físicas)**
   - **Format:** `123.456.789-09`
   - **Description:** A Brazilian individual taxpayer identification number. The library accepts CPF numbers with or without formatting.

2. **CNPJ (Cadastro Nacional da Pessoa Jurídica)**
   - **Format:** `12.345.678/0001-95`
   - **Description:** A Brazilian business taxpayer identification number. The library accepts CNPJ numbers with or without formatting.

3. **Email**
   - **Format:** `example@test.com`
   - **Description:** A valid email address. The library accepts well-formed email addresses as PIX keys.

4. **Phone**
   - **Format:** `+55 11 91234-5678`
   - **Description:** A Brazilian phone number including the country code. The library accepts phone numbers with various formatting styles, including spaces and dashes, while retaining the `+55` prefix.

5. **Random Key**
   - **Format:** `617ef6be-e18e-427f-919b-6e43bae33400`
   - **Description:** The Pix random key is a 32-character alphanumeric code, randomly generated by the Central Bank to be linked to a single account.

## Example Usage

You can pass any of the accepted key types to the `generatePix` method:

```php
// Using CPF
$pixCodeCpf = StaticPix::generatePix("123.456.789-09", "ID123", 100.00);

// Using CNPJ
$pixCodeCnpj = StaticPix::generatePix("12.345.678/0001-95", "ID456", 250.50);

// Using Email
$pixCodeEmail = StaticPix::generatePix("example@test.com", "ID789", 50.00);

// Using Phone
$pixCodePhone = StaticPix::generatePix("+55 11 91234-5678", "ID101", 75.00);

// Using Random Key
$pixCodeRandom = StaticPix::generatePix("617ef6be-e18e-427f-919b-6e43bae33400", "ID102", 30.00);
```
