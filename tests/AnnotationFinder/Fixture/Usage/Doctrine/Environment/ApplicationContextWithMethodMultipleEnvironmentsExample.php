<?php
declare(strict_types=1);

namespace Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\Environment;

use Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\Annotation\ApplicationContext;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\Annotation\Extension;
use Ecotone\AnnotationFinder\Annotation\Environment as Environment;

/**
 * @ApplicationContext()
 */
class ApplicationContextWithMethodMultipleEnvironmentsExample
{
    /**
     * @return array
     * @Extension()
     * @Environment({"dev", "prod", "test"})
     */
    public function configMultipleEnvironments() : array
    {
        return [];
    }
}