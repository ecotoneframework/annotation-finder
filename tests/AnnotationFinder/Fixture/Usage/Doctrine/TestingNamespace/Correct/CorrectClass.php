<?php

namespace TestingNamespace\Correct;

use Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\Annotation\ApplicationContext;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\Annotation\Extension;

class CorrectClass
{
    #[\Ecotone\Messaging\Annotation\ApplicationContext]
    public function someExtension() : array
    {
        return [];
    }
}