<?php
/*
 *  Required object values:
 *  data - 
 */
 
class lookupGetDomain extends openSRS_base {
	private $_dataObject;
	private $_formatHolder = "";

	function call($format, $data) {
		$this->_dataObject = $data;
		$this->_formatHolder = $format;
		$this->_processRequest();
	}
	public function __construct ($formatString, $dataObject) {
		parent::__construct();
		$this->_dataObject = $dataObject;
		$this->_formatHolder = $formatString;
		$this->_processRequest();
	}

	public function __destruct () {
		parent::__destruct();
	}

	private function _validateObject (){
		
		if(empty($this->_dataObject->data->cookie) && empty($this->_dataObject->data->domain)) {
		    trigger_error ("oSRS Error - cookie / bypass is not defined.", E_USER_WARNING);
		    return false;
		}

		if(empty($this->_dataObject->data->type)) {
			trigger_error ("oSRS Error - type required.", E_USER_WARNING);
			return false;
		}
		return true;
	}

	private function _processRequest (){

		$is_valid = $this->_validateObject();
		if (empty($is_valid)) {
			trigger_error ("oSRS Error - Failed validation.", E_USER_WARNING);
		};

		$cmd = array(
			'protocol' => 'XCP',
			'action' => 'get',
			'object' => 'domain',
			'attributes' => array (
				'type' => $this->_dataObject->data->type
			)
		);
		
		if (!empty($this->_dataObject->data->cookie)) $cmd['cookie'] = $this->_dataObject->data->cookie;
		if (!empty($this->_dataObject->data->domain)) $cmd['domain'] = $this->_dataObject->data->domain;
		if (!empty($this->_dataObject->data->registrant_ip)) $cmd['registrant_ip'] = $this->_dataObject->data->registrant_ip;
				
		// Command optional values
		if (!empty($this->_dataObject->data->limit)) $cmd['attributes']['limit'] = $this->_dataObject->data->limit;
		if (!empty($this->_dataObject->data->page)) $cmd['attributes']['page'] = $this->_dataObject->data->page;
		if (!empty($this->_dataObject->data->max_to_expiry)) $cmd['attributes']['max_to_expiry'] = $this->_dataObject->data->max_to_expiry;
		if (!empty($this->_dataObject->data->min_to_expiry)) $cmd['attributes']['min_to_expiry'] = $this->_dataObject->data->min_to_expiry;
		
		$this->response = openSRS_base::call($this->_formatHolder, $cmd);
	}
}
