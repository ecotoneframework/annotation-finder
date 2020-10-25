<?php


namespace Test\Ecotone\AnnotationFinder\Unit;


use Ecotone\AnnotationFinder\AnnotatedDefinition;
use Ecotone\AnnotationFinder\AnnotatedMethod;
use Ecotone\AnnotationFinder\Annotation\Environment;
use Ecotone\AnnotationFinder\AnnotationFinder;
use Ecotone\AnnotationFinder\AnnotationResolver;
use Ecotone\AnnotationFinder\ConfigurationException;
use Ecotone\AnnotationFinder\FileSystem\AutoloadFileNamespaceParser;
use Ecotone\AnnotationFinder\FileSystem\FileSystemAnnotationFinder;
use Ecotone\AnnotationFinder\FileSystem\InMemoryAutoloadNamespaceParser;
use PHPUnit\Framework\TestCase;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\Annotation\System;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\Annotation\EndpointAnnotation;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\Annotation\Extension;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\Annotation\MessageEndpoint;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\Annotation\MessageGateway;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\Annotation\Splitter;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\Environment\SystemContextWithClassEnvironment;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\MessageEndpoint\Gateway\FileSystem\GatewayWithReplyChannelExample;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\MessageEndpoint\Splitter\SplitterExample;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\MessageEndpoint\SplitterOnMethod\SplitterOnMethodExample;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\Environment\SystemContextWithMethodEnvironmentExample;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\Environment\SystemContextWithMethodMultipleEnvironmentsExample;

class FileSystemAttributeAnnotationFinderTest extends TestCase
{
    const ROOT_DIR = __DIR__ . '/../../../';

    public function getAnnotationNamespacePrefix(): string
    {
        return "Test\\Ecotone\\AnnotationFinder\\Fixture\\Usage\\Attribute";
    }

    public function getAnnotationResolver(): AnnotationResolver
    {
        return new AnnotationResolver\AttributeResolver();
    }

    public function test_retrieving_annotation_registration_for_application_context()
    {
        if (PHP_MAJOR_VERSION < 8) {
            return;
        }

        $gatewayAnnotation = new MessageGateway();
        $messageEndpoint   = new MessageEndpoint();
        $this->assertEquals(
            [
                AnnotatedDefinition::create(
                    $messageEndpoint,
                    $gatewayAnnotation,
                    GatewayWithReplyChannelExample::class,
                    "buy",
                    [$messageEndpoint],
                    [$gatewayAnnotation]
                )
            ],
            $this->createAnnotationRegistrationService($this->getAnnotationNamespacePrefix() . "\\MessageEndpoint\\Gateway\\FileSystem", "prod")
                ->findCombined(MessageEndpoint::class, MessageGateway::class)
        );
    }

    public function test_retrieving_all_classes_with_annotation()
    {
        if (PHP_MAJOR_VERSION < 8) {
            return;
        }

        $classes = $this->createAnnotationRegistrationService($this->getAnnotationNamespacePrefix(), "prod")->findAnnotatedClasses(System::class);

        $this->assertNotEmpty($classes, "File system class locator didn't find application context");
    }

    public function test_retrieving_method_and_class_annotations()
    {
        if (PHP_MAJOR_VERSION < 8) {
            return;
        }

        $gatewayAnnotation = new MessageGateway();

        $this->assertEquals(
            [
                $gatewayAnnotation
            ],
            $this->createAnnotationRegistrationService($this->getAnnotationNamespacePrefix() . "\\MessageEndpoint\Gateway\FileSystem", "prod")
                ->getAnnotationsForMethod(GatewayWithReplyChannelExample::class, "buy")
        );
    }

    public function test_retrieving_class_annotations()
    {
        if (PHP_MAJOR_VERSION < 8) {
            return;
        }

        $this->assertEquals(
            [
                new MessageEndpoint()
            ],
            $this->createAnnotationRegistrationService($this->getAnnotationNamespacePrefix() . "\\MessageEndpoint\Gateway\FileSystem", "prod")
                ->getAnnotationsForClass(GatewayWithReplyChannelExample::class)
        );
    }


