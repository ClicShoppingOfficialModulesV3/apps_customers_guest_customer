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
  use ClicShopping\OM\Hash;

  use ClicShopping\Apps\Configuration\TemplateEmail\Classes\Shop\TemplateEmail;

  class Success extends \ClicShopping\OM\PagesActionsAbstract
  {
    public function execute()
    {
      $CLICSHOPPING_Db = Registry::get('Db');
      $CLICSHOPPING_Mail = Registry::get('Mail');
      $CLICSHOPPING_Customer = Registry::get('Customer');
      $CLICSHOPPING_Language = Registry::get('Language');

      $CLICSHOPPING_Language->loadDefinitions('create_guest_checkout_success');

      if (isset($_POST['action']) && ($_POST['action'] == 'process') && isset($_POST['formid']) && ($_POST['formid'] === $_SESSION['sessiontoken'])) {
        $QcheckCustomer = $CLICSHOPPING_Db->prepare('select customers_firstname,
                                                                     customers_lastname,
                                                                     customers_password,
                                                                     customers_id,
                                                                     customers_email_address
                                                               from :table_customers
                                                               where customers_id = :customers_id
                                                             ');
        $QcheckCustomer->bindInt(':customers_id', $CLICSHOPPING_Customer->getId());
        $QcheckCustomer->execute();

        if (!empty($QcheckCustomer->value('customers_email_address'))) {
// Crypted password mods - create a new password, update the database and mail it to them
          $newpass = Hash::getRandomString(ENTRY_PASSWORD_MIN_LENGTH);
          $crypted_password = Hash::encrypt($newpass);

          $Qupdate = $CLICSHOPPING_Db->prepare('update :table_customers
                                                           set customers_password = :customers_password,
                                                               customer_guest_account = 0
                                                           where customers_id = :customers_id
                                                          ');
          $Qupdate->bindValue(':customers_password', $crypted_password);
          $Qupdate->bindInt(':customers_id', (int)$QcheckCustomer->valueInt('customers_id'));
          $Qupdate->execute();

//delete guest customer
          $text_password_body = CLICSHOPPING::getDef('email_password_reminder_body', [
            'username' => $QcheckCustomer->value('customers_email_address'),
            'store_name' => STORE_NAME,
            'password' => $newpass,
            'store_name_address' => STORE_NAME_ADDRESS,
            'store_owner_email_address' => STORE_OWNER_EMAIL_ADDRESS
            ]
          );

          $subject = CLICSHOPPING::getDef('email_reminder_subject', ['store_name' => STORE_NAME]);

          $message = CLICSHOPPING::getDef('email_introduction');
          $message .= $text_password_body;
          $message .= TemplateEmail::getTemplateEmailSignature();
          $message .= TemplateEmail::getTemplateEmailTextFooter();

          $CLICSHOPPING_Mail->clicMail($QcheckCustomer->value('customers_firstname') . ' ' . $QcheckCustomer->value('customers_lastname'), $QcheckCustomer->value('customers_email_address'), $subject, $message, STORE_NAME, STORE_OWNER_EMAIL_ADDRESS);
        }

        unset($_SESSION);

        Registry::get('Session')->kill();

        CLICSHOPPING::redirect();
      }
    }
  }