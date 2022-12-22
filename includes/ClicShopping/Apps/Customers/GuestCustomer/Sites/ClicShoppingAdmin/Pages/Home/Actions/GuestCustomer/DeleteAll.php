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

  class DeleteAll extends \ClicShopping\OM\PagesActionsAbstract
  {
    protected $app;

    public function __construct()
    {
      $this->app = Registry::get('GuestCustomer');
    }

    public function execute()
    {
      $page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? (int)$_GET['page'] : 1;

      if (isset($_POST['selected'])) {
        foreach ($_POST['selected'] as $id) {

          $this->app->db->delete('address_book', ['customers_id' => $id]);
          $this->app->db->delete('customers', ['customers_id' => $id]);
          $this->app->db->delete('customers_info', ['customers_info_id' => $id]);
          $this->app->db->delete('customers_basket', ['customers_id' => $id]);
          $this->app->db->delete('customers_basket_attributes', ['customers_id' => $id]);
          $this->app->db->delete('whos_online', ['customer_id' => $id]);

          if (isset($_POST['delete_reviews'])) {
            $Qreviews = $this->app->db->get('reviews', 'reviews_id', ['customers_id' => $id]);

            while ($Qreviews->fetch()) {
              $this->app->db->delete('reviews_description', ['reviews_id' => (int)$Qreviews->valueInt('reviews_id')]);
            }

            $this->app->db->delete('reviews', ['customers_id' => $id]);
          } else {
            $this->app->db->save('reviews', ['customers_id' => 'null'], ['customers_id' => $id]);
          }
        }
      }

      $this->app->redirect('Customers', 'page=' . $page);

      $this->app->redirect('GuestCustomer&GuestCustomer');
    }
  }
