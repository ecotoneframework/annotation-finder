<?php
declare(strict_types=1);

namespace Test\Ecotone\AnnotationFinder\Unit;

use Ecotone\AnnotationFinder\AnnotatedDefinition;
use Ecotone\AnnotationFinder\AnnotationResolver;
use Ecotone\AnnotationFinder\ConfigurationException;
use Ecotone\AnnotationFinder\FileSystem\AutoloadFileNamespaceParser;
use Ecotone\AnnotationFinder\FileSystem\InMemoryAutoloadNamespaceParser;
use Ecotone\AnnotationFinder\FileSystem\FileSystemAnnotationFinder;
use PHPUnit\Framework\TestCase;
use ReflectionException;

abstract class AnnotationFinderTest extends TestCase
{
    const ROOT_DIR = __DIR__ . '/../../../';

    public abstract function getAnnotationNamespacePrefix() : string;
    public abstract function getAnnotationResolver() : AnnotationResolver;

    protected function createAnnotationRegistration(object $classAnnotation, object $methodAnnotation, string $className, string $methodName, array $classAnnotations, array $methodAnnotations): AnnotatedDefinition
    {
        return AnnotatedDefinition::create(
            $classAnnotation,
            $methodAnnotation,
            $className,
            $methodName,
            $classAnnotations,
            $methodAnnotations
        );
    }

    protected function createAnnotationRegistrationService(string $namespace, string $environmentName): FileSystemAnnotationFinder
    {
        $fileSystemAnnotationRegistrationService = new FileSystemAnnotationFinder(
            $this->getAnnotationResolver(),
            new AutoloadFileNamespaceParser(),
            self::ROOT_DIR,
            [
                $namespace
            ],
            $environmentName,
            ""
        );

        return $fileSystemAnnotationRegistrationService;
    }

    protected function getAnnotationRegistrationService(): FileSystemAnnotationFinder
    {
        return $this->createAnnotationRegistrationService($this->getAnnotationNamespacePrefix(), "prod");
    }
}