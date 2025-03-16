<?php

namespace App\ThirdParty\ACF\ACFGutenberg\PostTypes;

use App\ThirdParty\ACF\ACFFields\ReusableFields;
use App\ThirdParty\ACF\ACFGutenberg\Base\BasePostType;

class PostTypeProduct extends BasePostType
{
    public static string $postTypeName = 'product';

    public static string $pluralName = 'Products';

    public static string $singularName = 'Product';

    public static string $slug = 'product';

    public static string $menuIcon = 'dashicons-cart';

    protected function addFieldsContent(): void
    {
        $this->fields
            ->addNumber('price', [
                'label' => 'Regular Price',
                'instructions' => 'Enter the regular price of the product',
                'required' => true,
                'min' => 0,
                'step' => 0.01,
            ])
            ->addNumber('discounted_price', [
                'label' => 'Discounted Price',
                'instructions' => 'Enter the discounted price (if applicable)',
                'min' => 0,
                'step' => 0.01,
            ])
            ->addTrueFalse('on_sale', [
                'label' => 'On Sale',
                'instructions' => 'Is this product currently on sale?',
                'default_value' => 0,
                'ui' => true,
            ])
            ->addTab('inventory', ['label' => 'Inventory'])
            ->addText('sku', [
                'label' => 'SKU',
                'instructions' => 'Enter the product SKU (Stock Keeping Unit)',
                'required' => true,
            ])
            ->addNumber('stock', [
                'label' => 'Stock Quantity',
                'instructions' => 'Enter the current stock quantity',
                'required' => true,
                'min' => 0,
                'default_value' => 0,
            ])
            ->addTrueFalse('manage_stock', [
                'label' => 'Manage Stock',
                'instructions' => 'Enable stock management for this product?',
                'ui' => true,
                'default_value' => true,
            ])
            ->addSelect('stock_status', [
                'label' => 'Stock Status',
                'instructions' => 'Select the current stock status',
                'required' => true,
                'choices' => [
                    'in_stock' => 'In Stock',
                    'out_of_stock' => 'Out of Stock',
                    'on_backorder' => 'On Backorder',
                ],
                'default_value' => 'in_stock',
            ])
            ->addTab('description', ['label' => 'Description'])
            ->addFields(ReusableFields::wysiwyg('product_description', 'Product Description', [
                'instructions' => 'Enter the full product description',
                'media_upload' => 1,
            ]))
            ->addFields(ReusableFields::wysiwyg('short_description', 'Short Description', [
                'instructions' => 'Enter a short description for product listings',
                'toolbar' => 'basic',
            ]))
            ->addTab('gallery', ['label' => 'Gallery'])
            ->addGallery('product_gallery', [
                'label' => 'Product Gallery',
                'instructions' => 'Add additional product images',
                'min' => 0,
                'max' => 10,
                'return_format' => 'array',
            ])
            ->addTab('specifications', ['label' => 'Specifications'])
            ->addRepeater('specifications', [
                'label' => 'Product Specifications',
                'instructions' => 'Add product specifications',
                'button_label' => 'Add Specification',
                'min' => 0,
            ])
            ->addText('spec_name', [
                'label' => 'Specification Name',
                'required' => true,
            ])
            ->addText('spec_value', [
                'label' => 'Specification Value',
                'required' => true,
            ])
            ->endRepeater()
            ->addTab('shipping', ['label' => 'Shipping'])
            ->addNumber('weight', [
                'label' => 'Weight (kg)',
                'instructions' => 'Enter the product weight in kilograms',
                'min' => 0,
                'step' => 0.01,
            ])
            ->addGroup('dimensions', [
                'label' => 'Dimensions',
            ])
            ->addNumber('length', [
                'label' => 'Length (cm)',
                'min' => 0,
                'step' => 0.1,
            ])
            ->addNumber('width', [
                'label' => 'Width (cm)',
                'min' => 0,
                'step' => 0.1,
            ])
            ->addNumber('height', [
                'label' => 'Height (cm)',
                'min' => 0,
                'step' => 0.1,
            ])
            ->endGroup()
            ->addTrueFalse('requires_shipping', [
                'label' => 'Requires Shipping',
                'instructions' => 'Does this product need to be shipped?',
                'ui' => true,
                'default_value' => true,
            ])
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
