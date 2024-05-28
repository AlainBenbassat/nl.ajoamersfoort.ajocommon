<?php

class CRM_Ajocommon_Contact {
  public int $id = 0;
  public string $first_name = '';
  public string $last_name = '';
  public int $uf_id = 0;

  public function __construct(int $contactId) {
    $contact = \Civi\Api4\Contact::get(FALSE)
      ->addSelect('*', 'custom.*', 'email_primary.email')
      ->addWhere('id', '=', $contactId)
      ->execute()
      ->first();

    foreach (get_object_vars($this) as $k => $v) {
      if (!empty($contact[$k])) {
        $this->$k = $contact[$k];
      }
    }

    $uFMatch = \Civi\Api4\UFMatch::get(FALSE)
      ->addSelect('uf_id')
      ->addWhere('contact_id', '=', $contactId)
      ->execute()
      ->first();
    if ($uFMatch) {
      $this->uf_id = $uFMatch['uf_id'];
    }
  }

  public function getParentsContactIds(): array {
    $parentsContactIds = [];

    $relationships = \Civi\Api4\Relationship::get(TRUE)
      ->addSelect('contact_id_b')
      ->addWhere('relationship_type_id', '=', 1)
      ->addWhere('is_active', '=', TRUE)
      ->addWhere('contact_id_a', '=', $this->id)
      ->execute();
    foreach ($relationships as $relationship) {
      $parentsContactIds[] = $relationship['contact_id_b'];
    }

    return $parentsContactIds;
  }

  public function getChildrenContactIds(): array {
    $childrenContactIds = [];

    $relationships = \Civi\Api4\Relationship::get(TRUE)
      ->addSelect('contact_id_a')
      ->addWhere('relationship_type_id', '=', 1)
      ->addWhere('is_active', '=', TRUE)
      ->addWhere('contact_id_b', '=', $this->id)
      ->execute();
    foreach ($relationships as $relationship) {
      $childrenContactIds[] = $relationship['contact_id_a'];
    }

    return $childrenContactIds;
  }

}