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

  use ClicShopping\OM\HTML;
    use ClicShopping\OM\CLICSHOPPING;
?>

<div class="col-md-<?php echo $content_width; ?>">
  <div class="separator"></div>
  <div class="modulesCreateAccountguestCustomerIntroductionTextLogin"><?php echo sprintf(CLICSHOPPING::getDef('module_create_guest_account_introduction_text_origin_login', ['store_name' => STORE_NAME]), CLICSHOPPING::link(null, 'Account&LogIn&' . CLICSHOPPING::getAllGET(['Account', 'LogIn']))); ?></div>
  <div class="modulesCreateAccountguestCustomerIntroductionTextB2B"><?php echo  '<br />' . CLICSHOPPING::getDef('module_create_guest_account_introduction_text_b2c')  . '  ' . HTML::button(CLICSHOPPING::getDef('button_continue'), null, CLICSHOPPING::link(null, 'Account&Create'), 'info', null, 'sm'); ?></div>
  <div class="separator"></div>
  <div class="hr"></div>
</div>