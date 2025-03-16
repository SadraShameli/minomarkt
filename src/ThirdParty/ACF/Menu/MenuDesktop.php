<?php

namespace App\ThirdParty\ACF\Menu;

use App\ThirdParty\ACF\Base\BaseMenu;

class MenuDesktop extends BaseMenu
{
    public static string $menuTitle = 'Desktop Menu';

    public static string $menuSlug = 'desktop-menu';

    public static string $menuName = 'desktop';

    protected function addFields(): void
    {
    }
}
