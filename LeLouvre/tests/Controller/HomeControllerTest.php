<?php

namespace Tests\App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{

    public function testHomePageIsUp()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        static::assertEquals(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testInfosPagesIsUp()
    {
        $client = static::createClient();
        $client->request('GET', '/infos');

        static::assertEquals(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testContactPageIsUp()
    {
        $client = static::createClient();
        $client->request('GET', '/contact');

        static::assertEquals(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );
    }
    
}