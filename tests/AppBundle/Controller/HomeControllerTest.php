<?php

namespace Tests\AppBundle\Controller;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Nelmio\Alice\Fixtures;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class HomeControllerTest
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class HomeControllerTest extends WebTestCase
{
    /** @var  EntityManager */
    private $em;

    /**
     * Functionnal test for homepage and return a successful request
     */
    public function testIndexAction()
    {
        $client = $this->getClient();

        static::assertTrue($client->getResponse()->isSuccessful());

        $crawler = $client->request('GET', '/');
        static::assertEquals(4, $crawler->filter('form > div')->count());
    }

    /**
     * Functionnal test on home to send contact form
     */
    public function testIndexActionWithSubmitContactForm()
    {
        $client = $this->getClient();

        $crawler = $client->request('GET', '/');

        $form = $crawler->selectButton('submitForm')->form();
        $form['contact[name]'] = 'John';
        $form['contact[email]'] = 'john@doe.com';
        $form['contact[subject]'] = 'Horaires d\'ouverture';
        $form['contact[message]'] = 'Question';

        $crawler = $client->submit($form);

        if ($profile = $client->getProfile()) {
            $swiftMailerProfiler = $profile->getCollector('swiftmailer');

            static::assertEquals(2, $swiftMailerProfiler->getMessageCount());
        }

        static::assertEquals('1', $crawler->filter('.flash-message:contains("Le mail a bien été envoyé")')->count());
    }

    /**
     * @return Client
     */
    private function getClient()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        return $client;
    }

    /**
     * Setup functionnal tests
     */
    public function setUp()
    {
        self::bootKernel();
        $this->em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $schemaTool = new SchemaTool($this->em);
        $metaData = $this->em->getMetadataFactory()->getAllMetadata();

        $schemaTool->dropSchema($metaData);
        $schemaTool->createSchema($metaData);
    }

    /**
     * Return fixtures for each functionnal test
     *
     * @return array
     */
    private function getFixtures()
    {
        return [
            __DIR__.'/../Resources/Fixtures/fixtures.yml',
        ];
    }
}
