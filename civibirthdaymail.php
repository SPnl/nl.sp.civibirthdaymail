<?php

require_once 'civibirthdaymail.civix.php';

/**
 * Implementation of hook_civicrm_alterAPIPermissions.
 * This hook is called when API 3 permissions are checked.
 * This hook alters the $permissions structure from CRM/Core/DAO/permissions.php for the group_contact entity action create, so the custom 'add to group enabled' is checked.
 *  
 * @param string $entity - the API entity (like contact)
 * @param string $action - the API action (like get)
 * @param array &$params - the API parameters
 * @param array &$permisisons - the associative permissions array (probably to be altered by this hook)
 *
 * @link https://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterAPIPermissions
 */
function civibirthdaymail_civicrm_alterAPIPermissions($entity, $action, &$params, &$permissions) {
}

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function civibirthdaymail_civicrm_config(&$config) {
  _civibirthdaymail_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function civibirthdaymail_civicrm_xmlMenu(&$files) {
  _civibirthdaymail_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function civibirthdaymail_civicrm_install() {
  _civibirthdaymail_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function civibirthdaymail_civicrm_postInstall() {
  _civibirthdaymail_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function civibirthdaymail_civicrm_uninstall() {
  _civibirthdaymail_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function civibirthdaymail_civicrm_enable() {
  _civibirthdaymail_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function civibirthdaymail_civicrm_disable() {
  _civibirthdaymail_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function civibirthdaymail_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _civibirthdaymail_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function civibirthdaymail_civicrm_managed(&$entities) {
  _civibirthdaymail_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function civibirthdaymail_civicrm_caseTypes(&$caseTypes) {
  _civibirthdaymail_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function civibirthdaymail_civicrm_angularModules(&$angularModules) {
  _civibirthdaymail_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function civibirthdaymail_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _civibirthdaymail_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function civibirthdaymail_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function civibirthdaymail_civicrm_navigationMenu(&$menu) {
  _civibirthdaymail_civix_insert_navigation_menu($menu, NULL, array(
    'label' => ts('The Page', array('domain' => 'nl.sp.civibirthdaymail')),
    'name' => 'the_page',
    'url' => 'civicrm/the-page',
    'permission' => 'access CiviReport,access CiviContribute',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _civibirthdaymail_civix_navigationMenu($menu);
} // */
