<?php


namespace Ecotone\AnnotationFinder\AnnotationResolver;


use Doctrine\Common\Annotations\AnnotationReader;
use Ecotone\AnnotationFinder\AnnotationResolver;

class OnlyAvailableResolver implements AnnotationResolver
{
    private AnnotationResolver $resolver;

    public function __construct()
    {
        if (PHP_MAJOR_VERSION < 8) {
            $resolver =  new DoctrineAnnotationResolver();
        }else {
            if (!class_exists(AnnotationReader::class)) {
                $resolver = new AttributeResolver();
            }else {
                $resolver = new CombinedResolver(new AttributeResolver(), new DoctrineAnnotationResolver());
            }
        }

        $this->resolver = $resolver;
    }

    /**
     * @inheritDoc
     */
    public function getAnnotationsForMethod(string $className, string $methodName): array
    {
        return $this->resolver->getAnnotationsForMethod($className, $methodName);
    }

    /**
     * @inheritDoc
     */
    public function getAnnotationsForClass(string $className): array
    {
        return $this->resolver->getAnnotationsForClass($className);
    }

    /**
     * @inheritDoc
     */
    public function getAnnotationsForProperty(string $className, string $propertyName): array
    {
        return $this->resolver->getAnnotationsForProperty($className, $propertyName);
    }
}