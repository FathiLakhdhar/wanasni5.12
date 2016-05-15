<?php
/**
 * Created by PhpStorm.
 * User: Toshiba
 * Date: 15-05-2016
 * Time: 13:56
 */

namespace Wanasni\AdminBundle\Listener;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class kernelListener
{


    public function onKernelResponse(FilterResponseEvent $event)
    {

        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }
        $response = new Response('Notre site passe en maintenance un court moment.
        Notre équipe est mobilisée pour que ce moment soit le plus court possible.', 400);
        $event->setResponse($response);
    }
}