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

  namespace ClicShopping\Apps\Customers\GuestCustomer\Classes\ClicShoppingAdmin;

  use ClicShopping\OM\Registry;

  class Status
  {
    protected int $customers_id;
    protected int $status;

    /**
     * Status guest account
     *
     * @param string fcustomer_id, guest account
     * @return string status on or off
     * @access public
     */

    Public static function GuestCustomersStatus(int $customers_id, int $customer_guest_account)
    {
      $CLICSHOPPING_Db = Registry::get('Db');

      if ($customer_guest_account == 1) {
        return $CLICSHOPPING_Db->save('customers', ['customer_guest_account' => 0],
          ['customers_id' => (int)$customers_id]
        );
      } else {
        return -1;
      }
    }
  }