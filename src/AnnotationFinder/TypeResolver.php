<?php

namespace Ecotone\AnnotationFinder;

/**
 * Class TypeResolver
 * @package Ecotone\Messaging\Handler
 * @author Dariusz Gafka <dgafka.mail@gmail.com>
 */
class TypeResolver
{
    private function __construct()
    {
    }

    public static function create(): self
    {
        return new self();
    }

    public static function getMethodOwnerClass(\ReflectionClass $analyzedClass, string $methodName) : \ReflectionClass
    {
        $methodReflection = $analyzedClass->getMethod($methodName);
        $declaringClass = self::getMethodDeclaringClass($analyzedClass, $methodReflection->getName());
        if ($analyzedClass->getName() !== $declaringClass->getName()) {
            return self::getMethodOwnerClass($declaringClass, $methodName);
        }
        if (self::isInheritDocComment($methodReflection->getDocComment())) {
            if ($analyzedClass->getParentClass() && $analyzedClass->getParentClass()->hasMethod($methodReflection->getName())) {
                return self::getMethodOwnerClass($analyzedClass->getParentClass(), $methodName);
            }
            foreach ($analyzedClass->getInterfaceNames() as $interfaceName) {
                if (method_exists($interfaceName, $methodReflection->getName())) {
                    $reflectionClass = new \ReflectionClass($interfaceName);
                    return self::getMethodOwnerClass($reflectionClass, $methodName);
                }
            }
        }
        foreach ($analyzedClass->getTraits() as $trait) {
            if ($trait->hasMethod($methodReflection->getName()) && !self::wasTraitOverwritten($methodReflection, $trait)) {
                return self::getMethodOwnerClass($trait, $methodName);
            }
        }

        return $analyzedClass;
    }

    private static function isInheritDocComment(string $docBlock) : bool
    {
        return preg_match("/@inheritDoc/", $docBlock);
    }

    private static function getMethodDeclaringClass(\ReflectionClass $analyzedClass, string $methodName): \ReflectionClass
    {
        return $analyzedClass->getMethod($methodName)->getDeclaringClass();
    }

    private static function wasTraitOverwritten(\ReflectionMethod $methodReflection, \ReflectionClass $trait): bool
    {
        return $methodReflection->getFileName() !== $trait->getMethod($methodReflection->getName())->getFileName();
    }
}