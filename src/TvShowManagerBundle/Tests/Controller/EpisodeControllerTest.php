<?php

namespace TvShowManagerBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EpisodeControllerTest extends WebTestCase
{

    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Go to the list view
        $crawler = $client->request('GET', '/episode/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /episode/");

        // Go to the show view
        $crawler = $client->click($crawler->selectLink('show')->link());
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code");
    }


}
