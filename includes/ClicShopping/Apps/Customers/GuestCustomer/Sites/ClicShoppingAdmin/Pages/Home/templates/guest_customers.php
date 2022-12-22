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

  use ClicShopping\OM\HTML;
  use ClicShopping\OM\DateTime;
  use ClicShopping\OM\CLICSHOPPING;
  use ClicShopping\OM\Registry;
  use ClicShopping\OM\ObjectInfo;

  $CLICSHOPPING_GuestCustomer = Registry::get('GuestCustomer');
  $CLICSHOPPING_Template = Registry::get('TemplateAdmin');
  $CLICSHOPPING_Hooks = Registry::get('Hooks');
  $CLICSHOPPING_Language = Registry::get('Language');

  $page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? (int)$_GET['page'] : 1;

  if (isset($_GET['search'])) {
    $_POST['search'] = HTML::sanitize($_GET['search']);
  }
?>
<div class="contentBody">
  <div class="row">
    <div class="col-md-12">
      <div class="card card-block headerCard">
        <div class="row">
          <div
            class="col-md-1 logoHeading"><?php echo HTML::image($CLICSHOPPING_Template->getImageDirectory() . 'categories/guest_checkout.png', $CLICSHOPPING_GuestCustomer->getDef('heading_title'), '40', '40'); ?></div>
          <div
            class="col-md-3 pageHeading float-start"><?php echo '&nbsp;' . $CLICSHOPPING_GuestCustomer->getDef('heading_title'); ?></div>
          <div class="col-md-3">
            <div class="form-group">
              <div class="controls">
                <?php
                  echo HTML::form('search', $CLICSHOPPING_GuestCustomer->link('Customers'), 'post', 'role="form" class="form-inline"', ['session_id' => true]);
                  echo HTML::inputField('search', '', 'id="inputKeywords" placeholder="' . $CLICSHOPPING_GuestCustomer->getDef('heading_title_search') . '"');
                ?>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-2 text-end">
            <?php
              if (isset($_POST['search']) && !is_null($_POST['search'])) {
                echo HTML::button($CLICSHOPPING_GuestCustomer->getDef('button_reset'), null, $CLICSHOPPING_GuestCustomer->link('Customers&page=' . $page), 'warning');
              }
            ?>
          </div>
          </form>

          <div class="col-md-3 text-end">
            <?php
              echo HTML::button($CLICSHOPPING_GuestCustomer->getDef('button_configure'), null, $CLICSHOPPING_GuestCustomer->link('Configure&module=GC'), 'success');

              echo HTML::form('delete_all', $CLICSHOPPING_GuestCustomer->link('GuestCustomer&DeleteAll&page=' . $page));
            ?>
            <a onclick="$('delete').prop('action', ''); $('form').submit();"
               class="button"><?php echo HTML::button($CLICSHOPPING_GuestCustomer->getDef('button_delete'), null, null, 'danger'); ?></a>&nbsp;
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="separator"></div>
  <div class="row">
    <div class="col-md-12">
      <div class="card-deck">
        <?php //echo $CLICSHOPPING_Hooks->output('Stats', 'StatsCustomersCompare'); ?>
      </div>
    </div>
  </div>

  <div class="separator"></div>
  <table border="0" width="100%" cellspacing="0" cellpadding="2">
    <td>
      <table class="table table-sm table-hover table-striped">
        <thead>
        <tr class="dataTableHeadingRow">
          <td width="1" class="text-center"><input type="checkbox"
                                                      onclick="$('input[name*=\'selected\']').prop('checked', this.checked);"/>
          </td>
          <td><?php echo $CLICSHOPPING_GuestCustomer->getDef('table_heading_customers_id'); ?></td>
          <td><?php echo $CLICSHOPPING_GuestCustomer->getDef('table_heading_lastname'); ?></td>
          <td><?php echo $CLICSHOPPING_GuestCustomer->getDef('table_heading_firstname'); ?></td>
          <td><?php echo $CLICSHOPPING_GuestCustomer->getDef('table_heading_entry_email_validation'); ?></td>
          <td><?php echo $CLICSHOPPING_GuestCustomer->getDef('table_heading_convert_to_customer'); ?></td>
          <td><?php echo $CLICSHOPPING_GuestCustomer->getDef('table_heading_country'); ?></td>
          <td><?php echo $CLICSHOPPING_GuestCustomer->getDef('table_heading_account_created'); ?></td>
          <td class="text-end"><?php echo $CLICSHOPPING_GuestCustomer->getDef('table_heading_action'); ?>&nbsp;
          </td>
        </tr>
        </thead>
        <tbody>
        <?php
          // Recherche
          $search = '';

          if (isset($_POST['search']) && !is_null($_POST['search'])) {

            $keywords = HTML::sanitize($_POST['search']);
            $search = " (c.customers_id like '" . $keywords . "' or
                 c.customers_lastname like '%" . $keywords . "%'
                 or c.customers_firstname like '%" . $keywords . "%'
                 or c.customers_email_address like '%" . $keywords . "%'
                 or a.entry_company like '%" . $keywords . "%'
                )
             ";

            $Qcustomers = $CLICSHOPPING_GuestCustomer->db->prepare('select  SQL_CALC_FOUND_ROWS c.customers_id,
                                                                                        c.customers_lastname,
                                                                                        c.customers_firstname,
                                                                                        c.customers_group_id,
                                                                                        c.customers_email_address,
                                                                                        a.entry_country_id,
                                                                                        c.customers_email_validation,
                                                                                        c.customer_guest_account
                                                            from :table_customers c left join :table_address_book a on c.customers_id = a.customers_id
                                                            where ' . $search . '
                                                            and c.customers_default_address_id = a.address_book_id
                                                            and c.customer_guest_account = 1
                                                            order by c.customers_id DESC
                                                            limit :page_set_offset, :page_set_max_results
                                                            ');

            $Qcustomers->setPageSet((int)MAX_DISPLAY_SEARCH_RESULTS_ADMIN);
            $Qcustomers->execute();

          } else {
            $Qcustomers = $CLICSHOPPING_GuestCustomer->db->prepare('select SQL_CALC_FOUND_ROWS c.customers_id,
                                                                                        c.customers_lastname,
                                                                                        c.customers_firstname,
                                                                                        c.customers_group_id,
                                                                                        c.customers_email_address,
                                                                                        a.entry_country_id,
                                                                                        c.customers_email_validation,
                                                                                        c.customer_guest_account
                                                              from :table_customers c left join :table_address_book a on c.customers_id = a.customers_id
                                                              where c.customers_default_address_id = a.address_book_id
                                                              and c.customer_guest_account = 1
                                                              order by c.customers_id desc
                                                              limit :page_set_offset, :page_set_max_results
                                                              ');

            $Qcustomers->setPageSet((int)MAX_DISPLAY_SEARCH_RESULTS_ADMIN);
            $Qcustomers->execute();
          }

          $listingTotalRow = $Qcustomers->getPageSetTotalRows();

          if ($listingTotalRow > 0) {

          while ($Qcustomers->fetch()) {
// suppression du membre non approuvé
            $Qinfo = $CLICSHOPPING_GuestCustomer->db->prepare('select customers_info_date_account_created as date_account_created,
                                                                 customers_info_date_account_last_modified as date_account_last_modified,
                                                                 customers_info_date_of_last_logon as date_last_logon,
                                                                 customers_info_number_of_logons as number_of_logons
                                                           from :table_customers_info
                                                           where customers_info_id = :customers_id
                                                          ');
            $Qinfo->bindInt(':customers_id', $Qcustomers->valueInt('customers_id'));
            $Qinfo->execute();

            $date_created = $Qinfo->value('date_account_created');
            $info = $Qinfo->fetch();

            $QcustColl = $CLICSHOPPING_GuestCustomer->db->prepare('select customers_group_id,
                                                                           customers_group_name
                                                                   from :table_customers_groups
                                                                   where customers_group_id = :customers_group_id
                                                                  ');
            $QcustColl->bindInt(':customers_group_id', $Qcustomers->valueInt('customers_group_id'));
            $QcustColl->execute();

            $cust_ret = $QcustColl->fetch();

            if ($QcustColl->valueInt('customers_group_id') == 0) {
              $cust_ret['customers_group_name'] = $CLICSHOPPING_GuestCustomer->getDef('visitor_name');
            }

            if ((!isset($_GET['cID']) || (isset($_GET['cID']) && ((int)$_GET['cID'] === $Qcustomers->valueInt('customers_id')))) && !isset($cInfo)) {

              $Qcountry = $CLICSHOPPING_GuestCustomer->db->prepare('select countries_name
                                                                     from :table_countries
                                                                     where countries_id = :countries_id
                                                                    ');
              $Qcountry->bindInt(':countries_id', $Qcustomers->valueInt('entry_country_id'));
              $Qcountry->execute();

              $country = $Qcountry->fetch();

              // recover from bad records
              if (!is_array($Qcountry->fetch())) {
                $country = array('Country is NULL');
              }

              if (!is_array($Qinfo->fetch())) {
                $info = array('Info is NULL');
              }

              $cInfo_array = array_merge($Qcustomers->toArray(), (array)$info, (array)$cust_ret);

              $cInfo = new ObjectInfo($cInfo_array);
            }
            ?>
            <td>
              <?php
                if (isset($_POST['selected'])) {
                  ?>
                  <input type="checkbox" name="selected[]" value="<?php echo $Qcustomers->valueInt('customers_id'); ?>"
                         checked="checked"/>
                  <?php
                } else {
                  ?>
                  <input type="checkbox" name="selected[]"
                         value="<?php echo $Qcustomers->valueInt('customers_id'); ?>"/>
                  <?php
                }
              ?>
            </td>
            <th scope="row"><?php echo $Qcustomers->valueInt('customers_id'); ?></th>
            <td><?php echo $Qcustomers->value('customers_lastname'); ?></td>
            <td><?php echo $Qcustomers->value('customers_firstname'); ?></td>
            <?php
            if ($Qcustomers->valueInt('customers_email_validation') == 0) {
              $email_validation = '<i class="fas fa-check fa-lg" aria-hidden="true"></i>';
            } else {
              $email_validation = '<i class="fas fa-times fa-lg" aria-hidden="true"></i>';
            }
            ?>
            <td class="text-center"><?php echo $email_validation; ?></td>
            <?php

            if ($Qcustomers->valueInt('customer_guest_account') == 1) {
              $guest = HTML::link($CLICSHOPPING_GuestCustomer->link('GuestCustomer&SetFlag&page=' . $page . '&cID=' . $Qcustomers->valueInt('customers_id') . '&flag=1'), '<i class="fas fa-times fa-lg" aria-hidden="true"></i>') . '</td>';
            }
            ?>
            <td class="text-center"><?php echo $guest; ?></td>
            <?php
            $QcustomersCountry = $CLICSHOPPING_GuestCustomer->db->prepare('select a.entry_country_id,
                                                                                   c.countries_id,
                                                                                   c.countries_name
                                                                           from :table_address_book a,
                                                                                :table_countries c
                                                                           where customers_id = :customers_id
                                                                           and a.entry_country_id = c.countries_id
                                                                          ');

            $QcustomersCountry->bindInt(':customers_id', $Qcustomers->valueInt('customers_id'));

            $QcustomersCountry->execute();
            ?>
            <td class="dataTableContent" align="left"><?php echo $QcustomersCountry->value('countries_name'); ?></td>
            <?php

            if (!is_null($date_created)) {
              echo '<td>' . DateTime::toShort($date_created) . '</td>';
            } else {
              echo '<td ></td>';
            }
            ?>
            <td class="text-end">
              <?php
                echo HTML::link(CLICSHOPPING::link(null, 'A&Communication\EMail&EMail&customer=' . $Qcustomers->value('customers_email_address')), HTML::image($CLICSHOPPING_Template->getImageDirectory() . 'icons/email.gif', $CLICSHOPPING_GuestCustomer->getDef('icon_email')));
                echo '&nbsp;';
                echo HTML::link(CLICSHOPPING::link(null, 'A&Orders\Orders&Orders'), HTML::image($CLICSHOPPING_Template->getImageDirectory() . 'icons/order.gif', $CLICSHOPPING_GuestCustomer->getDef('icon_edit_orders')));
                echo '&nbsp;';
                echo HTML::link($CLICSHOPPING_GuestCustomer->link('Customers\PasswordForgotten&cID=' . $Qcustomers->valueInt('customers_id')), HTML::image($CLICSHOPPING_Template->getImageDirectory() . 'icons/new_password.gif', $CLICSHOPPING_GuestCustomer->getDef('icon_edit_new_password')));
                echo '&nbsp;';
              ?>
            </td>
            </tr>
            <?php
          } // end while
        ?>
        </form><!-- end form delete all -->
        </tbody>
      </table>
      <?php
        } // end $listingTotalRow
      ?>
    </td>
  </table>
  <?php
    if ($listingTotalRow > 0) {
      ?>
      <div class="row">
        <div class="col-md-12">
          <div
            class="col-md-6 float-start pagenumber hidden-xs TextDisplayNumberOfLink"><?php echo $Qcustomers->getPageSetLabel($CLICSHOPPING_GuestCustomer->getDef('text_display_number_of_link')); ?></div>
          <div
            class="float-end text-end"> <?php echo $Qcustomers->getPageSetLinks(CLICSHOPPING::getAllGET(array('page', 'info', 'x', 'y'))); ?></div>
        </div>
      </div>
      <?php
//------------------------------------------------
//       Extra Button
//------------------------------------------------
      ?>
      <div class="col-md-12">
        <div class="card card-block footerCard">
          <div class="row">
            <?php
              //      echo $CLICSHOPPING_Hooks->output('GuestMailchimp', 'GuestMailBatch');
              echo '&nbsp;';
            ?>
          </div>
        </div>
      </div>
      <?php
    } // end $listingTotalRow
  ?>
</div>
