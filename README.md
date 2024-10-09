# PixPhp

A PHP library for generating QR codes for PIX payments, including optional transaction descriptions.

![PHP Version](https://img.shields.io/badge/php-%3E%3D8.2-brightgreen) ![License](https://img.shields.io/badge/license-MIT-blue)

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [Methods](#methods)
  - [StaticPix::generatePix](#staticpixgeneratepixkey-idtx--amount-000-description--)
  - [StaticPix::formatField](#staticpixformatfieldid-value)
  - [StaticPix::calculateCRC16](#staticpixcalculatecrc16data)

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

