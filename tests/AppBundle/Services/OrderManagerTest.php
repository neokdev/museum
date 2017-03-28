<?php

namespace Tests\AppBundle\Services;

use AppBundle\Services\OrderManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class OrderManagerTest
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class OrderManagerTest extends WebTestCase
{
    /**
     * Test if service is found in the container
     */
    public function testIfServiceIsFound()
    {
        $orderManager = static::$kernel->getContainer()->get('app.order_manager');

        self::assertInstanceOf(OrderManager::class, $orderManager);
    }

    /**
     * Setup unit test
     */
    public function setUp()
    {
        static::bootKernel();
    }
}
