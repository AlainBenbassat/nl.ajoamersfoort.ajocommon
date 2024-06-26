<?php

class CRM_Ajocommon_GroupContact {
  public static function isGroupContact(int $contactId, int $groupId, bool $ignoreStatus = FALSE): bool {
    $groupContact = \Civi\Api4\GroupContact::get(FALSE)
      ->addWhere('group_id', '=', $groupId)
      ->addWhere('contact_id', '=', $contactId)
      ->execute()
      ->first();

    if (empty($groupContact)) {
      return FALSE;
    }

    if ($ignoreStatus || $groupContact['status'] == 'Added') {
      return TRUE;
    }

    return FALSE;
  }

  public static function changeStatus(int $contactId, int $groupId, string $status): void {
    \Civi\Api4\GroupContact::update(FALSE)
      ->addValue('status', $status)
      ->addWhere('group_id', '=', $groupId)
      ->addWhere('contact_id', '=', $contactId)
      ->execute();
  }

  public static function delete(int $contactId, int $groupId): void {
    self::changeStatus($contactId, $groupId, 'Removed');
  }

  public static function create(int $contactId, int $groupId): void {
    if (self::isGroupContact($contactId, $groupId, TRUE)) {
      self::changeStatus($contactId, $groupId, 'Added');
    }
    else {
      \Civi\Api4\GroupContact::create(FALSE)
        ->addValue('status', 'Added')
        ->addValue('group_id', $groupId)
        ->addValue('contact_id', $contactId)
        ->execute();
    }
  }

  public static function swapGroup(int $contactId, int $oldGroupId, int $newGroupId): void {
    // in case the contact is already in the target group
    self::delete($contactId, $newGroupId);

    $sql = "
      update
        civicrm_group_contact
      set
        group_id = $newGroupId
      where
        contact_id = $contactId
      and
        group_id = $oldGroupId
      and
        status = 'Added'
    ";

    CRM_Core_DAO::executeQuery($sql);
  }
}