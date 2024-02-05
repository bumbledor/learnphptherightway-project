<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\InvoiceService;
use App\View;
use App\App;

class HomeController
{
    public function index(): View
    {
        App::$container->get(InvoiceService::class)->process([], 235);

        return View::make('index');
    }


}
