<?php


namespace Example\DoctrineAnnotation\Listener;

use Example\DoctrineAnnotation\Annotation\Listener;
use Example\DoctrineAnnotation\Annotation\Service;

/**
 * @Service()
 */
class OrderListener
{
    /**
     * @Listener()
     */
    public function doSomething() : void
    {

    }
}