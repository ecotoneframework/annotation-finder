<?php
declare(strict_types=1);

namespace IncorrectDoctrine\TestingNamespace\Wrong;

use Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\Annotation\ApplicationContext;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\Annotation\Extension;

class ClassWithIncorrectNamespaceAndClassName
{
    #[\Ecotone\Messaging\Annotation\ApplicationContext]
    public function someExtension() : array
    {
        return [];
    }
}