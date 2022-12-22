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

  namespace ClicShopping\Apps\Customers\GuestCustomer\Sites\ClicShoppingAdmin\Pages\Home;

  use ClicShopping\OM\Registry;

  use ClicShopping\Apps\Customers\GuestCustomer\GuestCustomer;

  class Home extends \ClicShopping\OM\PagesAbstract
  {
    public mixed $app;

    protected function init()
    {
      $CLICSHOPPING_GuestCustomer = new GuestCustomer();
      Registry::set('GuestCustomer', $CLICSHOPPING_GuestCustomer);

      $this->app = Registry::get('GuestCustomer');

      $this->app->loadDefinitions('Sites/ClicShoppingAdmin/main');
    }
  }
