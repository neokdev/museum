<?php

namespace Tests\AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Nelmio\Alice\Fixtures;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class HomeControllerTest
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class HomeControllerTest extends WebTestCase
{
    /** @var  EntityManager */
    private $em;

    /** @var  Session */
    private $session;

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
        $profile = $client->getProfile();

        if ($profile) {
            $swiftMailerProfiler = $profile->getCollector('swiftmailer');

            static::assertEquals(2, $swiftMailerProfiler->getMessageCount());
        }

        static::assertEquals('1', $crawler->filter('.flash-message:contains("Le mail a bien été envoyé")')->count());
    }

    /**
     * Functionnal test to check if access order page is ok
     * Must display two forms
     */
    public function testAccessOrderPage()
    {
        $client = $this->getClient();
        static::assertTrue($client->getResponse()->isSuccessful());

        $crawler = $client->request('GET', 'order');
        static::assertTrue($client->getResponse()->isSuccessful(), 'Response should be successful');
        static::assertEquals(2, $crawler->filter('form')->count());
    }

    /**
     * Funtionnal test to recovery order by mail
     */
    public function testRecoveryTicketsIfExist()
    {
        Fixtures::load($this->getFixtures(), $this->em);

        $client = $this->getClient();
        static::assertTrue($client->getResponse()->isSuccessful());

        $crawler = $client->request('GET', 'order');
        static::assertTrue($client->getResponse()->isSuccessful(), 'Response should be successful');
        static::assertEquals(2, $crawler->filter('form')->count());

        $form = $crawler->selectButton('submit_search')->form();
        $form['search_order[email]'] = 'john@doe.com';

        $client->submit($form);

        $profiler = $client->getProfile();
        if ($profiler) {
            $swiftMailerProfiler = $profiler->getCollector('swiftmailer');

            static::assertEquals(1, $swiftMailerProfiler->getMessageCount());
        }
    }

    /**
     * Functionnal test to check if submit order form is ok without error
     */
    public function testSubmitOrderFormWithoutError()
    {
        $client = $this->getClient();
        static::assertTrue($client->getResponse()->isSuccessful());

        $crawler = $client->request('GET', 'order');
        static::assertTrue($client->getResponse()->isSuccessful(), 'Response should be successful');
        static::assertEquals(2, $crawler->filter('form')->count());
        //TODO ecrire test pour le submit du form order et vérifier la redirection.
        $form = $crawler->selectButton('submit_order')->form();
        $form['order[email]'] = 'jane@doe.com';
        $form['order[dateVisit]'] = '2070-01-01';
        $form['order[typeTicket]']->select(0);
        $form['order[numberTickets]']->select('1');

//        $this->session->set('order', $form);

        $crawler = $client->submit($form);
        static::assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * Setup functionnal tests
     */
    public function setUp()
    {
        self::bootKernel();
        $this->em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->session = static::$kernel->getContainer()->get('session');
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

    /**
     * @return Client
     */
    private function getClient()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        return $client;
    }
}
