<?php


namespace Ecotone\AnnotationFinder\AnnotationResolver;


use Ecotone\AnnotationFinder\AnnotationResolver;

class CombinedResolver implements AnnotationResolver
{
    private AttributeResolver $attributeResolver;
    private DoctrineAnnotationResolver $doctrineAnnotationResolver;

    public function __construct(AttributeResolver $attributeResolver, DoctrineAnnotationResolver $doctrineAnnotationResolver)
    {
        $this->attributeResolver = $attributeResolver;
        $this->doctrineAnnotationResolver = $doctrineAnnotationResolver;
    }

    /**
     * @inheritDoc
     */
    public function getAnnotationsForMethod(string $className, string $methodName): array
    {
        return array_merge(
            $this->attributeResolver->getAnnotationsForMethod($className, $methodName),
            $this->doctrineAnnotationResolver->getAnnotationsForMethod($className, $methodName)
        );
    }

    /**
     * @inheritDoc
     */
    public function getAnnotationsForClass(string $className): array
    {
        return array_merge(
            $this->attributeResolver->getAnnotationsForClass($className),
            $this->doctrineAnnotationResolver->getAnnotationsForClass($className)
        );
    }

    /**
     * @inheritDoc
     */
    public function getAnnotationsForProperty(string $className, string $propertyName): array
    {
        return array_merge(
            $this->attributeResolver->getAnnotationsForProperty($className, $propertyName),
            $this->doctrineAnnotationResolver->getAnnotationsForProperty($className, $propertyName)
        );
    }
}