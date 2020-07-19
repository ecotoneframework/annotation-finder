<?php
declare(strict_types=1);

namespace Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\MessageEndpoint\Splitter;

use Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\Annotation\MessageEndpoint;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\Annotation\Splitter;

<<MessageEndpoint()>>
class SplitterExample
{
    <<Splitter>>
    public function split(string $payload) : array
    {
        return [];
    }
}