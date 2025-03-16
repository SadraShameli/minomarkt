<?php

namespace App\ThirdParty\ACF\Menu;

use App\ThirdParty\ACF\Base\BaseMenu;

class MenuFooter2 extends BaseMenu
{
    public static string $menuTitle = 'Footer Menu 2';

    public static string $menuSlug = 'footer-two-menu';

    public static string $menuName = 'footerTwo';

    protected function addFields(): void
    {
    }
}
