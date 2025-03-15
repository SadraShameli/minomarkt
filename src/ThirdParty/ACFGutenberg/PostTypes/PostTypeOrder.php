<?php

namespace App\ThirdParty\ACFGutenberg\PostTypes;

use App\ThirdParty\ACFGutenberg\Base\BasePostType;

class PostTypeOrder extends BasePostType
{
    public static string $postTypeName = 'order';

    public static string $pluralName = 'Orders';

    public static string $singularName = 'Order';

    public static string $slug = 'orders';

    public static string $menuIcon = 'dashicons-cart';

    protected function addFieldsContent(): void
    {
        $this->fields
            ->addText('order_number', [
                'label' => 'Order Number',
                'required' => true,
            ])
            ->addSelect('order_status', [
                'label' => 'Order Status',
                'choices' => [
                    'pending' => 'Pending',
                    'processing' => 'Processing',
                    'completed' => 'Completed',
                    'cancelled' => 'Cancelled',
                    'refunded' => 'Refunded',
                    'failed' => 'Failed',
                    'on-hold' => 'On Hold',
                ],
                'required' => true,
            ])
            ->addDateTimePicker('order_date', [
                'label' => 'Order Date',
                'required' => true,
            ])
            ->addNumber('order_total', [
                'label' => 'Order Total',
                'required' => true,
            ])
            ->addRepeater('order_items', [
                'label' => 'Order Items',
                'button_label' => 'Add Item',
            ])
            ->addPostObject('product', [
                'label' => 'Product',
                'post_type' => PostTypeProduct::$postTypeName,
                'required' => true,
            ])
            ->addNumber('quantity', [
                'label' => 'Quantity',
                'required' => true,
                'min' => 1,
            ])
            ->addNumber('price', [
                'label' => 'Price',
                'required' => true,
            ])
            ->endRepeater()
            ->addTab('customer_details', ['label' => 'Customer Details'])
            ->addText('customer_name', [
                'label' => 'Customer Name',
                'required' => true,
            ])
            ->addEmail('customer_email', [
                'label' => 'Customer Email',
                'required' => true,
            ])
            ->addText('customer_phone', [
                'label' => 'Customer Phone',
            ])
            ->addTab('billing_details', ['label' => 'Billing Details'])
            ->addText('billing_address', [
                'label' => 'Billing Address',
                'required' => true,
            ])
            ->addText('billing_city', [
                'label' => 'Billing City',
                'required' => true,
            ])
            ->addText('billing_state', [
                'label' => 'Billing State',
                'required' => true,
            ])
            ->addText('billing_postcode', [
                'label' => 'Billing Postcode',
                'required' => true,
            ])
            ->addText('billing_country', [
                'label' => 'Billing Country',
                'required' => true,
            ])
            ->addTab('shipping_details', ['label' => 'Shipping Details'])
            ->addText('shipping_address', [
                'label' => 'Shipping Address',
                'required' => true,
            ])
            ->addText('shipping_city', [
                'label' => 'Shipping City',
                'required' => true,
            ])
            ->addText('shipping_state', [
                'label' => 'Shipping State',
                'required' => true,
            ])
            ->addText('shipping_postcode', [
                'label' => 'Shipping Postcode',
                'required' => true,
            ])
            ->addText('shipping_country', [
                'label' => 'Shipping Country',
                'required' => true,
            ])
            ->addTab('payment_details', ['label' => 'Payment Details'])
            ->addSelect('payment_method', [
                'label' => 'Payment Method',
                'choices' => [
                    'credit_card' => 'Credit Card',
                    'paypal' => 'PayPal',
                    'bank_transfer' => 'Bank Transfer',
                    'cash_on_delivery' => 'Cash on Delivery',
                ],
                'required' => true,
            ])
            ->addText('transaction_id', [
                'label' => 'Transaction ID',
            ])
            ->addTab('notes', ['label' => 'Order Notes'])
            ->addTextarea('customer_notes', [
                'label' => 'Customer Notes',
            ])
            ->addTextarea('admin_notes', [
                'label' => 'Admin Notes',
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
