<?php
declare(strict_types=1);

namespace Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\ApplicationContext;

use Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\Annotation\ApplicationContext;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\Annotation\Extension;

#[ApplicationContext]
class ApplicationContextWithConstructorParameters
{
    public function __construct(\stdClass $some)
    {
    }

    #[Extension]
    public function someExtension()
    {
        return new \stdClass();
    }
}