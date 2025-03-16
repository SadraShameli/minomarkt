<?php

namespace App\ThirdParty\ACF\Blocks;

use App\ThirdParty\ACF\Reusable\ReusableFields;
use App\ThirdParty\ACF\Base\BaseBlock;
use App\ThirdParty\ACF\PostTypes\PostTypeFAQ;
use App\ThirdParty\ACF\Taxonomies\TaxonomyFAQCategories;
use Timber\Timber;

class BlockAccordion extends BaseBlock
{
    public static string $blockName = 'accordion';

    public static string $blockTitle = 'Accordion';

    public static string $blockIcon = 'list-view';

    protected function renderCallback(
        array $context,
        array $fields,
        array $block,
        string $content = '',
        bool $is_preview = true,
    ): void {
        if ($fields['use_faqs'] ?? false) {
            $manualSelection = $fields['manual_selection'] ?? false;

            if ($manualSelection && !empty($fields['selected_faqs'])) {
                $faqs = $fields['selected_faqs'];
            } else {
                $args = [
                    'post_type' => PostTypeFAQ::$postTypeName,
                    'posts_per_page' => -1,
                    'orderby' => 'menu_order',
                    'order' => 'ASC',
                ];

                if (!empty($fields['faq_categories'])) {
                    $args['tax_query'] = [
                        [
                            'taxonomy' => TaxonomyFAQCategories::$taxonomyName,
                            'field' => 'term_id',
                            'terms' => $fields['faq_categories'],
                        ],
                    ];
                }

                $faqs = get_posts($args);
            }

            $context['items'] = [];
            foreach ($faqs as $faq) {
                $context['items'][] = [
                    'question' => $faq->post_title,
                    'answer' => get_field('answer', $faq->ID),
                ];
            }
        } else {
            $context['items'] = $fields['items'] ?? [];
        }

        if (empty($context['items'])) {
            return;
        }

        $context['schema'] = $this->getSchema($context['items']);

        Timber::render('blocks/accordion.twig', $context);
    }

    protected function addFieldsContent(): void
    {
        $this->fields
            ->addText('subtitle', [
                'label' => 'Subtitle',
            ])
            ->addText('title', [
                'label' => 'Title',
            ])
            ->addTextarea('description', [
                'label' => 'Description',
            ])
            ->addFields(ReusableFields::button())
            ->addRepeater('items', [
                'label' => 'Items',
                'layout' => 'block',
                'button_label' => 'Add Item',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'use_faqs',
                            'operator' => '==',
                            'value' => false,
                        ],
                    ],
                ],
            ])
            ->addText('question', [
                'label' => 'Question',
                'required' => true,
            ])
            ->addFields(ReusableFields::wysiwyg('answer', 'Answer'))
            ->endRepeater()
        ;
    }

    protected function addFields(): void
    {
    }

    protected function addFieldsSettings(): void
    {
        $this->fields
            ->addTrueFalse('use_faqs', [
                'label' => 'Use FAQ Posts',
                'ui' => true,
                'default_value' => true,
            ])
            ->addTrueFalse('manual_selection', [
                'label' => 'Manual FAQ Selection',
                'ui' => true,
                'conditional_logic' => [
                    [
                        [
                            'field' => 'use_faqs',
                            'operator' => '==',
                            'value' => true,
                        ],
                    ],
                ],
            ])
            ->addTaxonomy('faq_categories', [
                'label' => 'FAQ Categories',
                'taxonomy' => TaxonomyFAQCategories::$taxonomyName,
                'field_type' => 'multi_select',
                'return_format' => 'id',
                'multiple' => 1,
                'conditional_logic' => [
                    [
                        [
                            'field' => 'use_faqs',
                            'operator' => '==',
                            'value' => true,
                        ],
                        [
                            'field' => 'manual_selection',
                            'operator' => '==',
                            'value' => false,
                        ],
                    ],
                ],
            ])
            ->addRelationship('selected_faqs', [
                'label' => 'Select FAQs',
                'post_type' => PostTypeFAQ::$postTypeName,
                'filters' => ['search'],
                'return_format' => 'object',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'use_faqs',
                            'operator' => '==',
                            'value' => true,
                        ],
                        [
                            'field' => 'manual_selection',
                            'operator' => '==',
                            'value' => true,
                        ],
                    ],
                ],
            ])
        ;
    }

    /**
     * @param array<array{question: string, answer: string}> $faqContent
     *
     * @return array<string, mixed>
     */
    private function getSchema(array $faqContent): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => array_map(static function ($faqItem): array {
                return [
                    '@type' => 'Question',
                    'name' => $faqItem['question'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $faqItem['answer'],
                    ],
                ];
            }, $faqContent),
        ];
    }
}
