<?php
declare(strict_types=1);

namespace Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\MessageEndpoint\SplitterOnMethod;

use Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\Annotation\Splitter;

class SplitterOnMethodExample
{
    /**
     * @Splitter()
     */
    public function split(string $payload) : array
    {
        return [];
    }
}