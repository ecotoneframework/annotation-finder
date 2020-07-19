<?php
use Ecotone\AnnotationFinder\AnnotationFinderFactory;

require __DIR__ . "/../../vendor/autoload.php";

// find all class annotated with @Subscriber

$rootProjectPath  = __DIR__ . "/../../"; // where composer.json is located
$namespacesToSearchIn = ["Example\Attribute\Order"];

$annotationFinder = AnnotationFinderFactory::createForAttributes($rootProjectPath, $namespacesToSearchIn);

var_dump($annotationFinder->findAnnotatedClasses(\Example\Attribute\Annotation\Service::class));

//array(1) {
//    [0]=>
//  string(53) "Example\Attribute\Order\OrderService"
//}