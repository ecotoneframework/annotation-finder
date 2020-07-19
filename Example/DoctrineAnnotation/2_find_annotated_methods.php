<?php
use Ecotone\AnnotationFinder\AnnotationFinderFactory;

require __DIR__ . "/../../vendor/autoload.php";

// find all class annotated with @Service on class level and @Listener on method level

$rootProjectPath  = __DIR__ . "/../../"; // where composer.json is located
$namespacesToSearchIn = ["Example\DoctrineAnnotation\Listener"];

$annotationFinder = AnnotationFinderFactory::createForDoctrine($rootProjectPath, $namespacesToSearchIn);

var_dump($annotationFinder->findAnnotatedMethods(
    \Example\DoctrineAnnotation\Annotation\Service::class,
    \Example\DoctrineAnnotation\Annotation\Listener::class)
);

//array(2) {
//    [0]=>
//  object(Ecotone\AnnotationFinder\AnnotatedDefinition)#10 (6) {
//  ["className":"Ecotone\AnnotationFinder\AnnotatedDefinition":private]=>
//    string(49) "Example\DoctrineAnnotation\Listener\OrderListener"
//    ["methodName":"Ecotone\AnnotationFinder\AnnotatedDefinition":private]=>
//    string(11) "doSomething"
//    ["annotationForClass":"Ecotone\AnnotationFinder\AnnotatedDefinition":private]=>
//    object(Example\DoctrineAnnotation\Annotation\Service)#14 (0) {}
//    ["annotationForMethod":"Ecotone\AnnotationFinder\AnnotatedDefinition":private]=>
//    object(Example\DoctrineAnnotation\Annotation\Listener)#17 (0) {}
//  }
//  [1]=>
//  object(Ecotone\AnnotationFinder\AnnotatedDefinition)#11 (6) {
//  ["className":"Ecotone\AnnotationFinder\AnnotatedDefinition":private]=>
//    string(51) "Example\DoctrineAnnotation\Listener\PaymentListener"
//["methodName":"Ecotone\AnnotationFinder\AnnotatedDefinition":private]=>
//    string(11) "doSomething"
//["annotationForClass":"Ecotone\AnnotationFinder\AnnotatedDefinition":private]=>
//    object(Example\DoctrineAnnotation\Annotation\Service)#15 (0) {}
//    ["annotationForMethod":"Ecotone\AnnotationFinder\AnnotatedDefinition":private]=>
//    object(Example\DoctrineAnnotation\Annotation\Listener)#16 (0) {}
//  }
//}
