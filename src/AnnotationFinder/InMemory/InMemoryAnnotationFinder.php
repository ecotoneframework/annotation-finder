<?php
declare(strict_types=1);

namespace Ecotone\AnnotationFinder\InMemory;

use Doctrine\Common\Annotations\AnnotationReader;
use Ecotone\AnnotationFinder\AnnotatedDefinition;
use Ecotone\AnnotationFinder\AnnotationFinder;
use Ecotone\AnnotationFinder\AnnotationResolver\AttributeResolver;
use Ecotone\AnnotationFinder\AnnotationResolver\CombinedResolver;
use Ecotone\AnnotationFinder\AnnotationResolver\DoctrineAnnotationResolver;
use Ecotone\AnnotationFinder\TypeResolver;

class InMemoryAnnotationFinder implements AnnotationFinder
{
    private const CLASS_ANNOTATIONS = "classAnnotations";
    private const CLASS_PROPERTIES = "classProperties";

    private array $annotationsForClass;

    private function __construct()
    {
        $this->annotationsForClass[self::CLASS_ANNOTATIONS] = [];
    }
    
    public static function createEmpty(): self
    {
        return new self();
    }

    public static function createFrom(array $classesWithAnnotationToRegister) : self
    {
        $annotationRegistrationService = self::createEmpty();

        foreach ($classesWithAnnotationToRegister as $classToRegister) {
            $annotationRegistrationService->registerClassWithAnnotations($classToRegister);
        }

        return $annotationRegistrationService;
    }

