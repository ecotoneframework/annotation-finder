<?php

namespace IncorrectDoctrine\TestingNamespace;

use Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\Annotation\ApplicationContext;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\Annotation\Extension;

class CorrectNamespace
{
    #[\Ecotone\Messaging\Annotation\ApplicationContext]
    public function someExtension() : array
    {
        return [];
    }
}