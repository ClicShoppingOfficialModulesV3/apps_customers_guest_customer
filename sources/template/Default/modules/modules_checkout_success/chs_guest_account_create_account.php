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

  use ClicShopping\OM\Registry;
  use ClicShopping\OM\CLICSHOPPING;
  use ClicShopping\OM\HTML;

  class chs_guest_account_create_account {
    public $code;
    public $group;
    public $title;
    public $description;
    public $sort_order;
    public $enabled = false;
    protected $customer;

    public function __construct() {
      $this->code = get_class($this);
      $this->group = basename(__DIR__);
      $this->customer = Registry::get('Customer');

      $this->title = CLICSHOPPING::getDef('module_checkout_success_guest_account_create_account_title');
      $this->description = CLICSHOPPING::getDef('module_checkout_success_guest_account_create_account_description');

      if ( defined('MODULE_CHECKOUT_SUCCESS_GUEST_ACCOUNT_CREATE_ACCOUNT_STATUS')) {
        $this->sort_order = defined('MODULE_CHECKOUT_SUCCESS_GUEST_ACCOUNT_CREATE_ACCOUNT_SORT_ORDER') ? MODULE_CHECKOUT_SUCCESS_GUEST_ACCOUNT_CREATE_ACCOUNT_SORT_ORDER : 0;
        $this->enabled = (MODULE_CHECKOUT_SUCCESS_GUEST_ACCOUNT_CREATE_ACCOUNT_STATUS == 'True');
      }
    }

    public function execute() {
      $CLICSHOPPING_Template = Registry::get('Template');

      if ($this->customer->getCustomerGuestAccount($this->customer->getID()) == 0){
        return false;
      }

      if (isset($_GET['Checkout']) && isset($_GET['Success'])) {
        if ($this->customer->getCustomerGuestAccount($this->customer->getID()) == 1) {
          $guest_account = 1;
        } else {
          $guest_account = 0;
        }

        if ($guest_account == 1) {
          $form =  HTML::form('guest', CLICSHOPPING::link(null, 'GuestCustomer&Success'), 'post', 'id="guest"',  ['tokenize' => true, 'action' => 'process']);
          $endform = '</form>';

          $content_width = (int)MODULE_CHECKOUT_SUCCESS_GUEST_ACCOUNT_CREATE_ACCOUNT_CONTENT_WIDTH;

          $guest_account_create_account = '<!-- cs_guest_account_create_account start -->' . "\n";

          ob_start();

          require_once($CLICSHOPPING_Template->getTemplateModules($this->group . '/content/guest_account_create_account'));
          $guest_account_create_account .= ob_get_clean();

          $guest_account_create_account .= '<!-- cs_guest_account_create_account end -->' . "\n";

          $CLICSHOPPING_Template->addBlock($guest_account_create_account, $this->group);
        }
      }
    }

    public function isEnabled() {
      return $this->enabled;
    }

    public function check() {
      return defined('MODULE_CHECKOUT_SUCCESS_GUEST_ACCOUNT_CREATE_ACCOUNT_STATUS');
    }

    public function install() {
      $CLICSHOPPING_Db = Registry::get('Db');

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Enable This module',
          'configuration_key' => 'MODULE_CHECKOUT_SUCCESS_GUEST_ACCOUNT_CREATE_ACCOUNT_STATUS',
          'configuration_value' => 'True',
          'configuration_description' => 'Display the module on Checkout Success ?',
          'configuration_group_id' => '6',
          'sort_order' => '1',
          'set_function' => 'clic_cfg_set_boolean_value(array(\'True\', \'False\'))',
          'date_added' => 'now()'
        ]
      );

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Select the width to display?',
          'configuration_key' => 'MODULE_CHECKOUT_SUCCESS_GUEST_ACCOUNT_CREATE_ACCOUNT_CONTENT_WIDTH',
          'configuration_value' => '12',
          'configuration_description' => 'select a number between 1 and 12',
          'configuration_group_id' => '6',
          'sort_order' => '1',
          'set_function' => 'clic_cfg_set_content_module_width_pull_down',
          'date_added' => 'now()'
        ]
      );

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Sort Order',
          'configuration_key' => 'MODULE_CHECKOUT_SUCCESS_GUEST_ACCOUNT_CREATE_ACCOUNT_SORT_ORDER',
          'configuration_value' => '20',
          'configuration_description' => 'Sort order of display. Lowest is displayed first. The sort order must be different on every module',
          'configuration_group_id' => '6',
          'sort_order' => '3',
          'set_function' => '',
          'date_added' => 'now()'
        ]
      );
    }

    public function remove() {
      return Registry::get('Db')->exec('delete from :table_configuration where configuration_key in ("' . implode('", "', $this->keys()) . '")');
    }

    public function keys() {
      return array('MODULE_CHECKOUT_SUCCESS_GUEST_ACCOUNT_CREATE_ACCOUNT_STATUS',
                   'MODULE_CHECKOUT_SUCCESS_GUEST_ACCOUNT_CREATE_ACCOUNT_CONTENT_WIDTH',
                   'MODULE_CHECKOUT_SUCCESS_GUEST_ACCOUNT_CREATE_ACCOUNT_SORT_ORDER'
                  );
    }
  }

