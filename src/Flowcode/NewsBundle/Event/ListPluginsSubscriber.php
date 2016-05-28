<?php

namespace Flowcode\NewsBundle\Event;

use Flowcode\DashboardBundle\Event\ListPluginsEvent;
use Flowcode\DashboardBundle\Event\ShowMenuEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;


/**
 * Created by PhpStorm.
 * User: juanma
 * Date: 5/28/16
 * Time: 12:20 PM
 */
class ListPluginsSubscriber implements EventSubscriberInterface
{
    protected $router;
    protected $translator;

    public function __construct(RouterInterface $router, TranslatorInterface $translator)
    {
        $this->router = $router;
        $this->translator = $translator;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return array(
            ListPluginsEvent::NAME => array('handler', 0),
        );
    }


    public function handler(ListPluginsEvent $event)
    {
        $plugins = $event->getPluginDescriptors();

        /* add default */
        $plugins[] = array(
            "name" => "AmulenNews",
            "image" => null,
            "version" => "v1.0",
            "settings" => '#',
            "description" => $this->translator->trans('amulen_news.description'),
            "website" => null,
            "authors" => array(
                array(
                    "name" => "Flowcode",
                    "email" => "info@flowcode.com.ar",
                    "website" => "http://flowcode.com.ar",
                ),
            ),
        );

        $event->setPluginDescriptors($plugins);

    }
}