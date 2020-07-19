<?php


namespace Ecotone\AnnotationFinder\AnnotationResolver;


use Doctrine\Common\Annotations\AnnotationReader;
use Ecotone\AnnotationFinder\AnnotationResolver;
use Ecotone\AnnotationFinder\ConfigurationException;
use Ecotone\AnnotationFinder\TypeResolver;

class DoctrineAnnotationResolver implements AnnotationResolver
{
    private AnnotationReader $annotationReader;

    public function __construct()
    {
        $this->annotationReader = new AnnotationReader();

        if (!class_exists(AnnotationReader::class)) {
            throw new \InvalidArgumentException("Can not use of Doctrine Annotation Resolver, as there is no " . AnnotationReader::class . " class available.");
        }
    }

    /**
     * @inheritDoc
     */
    public function getAnnotationsForMethod(string $className, string $methodName): array
    {
        try {
            $reflectionMethod = TypeResolver::getMethodOwnerClass(new \ReflectionClass($className), $methodName)->getMethod($methodName);

            $annotations = $this->annotationReader->getMethodAnnotations($reflectionMethod);
        } catch (\ReflectionException $e) {
            throw ConfigurationException::create("Class {$className} with method {$methodName} does not exists or got annotation configured wrong: " . $e->getMessage());
        }

        return $annotations;
    }

    /**
     * @inheritDoc
     */
    public function getAnnotationsForClass(string $className): array
    {
        $reflectionClass  = new \ReflectionClass($className);

        return $this->annotationReader->getClassAnnotations($reflectionClass);
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

                return $this->annotationReader->getPropertyAnnotations($property);
            }
        }while($parentClass = $parentClass->getParentClass());

        ConfigurationException::create("Can't resolve property {$propertyName} for class {$className}");
    }
}