<?php
declare(strict_types=1);

namespace Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\ApplicationContext;

use Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\Annotation\ApplicationContext;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\Annotation\Extension;

/**
 * @ApplicationContext()
 */
class ApplicationContextExample
{
    const HTTP_INPUT_CHANNEL = "httpEntry";
    const HTTP_OUTPUT_CHANNEL = "httpOutput";

    /**
     * @Extension()
     */
    public function gateway()
    {
        return new \stdClass();
    }

    /**
     * @Extension()
     */
    public function httpEntryChannel()
    {
        return new \stdClass();
    }

    /**
     * @Extension()
     */
    public function enricherHttpEntry()
    {
        return new \stdClass();
    }

    /**
     * @Extension()
     */
    public function withChannelInterceptors()
    {
        return new \stdClass();
    }

    /**
     * @Extension()
     */
    public function withStdClassConverterByExtension()
    {
        return new \stdClass();
    }

    public function wrongExtensionObject()
    {
        return new \stdClass();
    }
}