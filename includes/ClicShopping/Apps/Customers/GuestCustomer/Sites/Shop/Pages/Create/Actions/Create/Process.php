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

  namespace ClicShopping\Apps\Customers\GuestCustomer\Sites\Shop\Pages\Create\Actions\Create;

  use ClicShopping\OM\CLICSHOPPING;
  use ClicShopping\OM\Registry;
  use ClicShopping\OM\HTML;
  use ClicShopping\OM\HTTP;

  use ClicShopping\OM\Is;
  use ClicShopping\OM\Hash;

  use ClicShopping\Apps\Tools\ActionsRecorder\Classes\Shop\ActionRecorder;
  use ClicShopping\Apps\Configuration\TemplateEmail\Classes\Shop\TemplateEmail;

  class Process extends \ClicShopping\OM\PagesActionsAbstract
  {
    public function execute()
    {
      $CLICSHOPPING_Db = Registry::get('Db');
      $CLICSHOPPING_Customer = Registry::get('Customer');
      $CLICSHOPPING_MessageStack = Registry::get('MessageStack');
      $CLICSHOPPING_ShoppingCart = Registry::get('ShoppingCart');
      $CLICSHOPPING_Mail = Registry::get('Mail');
      $CLICSHOPPING_Language = Registry::get('Language');
      $CLICSHOPPING_Hooks = Registry::get('Hooks');

      $_SESSION['process'] = false;

      if (isset($_POST['action']) && ($_POST['action'] == 'process') && isset($_POST['formid']) && ($_POST['formid'] === $_SESSION['sessiontoken'])) {
        $error = false;
        $_SESSION['process'] = true;

        $CLICSHOPPING_Hooks->call('CreateGuest', 'PreAction');

        if (isset($_POST['firstname'])) {
          $firstname = HTML::sanitize($_POST['firstname']);
        }

        if (isset($_POST['lastname'])) {
          $lastname = HTML::sanitize($_POST['lastname']);
        }

        if (isset($_POST['email_address'])) {
          $email_address = HTML::sanitize($_POST['email_address']);
        }

        if (isset($_POST['email_address_confirm'])) {
          $email_address_confirm = HTML::sanitize($_POST['email_address_confirm']);
        }

        if (isset($_POST['postcode'])) {
          $postcode = HTML::sanitize($_POST['postcode']);
        }

        if (isset($_POST['city'])) {
          $city = HTML::sanitize($_POST['city']);
        }

        if (isset($_POST['street_address'])) {
          $street_address = HTML::sanitize($_POST['street_address']);
        }

        if (isset($_POST['suburb'])) {
          $suburb = HTML::sanitize($_POST['suburb']);
        }

        if (isset($_POST['create_account'])) {
          $create_account = 1;
        } else {
          $create_account = 0;
        }

        if (isset($_POST['country'])) {
          $country = HTML::sanitize($_POST['country']);
        }

        if (isset($_POST['telephone'])) {
          $telephone = HTML::sanitize($_POST['telephone']);
        }

        if (isset($_POST['cellular_phone'])) {
          $cellular_phone = HTML::sanitize($_POST['cellular_phone']);
        }

        if (isset($_POST['newsletter'])) {
          $newsletter = 1;
        } else {
          $newsletter = 0;
        }

        if (isset($_POST['customer_agree_privacy'])) {
          $customer_agree_privacy = HTML::sanitize($_POST['customer_agree_privacy']);
        }

        if (ACCOUNT_STATE == 'true') {
          if (isset($_POST['state'])) {
            $state = HTML::sanitize($_POST['state']);
          } else {
            $state = null;
          }

          if (isset($_POST['zone_id'])) {
            $zone_id = HTML::sanitize($_POST['zone_id']);
          }
        }

        if (DISPLAY_PRIVACY_CONDITIONS == 'true') {
          if ($customer_agree_privacy != 'on') {
            $error = true;

            $CLICSHOPPING_MessageStack->add(CLICSHOPPING::getDef('entry_agreement_check_error'), 'error');
          }
        }

// Clients B2C : Controle entree du prenom
        if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
          $error = true;

          $CLICSHOPPING_MessageStack->add(CLICSHOPPING::getDef('entry_first_name_error', ['min_length' => ENTRY_FIRST_NAME_MIN_LENGTH]), 'error');
        }

// Clients B2C : Controle entree du nom de famille
        if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
          $error = true;

          $CLICSHOPPING_MessageStack->add(CLICSHOPPING::getDef('entry_last_name_error', ['min_length' => ENTRY_LAST_NAME_MIN_LENGTH]), 'error');
        }

// Clients B2C : Controle entree adresse e-mail
        if (Is::EmailAddress($email_address) === false) {
          $error = true;

          $CLICSHOPPING_MessageStack->add(CLICSHOPPING::getDef('entry_email_address_check_error', ['min_length' => ENTRY_EMAIL_ADDRESS_MIN_LENGTH]), 'error', 'create_guest_account');

        } elseif ($email_address != $email_address_confirm) {
          $error = true;
          $CLICSHOPPING_MessageStack->add(CLICSHOPPING::getDef('entry_email_address_confirm_not_matching'), 'danger', 'create_guest_account');
        } else {
          $QcheckEmail = $CLICSHOPPING_Db->prepare('select customers_id,
                                                           customer_guest_account
                                                    from :table_customers
                                                    where customers_email_address = :customers_email_address
                                                   ');
          $QcheckEmail->bindValue(':customers_email_address', $email_address);

          $QcheckEmail->execute();

          $check_customer_id = $QcheckEmail->valueInt('customers_id');
          $customer_guest_account = $QcheckEmail->value('customer_guest_account');

          if ($QcheckEmail->fetch() !== false) {
            $error = true;

            $CLICSHOPPING_MessageStack->add(CLICSHOPPING::getDef('entry_email_address_error_exists'), 'error', 'create_guest_account');
          }

          if (CLICSHOPPING_APP_CUSTOMERS_GUEST_CUSTOMER_GC_FORCE_EMAIL == 'True' && $customer_guest_account == 1 && $error === true) {
            $error = false;
            $accept_guest_customer = true;
            $accept_guest_customer_id = $check_customer_id;
          } else {
            $accept_guest_customer = false;
          }
        }

        if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
          $error = true;

          $CLICSHOPPING_MessageStack->add(CLICSHOPPING::getDef('entry_street_address_error', ['min_length' => ENTRY_STREET_ADDRESS_MIN_LENGTH]), 'error');
        }

        if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
          $error = true;

          $CLICSHOPPING_MessageStack->add(CLICSHOPPING::getDef('entry_post_code_error', ['min_length' => ENTRY_POSTCODE_MIN_LENGTH]), 'danger', 'error');
        }

        if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
          $error = true;

          $CLICSHOPPING_MessageStack->add(CLICSHOPPING::getDef('entry_city_error', ['min_length' => ENTRY_CITY_MIN_LENGTH]), 'error');
        }

        if (!is_numeric($country)) {
          $Qcheck = $CLICSHOPPING_Db->prepare('select countries_id
                                               from :table_countries
                                               where countries_iso_code_2 = :countries_iso_code_2
                                              ');
          $Qcheck->bindValue(':countries_iso_code_2', $country);
          $Qcheck->execute();

          $country = $Qcheck->valueInt('countries_id');
          $_SESSION['country'] = $country;
        }

       if (ACCOUNT_STATE == 'true' && is_numeric($country)) {
          $zone_id = 0;

          $Qcheck = $CLICSHOPPING_Db->prepare('select count(*) as total
                                               from :table_zones
                                               where zone_country_id = :zone_country_id
                                              ');
          $Qcheck->bindInt(':zone_country_id', $country);
          $Qcheck->execute();

          $_SESSION['entry_state_has_zones'] = ($Qcheck->valueInt('total') > 0);

          if ($_SESSION['entry_state_has_zones'] === true) {
            if (ACCOUNT_STATE_DROPDOWN == 'true') {
              $Qzone = $CLICSHOPPING_Db->prepare('select distinct zone_id
                                                   from :table_zones
                                                   where zone_country_id = :zone_country_id
                                                   and zone_id = :zone_id
                                                   and zone_status = 0
                                                 ');

              $Qzone->bindInt(':zone_country_id', $country);
              $Qzone->bindInt(':zone_id', $state);
              $Qzone->execute();
            } else {
              if (!is_numeric($state)) {
                $Qzone = $CLICSHOPPING_Db->prepare('select distinct zone_id
                                                    from :table_zones
                                                    where zone_country_id = :zone_country_id
                                                    and zone_name = :zone_name
                                                    and zone_status = 0
                                                  ');
                $Qzone->bindInt(':zone_country_id', $country);
                $Qzone->bindValue(':zone_name', $state);

                $Qzone->execute();
              } else {
                $Qzone = $CLICSHOPPING_Db->prepare('select distinct zone_id
                                                  from :table_zones
                                                  where zone_country_id = :zone_country_id
                                                  and zone_id = :zone_id
                                                  and zone_status = 0
                                                ');
                $Qzone->bindInt(':zone_country_id', $country);
                $Qzone->bindValue(':zone_id', $state);

                $Qzone->execute();
              }
            }

            if (!empty($Qzone->valueInt('zone_id')) || !is_null($Qzone->valueInt('zone_id'))) {
              $zone_id = (int)$Qzone->valueInt('zone_id');
            } else {
              $error = true;

              $CLICSHOPPING_MessageStack->add(CLICSHOPPING::getDef('entry_state_error_select'), 'error');
            }
          } else {
            if ((strlen($state) < ENTRY_STATE_MIN_LENGTH)) {
              if (strlen($state) === 0) {
                $error = false;
              } else {
                $error = true;
                $CLICSHOPPING_MessageStack->add(CLICSHOPPING::getDef('entry_state_error', ['min_length' => ENTRY_STATE_MIN_LENGTH]), 'error');
              }

            }
          }
        }

        if (strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
          $error = true;

          $CLICSHOPPING_MessageStack->add(CLICSHOPPING::getDef('entry_telephone_number_error', ['min_length' => ENTRY_TELEPHONE_MIN_LENGTH]), 'error');
        }

        Registry::set('ActionRecorder', new ActionRecorder('ar_create_guest_account', ($CLICSHOPPING_Customer->isLoggedOn() ? $CLICSHOPPING_Customer->getID() : null), $lastname));
        $CLICSHOPPING_ActionRecorder = Registry::get('ActionRecorder');

        if (!$CLICSHOPPING_ActionRecorder->canPerform()) {
          $error = true;
          $CLICSHOPPING_ActionRecorder->record(false);

          $CLICSHOPPING_MessageStack->add(CLICSHOPPING::getDef('error_action_recorder', ['module_action_recorder_create_guest_account_email_minutes' => (defined('MODULE_ACTION_RECORDER_CREATE_GUEST_ACCOUNT_EMAIL_MINUTES') ? (int)MODULE_ACTION_RECORDER_CREATE_GUEST_ACCOUNT_EMAIL_MINUTES : 15)]), 'danger', 'create_guest_account');
        }

        if ($error === false) {
          $newpass = Hash::getRandomString(ENTRY_PASSWORD_MIN_LENGTH);
          $crypted_password = Hash::encrypt($newpass);

          if ($create_account == 1) {
            $create_account = 0;
          } else {
            $create_account = 1;
          }

          if (CLICSHOPPING_APP_CUSTOMERS_GUEST_CUSTOMER_GC_AUTO_CONVERT == 'True') {
            $create_account = 0;
          }

          if ($accept_guest_customer === true) {
            $customer_id = $accept_guest_customer_id;

            $sql_data_customer_array = [
              'customers_firstname' => $firstname,
              'customers_lastname' => $lastname,
              'customers_email_address' => $email_address,
              'customers_telephone' => $telephone,
              'customers_newsletter' => $newsletter,
              'customers_password' => $crypted_password,
              'languages_id' => (int)$CLICSHOPPING_Language->getId(),
              'member_level' => 1,
              'client_computer_ip' => HTTP::getIPAddress(),
              'provider_name_client' => HTTP::getProviderNameCustomer(),
              'customer_guest_account' => (int)$create_account,
            ];

            $update_customer_array = ['customers_id' => $customer_id];

            $CLICSHOPPING_Db->save('customers', $sql_data_customer_array, $update_customer_array);

            $sql_data_array = [
              'entry_firstname' => $firstname,
              'entry_lastname' => $lastname,
              'entry_street_address' => $street_address,
              'entry_postcode' => $postcode,
              'entry_city' => $city,
              'entry_country_id' => (int)$country
            ];

            if (ACCOUNT_SUBURB == 'true') $sql_data_array['entry_suburb'] = $suburb;

            if (ACCOUNT_STATE == 'true') {
              if ($zone_id > 0) {
                $sql_data_array['entry_zone_id'] = (int)$zone_id;
                $sql_data_array['entry_state'] = '';
              } else {
                $sql_data_array['entry_zone_id'] = 0;
                $sql_data_array['entry_state'] = $state;
              }
            }

            $update_address_array = ['customers_id' => $customer_id];

            $CLICSHOPPING_Db->save('address_book', $sql_data_array, $update_address_array);

            $sql_info_array = [
              'customers_info_number_of_logons' => 0,
              'customers_info_date_of_last_logon' => 'now()',
              'customers_info_date_account_last_modified' => 'now()',
            ];
            $update_info_array = ['customers_info_id' => $customer_id];

            $CLICSHOPPING_Db->save('customers_info', $sql_info_array, $update_info_array);
          } else {
//new guest
            $sql_data_array = [
              'customers_firstname' => $firstname,
              'customers_lastname' => $lastname,
              'customers_email_address' => $email_address,
              'customers_telephone' => $telephone,
              'customers_newsletter' => $newsletter,
              'customers_password' => $crypted_password,
              'languages_id' => (int)$CLICSHOPPING_Language->getId(),
              'member_level' => 1,
              'customers_default_address_id' => 1,
              'client_computer_ip' => HTTP::getIPAddress(),
              'provider_name_client' => HTTP::getProviderNameCustomer(),
              'customer_guest_account' => (int)$create_account,
            ];

            if (ACCOUNT_CELLULAR_PHONE == 'true') $sql_data_array['customers_cellular_phone'] = $cellular_phone;

            $sql_data_array['customers_group_id'] = 0;

            $CLICSHOPPING_Db->save('customers', $sql_data_array);

            $customer_id = $CLICSHOPPING_Db->lastInsertId();

            $sql_data_array =
              ['customers_id' => (int)$customer_id,
              'entry_firstname' => $firstname,
              'entry_lastname' => $lastname,
              'entry_street_address' => $street_address,
              'entry_postcode' => $postcode,
              'entry_city' => $city,
              'entry_country_id' => (int)$country
            ];

            if (ACCOUNT_SUBURB == 'true') $sql_data_array['entry_suburb'] = $suburb;

            if (ACCOUNT_STATE == 'true') {
              if ($zone_id > 0) {
                $sql_data_array['entry_zone_id'] = (int)$zone_id;
                $sql_data_array['entry_state'] = '';
              } else {
                $sql_data_array['entry_zone_id'] = 0;
                $sql_data_array['entry_state'] = $state;
              }
            }

            $CLICSHOPPING_Db->save('address_book', $sql_data_array);

            $address_id = $CLICSHOPPING_Db->lastInsertId();

            $CLICSHOPPING_Db->save('customers', ['customers_default_address_id' => (int)$address_id],
              ['customers_id' => (int)$customer_id]
            );

            $sql_array = [
              'customers_info_id' => (int)$customer_id,
              'customers_info_number_of_logons' => 0,
              'customers_info_date_account_created' => 'now()'
            ];

            $CLICSHOPPING_Db->save('customers_info', $sql_array);
          }

//open session
          $CLICSHOPPING_Customer->setData($customer_id);

          Registry::get('Session')->recreate();

// restore cart contents
          $CLICSHOPPING_ShoppingCart->getRestoreContents();

// build the message content
          if ($create_account == 0) {
            $name = $firstname . ' ' . $lastname;
            $template_email_welcome_catalog = CLICSHOPPING::getDef('email_welcome_guest_checkout', ['store_name' => STORE_NAME]);
            $email_coupon = CLICSHOPPING::getDef('text_password', ['password' => $newpass]);

            if (CLICSHOPPING_APP_CUSTOMERS_GUEST_CUSTOMER_GC_COUPON == 'True') {
              if (!empty(COUPON_CUSTOMER)) {
                $email_coupon_catalog = TemplateEmail::getTemplateEmailCouponCatalog();
                $email_coupon .= $email_coupon_catalog . COUPON_CUSTOMER;
              }
            }

// Content email
            $template_email_signature = TemplateEmail::getTemplateEmailSignature();
            $template_email_footer = TemplateEmail::getTemplateEmailTextFooter();
            $email_subject = CLICSHOPPING::getDef('email_subject', ['store_name' => STORE_NAME]);
            $email_gender = CLICSHOPPING::getDef('email_greet') . ' ' . $lastname;
            $email_text = $email_gender . ',<br /><br />' . $template_email_welcome_catalog . '<br /><br />' . $email_coupon . '<br /><br />' . $template_email_signature . '<br /><br />' . $template_email_footer;

// EEmail send
            $message = $email_text;
            $message = str_replace('src="/', 'src="' . HTTP::typeUrlDomain() . '/', $message);
            $CLICSHOPPING_Mail->addHtmlCkeditor($message);
            ;
            $from = STORE_OWNER_EMAIL_ADDRESS;
            $CLICSHOPPING_Mail->send($name, $email_address, '', $from, $email_subject);
          }

// Administrator email
          if (EMAIL_INFORMA_ACCOUNT_ADMIN == 'true') {
            $email_subject_admin = CLICSHOPPING::getDef('admin_email_subject', ['store_name' => STORE_NAME]);
            $admin_email_welcome = CLICSHOPPING::getDef('admin_email_welcome');

            $data_array = [
              'customer_name' => HTML::sanitize($_POST['lastname']),
              'customer_firstame' => HTML::sanitize($_POST['firstname']),
              'customer_mail' => HTML::sanitize($_POST['email_address'])
            ];

            $admin_email_text_admin = CLICSHOPPING::getDef('admin_email_text', $data_array);

            $email_address = STORE_OWNER_EMAIL_ADDRESS;
            $from = STORE_OWNER_EMAIL_ADDRESS;
            $admin_email_text_admin .= $admin_email_welcome . $admin_email_text_admin;
            $CLICSHOPPING_Mail->addHtmlCkeditor($admin_email_text_admin);
            ;
            $CLICSHOPPING_Mail->send(STORE_NAME, $email_address, '', $from, $email_subject_admin);
          }

          $CLICSHOPPING_ActionRecorder->record();

          $CLICSHOPPING_Hooks->call('GuestCustomer', 'Process');

          CLICSHOPPING::redirect(null, 'Checkout&Shipping');
        }
      }
    }
  }