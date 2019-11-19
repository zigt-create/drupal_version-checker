<?php
/**
 * @file
 * Contains \Drupal\my_event_subscriber\EventSubscriber\MyEventSubscriber.
 */

namespace Drupal\version_checker\EventSubscriber;

use Drupal;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event Subscriber MyEventSubscriber.
 */
class MyEventSubscriber implements EventSubscriberInterface
{
    /**
     * Create app_version for the monitor
     *
     * @param FilterResponseEvent $event
     * @return JSON json response
     */
    public function onRespond(FilterResponseEvent $event)
    {
        if (isset($_GET['app_version']) && $_GET['app_version'] !== "") {
            $data = [];
            $data['app_version'] = \Drupal::VERSION;
            $data['php_version'] = phpversion();
            $data['max_upload_size'] = ini_get('upload_max_filesize');
            $data['max_post_size'] = ini_get('post_max_size');
            $data['memory_limit'] = ini_get('memory_limit');
            $data['max_execution_time'] = ini_get('max_execution_time');
            $data['cms'] = "Drupal";

            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');

            echo json_encode($data);
            exit;
        }
    }

    public static function getSubscribedEvents()
    {
        $events[KernelEvents::RESPONSE][] = ['onRespond'];
        return $events;
    }

}
