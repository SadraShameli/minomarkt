<?php

namespace App\ThirdParty\ACF\ACFGutenberg\PostTypes;

use App\ThirdParty\ACF\ACFGutenberg\Base\BasePostType;

class PostTypeCoupon extends BasePostType
{
    public static string $postTypeName = 'coupon';

    public static string $pluralName = 'Coupons';

    public static string $singularName = 'Coupon';

    public static string $slug = 'coupons';

    public static string $menuIcon = 'dashicons-tickets-alt';

    protected function addFieldsContent(): void
    {
        $this->fields
            ->addText('coupon_code', [
                'label' => 'Coupon Code',
                'required' => true,
                'instructions' => 'Enter a unique coupon code',
            ])
            ->addSelect('discount_type', [
                'label' => 'Discount Type',
                'choices' => [
                    'percentage' => 'Percentage Discount',
                    'fixed_cart' => 'Fixed Cart Discount',
                    'fixed_product' => 'Fixed Product Discount',
                ],
                'required' => true,
            ])
            ->addNumber('discount_amount', [
                'label' => 'Discount Amount',
                'required' => true,
                'min' => 0,
            ])
            ->addDateTimePicker('start_date', [
                'label' => 'Start Date',
                'required' => true,
            ])
            ->addDateTimePicker('expiry_date', [
                'label' => 'Expiry Date',
            ])
            ->addTab('usage_limits', ['label' => 'Usage Limits'])
            ->addNumber('usage_limit', [
                'label' => 'Usage Limit per Coupon',
                'instructions' => 'How many times this coupon can be used before it is void. Leave blank for unlimited.',
            ])
            ->addNumber('usage_limit_per_user', [
                'label' => 'Usage Limit per User',
                'instructions' => 'How many times this coupon can be used by a single user. Leave blank for unlimited.',
            ])
            ->addNumber('minimum_spend', [
                'label' => 'Minimum Spend',
                'instructions' => 'Minimum spend amount to use this coupon',
            ])
            ->addNumber('maximum_spend', [
                'label' => 'Maximum Spend',
                'instructions' => 'Maximum spend amount to use this coupon',
            ])
            ->addTrueFalse('individual_use', [
                'label' => 'Individual Use Only',
                'instructions' => 'Check this box if the coupon cannot be used in conjunction with other coupons',
                'ui' => true,
            ])
            ->addTrueFalse('exclude_sale_items', [
                'label' => 'Exclude Sale Items',
                'instructions' => 'Check this box if the coupon should not apply to items on sale',
                'ui' => true,
            ])
            ->addTab('restrictions', ['label' => 'Restrictions'])
            ->addRepeater('product_categories', [
                'label' => 'Product Categories',
                'instructions' => 'Coupon will be applied only to these categories',
            ])
            ->addTaxonomy('category', [
                'label' => 'Category',
                'taxonomy' => 'product_cat',
                'field_type' => 'select',
                'required' => true,
            ])
            ->endRepeater()
            ->addRepeater('excluded_product_categories', [
                'label' => 'Excluded Product Categories',
                'instructions' => 'Coupon will not be applied to these categories',
            ])
            ->addTaxonomy('category', [
                'label' => 'Category',
                'taxonomy' => 'product_cat',
                'field_type' => 'select',
                'required' => true,
            ])
            ->endRepeater()
            ->addRelationship('products', [
                'label' => 'Products',
                'instructions' => 'Coupon will be applied only to these products',
                'post_type' => PostTypeProduct::$postTypeName,
            ])
            ->addRelationship('excluded_products', [
                'label' => 'Excluded Products',
                'instructions' => 'Coupon will not be applied to these products',
                'post_type' => PostTypeProduct::$postTypeName,
            ])
            ->addTab('usage_history', ['label' => 'Usage History'])
            ->addRepeater('usage_history', [
                'label' => 'Usage History',
                'readonly' => true,
            ])
            ->addDateTimePicker('used_date', [
                'label' => 'Used Date',
                'readonly' => true,
            ])
            ->addText('order_id', [
                'label' => 'Order ID',
                'readonly' => true,
            ])
            ->addText('user_id', [
                'label' => 'User ID',
                'readonly' => true,
            ])
            ->addNumber('discount_amount_used', [
                'label' => 'Discount Amount Used',
                'readonly' => true,
            ])
            ->endRepeater()
        ;
    }

    protected function addFields(): void
    {
    }

    protected function addFieldsRelations(): void
    {
    }

    protected function addFieldsSettings(): void
    {
    }
}
