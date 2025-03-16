<?php

namespace App\ThirdParty\ACF\Menu;

use App\ThirdParty\ACF\Base\BaseMenu;

class MenuLegal extends BaseMenu
{
    public static string $menuTitle = 'Legal Menu';

    public static string $menuSlug = 'legal-menu';

    public static string $menuName = 'legal';

    protected function addFields(): void
    {
    }
}
