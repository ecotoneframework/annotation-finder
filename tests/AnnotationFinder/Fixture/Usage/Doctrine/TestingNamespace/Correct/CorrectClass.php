<?php

namespace TestingNamespace\Correct;

use Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\Annotation\ApplicationContext;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\Annotation\Extension;

/**
 * @ApplicationContext()
 */
class CorrectClass
{
    /**
     * @Extension()
     */
    public function someExtension() : array
    {
        return [];
    }
}