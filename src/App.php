<?php

namespace App;

use App\Core\Enqueues;
use App\Core\ExtendTwig;
use App\Core\Gutenberg;
use App\Core\Vite;
use App\ThirdParty\ACF;
use App\ThirdParty\ACFFields\Fields\FooterSettings;
use App\ThirdParty\ACFFields\Fields\GeneralSettings;
use App\ThirdParty\ACFFields\Fields\HeaderSettings;

class App
{
    public function __construct()
    {
        new ACF();
        new Enqueues();
        new ExtendTwig();
        new FooterSettings();
        new GeneralSettings();
        new Gutenberg();
        new HeaderSettings();
        new Vite();
    }
}
