<?php

namespace Tests\AppBundle\Validator;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Context\ExecutionContext;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilder;

/**
 * Class AbstractValidatorTest
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
abstract class AbstractValidatorTest extends TestCase
{
    /**
     * Configure Validator for unit test
     *
     * @param null $expectedMessage
     *
     * @return ConstraintValidatorInterface
     */
    public function configureValidator($expectedMessage = null)
    {
        $builder = $this->getMockBuilder(ConstraintViolationBuilder::class)
            ->disableOriginalConstructor()
            ->setMethods(
                [
                    'addViolation',
                ]
            )
            ->getMock();

        $context = $this->getMockBuilder(ExecutionContext::class)
            ->disableOriginalConstructor()
            ->setMethods(
                [
                    'buildViolation',
                ]
            )
            ->getMock();

        if ($expectedMessage) {
            $builder->expects($this->once())
                ->method('addViolation');

            $context->expects($this->once())
                ->method('buildViolation')
                ->with($this->equalTo($expectedMessage))
                ->will($this->returnValue($builder));
        } else {
            $context->expects($this->never())
                ->method('buildViolation');
        }

        $validator = $this->getValidator();
        $validator->initialize($context);

        return $validator;
    }

    /**
     * Test Validator on invalid value
     */
    abstract public function testValidateOnInvalid();

    /**
     * Test Validator on valid value
     */
    abstract public function testValidateOnValid();

    /**
     * @return ConstraintValidatorInterface
     */
    abstract public function getValidator();

    /**
     * @return Constraint
     */
    abstract public function getConstraint();
}
