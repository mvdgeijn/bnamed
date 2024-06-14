<?php

namespace Tests;

use Mvdgeijn\BNamed\BNamed;
use Mvdgeijn\BNamed\Responses\CheckResponse;
use PHPUnit\Framework\TestCase;

include('../test.php');

class TestCaseTest extends TestCase
{
    public function init(): BNamed
    {
        return new BNamed(
            BNAMED_API_URL,
            BNAMED_USERNAME,
            BNAMED_PASSWORD,
        );
    }

    public function testCheckDomain()
    {
        $bNamed = $this->init();

        $result = $bNamed->check(['yahoo.com','yahoo-5391342341.com','1.com']);

        $this->assertTrue( count( $result->data ) == 3, 'Number of results is not 3' );

        $this->assertTrue( isset( $result->data['yahoo.com'] ) === true, 'Result for yahoo.com not in result data');
        $this->assertTrue( $result->data['yahoo.com']['sld'] === "yahoo", 'sld does not contain yahoo' );
        $this->assertTrue( $result->data['yahoo.com']['tld'] === "com", 'tld does not contain com' );
        $this->assertTrue( $result->data['yahoo.com']['code'] == CheckResponse::REGISTERED, 'status is not registered' );

        $this->assertTrue( isset( $result->data['yahoo-5391342341.com'] ) === true, 'Result for yahoo-5391342341.com not in result data' );
        $this->assertTrue( $result->data['yahoo-5391342341.com']['sld'] === "yahoo-5391342341", 'sld does not contain yahoo-5391342341' );
        $this->assertTrue( $result->data['yahoo-5391342341.com']['tld'] === "com", 'tld does not contain com' );
        $this->assertTrue( $result->data['yahoo-5391342341.com']['code'] == CheckResponse::UNREGISTERED, 'status is not unregistered' );

        $this->assertTrue( isset( $result->data['1.com'] ) );
    }
}
