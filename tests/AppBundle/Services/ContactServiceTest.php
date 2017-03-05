<?php

namespace Tests\AppBundle\Services;

use AppBundle\Services\ContactService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class ContactServiceTest
 */
class ContactServiceTest extends KernelTestCase
{
    /** {@inheritdoc} */
    public function setUp()
    {
        static::bootKernel();
    }

    /**
     * Tests if contact service is found
     */
    public function testIfServiceFound()
    {
        $contact = static::$kernel->getContainer()->get('app.contact_service');

        static::assertInstanceOf(ContactService::class, $contact);
    }
}
