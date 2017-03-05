<?php
namespace Tests\AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;
/**
 * Class AbstractEntityTest.
 */
abstract class AbstractEntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Closure
     */
    protected $setEntityIdValue;
    /**
     * @var 'Object entity'
     */
    protected $entityObject;
    /**
     * @var PropertyAccessor
     */
    protected static $accessor;
    public static function setUpBeforeClass()
    {
        self::$accessor = PropertyAccess::createPropertyAccessor();
    }
    protected function setUp()
    {
        $this->entityObject = $this->getEntityInstance();
        // for all entities the "id" property is not writable
        // create a reflection for give him a value
        $reflectionClass = new \ReflectionClass($this->entityObject);
        if ($reflectionClass->hasProperty('id')) {
            $reflectionPropertyId = $reflectionClass->getProperty('id');
            $reflectionPropertyId->setAccessible(true);
            $this->setEntityIdValue = \Closure::bind(
                function ($value) use ($reflectionPropertyId) {
                    $reflectionPropertyId->setValue($this, $value);
                },
                $this->entityObject
            );
        }
    }
    /**
     * @param string        $propertyName
     * @param string        $propertyType
     * @param string|object $propertyValue
     * @param array         $doNotTest
     *
     * @throws \Throwable
     * @throws \TypeError
     *
     * @group test-entities
     * @dataProvider entityPropertyProvider
     */
    public function testGetterAndSetter($propertyName, $propertyType, $propertyValue, array $doNotTest = array())
    {
        // check initial value
        $this->assertEmpty(self::$accessor->getValue($this->entityObject, $propertyName));
        // check initial type of collection
        if ($propertyType == 'collection') {
            $this->assertInstanceOf(ArrayCollection::class, self::$accessor->getValue($this->entityObject, $propertyName));
        }
        // "id" property is not accessible, set his value via reflection
        if ($propertyName == 'id') {
            $f = $this->setEntityIdValue;
            $f($propertyValue);
        } else {
            if (!in_array('set', $doNotTest)) {
                self::$accessor->setValue($this->entityObject, $propertyName, $propertyValue);
            }
        }
        // check after set value
        if (!in_array('set', $doNotTest)) {
            $this->assertEquals(self::$accessor->getValue($this->entityObject, $propertyName), $propertyValue);
        }
        // test the remover by set a different value
        if ($propertyType == 'collection') {
            if (!in_array('set', $doNotTest)) {
                self::$accessor->setValue($this->entityObject, $propertyName, new ArrayCollection());
                $this->assertEquals(self::$accessor->getValue($this->entityObject, $propertyName), new ArrayCollection());
            }
        }
    }
    /**
     * @return array
     */
    abstract public function entityPropertyProvider();
    /**
     * Get instance of entity to test.
     *
     * @return object
     */
    abstract protected function getEntityInstance();
}