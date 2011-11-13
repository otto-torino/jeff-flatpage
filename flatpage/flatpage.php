<?php
/**
 * The flatpage model
 * 
 * @package jeff-flatpage
 * @version 1.0
 * @copyright 2011 Otto srl
 * @author abidibo <abidibo@gmail.com> 
 * @license http://www.opensource.org/licenses/mit-license.php MIT license
 */

/**
 * The flatpage model class 
 * 
 * Inherits from jeff model class.<br />
 * This class defines the flatpage fields and provides a method to retrieve an object from a slug (url request) 
 *
 * Model fields:<br />
 * - int <b>id</b>: page identifier<br />
 * - string <b>date</b>: page date<br />
 * - string <b>title</b>: page title<br />
 * - string <b>slug</b>: url query string<br />
 * - string <b>subtitle</b>: page subtitle<br />
 * - string <b>abstract</b>: page abstract<br />
 * - string <b>text</b>: page text<br />
 * - string <b>image1</b>: first image filename<br />
 * - string <b>image2</b>: second image filename<br />
 * - string <b>video1</b>: first video url code (youtube)<br />
 * - string <b>video2</b>: second video url code (youtube)<br />
 * - string <b>groups</b>: comma separated list of system group ids who may access the content. If empty the content is visible to everyone.
 *
 * @uses model
 * @package jeff-flatpage 
 * @version 1.0
 * @copyright 2011 Otto srl
 * @author abidibo <abidibo@gmail.com> 
 * @license http://www.opensource.org/licenses/mit-license.php MIT license
 */
class flatpage extends model {

	/**
	 * flatpage model constructor 
	 * 
	 * @param registry $registry 
	 * @param int $id 
	 * @access public
	 * @return void
	 */
	function __construct($registry, $id) {
	
		$this->_registry = $registry;
		$this->_tbl_data = TBL_FLATPAGE;
		parent::__construct($this->initP($id));

	}

	/**
	 * Initialize the class properties retrieving them from database 
	 * 
	 * @param int $id 
	 * @access private
	 * @return array[string]mixed
	 */
	private function initP($id) {

		return $this->initDbProp($id);

	}

	/**
	 * Get flatpage object from slug
	 *
	 * Perform an sql select statement to retrieve page data from given slug.<br />
	 * Return a model instance if the slug is found, null otherwise  
	 * 
	 * @param registry $registry 
	 * @param string $slug 
	 * @static
	 * @access public
	 * @return mixed
	 */
	public static function getFromSlug($registry, $slug) {
		
		$rows = $registry->db->autoSelect("id", TBL_FLATPAGE, "slug='$slug'", "date DESC", array(0, 1));	

		return count($rows) ? new flatpage($registry, $rows[0]['id']) : null;

	}

}

?>
