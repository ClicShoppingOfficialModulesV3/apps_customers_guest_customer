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

  namespace ClicShopping\Apps\Customers\GuestCustomer\Sites\Shop\Pages\Create\Actions;

  use ClicShopping\OM\CLICSHOPPING;
  use ClicShopping\OM\Registry;

  class Create extends \ClicShopping\OM\PagesActionsAbstract
  {
    public function execute()
    {
      $CLICSHOPPING_Template = Registry::get('Template');
      $CLICSHOPPING_Breadcrumb = Registry::get('Breadcrumb');
      $CLICSHOPPING_GuestCustomer = Registry::get('GuestCustomer');

// templates
      $this->page->setFile('main.php');
//Content
      $this->page->data['content'] = $CLICSHOPPING_Template->getTemplateFiles('create_guest_account');
      $this->page->data['action'] = 'Process';
//language
      $CLICSHOPPING_GuestCustomer->loadDefinitions('Sites/Shop/Create/guest');

      $CLICSHOPPING_Breadcrumb->add($CLICSHOPPING_GuestCustomer->getDef('navbar_title'), CLICSHOPPING::link(null, 'GuestCustomer&Create'));
    }
  }