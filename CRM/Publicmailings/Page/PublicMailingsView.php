<?php

require_once 'CRM/Core/Page.php';

class CRM_Publicmailings_Page_PublicMailingsView extends CRM_Core_Page {
  function run() {
    $this->_id = CRM_Utils_Request::retrieve('id', 'Positive', $this, TRUE);
    $id = $this->_id;
    $params = array(
			'version' => 3,
			'option' => 'com_civicrm',
			'task' => 'civicrm/ajax/rest',
			'sequential' => 1,
			'visibility' => 'Public Pages',
      'id' => $id,
		);
    $result = civicrm_api('Mailing', 'get', $params);
    $mailings = $result['values'];
    $content = $mailings['0']['body_html'];
    $content = preg_replace('#\{.*?\}#s', '', $content); 
    $title = $mailings['0']['subject'];
    CRM_Utils_System::setTitle(ts($title));
    $this->assign('content', $content);
    parent::run();
  }
}
