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

  use ClicShopping\OM\HTML;
  use ClicShopping\OM\CLICSHOPPING;

  echo $form;
?>
  <div class="col-md-<?php echo $content_width; ?>">
<?php
  if ($CLICSHOPPING_MessageStack->exists('main')) {
    echo $CLICSHOPPING_MessageStack->get('main');
  }
?>
    <div class="separator"></div>
    <div class="card">
      <div class="card-header">
        <span class="alert-warning float-end" role="alert"><?php echo CLICSHOPPING::getDef('form_required'); ?></span>
        <span class="modulesCreateGuestAccountRegistrationPageHeader"><h3><?php echo CLICSHOPPING::getDef('category_personal'); ?></h3></span>
      </div>
      <div class="card-block">
        <div class="separator"></div>
        <div class="card-text">
          <div class="separator"></div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group row">
                <label for="InputFirstName" class="col-sm-6 col-md-4 col-form-label"><?php echo CLICSHOPPING::getDef('entry_first_name'); ?></label>
                <div class="col-sm-6 col-md-4">
<?php
  echo HTML::inputField('firstname', null, 'required aria-required="true" id="InputFirstName" autocomplete="name" aria-describedby="' . CLICSHOPPING::getDef('entry_first_name') . '" placeholder="' . CLICSHOPPING::getDef('entry_first_name') . '" minlength="'. ENTRY_FIRST_NAME_PRO_MIN_LENGTH .'"');
  if (ENTRY_FIRST_NAME_MIN_LENGTH) {
    echo '&nbsp;' . (!is_null(CLICSHOPPING::getDef('entry_first_name_text')) ? '<span class="text-warning">' . CLICSHOPPING::getDef('entry_first_name_text') . '</span>': '');
  }
?>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group row">
                <label for="InputLastName" class="col-sm-6 col-md-4 col-form-label"><?php echo CLICSHOPPING::getDef('entry_last_name'); ?></label>
                <div class="col-sm-6 col-md-4">
<?php
  echo HTML::inputField('lastname', null, 'required aria-required="true" id="InputLastName" autocomplete="name" aria-describedby="' . CLICSHOPPING::getDef('entry_last_name') . '" placeholder="' . CLICSHOPPING::getDef('entry_last_name') . '" minlength="'. ENTRY_LAST_NAME_PRO_MIN_LENGTH .'"');
  if (ENTRY_LAST_NAME_MIN_LENGTH > 0) {
    echo '&nbsp;' . (!is_null(CLICSHOPPING::getDef('entry_last_name_text')) ? '<span class="text-warning">' . CLICSHOPPING::getDef('entry_last_name_text') . '</span>': '');
  }
?>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group row">
                <label for="InputTelephone" class="col-sm-6 col-md-4 col-form-label"><?php echo CLICSHOPPING::getDef('entry_telephone_number'); ?></label>
                <div class="col-sm-6 col-md-4">
                  <?php echo HTML::inputField('telephone', null, 'rel="txtTooltipPhone" title="' . CLICSHOPPING::getDef('entry_phone_dgrp') . '" data-toggle="tooltip" data-placement="right" required aria-required="true" id="InputTelephone" autocomplete="tel" aria-describedby="' . CLICSHOPPING::getDef('entry_telephone_number') . '" placeholder="' . CLICSHOPPING::getDef('entry_telephone_number') . '"', 'phone'); ?>
                </div>
              </div>
            </div>
          </div>
<?php
    if (ACCOUNT_CELLULAR_PHONE == 'true') {
?>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group row">
                <label for="InputCellularPhone" class="col-sm-6 col-md-4 col-form-label"><?php echo CLICSHOPPING::getDef('entry_cellular_phone_number'); ?></label>
                <div class="col-sm-6 col-md-4">
                  <?php echo HTML::inputField('cellular_phone', null, 'rel="txtTooltipPhone" title="' . CLICSHOPPING::getDef('entry_phone_dgrp') . '" data-toggle="tooltip" data-placement="right" id="InputCellularPhone" autocomplete="tel" aria-describedby="' . CLICSHOPPING::getDef('entry_cellular_phone_number') . '" placeholder="' . CLICSHOPPING::getDef('entry_cellular_phone_number') . '"'); ?>
                </div>
              </div>
            </div>
          </div>
<?php
     }
?>
        </div>
      </div>
    </div>
<?php
// ***********************************
// Address
// ***********************************
?>
    <div class="separator"></div>
    <div class="card">
      <div class="card-header">
        <span class="alert-warning float-end" role="alert"><?php echo CLICSHOPPING::getDef('form_required'); ?></span>
        <span class="modulesCreateGuestAccountRegistrationPageHeader"><h3><?php echo CLICSHOPPING::getDef('category_address'); ?></h3></span>
      </div>
      <div class="card-block">
        <div class="separator"></div>
        <div class="card-text">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group row">
                <label for="InputStreetAddress" class="col-sm-6 col-md-4 col-form-label"><?php echo CLICSHOPPING::getDef('entry_street_address'); ?></label>
                  <div class="col-sm-6 col-md-4">
