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
        $data = "00020126330014br.gov.bcb.pix0111chave-teste5204000053039865406100.005802BR5901N6001C62090505ID1236304";
        $crc = StaticPix::calculateCRC16($data);
        $this->assertEquals("9F03", $crc);
    }

    public function testGeneratePixWithoutDescription()
    {
        $pixCode = StaticPix::generatePix("chave-teste", "ID123", 100.00);
        $this->assertStringContainsString("0014br.gov.bcb.pix0111chave-teste", $pixCode);
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
        $pixCode = StaticPix::generatePix("chave-teste", "ID123", 100.00, "Pagamento de teste");
        $this->assertStringContainsString("0014br.gov.bcb.pix0111chave-teste", $pixCode);
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
        $pixCode = StaticPix::generatePix("chave-teste", "ID123", 0.00);
        $this->assertStringNotContainsString("54", $pixCode); // Amount should not be included for 0.00
    }
}
