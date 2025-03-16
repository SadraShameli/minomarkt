<?php

namespace App\ThirdParty\ACF\Menu;

use App\ThirdParty\ACF\Base\BaseMenu;

class MenuFooter1 extends BaseMenu
{
    public static string $menuTitle = 'Footer Menu 1';

    public static string $menuSlug = 'footer-one-menu';

    public static string $menuName = 'footerOne';

    protected function addFields(): void
    {
    }
}
