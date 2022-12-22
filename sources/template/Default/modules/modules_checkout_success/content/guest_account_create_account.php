<?php
  /**
 *
 *  @copyright 2008 - https://www.clicshopping.org
 *  @Brand : ClicShopping(Tm) at Inpi all right Reserved
 *  @Licence GPL 2 & MIT
 *  @licence MIT - Portion of osCommerce 2.4
 *  @Info : https://www.clicshopping.org/forum/trademark/
 *
 */

  use ClicShopping\OM\CLICSHOPPING;
  use ClicShopping\OM\HTML;
?>
<div class="col-md-<?php echo $content_width; ?>">
  <div class="separator"></div>
  <div class="card">
    <div class="card-header"><?php echo CLICSHOPPING::getDef('module_checkout_success_success_guest_account_create_account_heading'); ?></div>
    <div class="separator"></div>
    <div class="col-md-12">
      <div><?php echo CLICSHOPPING::getDef('create_account_checkout_success_guest_account_create_account_body', ['store_name' => STORE_NAME]); ?></div>
      <div class="separator"></div>
      <div class="separator"></div>
      <div class="ClicShoppingCheckoutSuccessText">
<?php
  if ($guest_account == 1) {
    echo CLICSHOPPING::getDef('module_checkout_success_create_account_success_text') . ' ';
    echo $form;

    echo '<label for="buttonSuccess">' . HTML::button(CLICSHOPPING::getDef('module_checkout_success_create_account_success_button'), null, null, 'primary', null, 'sm') . '</label>';
    echo $endform;
  }
?>
      </div>
    </div>
  </div>
  <div class="separator"></div>
</div>