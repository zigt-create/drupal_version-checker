<?php
/**
 * @file
 * Contains \Drupal\version_checker\EventSubscriber\Subscriber.
 */

namespace Drupal\version_checker\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event Subscriber Subscriber.
 */
class Subscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        $events[KernelEvents::RESPONSE][] = ['onRespond'];
        return $events;
    }

    /**
     * Create app_version for the monitor
     *
     * @param FilterResponseEvent $event
     * @return JSON json response
     */
    public function onRespond()
    {
        // Check if uri contains `app_version`
        if (isset($_GET['app_version']) && $_GET['app_version'] != "") {
            // Create data array.
            $data = [];
            // Set the current versions of drupal and php.
            $data['app_version'] = \Drupal::VERSION;
            $data['php_version'] = phpversion();
            $data['cms'] = "Drupal";
            // Set the headers to JSON.
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            // Display the JSON data to the screen and kill the rest of the page.
            echo json_encode($data);
            exit;
        }
    }

    

}
