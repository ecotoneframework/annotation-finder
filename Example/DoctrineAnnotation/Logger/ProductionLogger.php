<?php


namespace Example\DoctrineAnnotation\Logger;

use Example\DoctrineAnnotation\Annotation\Logger;
use Ecotone\AnnotationFinder\Annotation\Environment;

/**
 * @Logger()
 * @Environment({"prod"})
 */
class ProductionLogger
{

}