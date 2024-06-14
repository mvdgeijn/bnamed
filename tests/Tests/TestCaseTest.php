<?php

namespace Tests;

use Mvdgeijn\BNamed\BNamed;
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

        dd( $result );
    }
}
