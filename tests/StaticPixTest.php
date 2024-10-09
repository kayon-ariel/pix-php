<?php

use PHPUnit\Framework\TestCase;
use PixPhp\StaticPix;

class StaticPixTest extends TestCase
{
    public function testFormatField()
    {
        $field = StaticPix::formatField("01", "12345");
        $this->assertEquals("010512345", $field);

        $field = StaticPix::formatField("26", "br.gov.bcb.pix");
        $this->assertEquals("2614br.gov.bcb.pix", $field);
    }

    public function testCalculateCRC16()
    {
        $data = "00020126580014br.gov.bcb.pix0136617ef6be-e18e-427f-919b-6e43bae3340052040000530398654041.005802BR5901N6001C6205050116304";
        $crc = StaticPix::calculateCRC16($data);
        $this->assertEquals("2BD6", $crc);
    }

    public function testGeneratePixWithoutDescription()
    {
        $pixCode = StaticPix::generatePix("617ef6be-e18e-427f-919b-6e43bae33400", "ID123", 100.00);
        $this->assertStringContainsString("0014br.gov.bcb.pix0136617ef6be-e18e-427f-919b-6e43bae33400", $pixCode);
        $this->assertStringContainsString("52040000", $pixCode); // Fixed code
        $this->assertStringContainsString("5303986", $pixCode);  // Currency (Real)
        $this->assertStringContainsString("5406100.00", $pixCode); // Amount
        $this->assertStringContainsString("5802BR", $pixCode); // Country
        $this->assertStringContainsString("5901N", $pixCode); // Name
        $this->assertStringContainsString("6001C", $pixCode); // City
        $this->assertStringContainsString("ID123", $pixCode); // Transaction ID

        // Calculates CRC16 for code without part 6304
        $pixCodeWithoutCRC = substr($pixCode, 0, -4); // Remove the CRC part and its size
        $this->assertStringEndsWith("6304" . StaticPix::calculateCRC16($pixCodeWithoutCRC), $pixCode); // CRC16
    }

    public function testGeneratePixWithDescription()
    {
        $pixCode = StaticPix::generatePix("617ef6be-e18e-427f-919b-6e43bae33400", "ID123", 100.00, "Pagamento de teste");
        $this->assertStringContainsString("0014br.gov.bcb.pix0136617ef6be-e18e-427f-919b-6e43bae33400", $pixCode);
        $this->assertStringContainsString("52040000", $pixCode); // Fixed code
        $this->assertStringContainsString("5303986", $pixCode);  // Currency (Real)
        $this->assertStringContainsString("5406100.00", $pixCode); // Amount
        $this->assertStringContainsString("5802BR", $pixCode); // Country
        $this->assertStringContainsString("5901N", $pixCode); // Name
        $this->assertStringContainsString("6001C", $pixCode); // City
        $this->assertStringContainsString("ID123", $pixCode); // Transaction ID
        $this->assertStringContainsString("Pagamento de teste", $pixCode); // Description

        // Calculates CRC16 for code without part 6304
        $pixCodeWithoutCRC = substr($pixCode, 0, -4); // Remove the CRC part and its size
        $this->assertStringEndsWith("6304" . StaticPix::calculateCRC16($pixCodeWithoutCRC), $pixCode); // CRC16
    }

    public function testGeneratePixWithZeroAmount()
    {
        $pixCode = StaticPix::generatePix("617ef6be-e18e-427f-919b-6e43bae33400", "ID123", 0.00);
        $this->assertStringNotContainsString("54", $pixCode); // Amount should not be included for 0.00
    }

    public function testGeneratePixWithCpf()
    {
        $pixKey = '123.456.789-09'; // Example CPF
        $pixCode = StaticPix::generatePix($pixKey, "ID123", 100.00);

        $this->assertStringContainsString("0014br.gov.bcb.pix011112345678909", $pixCode); // Formatted CPF
        $this->assertStringContainsString("5406100.00", $pixCode); // Amount

        // Calculates CRC16 for code without part 6304
        $pixCodeWithoutCRC = substr($pixCode, 0, -4); // Remove the CRC part and its size
        $this->assertStringEndsWith("6304" . StaticPix::calculateCRC16($pixCodeWithoutCRC), $pixCode); // CRC16
    }

    public function testGeneratePixWithCnpj()
    {
        $pixKey = '12.345.678/0001-95'; // Example CNPJ
        $pixCode = StaticPix::generatePix($pixKey, "ID456", 250.50);

        $this->assertStringContainsString("0014br.gov.bcb.pix011412345678000195", $pixCode); // Formatted CNPJ
        $this->assertStringContainsString("5406250.50", $pixCode); // Amount

        // Calculates CRC16 for code without part 6304
        $pixCodeWithoutCRC = substr($pixCode, 0, -4); // Remove the CRC part and its size
        $this->assertStringEndsWith("6304" . StaticPix::calculateCRC16($pixCodeWithoutCRC), $pixCode); // CRC16
    }

    public function testGeneratePixWithEmail()
    {
        $pixKey = 'example@test.com'; // Example Email
        $pixCode = StaticPix::generatePix($pixKey, "ID789", 250.50);

        $this->assertStringContainsString("0014br.gov.bcb.pix0116example@test.com", $pixCode); // Formatted Email
        $this->assertStringContainsString("5406250.50", $pixCode); // Amount

        // Calculates CRC16 for code without part 6304
        $pixCodeWithoutCRC = substr($pixCode, 0, -4); // Remove the CRC part and its size
        $this->assertStringEndsWith("6304" . StaticPix::calculateCRC16($pixCodeWithoutCRC), $pixCode); // CRC16
    }

    public function testGeneratePixWithPhone()
    {
        $pixKey = '+55 11 91234-5678'; // Example Phone
        $pixCode = StaticPix::generatePix($pixKey, "ID789", 250.50);

        $this->assertStringContainsString("0014br.gov.bcb.pix0114+5511912345678", $pixCode); // Formatted Email
        $this->assertStringContainsString("5406250.50", $pixCode); // Amount

        // Calculates CRC16 for code without part 6304
        $pixCodeWithoutCRC = substr($pixCode, 0, -4); // Remove the CRC part and its size
        $this->assertStringEndsWith("6304" . StaticPix::calculateCRC16($pixCodeWithoutCRC), $pixCode); // CRC16
    }
}
