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

  require($CLICSHOPPING_Template->getTemplateFiles('breadcrumb'));
?>
<section class="create_guest_account" id="create_guest_account">
  <div class="contentContainer">
    <div class="contentText">
      <div class="page-title"><h1><?php echo CLICSHOPPING::getDef('heading_title_create_guest_account'); ?></h1></div>
      <div class="separator"></div>
      <div><?php echo $CLICSHOPPING_Template->getBlocks('modules_create_guest_account'); ?></div>
    </div>
  </div>
</section>
