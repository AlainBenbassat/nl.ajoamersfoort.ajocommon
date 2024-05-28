<?php

class CRM_Ajocommon_User {
  private WP_User $wpUser;

  public function loadById(int $userId): void {
    $this->wpUser = get_user_by('id', $userId);
  }

  public function removeRole($role) {
    $this->wpUser->remove_role($role);
  }
}