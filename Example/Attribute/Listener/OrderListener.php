<?php


namespace Example\Attribute\Listener;

use Example\Attribute\Annotation\Listener;
use Example\Attribute\Annotation\Service;

#[Service]
class OrderListener
{
    #[Listener]
    public function doSomething() : void
    {

    }
}