<?php
use Ecotone\AnnotationFinder\AnnotationFinderFactory;

require __DIR__ . "/../../vendor/autoload.php";

// find all class annotated with @Subscriber

$rootProjectPath  = __DIR__ . "/../../"; // where composer.json is located
$namespacesToSearchIn = ["Example\DoctrineAnnotation\Logger"];

$currentEnvironment = "prod"; // <<< Now we set up current environment

$annotationFinder = AnnotationFinderFactory::createForDoctrine($rootProjectPath, $namespacesToSearchIn, $currentEnvironment);

var_dump($annotationFinder->findAnnotatedClasses(\Example\DoctrineAnnotation\Annotation\Logger::class));

// Only production logger will be found, as other is registered for dev environment
//array(1) {
//    [0]=>
//  string(50) "Example\DoctrineAnnotation\Logger\ProductionLogger"
//}