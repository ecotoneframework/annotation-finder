<?php


namespace Example\Attribute\Logger;

use Example\Attribute\Annotation\Logger;
use Ecotone\AnnotationFinder\Annotation\Environment;

#[Logger]
#[Environment(["dev"])]
class DevelopingLogger
{

}