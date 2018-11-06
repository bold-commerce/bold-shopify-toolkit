<?php

class HasAttributesTraitTest extends \PHPUnit\Framework\TestCase
{
    /** @var \BoldApps\ShopifyToolkit\Models\Customer */
    private $customerObject;

    protected function setUp()
    {
        $this->customerObject = new \BoldApps\ShopifyToolkit\Models\Customer();
    }

    public function testHasAttribute()
    {
        $firstName = 'cool first name';
        $this->customerObject->setFirstName($firstName);
        $this->assertEquals($firstName, $this->customerObject->first_name);
        $this->assertEquals($firstName, $this->customerObject->firstName);
        $this->assertEquals($this->customerObject->getFirstName(), $this->customerObject->first_name);
        $this->assertEquals($this->customerObject->getFirstName(), $this->customerObject->firstName);
    }

    public function testHasAttributeFails()
    {
        $this->assertNull($this->customerObject->yesnt_exists);
        $this->assertNull($this->customerObject->yesntExists);
    }

    public function testHasMutator()
    {
        $this->assertTrue($this->customerObject->hasGetMutator('first_name'));
        $this->assertTrue($this->customerObject->hasGetMutator('firstName'));
    }

    public function testHasMutatorFails()
    {
        $this->assertFalse($this->customerObject->hasGetMutator('yesnt_exists'));
        $this->assertFalse($this->customerObject->hasGetMutator('yesntExists'));
    }

    public function testIsset()
    {
        $firstName = 'cool first name';
        $this->customerObject->setFirstName($firstName);
        $this->assertTrue(isset($this->customerObject->first_name));
    }

    public function testIssetFails()
    {
        $this->assertFalse(isset($this->customerObject->first_name));
    }
}
