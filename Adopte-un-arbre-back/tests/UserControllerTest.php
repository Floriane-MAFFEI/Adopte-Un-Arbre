<?php

namespace App\Tests\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testLogout()
    {
        $client = static::createClient();
        $client->request('GET', '/api/logout');

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }
}