<?php
  echo HTML::inputField('street_address', null, 'required aria-required="true" id="InputStreetAddress" aria-describedby="' . CLICSHOPPING::getDef('entry_street_address') . '" placeholder="' . CLICSHOPPING::getDef('entry_street_address') . '" minlength="'. ENTRY_STREET_ADDRESS_PRO_MIN_LENGTH .'"');
  if (ENTRY_STREET_ADDRESS_MIN_LENGTH > 0) {
    echo '&nbsp;' . (!is_null(CLICSHOPPING::getDef('entry_street_address_text')) ? '<span class="text-warning">' . CLICSHOPPING::getDef('entry_street_address_text') . '</span>': '');
  }
?>
                </div>
              </div>
            </div>
          </div>
<?php
  if (ACCOUNT_SUBURB == 'true') {
?>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group row">
                <label for="InputSuburb" class="col-sm-6 col-md-4 col-form-label"><?php echo CLICSHOPPING::getDef('entry_suburb'); ?></label>
                  <div class="col-sm-6 col-md-4">
                    <?php echo HTML::inputField('suburb', null, 'id="InputSuburb" aria-describedby="' . CLICSHOPPING::getDef('entry_suburb') . '" placeholder="' . CLICSHOPPING::getDef('entry_suburb') . '"'); ?>
                </div>
              </div>
            </div>
          </div>

<?php
  }
?>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group row">
                <label for="InputPostCode" class="col-sm-6 col-md-4 col-form-label"><?php echo CLICSHOPPING::getDef('entry_post_code'); ?></label>
                  <div class="col-sm-6 col-md-4">
<?php
  echo HTML::inputField('postcode', null, 'required aria-required="true" id="InputPostCode" aria-describedby="' . CLICSHOPPING::getDef('entry_post_code') . '" placeholder="' . CLICSHOPPING::getDef('entry_post_code') . '"');
  if (ENTRY_POSTCODE_MIN_LENGTH > 0) {
    echo '&nbsp;' . (!is_null(CLICSHOPPING::getDef('entry_post_code_text')) ? '<span class="text-warning">' . CLICSHOPPING::getDef('entry_post_code_text') . '</span>': '');
  }
?>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group row">
                  <label for="InputCity" class="col-sm-6 col-md-4 col-form-label"><?php echo CLICSHOPPING::getDef('entry_city'); ?></label>
                  <div class="col-sm-6 col-md-4">
<?php
  echo HTML::inputField('city', null, 'required aria-required="true" id="InputCity" aria-describedby="' . CLICSHOPPING::getDef('entry_city') . '" placeholder="' . CLICSHOPPING::getDef('entry_city') . '"');
  if (ENTRY_CITY_MIN_LENGTH > 0) {
    echo '&nbsp;' . (!is_null(CLICSHOPPING::getDef('entry_city_text')) ? '<span class="text-warning">' . CLICSHOPPING::getDef('entry_city_text') . '</span>': '');
  }
?>
                </div>
              </div>
            </div>
          </div>
