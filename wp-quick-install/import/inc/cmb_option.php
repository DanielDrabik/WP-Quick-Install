<?php

class cmbOption {

	public $prefix;
	public $option_key;
	public $title;

	private $metabox;

	private $tabsSetting;
	private $currentTab = null;

	private $currentField = null;

	public function __construct($option_key, $title) {

		$this->option_key = $option_key;
		$this->title = $title;

		$this->metabox = array(
			'id'          => $this->option_key . '_metabox',
			'title'       => __( $this->title, 'cmb2' ),
			'show_names'  => true,
			'object_type' => 'options-page',
			'show_on'     => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->option_key )
			),
		);

		$this->tabsSetting  = array(
	        'config' => $this->metabox,
	        //'layout' => 'vertical', // Default : horizontal
	        'tabs'   => array()
	    );
	}

	public function addTab($prefix, $title) {

		if($this->currentField != null) {
			$this->currentTab['fields'][] = $this->currentField;
			$this->currentField = null;
		}				

		if($this->currentTab != null) 
			$this->tabsSetting['tabs'][] = $this->currentTab;

		$this->currentTab = array(
	        'id'     => $prefix,
	        'title'  => __( $title, 'cmb2' ),
	        'fields' => array()
	    );
	}

	public function addField($id, $name, $type, $group_id = null) {

		if($group_id != null) {

			$this->currentField['fields'][] =  array(
			        'name' => __( $name, 'cmb2' ),
			        'id'   => $id,
			        'type' => $type,
			    );			
		}
		else {

			if($this->currentField != null)
				$this->currentTab['fields'][] = $this->currentField;

			
			$this->currentField =  array(
		        'name' => __( $name, 'cmb2' ),
		        'id'   => $id,
		        'type' => $type,
		    );
			
		}
	}

	public function generateCMB() {

		if($this->currentField != null)
				$this->currentTab['fields'][] = $this->currentField;

		if($this->currentTab != null) 
			$this->tabsSetting['tabs'][] = $this->currentTab;

		return $this->metabox;
	}

	public function generateTabs() {

		$tabs = array(
	        'id'   => $this->option_key . '__tabs',
	        'type' => 'tabs',
	        'tabs' => $this->tabsSetting,
	    );

	    return $tabs;
	}

}
