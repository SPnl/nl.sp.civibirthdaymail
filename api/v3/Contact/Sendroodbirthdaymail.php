<?php

/**
 * Contact.Sendoordbirthdaymail API specification (optional)
 * This is used for documentation and validation.
 * @param array $spec description of fields supported by this API call
 * @return void
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC/API+Architecture+Standards
 */
function _civicrm_api3_contact_Sendroodbirthdaymail_spec(&$spec) {
    $spec['email_template_id'] = [
        'api.required' => 1,
        'name' => 'email_template_id',
        'title' => 'Email template ID to send',
    ];
}

/** Send ROOD mail to the contacts
 * @param array $contactIds An array of contact Ids
 * @param int $templateId The template to send
 */
function _civicrm_api3_contact_Sendroodmail($contactIds, $templateId) {
    // Needs to be seperated by comma instead of an array for
    // the Email API
    $implodedContactIds = implode(',', $contactIds);
    civicrm_api3('Email', 'send', array(
        'template_id' => $templateId,
        'contact_id' => $implodedContactIds,
    ));
}

/**
 * Contact.Sendroodbirthdaymail API
 *
 * Sends a mail to all the ROOD members on their 16th birthday
 * @param array $params
 * @return array API result descriptor
 * @see civicrm_api3_create_success
 * @see civicrm_api3_create_error
 * @throws API_Exception
 */
function civicrm_api3_contact_Sendroodbirthdaymail($params) {
    // TODO: Find exact permission for message template creation
    if (!CRM_Core_Permission::check("access CiviCRM")) {
        throw new API_Exception("Insufficient permissions");
    }
    $query = "
        SELECT id
        FROM civicrm_contact
        WHERE DATE_FORMAT(birth_date,'%m-%d') = DATE_FORMAT(NOW(),'%m-%d')
              AND TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) = 16;
        ";
    $dao = CRM_Core_DAO::executeQuery($query);
    $result = $dao->fetchAll();
    if (empty($result)) {
        // No contacts to send mail to
        return civicrm_api3_create_success([], [], 'Contact', 'Sendroodbirthdaymail');
    }
    $contactIds = array_map(function($contact) { return $contact['id']; }, $result);
    _civicrm_api3_contact_Sendroodmail($contactIds, $params['email_template_id']);
    //    $contactParams = ['id' => $contactIds, 'return' => 'id,email'];
    // $contacts = civicrm_api3_contact_get($contactParams)['values'];
    return civicrm_api3_create_success($contactIds,
                                       $params, 'Contact', 'Sendroodbirthdaymail');
}
