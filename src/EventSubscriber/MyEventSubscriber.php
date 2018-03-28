<?php
/**
 * @file
 * Contains \Drupal\my_event_subscriber\EventSubscriber\MyEventSubscriber.
 */

namespace Drupal\kees_version_checker\EventSubscriber;

use Drupal;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event Subscriber MyEventSubscriber.
 */
class MyEventSubscriber implements EventSubscriberInterface {

  /**
   * Code that should be triggered on event specified 
   */
  public function onRespond(FilterResponseEvent $event) {
		if(isset($_GET['app_version']) && $_GET['app_version'] != ""){

			$data = array();
 			$data['app_version'] = \Drupal::VERSION; 	
			$data['php_version'] = phpversion();
			$data['cms'] = "Drupal";
			
			header('Access-Control-Allow-Origin: *');  
			
			echo json_encode($data);
			exit;  
		}	
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
		
    // For this example I am using KernelEvents constants (see below a full list).
    $events[KernelEvents::RESPONSE][] = ['onRespond'];
    return $events;
  }

}
