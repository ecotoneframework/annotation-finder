<?php

namespace Ecotone\AnnotationFinder;

interface AnnotationFinder extends AnnotationResolver
{
    /**
     * @return AnnotatedDefinition[]
     */
    public function findAnnotatedMethods(string $classAnnotationName, string $methodAnnotationClassName) : array;

    /**
     * @return string[]
     */
    public function findAnnotatedClasses(string $annotationClassName): array;
}