<?php
  /**
   *
   * @copyright 2008 - https://www.clicshopping.org
   * @Brand : ClicShopping(Tm) at Inpi all right Reserved
   * @Licence GPL 2 & MIT
   * @licence MIT - Portion of osCommerce 2.4
   * @Info : https://www.clicshopping.org/forum/trademark/
   *
   */

  use ClicShopping\OM\CLICSHOPPING;
  use ClicShopping\OM\Registry;

  $CLICSHOPPING_Breadcrumb = Registry::get('Breadcrumb');
  $CLICSHOPPING_Template = Registry::get('Template');
  $CLICSHOPPING_Language = Registry::get('Language');

  $CLICSHOPPING_Language->loadDefinitions('create_guest_account');

  // templates
  $CLICSHOPPING_Breadcrumb->add(CLICSHOPPING::getDef('navbar_title'), CLICSHOPPING::link(null, 'GuestCustomer&Create'));

  require_once($CLICSHOPPING_Template->getTemplateHeaderFooter('header'));

  require_once($CLICSHOPPING_Template->getTemplateFiles('create_guest_account'));

  require_once($CLICSHOPPING_Template->getTemplateHeaderFooter('footer'));