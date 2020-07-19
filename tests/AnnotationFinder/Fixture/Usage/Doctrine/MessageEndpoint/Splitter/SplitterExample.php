<?php
declare(strict_types=1);

namespace Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\MessageEndpoint\Splitter;

use Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\Annotation\MessageEndpoint;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\Annotation\Splitter;

/**
 * @MessageEndpoint()
 */
class SplitterExample
{
    /**
     * @Splitter()
     */
    public function split(string $payload) : array
    {
        return [];
    }
}