<?php
declare(strict_types=1);

namespace Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\Environment;

use Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\Annotation\ApplicationContext;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\Annotation\Extension;
use Ecotone\AnnotationFinder\Annotation\Environment;

#[ApplicationContext]
class ApplicationContextWithMethodMultipleEnvironmentsExample
{
    #[Extension]
    #[Environment(["dev", "prod", "test"])]
    public function configMultipleEnvironments() : array
    {
        return [];
    }
}