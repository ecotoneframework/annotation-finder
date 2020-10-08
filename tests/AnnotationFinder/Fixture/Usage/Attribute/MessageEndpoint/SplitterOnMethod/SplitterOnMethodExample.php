<?php
declare(strict_types=1);

namespace Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\MessageEndpoint\SplitterOnMethod;

use Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\Annotation\Splitter;

class SplitterOnMethodExample
{
    #[Splitter]
    public function split(string $payload) : array
    {
        return [];
    }
}