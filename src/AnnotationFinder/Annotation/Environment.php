<?php


namespace Ecotone\AnnotationFinder\Annotation;

if (PHP_MAJOR_VERSION >= 8) {
    class_alias(\Annotation\AttributeEnvironment::class, "Ecotone\AnnotationFinder\Annotation\Environment");
}else {
    class_alias(\Annotation\DoctrineEnvironment::class, "Ecotone\AnnotationFinder\Annotation\Environment");
}

//class Environment
//{
//    /**
//     * @var string[]
//     */
//    public $names = [];
//}