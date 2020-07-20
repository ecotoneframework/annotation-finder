<?php

namespace Ecotone\AnnotationFinder;

class AnnotatedMethod
{
    private string $className;
    private string $methodName;
    private object $annotationForMethod;
    /**
     * @var object[]
     */
    private array $methodAnnotations;
    /**
     * @var object[]
     */
    private array $classAnnotations;

    private function __construct(object $annotationForMethod, string $className, string $methodName, array $classAnnotations, array $methodAnnotations)
    {
        $this->annotationForMethod = $annotationForMethod;
        $this->className = $className;
        $this->methodName = $methodName;
        $this->methodAnnotations = $methodAnnotations;
        $this->classAnnotations = $classAnnotations;
    }

    /**
     * @param object[] $classAnnotations
     * @param object[] $methodAnnotations
     */
    public static function create(object $annotationForMethod, string $className, string $methodName, array $classAnnotations, array $methodAnnotations) : self
    {
        return new self($annotationForMethod, $className, $methodName, $classAnnotations, $methodAnnotations);
    }

    public function getAnnotationForMethod() : object
    {
        return $this->annotationForMethod;
    }

    public function getClassName(): string
    {
        return $this->className;
    }

    public function getMethodName(): string
    {
        return $this->methodName;
    }

    /**
     * @return object[]
     */
    public function getMethodAnnotations(): array
    {
        return $this->methodAnnotations;
    }

    public function hasMethodAnnotation(string $type) : bool
    {
        foreach ($this->methodAnnotations as $methodAnnotation) {
            if (get_class($methodAnnotation) === $type) {
                return true;
            }
        }

        return false;
    }

    public function hasClassAnnotation(string $type) : bool
    {
        foreach ($this->classAnnotations as $classAnnotation) {
            if (get_class($classAnnotation) === $type) {
                return true;
            }
        }

        return false;
    }

    public function __toString()
    {
        return $this->className . "::" . $this->methodName . "::" . get_class($this->annotationForMethod);
    }
}