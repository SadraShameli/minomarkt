<?php

namespace App\ThirdParty\ACFGutenberg\Blocks;

use App\ThirdParty\ACFGutenberg\Base\BaseBlock;
use Timber\Timber;

class BlockDivider extends BaseBlock
{
    public static string $blockName = 'divider';

    public static string $blockTitle = 'Divider';

    public static string $blockIcon = 'editor-insertmore';

    public static array $blockKeywords = ['separator'];

    protected function renderCallback(
        array $context,
        array $fields,
        array $block,
        string $content = '',
        bool $is_preview = true,
    ): void {
        Timber::render('blocks/block-divider.twig', $context);
    }

    protected function addFieldsContent(): void
    {
    }

    protected function addFields(): void
    {
    }

    protected function addFieldsSettings(): void
    {
    }
}
