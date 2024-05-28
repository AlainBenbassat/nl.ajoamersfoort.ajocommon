<?php

require_once 'ajocommon.civix.php';

use CRM_Ajocommon_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function ajocommon_civicrm_config(&$config): void {
  _ajocommon_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function ajocommon_civicrm_install(): void {
  _ajocommon_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function ajocommon_civicrm_enable(): void {
  _ajocommon_civix_civicrm_enable();
}
