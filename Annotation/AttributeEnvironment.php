<?php
namespace Annotation;

use Doctrine\Common\Annotations\Annotation\Target;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 */
<<\Attribute>>
class AttributeEnvironment
{
    /**
     * @var string[]
     */
    public array $names = [];

    public function __construct(array $environments = [])
    {
        if (isset($environments['value'])) {
            $environments = $environments['value'];
        }

        $this->names = $environments;
    }
}