###### Remove price block from the product list
```php
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
```

###### add link demo to general
```php
function hoatq_custom_link_demo_fields() {
  $field = array(
    'id' => '_link_demo_field',
    "label" => __("Link demo", "woocommerce") ,
    'data_type' => 'number',
    'custom_attributes' => array(
        'step' => 'any',
        'min' => '0'
    )
);
  woocommerce_wp_text_input($field);
}
add_action( 'woocommerce_product_options_general_product_data', 'hoatq_custom_link_demo_fields' );
```

###### save field to db
```php
function hoatq_custom_field_save($post_id){
  $link_demo_field = isset( $_POST['_link_demo_field'] ) ? $_POST['_link_demo_field'] : '';
 
  $product = wc_get_product( $post_id );
  $product->update_meta_data( '_link_demo_field', $link_demo_field );
  $product->save();
}
add_action("woocommerce_process_product_meta", "hoatq_custom_field_save");
```
###### Get a field when custom. 
```php
$product->get_meta( '_link_demo_field' )
```
###### Custom product box actions.
```php
add_action("flatsome_product_box_actions", "custom_product_box_actions");
```
