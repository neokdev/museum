<?php

namespace tests\AppBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\CoreExtension;
use Symfony\Component\Form\Extension\Validator\Type\FormTypeValidatorExtension;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AbstractTypeTest
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
abstract class AbstractTypeTest extends TypeTestCase
{
    /**
     * Setup unit test
     */
    protected function setUp()
    {
        parent::setUp();

        $validator = $this->createMock(ValidatorInterface::class);
        $validator->method('validate')->will(($this->returnValue(new ConstraintViolationList())));
        $formTypeExtension = new FormTypeValidatorExtension($validator);
        $coreExtension = new CoreExtension();

        $this->factory = Forms::createFormFactoryBuilder()
            ->addExtensions($this->getExtensions())
            ->addExtension($coreExtension)
            ->addTypeExtension($formTypeExtension)
            ->getFormFactory();
    }

    /**
     * Test to submit valid data
     *
     * @return mixed
     */
    abstract public function testSubmitedValidData();
}
