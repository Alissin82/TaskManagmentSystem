<?php

namespace App\Traits;

use ReflectionClass;

trait DtoToArrayTrait
{
    /**
     * Convert the object's properties to an associative array.
     *
     * @return array
     */
    public function toArray(): array
    {
        $properties = [];
        $reflection = new ReflectionClass($this);

        foreach ($reflection->getProperties() as $property) {
            $properties[$property->getName()] = $property->getValue($this);
        }

        return $properties;
    }
}
