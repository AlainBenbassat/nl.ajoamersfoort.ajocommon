<?php

class CRM_Ajocommon_MembershipContact {
  public static function getCurrent($contactId, $typeId) {
    return \Civi\Api4\Membership::get(TRUE)
      ->addWhere('contact_id', $contactId)
      ->addWhere('membership_type_id', $typeId)
      ->addWhere('status_id', 'IN', [1, 2])
      ->execute()
      ->first();
  }

  public static function terminate($membershipId) {
    $today = date('Y-m-d');

    \Civi\Api4\Membership::update(FALSE)
      ->addValue('status_id', CRM_Ajocommon_Membership::STATUS_EX_MEMBER)
      ->addValue('end_date', $today)
      ->addWhere('id', '=', $membershipId)
      ->execute();
  }
}