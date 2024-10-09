<?php

use PHPUnit\Framework\TestCase;
use PixPhp\PixKey;

class PixKeyTest extends TestCase
{
    public function testValidCpf()
    {
        $cpf = '123.456.789-09';
        $this->assertEquals('CPF', PixKey::validateKey($cpf));
        $this->assertEquals('12345678909', PixKey::formatKey($cpf));
    }

    public function testValidCnpj()
    {
        $cnpj = '12.345.678/0001-95';
        $this->assertEquals('CNPJ', PixKey::validateKey($cnpj));
        $this->assertEquals('12345678000195', PixKey::formatKey($cnpj));
    }

    public function testValidEmail()
    {
        $email = 'example@test.com';
        $this->assertEquals('EMAIL', PixKey::validateKey($email));
        $this->assertEquals('example@test.com', PixKey::formatKey($email));
    }

    public function testValidPhone()
    {
        $phone = '+55 11 91234-5678';
        $this->assertEquals('PHONE', PixKey::validateKey($phone));
        $this->assertEquals('+5511912345678', PixKey::formatKey($phone));
    }

    public function testInvalidKey()
    {
        $this->expectException(InvalidArgumentException::class);
        $invalidKey = 'invalid_key';
        PixKey::validateKey($invalidKey);
    }
}
