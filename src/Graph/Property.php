<?php

namespace Kickin\TreeWalker\Graph;


use ReflectionProperty;

class Property
{
	/** @var string */
	private $name;
	/** @var Entity */
	private $class;

	public function __construct(ReflectionProperty $reflectionProperty, Entity $class)
	{
		$this->name = $reflectionProperty->getName();
		$this->class = $class;
	}

	/**
	 * @return string the name of the entity-property being modeled
	 */
	public function getName(): string
	{
		return $this->name;
	}
}