<?php
  if (ACCOUNT_STATE == 'true') {
    if (ACCOUNT_STATE_DROPDOWN == 'true') {
?>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group row">
                <label for="InputCountry" class="col-sm-6 col-md-4 col-form-label"><?php echo CLICSHOPPING::getDef('entry_country'); ?></label>
                <div class="col-sm-6 col-md-4">
                  <?php echo HTML::selectMenuCountryList('country', null, 'onchange="update_zone(this.form);" aria-required="true"'); ?>
                  <?php echo (!is_null(CLICSHOPPING::getDef('entry_country_text')) ? '<span class="text-warning">' . CLICSHOPPING::getDef('entry_country_text') . '</span>': ''); ?>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group row">
                <label for="InputState" class="col-sm-6 col-md-4 col-form-label"><?php echo CLICSHOPPING::getDef('entry_state'); ?></label>
                <div class="col-sm-6 col-md-4">
                  <?php echo HTML::selectField('state', $CLICSHOPPING_Address->getPrepareCountryZonesPullDown(), null, 'aria-required="true"'); ?>
                  <?php echo(!is_null(CLICSHOPPING::getDef('entry_state_text')) ? '<span class="text-warning">' . CLICSHOPPING::getDef('entry_state_text') . '</span>' : ''); ?>
                </div>
              </div>
            </div>
          </div>
<?php
      include_once(CLICSHOPPING::getConfig('dir_root', 'Shop') . 'ext/javascript/clicshopping/ClicShoppingAdmin/state_dropdown.php');
    } else {
?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group row">
                  <label for="InputCountry" class="col-sm-6 col-md-4 col-form-label"><?php echo CLICSHOPPING::getDef('entry_country'); ?></label>
                  <div class="col-sm-6 col-md-4">
                    <?php echo HTML::selectMenuCountryList('country', STORE_COUNTRY, 'aria-required="true"'); ?>
                    <?php echo (!is_null(CLICSHOPPING::getDef('entry_country_text')) ? '<span class="text-warning">' . CLICSHOPPING::getDef('entry_country_text') . '</span>': ''); ?>
                  </div>
                </div>
              </div>
            </div>

        <div class="row">
          <div class="col-md-12">
            <div class="form-group row">
              <label for="InputState" class="col-sm-6 col-md-4 col-form-label"><?php echo CLICSHOPPING::getDef('entry_state'); ?></label>
                  <div class="col-sm-6 col-md-4">
<?php
    if ($process === true) {
      if ($_SESSION['entry_state_has_zones'] === true && is_numeric($country)) {
        $zones_array = [];

        $Qcheck = $CLICSHOPPING_Db->prepare('select zone_name
                                             from :table_zones
                                             where zone_country_id = :zone_country_id
                                             and zone_status = 0
                                             order by zone_name
                                           ');
        $Qcheck->bindInt(':zone_country_id', $country);
        $Qcheck->execute();

        while ($Qcheck->fetch()) {
          $zones_array[] = ['id' => $Qcheck->value('zone_name'),
                            'text' => $Qcheck->value('zone_name')
                           ];
        }

        echo HTML::selectMenu('state', $zones_array);
      } else {
        $country = null;
        echo HTML::inputField('state', '', 'id="inputState" placeholder="' . CLICSHOPPING::getDef('entry_state') . '"');
      }
    } else {
      echo HTML::inputField('state', (isset($entry['country_id']) ? $CLICSHOPPING_Address->getZoneName($entry['country_id'], $entry['zone_id'], $entry['entry_state']) : ''), 'id="state" placeholder="' . CLICSHOPPING::getDef('entry_state') . '"');
    }

    if (ENTRY_STATE_MIN_LENGTH > 0) {
      echo '&nbsp;<span class="text-warning">' . CLICSHOPPING::getDef('entry_state_text') . '</span>';
    }
?>
                  </div>
                </div>
            </div>
          </div>
        </div>
<?php
    }
  }
?>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group row">
                <div class="modulesCreateGuestAccountRegistrationNewAccount">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item-slider">
                      <div class="separator"></div>
                      <?php echo CLICSHOPPING::getDef('text_create_account'); ?>
                      <label class="switch">
                        <?php echo HTML::checkboxField('create_account', null, false, 'id="InputCreateNewAccount" class="success"'); ?>
                        <span class="slider"></span>
                      </label>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php
  // ----------------------
  // Email
  // ----------------------
?>
    <div class="separator"></div>
    <div class="card">
      <div class="card-header">
        <span class="alert-warning float-end" role="alert"><?php echo CLICSHOPPING::getDef('form_required'); ?></span>
        <span class="modulesCreateGuestAccountRegistrationCategoryOptionsPageHeader"><h3><?php echo CLICSHOPPING::getDef('entry_email'); ?></h3></span>
      </div>
      <div class="card-block">
        <div class="separator"></div>
        <div class="card-text">
          <div class="separator"></div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group row">
                <label for="InputEmail" class="col-sm-6 col-md-4 col-form-label"><?php echo CLICSHOPPING::getDef('entry_email_address'); ?></label>
                <div class="col-sm-6 col-md-6">
                  <?php echo HTML::inputField('email_address', null, 'rel="txtTooltipEmailAddress" autocomplete="email" title="' . CLICSHOPPING::getDef('entry_email_address') . '" data-toggle="tooltip" data-placement="right" required aria-required="true" id="InputEmail" aria-describedby="' . CLICSHOPPING::getDef('entry_email_address') . '" placeholder="' . CLICSHOPPING::getDef('entry_email_address') . '"', 'email'); ?>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group row">
                <label for="InputEmailConfirm" class="col-sm-6 col-md-4 col-form-label"><?php echo CLICSHOPPING::getDef('entry_email_address_confirmation'); ?></label>
                <div class="col-sm-6 col-md-4">
                  <?php echo HTML::inputField('email_address_confirm', null, 'required aria-required="true" id="InputEmailConfirm" autocomplete="email" aria-describedby="' . CLICSHOPPING::getDef('entry_email_address_confirmation') . '" placeholder="' . CLICSHOPPING::getDef('entry_email_address_confirmation') . '"', 'email'); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="separator"></div>
<?php
// ----------------------
// Newsletter Information
// ----------------------
?>
    <div class="card">
      <div class="card-header">
        <span class="modulesCreateGuestAccountRegistrationCategoryOptionsPageHeader"><h3><?php echo CLICSHOPPING::getDef('entry_newsletter'); ?></h3></span>
      </div>
      <div class="card-block">
        <div class="separator"></div>
        <div class="card-text">
          <div class="row">
            <div class="col-md-12">
              <div class="modulesCreateGuestAccountRegistrationnewletter">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item-slider">
                    <div class="separator"></div>
                    <?php echo CLICSHOPPING::getDef('entry_newsletter'); ?>
                    <label class="switch">
                      <?php echo HTML::checkboxField('newsletter', null, false, 'id="Inputnewsletter" class="success"'); ?>
                      <span class="slider"></span>
                    </label>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="separator"></div>
    <div class="separator"></div>
