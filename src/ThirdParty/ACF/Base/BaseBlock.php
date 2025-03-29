<?php

namespace App\ThirdParty\ACF\Base;

use App\Core\Gutenberg;
use App\ThirdParty\ACF\Reusable\ReusableFields;
use StoutLogic\AcfBuilder\FieldsBuilder;
use Timber\Timber;

abstract class BaseBlock
{
    public static string $blockName;

    public static string $blockTitle;

    public static string $blockIcon = 'block-default';

    public static string $blockMessage = '';

    /** @var array<string> */
    public static array $blockKeywords = [];

    protected FieldsBuilder $fields;

    /** @var BaseBlock[] */
    protected static array $instances = [];

    public function __construct()
    {
        static::$instances[] = $this;
    }

    public static function register(): void
    {
        usort(static::$instances, static fn (BaseBlock $a, BaseBlock $b): int => strcmp($a::$blockTitle, $b::$blockTitle));

        foreach (static::$instances as $instance) {
            $instance->registerBlock();
            $instance->registerFieldGroup();
        }
    }

    /**
     * @param array<string, mixed> $block
     * @param string               $content
     * @param bool                 $is_preview
     */
    public function renderCallbackACF(array $block, string $content = '', bool $is_preview = true): void
    {
        $context = Timber::context();
        $fields = get_fields() ?: [];

        $context['fields'] = $fields;
        $context['blockLayout'] = $fields['layout'] ?? null;

        $this->renderCallback($context, $fields, $block, $content, $is_preview);
    }

    abstract protected function addFields(): void;

    abstract protected function addFieldsContent(): void;

    abstract protected function addFieldsSettings(): void;

    /**
     * @param array<string, mixed> $context
     * @param array<string, mixed> $fields
     * @param array<string, mixed> $block
     * @param string               $content
     * @param bool                 $is_preview
     */
    abstract protected function renderCallback(
        array $context,
        array $fields,
        array $block,
        string $content = '',
        bool $is_preview = true,
    ): void;

    private function registerBlock(): void
    {
        acf_register_block_type([
            'category' => Gutenberg::$blockCategorySlug,
            'icon' => static::$blockIcon,
            'keywords' => [static::$blockTitle, ...static::$blockKeywords],
            'mode' => 'edit',
            'name' => 'block-' . str_replace('_', '-', static::$blockName),
            'render_callback' => [&$this, 'renderCallbackACF'],
            'title' => static::$blockTitle,
        ]);
    }

    private function registerFieldGroup(): void
    {
        $this->fields = ReusableFields::setupGroup('Block: ' . static::$blockTitle);

        $this->fields->addAccordion('message', [
            'label' => static::$blockMessage ? static::$blockTitle . ' • ' . static::$blockMessage : static::$blockTitle,
        ]);

        $this->addFieldsContentDefault();
        $this->addFieldsContent();
        $this->addFields();
        $this->addFieldsSettingsDefault();

        $this->fields->setLocation('block', '==', 'acf/block-' . str_replace('_', '-', static::$blockName));

        acf_add_local_field_group($this->fields->build());
    }

    private function addFieldsContentDefault(): void
    {
        $this->fields
            ->addFields(ReusableFields::tabContent())
        ;
    }

    private function addFieldsSettingsDefault(): void
    {
        $this->fields
            ->addFields(ReusableFields::tabSettings())
        ;

        $this->addFieldsSettings();

        $this->fields
            ->addFields(ReusableFields::tabLayout())
            ->addGroup('layout', [
                'label' => 'Layout',
            ])
            ->addFields(ReusableFields::spacing())
            ->addFields(ReusableFields::width())
            ->addFields(ReusableFields::anchor())
            ->endGroup()
        ;
    }
}
