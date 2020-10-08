<?php
declare(strict_types=1);

namespace Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\Environment;

use Ecotone\AnnotationFinder\Annotation\Environment;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\Annotation\ApplicationContext;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\Annotation\Extension;

#[ApplicationContext]
#[Environment(["prod"])]
class ApplicationContextWithClassEnvironment
{
    #[Extension]
    public function someAction() : void
    {

    }
}