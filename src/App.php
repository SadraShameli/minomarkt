<?php

namespace App;

use App\Core\Enqueues;
use App\Core\ExtendTwig;
use App\Core\Gutenberg;
use App\Core\Vite;
use App\ThirdParty\ACF\ACF;

class App
{
    public function __construct()
    {
        new Gutenberg();
        new ExtendTwig();
        new Vite();
        new Enqueues();
        new ACF();
    }
}
