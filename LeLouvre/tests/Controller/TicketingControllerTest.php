<?php

namespace Tests\App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TicketingControllerTest extends WebTestCase
{
    public function testNew()
    {
        $client = static::createClient();
        $client->request('GET', '/reservation');

        static::assertEquals(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testSummary()
    {
        $client = static::createClient();
        $client->request('GET', '/summary');

        static::assertEquals(
            Response::HTTP_FOUND,
            $client->getResponse()->getStatusCode()
        );
    }       
}