    public function test_retrieving_for_specific_environment()
    {
        if (PHP_MAJOR_VERSION < 8) {
            return;
        }

        $fileSystemAnnotationRegistrationService = $this->createAnnotationRegistrationService($this->getAnnotationNamespacePrefix() . "\\Environment", "dev");
        $devEnvironment                          = new Environment();
        $devEnvironment->names                   = ["dev"];
        $prodDevEnvironment                      = new Environment();
        $prodDevEnvironment->names               = ["prod", "dev"];
        $prodEnvironment                         = new Environment();
        $prodEnvironment->names                  = ["prod"];
        $allEnvironment                          = new Environment();
        $allEnvironment->names                   = ["dev", "prod", "test"];
        $methodAnnotation                        = new Extension();
        $System                      = new System();

        $this->assertEquals(
            [
                AnnotatedDefinition::create(
                    $System,
                    $methodAnnotation,
                    SystemContextWithMethodEnvironmentExample::class,
                    "configSingleEnvironment",
                    [$System, $prodDevEnvironment],
                    [$methodAnnotation, $devEnvironment]
                ),
                AnnotatedDefinition::create(
                    $System,
                    $methodAnnotation,
                    SystemContextWithMethodMultipleEnvironmentsExample::class,
                    "configMultipleEnvironments",
                    [$System],
                    [$methodAnnotation, $allEnvironment]
                )
            ],
            $fileSystemAnnotationRegistrationService->findCombined(System::class, Extension::class)
        );


        $fileSystemAnnotationRegistrationService = $this->createAnnotationRegistrationService($this->getAnnotationNamespacePrefix() . "\\Environment", "test");
        $this->assertEquals(
            [
                AnnotatedDefinition::create(
                    $System,
                    $methodAnnotation,
                    SystemContextWithMethodMultipleEnvironmentsExample::class,
                    "configMultipleEnvironments",
                    [$System],
                    [$methodAnnotation, $allEnvironment]
                )
            ],
            $fileSystemAnnotationRegistrationService->findCombined(System::class, Extension::class)
        );

        $fileSystemAnnotationRegistrationService = $this->createAnnotationRegistrationService($this->getAnnotationNamespacePrefix() . "\\Environment", "prod");
        $this->assertEquals(
            [
                AnnotatedDefinition::create(
                    $System,
                    $methodAnnotation,
                    SystemContextWithClassEnvironment::class,
                    "someAction",
                    [$System, $prodEnvironment],
                    [$methodAnnotation]
                ),
                AnnotatedDefinition::create(
                    $System,
                    $methodAnnotation,
                    SystemContextWithMethodMultipleEnvironmentsExample::class,
                    "configMultipleEnvironments",
                    [$System],
                    [$methodAnnotation, $allEnvironment]
                )
            ],
            $fileSystemAnnotationRegistrationService->findCombined(System::class, Extension::class)
        );
    }

    public function test_retrieving_subclass_annotation()
    {
        if (PHP_MAJOR_VERSION < 8) {
            return;
        }

        $annotation = new Splitter();

        $fileSystemAnnotationRegistrationService = $this->createAnnotationRegistrationService($this->getAnnotationNamespacePrefix() . "\\MessageEndpoint\\Splitter", "prod");

        $annotationForClass = new MessageEndpoint();
        $this->assertEquals(
            [
                AnnotatedDefinition::create(
                    $annotationForClass,
                    $annotation,
                    SplitterExample::class,
                    "split",
                    [$annotationForClass],
                    [$annotation]
                )
            ],
            $fileSystemAnnotationRegistrationService->findCombined(MessageEndpoint::class, EndpointAnnotation::class)
        );
    }

    public function test_retrieving_by_only_method_annotation()
    {
        if (PHP_MAJOR_VERSION < 8) {
            return;
        }

        $annotation = new Splitter();

        $fileSystemAnnotationRegistrationService = $this->createAnnotationRegistrationService($this->getAnnotationNamespacePrefix() . "\\MessageEndpoint\\SplitterOnMethod", "prod");

        $this->assertEquals(
            [
                AnnotatedMethod::create(
                    $annotation,
                    SplitterOnMethodExample::class,
                    "split",
                    [],
                    [$annotation]
                )
            ],
            $fileSystemAnnotationRegistrationService->findAnnotatedMethods(Splitter::class)
        );
    }

    public function test_throwing_exception_if_class_is_registed_under_incorrect_namespace()
    {
        if (PHP_MAJOR_VERSION < 8) {
            return;
        }

        $this->expectException(\ReflectionException::class);

        new FileSystemAnnotationFinder(
            $this->getAnnotationResolver(),
            new AutoloadFileNamespaceParser(),
            self::ROOT_DIR,
            [
                "IncorrectAttribute"
            ],
            "test",
            ""
        );
    }

    public function test_not_including_classes_from_unregistered_namespace_when_using_namespace_inside()
    {
        if (PHP_MAJOR_VERSION < 8) {
            return;
        }

        new FileSystemAnnotationFinder(
            $this->getAnnotationResolver(),
            new AutoloadFileNamespaceParser(),
            self::ROOT_DIR,
            [
                "TestingNamespace"
            ],
            "test",
            ""
        );

        $this->assertTrue(true);
    }

    public function test_not_including_classes_from_unregistered_when_only_namespace_prefix_match()
    {
        if (PHP_MAJOR_VERSION < 8) {
            return;
        }

        new FileSystemAnnotationFinder(
            $this->getAnnotationResolver(),
            new AutoloadFileNamespaceParser(),
            self::ROOT_DIR,
            [
                "IncorrectAttribute\Testing"
            ],
            "test",
            ""
        );

        $this->assertTrue(true);
    }

    public function test_throwing_exception_if_given_catalog_to_load_and_no_namespaces_to_load()
    {
        if (PHP_MAJOR_VERSION < 8) {
            return;
        }

        $this->expectException(ConfigurationException::class);

        new FileSystemAnnotationFinder(
            $this->getAnnotationResolver(),
            InMemoryAutoloadNamespaceParser::createEmpty(),
            self::ROOT_DIR,
            [],
            "test",
            "src"
        );
    }

    public function test_throwing_exception_if_given_catalog_to_load_and_only_ecotone_namespace_defined_to_load()
    {
        if (PHP_MAJOR_VERSION < 8) {
            return;
        }

        $this->expectException(ConfigurationException::class);

        new FileSystemAnnotationFinder(
            $this->getAnnotationResolver(),
            InMemoryAutoloadNamespaceParser::createEmpty(),
            self::ROOT_DIR,
            [FileSystemAnnotationFinder::FRAMEWORK_NAMESPACE],
            "test",
            "src"
        );
    }

    private function createAnnotationRegistrationService(string $namespace, string $environmentName): AnnotationFinder
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
}