    public function registerClassWithAnnotations(string $className) : self
    {
        $annotationResolver = new CombinedResolver(new AttributeResolver(), new DoctrineAnnotationResolver());

        $reflectionClass = new \ReflectionClass($className);
        foreach (get_class_methods($className) as $method) {
            $methodOwnerClass = TypeResolver::getMethodOwnerClass($reflectionClass, $method)->getName();
            foreach ($annotationResolver->getAnnotationsForMethod($methodOwnerClass, $method) as $methodAnnotation) {
                $this->addAnnotationToClassMethod($className, $method, $methodAnnotation);
            }
        }

        foreach ($annotationResolver->getAnnotationsForClass($className) as $classAnnotation) {
            $this->addAnnotationToClass($className, $classAnnotation);
        }
        foreach ($reflectionClass->getProperties() as $property) {
            foreach ($annotationResolver->getAnnotationsForProperty($className, $property->getName()) as $annotation) {
                if (!$this->hasRegisteredAnnotationForProperty($reflectionClass->getName(), $property->getName(), $annotation)) {
                    $this->addAnnotationToProperty($reflectionClass->getName(), $property->getName(), $annotation);
                }
            }
        }
        $parentClass = $reflectionClass;
        do {
            foreach ($parentClass->getProperties() as $property) {
                foreach ($annotationResolver->getAnnotationsForProperty($parentClass->getName(), $property->getName()) as $annotation) {
                    if (!$this->hasRegisteredAnnotationForProperty($reflectionClass->getName(), $property->getName(), $annotation)) {
                        $this->addAnnotationToProperty($reflectionClass->getName(), $property->getName(), $annotation);
                    }
                    if (!$this->hasRegisteredAnnotationForProperty($parentClass->getName(), $property->getName(), $annotation)) {
                        $this->addAnnotationToProperty($parentClass->getName(), $property->getName(), $annotation);
                    }
                }
            }
        }while($parentClass = $parentClass->getParentClass());

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getAnnotationsForMethod(string $className, string $methodName): array
    {
        if (!isset($this->annotationsForClass[$className][$methodName])) {
            return [];
        }

        return array_values($this->annotationsForClass[$className][$methodName]);
    }

    /**
     * @inheritDoc
     */
    public function getAnnotationsForClass(string $classNameToFind): array
    {
        if (!isset($this->annotationsForClass[self::CLASS_ANNOTATIONS][$classNameToFind])) {
            return [];
        }

        return array_values($this->annotationsForClass[self::CLASS_ANNOTATIONS][$classNameToFind]);
    }

    /**
     * @inheritDoc
     */
    public function getAnnotationsForProperty(string $className, string $propertyName): array
    {
        if (!isset($this->annotationsForClass[self::CLASS_PROPERTIES][$className][$propertyName])) {
            return [];
        }

        return $this->annotationsForClass[self::CLASS_PROPERTIES][$className][$propertyName];
    }

    /**
     * @inheritDoc
     */
    public function findAnnotatedMethods(string $classAnnotationName, string $methodAnnotationClassName): array
    {
        $classes = $this->getAllClassesWithAnnotation($classAnnotationName);

        $registrations = [];
        foreach ($classes as $class) {
            if (!isset($this->annotationsForClass[$class])) {
                continue;
            }

            foreach ($this->annotationsForClass[$class] as $methodName => $methodAnnotations) {
                foreach ($methodAnnotations as $methodAnnotation) {
                    if (get_class($methodAnnotation) == $methodAnnotationClassName  || $methodAnnotation instanceof $methodAnnotationClassName) {
                        $registrations[] = AnnotatedDefinition::create(
                            $this->annotationsForClass[self::CLASS_ANNOTATIONS][$class][$classAnnotationName],
                            $methodAnnotation,
                            $class,
                            $methodName,
                            $this->getAnnotationsForClass($class),
                            $methodAnnotations
                        );
                    }
                }
            }
        }

        return $registrations;
    }

    private function getAllClassesWithAnnotation(string $annotationClassName): array
    {
        $classes = [];

        foreach ($this->annotationsForClass[self::CLASS_ANNOTATIONS] as $className => $annotations) {
            foreach ($annotations as $annotation) {
                if (get_class($annotation) == $annotationClassName) {
                    $classes[] = $className;
                }
            }
        }

        return $classes;
    }

    /**
     * @inheritDoc
     */
    public function findAnnotatedClasses(string $annotationClassName): array
    {
        $classes = [];

        foreach ($this->annotationsForClass[self::CLASS_ANNOTATIONS] as $className => $annotations) {
            foreach ($annotations as $annotation) {
                if (get_class($annotation) == $annotationClassName) {
                    $classes[] = $className;
                }
            }
        }

        return $classes;
    }

    /**
     * @param string $className
     * @param $classAnnotationObject
     *
     * @return InMemoryAnnotationFinder
     */
    public function addAnnotationToClass(string $className, $classAnnotationObject): self
    {
        $this->annotationsForClass[self::CLASS_ANNOTATIONS][$className][get_class($classAnnotationObject)] = $classAnnotationObject;

        return $this;
    }

    /**
     * @param string $className
     * @param string $property
     * @param $propertyAnnotationObject
     *
     * @return InMemoryAnnotationFinder
     */
    public function addAnnotationToProperty(string $className, string $property, $propertyAnnotationObject) : self
    {
        $this->annotationsForClass[self::CLASS_PROPERTIES][$className][$property][] = $propertyAnnotationObject;

        return $this;
    }

    /**
     * @param string $className
     * @param string $methodName
     * @param $methodAnnotationObject
     *
     * @return InMemoryAnnotationFinder
     */
    public function addAnnotationToClassMethod(string $className, string $methodName, $methodAnnotationObject): self
    {
        $this->annotationsForClass[$className][$methodName][get_class($methodAnnotationObject)] = $methodAnnotationObject;

        return $this;
    }

    private function hasRegisteredAnnotationForProperty(string $className, string $propertyName, $annotation): bool
    {
        foreach ($this->getAnnotationsForProperty($className, $propertyName) as $registeredAnnotation) {
            if ($registeredAnnotation == $annotation) {
                return true;
            }
        }

        return false;
    }
}