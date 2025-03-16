<?php

namespace App\ThirdParty\ACF\Menu;

use App\ThirdParty\ACF\Base\BaseMenu;

class MenuMobile extends BaseMenu
{
    public static string $menuTitle = 'Mobile Menu';

    public static string $menuSlug = 'mobile-menu';

    public static string $menuName = 'mobile';

    protected function addFields(): void
    {
    }
}
