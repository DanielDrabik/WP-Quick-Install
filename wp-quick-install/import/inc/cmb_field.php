<?php

class cmbField {

	public $prefix;
	public $title;
	public $type;
	public $show_on;

	private $metabox;
	private $tabsSetting;
	private $currentTab = null;
	private $currentTabId = 0;

	private $currentField = null;


	public function __construct( $prefix, $title, $type = array(), $show_on = array()) {

		$this->prefix = $prefix;
		$this->title = $title;
		$this->type = $type;
		$this->show_on = $show_on;

		$this->metabox = array(
	        'id' => $this->prefix . 'metabox',
	        'title' => esc_html__($this->title, 'cmb2'),
	        'object_types' => $this->type,
	        'show_on' => $this->show_on,
	        'closed' => false, // true to keep the metabox closed by default
	    );

	    $this->tabsSetting  = array(
	        'config' => $this->metabox,
	        'layout' => 'vertical', // Default : horizontal
	        'tabs'   => array()
	    );
	}

	public function addTab($title) {

		if($this->currentField != null) {
			$this->currentTab['fields'][] = $this->currentField;
			$this->currentField = null;
		}				

		if($this->currentTab != null) 
			$this->tabsSetting['tabs'][] = $this->currentTab;

		$this->currentTabId++;
		$this->currentTab = array(
	        'id'     => $this->prefix. $this->currentTabId,
	        'title'  => __( $title, 'cmb2' ),
	        'fields' => array()
	    );
	}

	public function addField($id, $name, $type, $group_id = null) {

		if($group_id != null) {

			$this->currentField['fields'][] =  array(
			        'name' => __( $name, 'cmb2' ),
			        'id'   => $this->prefix. $this->currentTabId .'_'. $id,
			        'type' => $type,
			    );			
		}
		else {

			if($this->currentField != null)
				$this->currentTab['fields'][] = $this->currentField;

			
			$this->currentField =  array(
		        'name' => __( $name, 'cmb2' ),
		        $this->prefix. $this->currentTabId .'_'. $id,
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
	        'id'   => $this->prefix . '__tabs',
	        'type' => 'tabs',
	        'tabs' => $this->tabsSetting,
	    );

	    return $tabs;
	}

}
