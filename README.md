Yousign Bundle for Symfony
=================================================
### This is a fork for allow Symfony 7 & PHP 8 min

* A Symfony bundle for [Yousign](https://yousign.com/).
* Provide a service to access the API for a better Symfony integration
* Webhook handler (HTTP controller) + Webhook Event

## Requirements

* PHP >= 8.1
* Symfony 5 / 6 / 7

## Installation

```console
$ composer require ocb974/yousign-bundle
```

Load the bundle in your app if not case

```php
$bundles = [
    // ...
    new \Neyric\YousignBundle\NeyricYousignBundle(),
];
```

## Configuration

The bundle (in particular the YousignApiClient), expects those 2 environement variables to be defined

* YOUSIGN_BASE_URL (should be https://staging-app.yousign.com or https://api.yousign.com)
* YOUSIGN_API_KEY


## Using the webhook handler

First, setup the route in your routes.yaml file :

```yaml
neyric_yousign:
    path: /yousign_webook/hook_handler # Customizable url
    controller: Neyric\YousignBundle\Controller\YousignController::webhookHandlerAction
```


Create a subscriber

```php
use Neyric\YousignBundle\Event\WebhookEvent;

class MySubscriber implements EventSubscriberInterface
{
    
    public function onYousignWebhook(WebhookEvent $event)
    {
        $headers = $event->getHeaders();

        if (array_key_exists('x-my-custom-header', $headers)) {
            // ...
        }

        // ...
    }

    public static function getSubscribedEvents()
    {
        return [
            WebhookEvent::class => ['onYousignWebhook'],
        ];
    }
}
```

And eventually declare the service with the  `kernel.event_subscriber` tag :

```yaml
    App\Subscriber\MySubscriber:
        class: App\Subscriber\MySubscriber
        tags:
            - { name: kernel.event_subscriber }
```


Prepare a local tunnel
----------------------------------------

Using a local tunnel will save you a lot of time because you can test locally. The recommended choice is [ngrok](https://ngrok.com/). Ngrok is a tool to tunnel our local server to the web, making our local webhook handlers available to the email providers webhooks.


License
-------------------------------------------------
neyric/yousign-bundle is distributed under MIT license, see the [LICENSE file](https://github.com/neyric/yousign-bundle/blob/master/LICENSE).


Contacts
-------------------------------------------------
Report bugs or suggest features using [issue tracker on GitHub](https://github.com/neyric/yousign-bundle).