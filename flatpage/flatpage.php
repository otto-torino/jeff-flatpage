<?php

class flatpage extends model {

	function __construct($registry, $id) {
	
		$this->_registry = $registry;
		$this->_tbl_data = TBL_FLATPAGE;
		parent::__construct($this->initP($id));

	}

	private function initP($id) {

		return $this->initDbProp($id);

	}

	public static function getFromSlug($registry, $slug) {
		
		$rows = $registry->db->autoSelect("id", TBL_FLATPAGE, "slug='$slug'", "date DESC", array(0, 1));	

		return count($rows) ? new flatpage($registry, $rows[0]['id']) : null;

	}

}

?>
