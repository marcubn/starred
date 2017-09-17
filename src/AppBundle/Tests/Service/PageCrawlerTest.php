<?php

namespace AppBundle\Tests\Service;

use AppBundle\Service\PageCrawler;
use PHPUnit\Framework\TestCase;
//use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageCrawlerTest extends TestCase
{
    /**
     * @dataProvider provideConversionScenarios
     * @param $message
     * @param $expectedResult
     */
    public function testGetLinks($message, $expectedResult)
    {
        echo '1235';
        var_dump($message);exit;

        $service = new PageCrawler();
        $something=$service->parseHtml($message);
    }

    public function provideConversionScenarios()
    {
        return '<html>
        ...
        <a href="http://test.inlineweb.ro/1.html">Back</a>
        
        <a href="http://test.inlineweb.ro/877.html">Back</a>
        Please contact the support by this email: support@example.com
        ...
        </html>';
    }
}