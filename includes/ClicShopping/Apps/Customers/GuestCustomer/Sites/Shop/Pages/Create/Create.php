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

  namespace ClicShopping\Apps\Customers\GuestCustomer\Sites\Shop\Pages\Create;

  use ClicShopping\OM\Registry;

  use ClicShopping\Apps\Customers\GuestCustomer\GuestCustomer as GuestCustomerApp;

  class Create extends \ClicShopping\OM\PagesAbstract
  {
    public mixed $app;

    protected function init()
    {
      if (!Registry::exists('GuestCustomer')) {
        Registry::set('GuestCustomer', new GuestCustomerApp());
      }

      $CLICSHOPPING_GuestCustomer = Registry::get('GuestCustomer');

      $CLICSHOPPING_GuestCustomer->loadDefinitions('Sites/Shop/main');
    }
  }