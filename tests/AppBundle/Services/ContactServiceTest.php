<?php

namespace Tests\AppBundle\Services;

use AppBundle\Services\ContactService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class ContactServiceTest
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class ContactServiceTest extends WebTestCase
{
    /**
     * Setup unit test
     */
    public function setUp()
    {
        static::bootKernel();
    }

    /**
     * Unit test to check if contact service is found
     */
    public function testIfServiceIsFound()
    {
        $contactSrv = static::$kernel->getContainer()->get('app.contact_service');

        static::assertInstanceOf(ContactService::class, $contactSrv);
    }
}
