<?php

require_once 'mycontacttab.civix.php';

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function mycontacttab_civicrm_config(&$config) {
  _mycontacttab_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @param $files array(string)
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function mycontacttab_civicrm_xmlMenu(&$files) {
  _mycontacttab_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function mycontacttab_civicrm_install() {
  _mycontacttab_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function mycontacttab_civicrm_uninstall() {
  _mycontacttab_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function mycontacttab_civicrm_enable() {
  _mycontacttab_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function mycontacttab_civicrm_disable() {
  _mycontacttab_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed
 *   Based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function mycontacttab_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _mycontacttab_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function mycontacttab_civicrm_managed(&$entities) {
  _mycontacttab_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function mycontacttab_civicrm_caseTypes(&$caseTypes) {
  _mycontacttab_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function mycontacttab_civicrm_angularModules(&$angularModules) {
  _mycontacttab_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function mycontacttab_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _mycontacttab_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Functions below this ship commented out. Uncomment as required.
 *
 *
 * /**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
 * function mycontacttab_civicrm_preProcess($formName, &$form) {
 *
 * }

 */

function mycontacttab_civicrm_tabs(&$tabs, $contactID) {
  $tab = array(
    'id' => 'mysummary',
    'url' => CRM_Utils_System::url('civicrm/my-contact-tab', array(
      'cid' => $contactID,
      'snippet' => 1,
    )),
    'title' => ts('My Summary'),
    'weight' => 10,
    //'count' => CRM_HRJob_BAO_HRJob::getRecordCount(array(
    //  'contact_id' => $contactID
    //)),
  );
  $tabs[] = $tab;
  $selectedChild = CRM_Utils_Request::retrieve('selectedChild', 'String');
  CRM_Core_Resources::singleton()->addSetting(array(
    'tabs' => array(
      'selectedChild' => $selectedChild,
    ),
  ));
  CRM_Core_Resources::singleton()->addScript("
  (function ($, _) {
    $(document).on('crmLoad', function() {
      //move job tab to the beginning
      var jobTab = $(\"div#mainTabContainer ul li#tab_mysummary\");
      jobTab.prependTo(jobTab.parent());

      //make \"job\" tab as default in case selectedChild is not set
      var selectedTab = CRM.tabs.selectedChild ? CRM.tabs.selectedChild : 'mysummary';
      var tabIndex = $('#tab_' + selectedTab).prevAll().length;
      setTimeout(function(){
        $('#mainTabContainer').tabs('option', 'active', tabIndex)
        $('#tab_summary a').text('Details');
      }, 100);
    });
  }(CRM.$, CRM._));"
  );
}
