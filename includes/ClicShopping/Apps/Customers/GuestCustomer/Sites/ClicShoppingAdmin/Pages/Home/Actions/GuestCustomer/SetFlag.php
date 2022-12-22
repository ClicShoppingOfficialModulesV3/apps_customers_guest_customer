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


  namespace ClicShopping\Apps\Customers\GuestCustomer\Sites\ClicShoppingAdmin\Pages\Home\Actions\GuestCustomer;

  use ClicShopping\OM\Registry;
  use ClicShopping\OM\HTML;

  use ClicShopping\Apps\Customers\GuestCustomer\Classes\ClicShoppingAdmin\Status;

  class SetFlag extends \ClicShopping\OM\PagesActionsAbstract
  {

    public function execute()
    {
      $CLICSHOPPING_GuestCustomer = Registry::get('GuestCustomer');

      $page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? (int)$_GET['page'] : 1;

      if (isset($_GET['id'])) $ciD = HTML::sanitize($_GET['id']);
      if (isset($_GET['flag'])) $flag = HTML::sanitize($_GET['flag']);

      Status::GuestCustomersStatus($ciD, $flag);

      $CLICSHOPPING_GuestCustomer->redirect('GuestCustomer&page=' . $page . '&cID=' . $ciD);
    }
  }

