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

  namespace ClicShopping\Apps\Customers\GuestCustomer\Module\Hooks\Shop\OrderConditions;

  use ClicShopping\OM\Registry;
  use ClicShopping\OM\CLICSHOPPING;

  use ClicShopping\Apps\Customers\GuestCustomer\GuestCustomer as GuestCustomerApp;

  class PreAction implements \ClicShopping\OM\Modules\HooksInterface
  {
    protected $app;

    public function __construct()
    {
      if (!Registry::exists('GuestCustomerApp')) {
        Registry::set('GuestCustomerApp', new GuestCustomerApp());
      }

      $this->app = Registry::get('GuestCustomerApp');
    }

    public function execute()
    {
      $CLICSHOPPING_Customer = Registry::get('Customer');

      if ($CLICSHOPPING_Customer->getCustomerGuestAccount($CLICSHOPPING_Customer->getID()) == 1) {
        CLICSHOPPING::redirect(null, 'Account&LogOff');
      }
    }
  }