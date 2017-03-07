<?php

namespace Tests\AppBundle\Services;

use AppBundle\Services\MailerService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class MailerServiceTest
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class MailerServiceTest extends WebTestCase
{
    /**
     * Setup unit test
     */
    public function setUp()
    {
        static::bootKernel();
    }

    /**
     * Test if mailer service is found
     */
    public function testIfServiceFound()
    {
        $mailer = static::$kernel->getContainer()->get('app.mailer_service');

        static::assertInstanceOf(MailerService::class, $mailer);
    }
}
