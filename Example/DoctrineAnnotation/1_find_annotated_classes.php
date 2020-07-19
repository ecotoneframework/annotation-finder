<?php
use Ecotone\AnnotationFinder\AnnotationFinderFactory;

require __DIR__ . "/../../vendor/autoload.php";

// find all class annotated with @Subscriber

$rootProjectPath  = __DIR__ . "/../../"; // where composer.json is located
$namespacesToSearchIn = ["Example\DoctrineAnnotation\Order"];

$annotationFinder = AnnotationFinderFactory::createForDoctrine($rootProjectPath, $namespacesToSearchIn);

var_dump($annotationFinder->findAnnotatedClasses(\Example\DoctrineAnnotation\Annotation\Service::class));

//array(1) {
//    [0]=>
//  string(53) "Example\DoctrineAnnotation\Order\OrderService"
//}