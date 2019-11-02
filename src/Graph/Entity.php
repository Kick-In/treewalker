<?php

namespace Kickin\TreeWalker\Graph;

use ReflectionClass;

class Entity
{
	/** @var string */
	private $name;
	/** @var Property[] */
	private $properties = [];

	public function __construct(ReflectionClass $reflectionClass)
	{
		$this->name = $reflectionClass->getName();
		foreach ($reflectionClass->getProperties() as $property) {
			$this->properties[] = new Property($property, $this);
		}
	}

	/**
	 * @return string the name of the entity being modeled
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @param string $propertyName a glob by which property names are removed
	 * @throws GraphBuilderException when no properties were matched
	 */
	public function removeProperty(string $propertyName)
	{
		$preCount = $this->countProperties();

		foreach ($this->properties as $idx => $property) {
			if (fnmatch($propertyName, $property->getName())) {
				array_splice($this->properties, $idx, 1);
			}
		}

		//If no properties were removed, warn the developer about that.
		//As the internal state has not changed, we do not need to revert anything
		if ($this->countProperties() == $preCount) {
			throw new GraphBuilderException("No properties matching '$propertyName' could be found");
		}
	}

	/**
	 * @return int the amount of properties of this entity
	 */
	public function countProperties()
	{
		return count($this->properties);
	}
}
