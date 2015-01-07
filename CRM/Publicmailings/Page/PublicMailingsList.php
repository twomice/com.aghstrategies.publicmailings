<?php

require_once 'CRM/Core/Page.php';

class CRM_Publicmailings_Page_PublicMailingsList extends CRM_Core_Page {
    function getDate(){
    $year  = CRM_Utils_Request::retrieve('year', 'Positive', $this, FALSE);
    $month = CRM_Utils_Request::retrieve('month', 'Positive', $this, FALSE);
    $date1 = CRM_Utils_Array::value('date1', $_GET, '0');;
    $date2 = CRM_Utils_Array::value('date2', $_GET, '0');;
    if($year> 0 && $month<1){
      $yearstring = $year . "-1-1";
      $this->_date1 = date("YmdHis", strtotime($yearstring) );
      $this->_date2 = date("YmdHis", strtotime('+1 year', strtotime($yearstring)));
    } 
    if($month>0){
      if($year<1){ $year = date("Y"); }
      $monthstring = $year ."-".$month."-1";
      $this->_date1 = date("YmdHis", strtotime($monthstring) );
      $this->_date2 = date("YmdHis", strtotime('+1 month', strtotime($monthstring)));
    } else {
      if($date1>0){
        $this->_date1 = date("YmdHis", strtotime($date1) );
      }
      if($date2>0){
        $this->_date2 = date("YmdHis", strtotime($date2) );
      }
    }
  }

  function run() {
    CRM_Utils_System::setTitle(ts('Public Mailings Archive'));
    $this->_pid = CRM_Utils_Request::retrieve('crmPID', 'Positive', $this, FALSE);
    $this->_tid = CRM_Utils_Request::retrieve('tid', 'Positive', $this, FALSE);
    $pid = preg_replace('#[^0-9]#', '', $this->_pid);
    $tid = preg_replace('#[^0-9]#', '', $this->_tid);
    $this->getDate();
   /*** Get Count ***/
    $params = array(
			'version' => 3,
			'option' => 'com_civicrm',
			'task' => 'civicrm/ajax/rest',
			'sequential' => 1,
			'visibility' => 'Public Pages',
		);
    if($tid>0){
      $params['msg_template_id'] = $tid;
    }
    if(isset($this->_date1)){
      $params['filter.scheduled_date_low'] = $this->_date1;
    }
    if(isset($this->_date2)){
      $params['filter.scheduled_date_high'] = $this->_date2;
    }
    $count = civicrm_api('Mailing', 'getcount', $params);
    /*** Make Pagination ***/
    if(!$pid || $pid < 1){ $pid = 1;}
    $results_per_page = 10;
    $params = array(
      'rowCount' => $results_per_page,
      'pageID' => $pid,
      'total' => $count,
    );
    $params['status'] = ts('Archived Mailings') . ' %%StatusMessage%%';
    $pager = new CRM_Utils_Pager($params);
    /***Make API Call***/
    list($offset, $limit) = $pager->getOffsetAndRowCount();
    $params = array(
			'version' => 3,
			'option' => 'com_civicrm',
			'task' => 'civicrm/ajax/rest',
			'sequential' => 1,
			'visibility' => 'Public Pages',
      'options'=> array(
                   'limit' => $limit,
                   'offset'=> $offset,
                   'sort' => 'scheduled_date ASC',
      					  ),
		  );
    if($tid>0){
     $params['msg_template_id'] = $tid;
    }
    if(isset($this->_date1)){
     $params['filter.scheduled_date_low'] = $this->_date1;
    }
    if(isset($this->_date2)){
     $params['filter.scheduled_date_high'] = $this->_date2;
    }
    $result = civicrm_api('Mailing', 'get', $params);
    $mailings = $result['values'];
   
    $this->assign('mailings',$mailings);
    $this->assign('pager', $pager);
    
    $path = "civicrm/public_mailing_view";
    $foreach_url = CRM_Utils_System::url($path);
    $this->assign('foreach_url', $foreach_url);
    parent::run();
  }
}
