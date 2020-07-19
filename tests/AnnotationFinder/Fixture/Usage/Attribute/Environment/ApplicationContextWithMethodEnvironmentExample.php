<?php
declare(strict_types=1);

namespace Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\Environment;

use Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\Annotation\ApplicationContext;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\Annotation\Extension;
use Ecotone\AnnotationFinder\Annotation\Environment;

<<ApplicationContext>>
<<Environment(["prod", "dev"])>>
class ApplicationContextWithMethodEnvironmentExample
{
    <<Extension>>
    <<Environment(["dev"])>>
    public function configSingleEnvironment() : array
    {
        return [];
    }
}