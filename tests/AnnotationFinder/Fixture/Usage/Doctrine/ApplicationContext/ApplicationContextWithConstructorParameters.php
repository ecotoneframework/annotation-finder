<?php
declare(strict_types=1);

namespace Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\ApplicationContext;

use Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\Annotation\ApplicationContext;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\Annotation\Extension;

/**
 * @ApplicationContext()
 */
class ApplicationContextWithConstructorParameters
{
    public function __construct(\stdClass $some)
    {
    }

    /**
     * @Extension()
     */
    public function someExtension()
    {
        return new \stdClass();
    }
}