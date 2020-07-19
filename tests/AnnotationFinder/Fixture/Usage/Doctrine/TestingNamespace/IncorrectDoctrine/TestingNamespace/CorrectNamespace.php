<?php

namespace IncorrectDoctrine\TestingNamespace;

use Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\Annotation\ApplicationContext;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\Annotation\Extension;

/**
 * @ApplicationContext()
 */
class CorrectNamespace
{
    /**
     * @Extension()
     */
    public function someExtension() : array
    {
        return [];
    }
}