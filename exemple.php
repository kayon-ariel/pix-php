<?php

require 'vendor/autoload.php';

use PixPhp\StaticPix;

// Exemplo de uso da biblioteca PixPhp
$pixKey = '13.366.069/0001-85'; // Substitua pela sua chave PIX
$transactionId = 1234; // ID da transação opcional
$amount = 0.01; // Valor a ser pago
$description = 'Teste'; // Descrição opcional

// Gerar o código PIX
$pixCode = StaticPix::generatePix($pixKey, $transactionId, $amount, $description);

// Exibir o código PIX
echo "Generated PIX Code: " . $pixCode . "\n";