<?php
declare(strict_types=1);

namespace IncorrectDoctrine\TestingNamespace\Wrong;

use Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\Annotation\ApplicationContext;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\Annotation\Extension;

/**
 * @ApplicationContext()
 */
class ClassWithIncorrectNamespaceAndClassName
{
    /**
     * @Extension()
     */
    public function someExtension() : array
    {
        return [];
    }
}