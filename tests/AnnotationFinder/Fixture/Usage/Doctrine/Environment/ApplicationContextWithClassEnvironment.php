<?php
declare(strict_types=1);

namespace Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\Environment;

use Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\Annotation\System;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\Annotation\Extension;
use Ecotone\AnnotationFinder\Annotation\Environment as Environment;

/**
 * @System()
 * @Environment({"prod"})
 */
class ApplicationContextWithClassEnvironment
{
    /**
     * @Extension()
     */
    public function someAction() : void
    {

    }
}