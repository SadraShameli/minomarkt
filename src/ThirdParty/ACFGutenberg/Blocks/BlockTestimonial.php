<?php

namespace App\ThirdParty\ACFGutenberg\Blocks;

use App\ThirdParty\ACFFields\ReusableFields;
use App\ThirdParty\ACFGutenberg\Base\BaseBlock;
use App\ThirdParty\ACFGutenberg\PostTypes\PostTypeTestimonial;
use App\ThirdParty\ACFGutenberg\Taxonomies\TaxonomyTestimonialCategories;
use Timber\Timber;

class BlockTestimonial extends BaseBlock
{
    public static string $blockName = 'testimonial';

    public static string $blockTitle = 'Testimonial';

    public static string $blockIcon = 'format-quote';

    protected function renderCallback(
        array $context,
        array $fields,
        array $block,
        string $content = '',
        bool $is_preview = true,
    ): void {
        $testimonials = [];

        if (!empty($fields['testimonial_selection']) && 'manual' === $fields['testimonial_selection'] && !empty($fields['selected_testimonials'])) {
            $testimonials = $this->getSelectedTestimonials($fields['selected_testimonials']);
        } else {
            $limit = ($fields['testimonial_limit'] ?? null) ?: 3;
            $testimonials = $this->getHighestRatedTestimonials($limit, $fields['testimonial_category'] ?? null);
        }

        $context['testimonials'] = $testimonials;

        Timber::render('blocks/block-testimonial.twig', $context);
    }

    protected function addFieldsContent(): void
    {
        $this->fields
            ->addText('title', [
                'label' => 'Title',
            ])
            ->addFields(ReusableFields::wysiwyg('description', 'Description'))
            ->addSelect('testimonial_selection', [
                'label' => 'Testimonial Selection',
                'choices' => [
                    'auto' => 'Automatic (highest rated)',
                    'manual' => 'Manual selection',
                ],
                'default_value' => 'auto',
                'return_format' => 'value',
                'allow_null' => 0,
            ])
            ->addNumber('testimonial_limit', [
                'label' => 'Number of testimonials to show',
                'min' => 1,
                'max' => 10,
                'conditional_logic' => [
                    [
                        [
                            'field' => 'testimonial_selection',
                            'operator' => '==',
                            'value' => 'auto',
                        ],
                    ],
                ],
            ])
            ->addTaxonomy('testimonial_category', [
                'label' => 'Filter by category',
                'taxonomy' => TaxonomyTestimonialCategories::$taxonomyName,
                'field_type' => 'select',
                'allow_null' => 1,
                'add_term' => 0,
                'save_terms' => 0,
                'load_terms' => 0,
                'return_format' => 'id',
                'multiple' => 0,
                'conditional_logic' => [
                    [
                        [
                            'field' => 'testimonial_selection',
                            'operator' => '==',
                            'value' => 'auto',
                        ],
                    ],
                ],
            ])
            ->addRelationship('selected_testimonials', [
                'label' => 'Select Testimonials',
                'post_type' => PostTypeTestimonial::$postTypeName,
                'filters' => ['search', 'taxonomy'],
                'return_format' => 'id',
                'min' => 1,
                'max' => 10,
                'conditional_logic' => [
                    [
                        [
                            'field' => 'testimonial_selection',
                            'operator' => '==',
                            'value' => 'manual',
                        ],
                    ],
                ],
            ])
        ;
    }

    protected function addFields(): void
    {
    }

    protected function addFieldsSettings(): void
    {
        $this->fields
            ->addTrueFalse('show_title', [
                'label' => 'Show Title',
                'ui' => true,
                'default_value' => true,
            ])
            ->addTrueFalse('show_description', [
                'label' => 'Show Description',
                'ui' => true,
                'default_value' => true,
            ])
            ->addSelect('display_style', [
                'label' => 'Display Style',
                'choices' => [
                    'grid' => 'Grid',
                    'slider' => 'Slider',
                ],
                'default_value' => 'grid',
                'return_format' => 'value',
                'allow_null' => false,
            ])
            ->addTrueFalse('show_ratings', [
                'label' => 'Show Ratings',
                'ui' => true,
                'default_value' => true,
            ])
        ;
    }

    /**
     * @param array<int> $ids
     *
     * @return array<int, array<string, mixed>>
     */
    private function getSelectedTestimonials(array $ids): array
    {
        $args = [
            'post_type' => 'testimonial',
            'post__in' => $ids,
            'orderby' => 'post__in',
            'posts_per_page' => count($ids),
            'post_status' => 'publish',
        ];

        return $this->getTestimonialPosts($args);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function getHighestRatedTestimonials(int $limit = 3, ?int $category = null): array
    {
        $args = [
            'post_type' => 'testimonial',
            'posts_per_page' => $limit,
            'post_status' => 'publish',
            'meta_key' => 'rating',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
        ];

        if ($category) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'testimonial_category',
                    'field' => 'term_id',
                    'terms' => $category,
                ],
            ];
        }

        return $this->getTestimonialPosts($args);
    }

    /**
     * @param array<string, mixed> $args
     *
     * @return array<int, array<string, mixed>>
     */
    private function getTestimonialPosts(array $args): array
    {
        /** @var \WP_Post[] $posts */
        $posts = get_posts($args);

        return array_map(static function (\WP_Post $post): array {
            return [
                'name' => $post->post_title,
                'quote' => get_field('quote', $post->ID),
                'author' => get_field('author', $post->ID),
                'rating' => (int) get_field('rating', $post->ID),
                'image' => get_field('image', $post->ID),
            ];
        }, $posts);
    }
}
