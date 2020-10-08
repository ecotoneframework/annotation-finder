<?php
declare(strict_types=1);

namespace Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\ApplicationContext;

use Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\Annotation\ApplicationContext;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\Annotation\Extension;

#[ApplicationContext]
class ApplicationContextWithMethodParameters
{

    #[Extension]
    public function someExtension(\stdClass $some)
    {
        return new \stdClass();
    }
}