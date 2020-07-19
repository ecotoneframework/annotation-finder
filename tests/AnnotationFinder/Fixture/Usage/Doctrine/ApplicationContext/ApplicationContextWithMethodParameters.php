<?php
declare(strict_types=1);

namespace Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\ApplicationContext;

use Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\Annotation\ApplicationContext;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\Annotation\Extension;

/**
 * @ApplicationContext()
 */
class ApplicationContextWithMethodParameters
{
    /**
     * @Extension()
     */
    public function someExtension(\stdClass $some)
    {
        return new \stdClass();
    }
}