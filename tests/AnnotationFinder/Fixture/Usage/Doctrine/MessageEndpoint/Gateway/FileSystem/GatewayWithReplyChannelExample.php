<?php
declare(strict_types=1);

namespace Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\MessageEndpoint\Gateway\FileSystem;

use Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\Annotation\MessageEndpoint;
use Test\Ecotone\AnnotationFinder\Fixture\Usage\Doctrine\Annotation\MessageGateway;

/**
 * @MessageEndpoint()
 */
interface GatewayWithReplyChannelExample
{
    /**
     * @MessageGateway()
     */
    public function buy(string $orderId): bool;
}