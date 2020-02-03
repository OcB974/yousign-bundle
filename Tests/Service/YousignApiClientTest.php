<?php

namespace Neyric\YousignBundle\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Response;

class YousignApiClientTest extends KernelTestCase
{
    public function testYousignApiClientService()
    {
        self::bootKernel();
        $container = self::$container;

        $yousignService = $container->get('neyric_yousign.service');

        $this->assertNotNull($yousignService);
    }
}
