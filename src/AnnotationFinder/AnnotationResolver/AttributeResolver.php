<?php

namespace Ecotone\AnnotationFinder\AnnotationResolver;

use Ecotone\AnnotationFinder\AnnotationResolver;
use Ecotone\AnnotationFinder\ConfigurationException;
use Ecotone\AnnotationFinder\TypeResolver;

class AttributeResolver implements AnnotationResolver
{
    public function __construct()
    {
        if (PHP_MAJOR_VERSION < 8) {
            throw new \InvalidArgumentException("Can't use of PHP Native Attribute Resolver, as PHP version is lower than 8.");
        }
    }

    /**
     * @inheritDoc
     */
    public function getAnnotationsForMethod(string $className, string $methodName): array
    {
        try {
            $reflectionMethod = TypeResolver::getMethodOwnerClass(new \ReflectionClass($className), $methodName)->getMethod($methodName);

            return array_map(function(\ReflectionAttribute $attribute){
                return $attribute->newInstance();
            }, $reflectionMethod->getAttributes());
        } catch (\ReflectionException $e) {
            throw ConfigurationException::create("Class {$className} with method {$methodName} does not exists or got annotation configured wrong: " . $e->getMessage());
        }
    }

    /**
     * @inheritDoc
     */
    public function getAnnotationsForClass(string $className): array
    {
        return array_map(function(\ReflectionAttribute $attribute){
            return $attribute->newInstance();
        }, (new \ReflectionClass($className))->getAttributes());;
    }

    /**
     * @inheritDoc
     */
    public function getAnnotationsForProperty(string $className, string $propertyName): array
    {
        $reflectionClass = new \ReflectionClass($className);
        $parentClass = $reflectionClass;

        do {
            foreach ($parentClass->getProperties() as $property) {
                if ($property->getName() !== $propertyName) {
                    continue;
                }

                $attributes = (new \ReflectionProperty($className, $propertyName))->getAttributes();

                return array_map(function(\ReflectionAttribute $attribute){
                    return $attribute->newInstance();
                }, $attributes);
            }
        }while($parentClass = $parentClass->getParentClass());

        ConfigurationException::create("Can't resolve property {$propertyName} for class {$className}");
    }
}