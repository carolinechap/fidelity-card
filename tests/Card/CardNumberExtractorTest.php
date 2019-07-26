<?php


namespace App\Card\Tests;

use App\Card\CardNumberExtractor;
use PHPUnit\Framework\TestCase;

class CardNumberExtractorTest extends TestCase
{
    /**
     * @test
     */
    public function evaluateNumberWithDash()
    {
        $valueToEvaluateWithDash = '123-456789-0';

        $cardNumberExtractor = new CardNumberExtractor();
        $result = $cardNumberExtractor->evaluate($valueToEvaluateWithDash);

        $this->assertEquals('123', $result['code_centre']);
        $this->assertEquals('456789', $result['code_carte']);
        $this->assertEquals('0', $result['checksum']);

    }

    /**
     * @test
     */
    public function evaluateNumberWithoutDash()
    {
        $valueToEvaluateWithoutDash = 1234567890;

        $cardNumberExtractor = new CardNumberExtractor();
        $result = $cardNumberExtractor->evaluate($valueToEvaluateWithoutDash);

        $this->assertEquals(123, $result['code_centre']);
        $this->assertEquals(456789, $result['code_carte']);
        $this->assertEquals(0, $result['checksum']);

    }

}