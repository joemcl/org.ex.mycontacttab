<?php

require_once 'CRM/Core/Page.php';

class CRM_Mycontacttab_Page_MyContactTab extends CRM_Core_Page {
  function run() {
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(ts('MyContactTab'));

    // Example: Assign a variable for use in a template
    $this->assign('currentTime', date('Y-m-d H:i:s'));

    $contact = civicrm_api3('Contact', 'get', array(
      'id' => CRM_Utils_Request::retrieve('cid', 'Positive'),
    ));

    parent::run();
  }
}
