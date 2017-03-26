<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;

/**
 * Class LoadUserData
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class LoadUserData implements FixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        Fixtures::load(
            [
                __DIR__.'/../../../../app/Resources/Fixtures/prod/fixtures.yml',
            ],
            $manager
        );
    }
}
