<?php
declare(strict_types=1);

namespace Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\MessageEndpoint\Gateway\FileSystem;

use Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\Annotation\MessageEndpoint;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Attribute\Annotation\MessageGateway;

#[MessageEndpoint]
interface GatewayWithReplyChannelExample
{
    #[MessageGateway]
    public function buy(string $orderId): bool;
}