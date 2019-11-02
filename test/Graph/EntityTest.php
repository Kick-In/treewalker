<?php

namespace Test\Graph;

use Exception;
use Kickin\TreeWalker\Graph\Entity;
use Kickin\TreeWalker\Graph\GraphBuilderException;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Test\TestUtil;

class EntityTest extends TestCase
{
	private $entity;

	public function setUp(): void
	{
		$this->entity = new Entity(new ReflectionClass(EntityMock::class));
	}

	public function testRemoveSingularProperty()
	{
		$this->assertEquals(3, $this->entity->countProperties());
		$this->entity->removeProperty("fieldA");
		$this->assertEquals(2, $this->entity->countProperties());
	}

	public function testRemoveGlobedProperties()
	{
		$this->assertEquals(3, $this->entity->countProperties());
		$this->entity->removeProperty("field*");
		$this->assertEquals(1, $this->entity->countProperties());
	}

	public function testRemoveUnknownProperty()
	{
		TestUtil::assertThrows(function () {
			$this->entity->removeProperty("nonExistent");
		}, function (Exception $exception) {
			$this->assertInstanceOf(GraphBuilderException::class, $exception);
			$this->assertStringContainsString('nonExistent',$exception->getMessage());
		});
	}
}
