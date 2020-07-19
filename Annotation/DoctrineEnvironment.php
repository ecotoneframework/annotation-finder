<?php


namespace Annotation;

use Doctrine\Common\Annotations\Annotation\Target;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 */
class DoctrineEnvironment
{
    /**
     * @var string[]
     */
    public $names;
}