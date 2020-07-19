<?php


namespace Ecotone\AnnotationFinder;


use Doctrine\Common\Annotations\AnnotationReader;
use Ecotone\AnnotationFinder\AnnotationResolver\AttributeResolver;
use Ecotone\AnnotationFinder\AnnotationResolver\CombinedResolver;
use Ecotone\AnnotationFinder\AnnotationResolver\DoctrineAnnotationResolver;
use Ecotone\AnnotationFinder\AnnotationResolver\OnlyAvailableResolver;
use Ecotone\AnnotationFinder\FileSystem\AutoloadFileNamespaceParser;
use Ecotone\AnnotationFinder\FileSystem\FileSystemAnnotationFinder;

class AnnotationFinderFactory
{
    public static function createForDoctrine(string $rootProjectPath, array $namespaces, string $environmentName = "prod", string $directoryToDiscoverNamespaces = "") : AnnotationFinder
    {
        return new FileSystemAnnotationFinder(
            new DoctrineAnnotationResolver(),
            new AutoloadFileNamespaceParser(),
            $rootProjectPath,
            $namespaces,
            $environmentName,
            $directoryToDiscoverNamespaces
        );
    }

    public static function createForAttributes(string $rootProjectPath, array $namespaces, string $environmentName = "prod", string $directoryToDiscoverNamespaces = "") : AnnotationFinder
    {
        return new FileSystemAnnotationFinder(
            new AttributeResolver(),
            new AutoloadFileNamespaceParser(),
            $rootProjectPath,
            $namespaces,
            $environmentName,
            $directoryToDiscoverNamespaces
        );
    }

    public static function createCombinedDoctrineAndAttributes(string $rootProjectPath, array $namespaces, string $environmentName = "prod", string $directoryToDiscoverNamespaces = "") : AnnotationFinder
    {
        return new FileSystemAnnotationFinder(
            new CombinedResolver(new AttributeResolver(), new DoctrineAnnotationResolver()),
            new AutoloadFileNamespaceParser(),
            $rootProjectPath,
            $namespaces,
            $environmentName,
            $directoryToDiscoverNamespaces
        );
    }

    public static function createFromWhatIsAvailable(string $rootProjectPath, array $namespaces, string $environmentName = "prod", string $directoryToDiscoverNamespaces = "") : AnnotationFinder
    {
        return new FileSystemAnnotationFinder(
            new OnlyAvailableResolver(),
            new AutoloadFileNamespaceParser(),
            $rootProjectPath,
            $namespaces,
            $environmentName,
            $directoryToDiscoverNamespaces
        );
    }
}