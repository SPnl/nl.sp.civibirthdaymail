<?php

/**
 * Contact.Sendbirthdaymail API specification (optional)
 * This is used for documentation and validation.
 * @param array $spec description of fields supported by this API call
 * @return void
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC/API+Architecture+Standards
 */
function _civicrm_api3_contact_Sendbirthdaymail_spec(&$spec) {
    $spec['email_template_id'] = [
        'api.required' => 1,
        'name' => 'email_template_id',
        'title' => 'Email template ID to send',
    ];
    $spec['age'] = [
        'api.required' => 0,
        'name' => 'age',
        'title' => 'Only send contacts that reached this age',
    ];
    $spec['skip_age'] = [
        'api.required' => 0,
        'name' => 'skip_ages',
        'title' => 'Age to skip mailing',
    ];
    $spec['membership_id'] = [
        'api.required' => 0,
        'name' => 'membership_id',
        'title' => 'Send only to members with this membership'
    ];
}

/** Send mail to the contacts
 * @param array $contactIds An array of contact Ids
 * @param int $templateId The template to send
 */
function _civicrm_api3_contact_Sendbirthdaymail($contactIds, $templateId) {
    // Needs to be seperated by comma instead of an array for
    // the Email API
    $implodedContactIds = implode(',', $contactIds);
    civicrm_api3('Email', 'send', array(
        'template_id' => $templateId,
        'contact_id' => $implodedContactIds,
    ));
}

/**
 * Contact.Sendbirthdaymail API
 *
 * Sends a mail to all certain contacts on their x-th birthday
 * @param array $params
 * @return array API result descriptor
 * @see civicrm_api3_create_success
 * @see civicrm_api3_create_error
 * @throws API_Exception
 */
function civicrm_api3_contact_Sendbirthdaymail($params) {
    // TODO: Find exact permission for message template creation
    if (!CRM_Core_Permission::check("access CiviCRM")) {
        throw new API_Exception("Insufficient permissions");
    }
    $query = "
        SELECT civicrm_contact.id
        FROM civicrm_contact
";
    $paramAmount = 0;
    $sqlParams = [];
    if (isset($params['membership_id']) && $params['membership_id'] != null) {
        $paramAmount += 1;
        $query .= "
               INNER JOIN civicrm_membership
               ON civicrm_membership.contact_id = civicrm_contact.id
               AND civicrm_membership.membership_type_id = %$paramAmount
               AND civicrm_membership.status_id = 2
         ";
        $membershipId = $params['membership_id'];
        $sqlParams[$paramAmount] = [$membershipId, 'Integer'];
    }
    $query .="
        WHERE DATE_FORMAT(birth_date,'%m-%d') = DATE_FORMAT(NOW(),'%m-%d')
        ";
    if (isset($params['age']) && $params['age'] != null) {
        $paramAmount += 1;
        $query .= " AND TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) = %$paramAmount";
        $age = $params['age'];
        $sqlParams[$paramAmount] = [$age, 'Integer'];
    }
    if (isset($params['skip_age']) && $params['skip_age'] != null) {
        $paramAmount += 1;
        $query .= " AND TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) != %$paramAmount";
        $skipAge = $params['skip_age'];
        $sqlParams[$paramAmount] = [$skipAge, 'Integer'];
    }
    $dao = CRM_Core_DAO::executeQuery($query, $sqlParams);
    $result = $dao->fetchAll();
    if (empty($result)) {
        // No contacts to send mail to
        return civicrm_api3_create_success([], [], 'Contact', 'Sendbirthdaymail');
    }
    $contactIds = array_map(function($contact) { return $contact['id']; }, $result);
    print_r($contactIds);
    _civicrm_api3_contact_Sendbirthdaymail($contactIds, $params['email_template_id']);
    return civicrm_api3_create_success($contactIds,
                                       $params, 'Contact', 'Sendbirthdaymail');
}
