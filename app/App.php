<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\RouteNotFoundException;
use App\Services\InvoiceService;
use App\Services\PaymentGatewayService;
use App\Services\SalesTaxService;
use App\Services\EmailService;

class App
{
    private static DB $db;
    public static Container $container;

    public function __construct(protected Router $router, protected array $request, protected Config $config)
    {
        static::$db = new DB($config->db ?? []);
        static::$container = new Container();

        static::$container->set(
            InvoiceService::class,
            function (Container $c) {
                return new InvoiceService(
                    $c->get(SalesTaxService::class),
                    $c->get(PaymentGatewayService::class),
                    $c->get(EmailService::class)
                );
            }
        );

        self::$container->set(SalesTaxService::class, fn() => new SalesTaxService());
        self::$container->set(PaymentGatewayService::class, fn() => new PaymentGatewayService());
        self::$container->set(EmailService::class, fn() => new EmailService());
    }

    public static function db(): DB
    {
        return static::$db;
    }

    public function run()
    {
        try {
            echo $this->router->resolve($this->request['uri'], strtolower($this->request['method']));
        } catch (RouteNotFoundException) {
            http_response_code(404);

            echo View::make('error/404');
        }
    }
}
