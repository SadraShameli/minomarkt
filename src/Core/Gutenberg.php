<?php

namespace App\Core;

class Gutenberg
{
    public function __construct()
    {
        add_filter('render_block', [&$this, 'modifyBlockOutput'], 10, 2);
    }

    /**
     * @param array<string, mixed> $block
     */
    public function modifyBlockOutput(string $block_content, array $block): string
    {
        return match ($block['blockName']) {
            'complianz/document' => sprintf(
                '<section class="mino-complianz-document">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-lg-10 col-xl-8 offset-lg-1 offset-xl-2">
                                %s
                            </div>
                        </div>
                    </div>
                </section>',
                $block_content,
            ),
            default => $block_content,
        };
    }
}
