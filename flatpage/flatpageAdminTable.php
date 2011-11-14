<?php
/**
 * The flatpage admin table backoffice 
 * 
 * @package jeff-flatpage
 * @version 1.21
 * @copyright 2011 Otto srl
 * @author abidibo <abidibo@gmail.com> 
 * @license http://www.opensource.org/licenses/mit-license.php MIT license
 */

/**
 * flatpageAdminTable 
 *
 * Inherits from jeff adminTable class.<br />
 * This class allows the flatpage backoffice generation.
 *
 * @uses adminTable
 * @package jeff-flatpage 
 * @version 1.21
 * @copyright 2011 Otto srl
 * @author abidibo <abidibo@gmail.com> 
 * @license http://www.opensource.org/licenses/mit-license.php MIT license
 */
class flatpageAdminTable extends adminTable {
	
	/**
	 * flatpageAdminTable constructor
	 *
	 * Construct the parent class 
	 * 
	 * @param registry $registry 
	 * @param string $table 
	 * @param array[string]mixed $opts 
	 * @access public
	 * @return void
	 */
	function __construct($registry, $table, $opts=null) {
	
		parent::__construct($registry, $table, $opts);
	}

	/**
	 * Generation of backoffice pages list
	 *
	 * Add the url visualization to standard adminTable view list
	 * 
	 * @access public
	 * @return string
	 */
	public function view() {

		$order = cleanInput('get', 'order', 'string');

		$tot_fk = count($this->_fkeys);
		$tot_sf = count($this->_sfields);

		// get order field and direction
		preg_match("#^([^ ,]*)\s?((ASC)|(DESC))?.*$#", $order, $matches);
		$field_order = isset($matches[1]) ? $matches[1] : null;
		$order_dir = isset($matches[2]) ? $matches[2] : null;

		$fields_names = $this->_registry->db->getFieldsName($this->_table);

		$pag = new pagination($this->_registry, $this->_efp, $this->_registry->db->getNumRecords($this->_table, null, $this->_primary_key));

		$limit = array($pag->start(), $this->_efp);

		if(count($this->_changelist_fields)) {
			if(!in_array($this->_primary_key, $this->_changelist_fields)) 
				array_unshift($this->_changelist_fields, $this->_primary_key);
			$field_selection = isset($this->_fkeys[$field_order]) 
					? 'a.'.implode(', a.', $this->_changelist_fields)
					: implode(',', $this->_changelist_fields);
		}
		else 
			$field_selection = isset($this->_fkeys[$field_order]) ? "a.*" : "*"; 

		// different queries if the order field is a foreign key
		if(isset($this->_fkeys[$field_order])) {
			$records = $this->_registry->db->autoSelect($field_selection, array($this->_table." AS a", $this->_fkeys[$field_order]['table']." AS b"), "a.$field_order=b.".$this->_fkeys[$field_order]['key'], "b.".$this->_fkeys[$field_order]['order']." $order_dir", $limit);
		}
		else 
			$records = $this->_registry->db->autoSelect($field_selection, $this->_table, null, $order, $limit);

		$all = "<span class=\"link\" onclick=\"$$('#atbl_form input[type=checkbox]').setProperty('checked', 'checked');\">".__("all")."</span>";
		$none = "<span class=\"link\" onclick=\"$$('#atbl_form input[type=checkbox]').removeProperty('checked');\">".__("none")."</span>";
		$heads = ($this->_edit_deny != 'all' || $this->_export) ? array("0"=>"$all | $none") : array();
		foreach($fields_names as $fn) {
			if(!$this->_changelist_fields || in_array($fn, $this->_changelist_fields)) {
				$ord = $order == $fn." ASC" ? $fn." DESC" : $fn." ASC";

				if($order == $fn." ASC") {
					$jsover = "$(this).getNext('img').setProperty('src', '$this->_arrow_down_path')";
					$jsout = "$(this).getNext('img').setProperty('src', '$this->_arrow_up_path')";
					$a_style = "visibility:visible";
					$apath = $this->_arrow_up_path;
				}
				elseif($order == $fn." DESC") {
					$jsover = "$(this).getNext('img').setProperty('src', '$this->_arrow_up_path')";
					$jsout = "$(this).getNext('img').setProperty('src', '$this->_arrow_down_path')";
					$js = "$(this).getNext('img').getNext('img').setStyle('visibility', 'visible')";
					$a_style = "visibility:visible";
					$apath = $this->_arrow_down_path;
				}
				else {
					$js = '';
					$jsover = "$(this).getNext('img').setStyle('visibility', 'visible')";
					$jsout = "$(this).getNext('img').setStyle('visibility', 'hidden')";
					$a_style = "visibility:hidden";
					$apath = $this->_arrow_up_path;
				}

				$link = preg_replace("#/p/\d+/#", "/", $_SERVER['REQUEST_URI']);
				$link = preg_replace("#\?.*#", "", $link);
				$head_t = anchor($link."?order=$ord", __($fn), array('over'=>$jsover, 'out'=>$jsout));
				$heads[] = $head_t." <img src=\"$apath\" alt=\"down\" style=\"$a_style\" />";
			}
		}

		$heads[] = __("URL");

		$rows = array();
		foreach($records as $r) {
			$input = "<input type=\"checkbox\" name=\"f[]\" value=\"".$r[$this->_primary_key]."\" />";
			if($tot_fk) $r = $this->parseForeignKeys($r);
			if($tot_sf) $r = $this->parseSpecialFields($r);
			$r = $this->parseDateFields($r);
			$flatpage = new flatpage($this->_registry, $r['id']);
			$r = array_merge($r, array(ROOT."/flatpage/view/".$flatpage->slug));
			if($this->_edit_deny=='all' && !$this->_export) $rows[] = $r;
			elseif(is_array($this->_edit_deny) && in_array($r[$this->_primary_key], $this->_edit_deny)) $rows[] = array_merge(array(""), $r);
			else $rows[] = array_merge(array($input), $r);
		}

		$this->_view->setTpl('table');
		$this->_view->assign('class', 'generic wide');
		$this->_view->assign('caption', __("RecordInTable")." ".$this->_table);
		$this->_view->assign('heads', $heads);
		$this->_view->assign('rows', $rows);

		$table = $this->_view->render();

		if($this->_edit_deny!='all' || $this->_export) {
			$myform = new form($this->_registry, 'post', 'atbl_form', array("validation"=>false));
			$formstart = $myform->sform('?edit'.($order ? "&order=$order" : ""), null);
			$formend = $myform->cform();
		}
		else {
			$formstart = '';
			$formend = '';
		}

		if($this->_edit_deny=='all') {
			$input_edit = '';
			$input_delete = '';
		}
		else {
			$onclick = "var checked = false;
				    var felements = $$('#atbl_form input[type=checkbox]');
				    for(var i=0;i<felements.length;i++) if(felements[i].checked) {checked = true;break;}
				    if(!checked) {alert('".jsVar(__("SelectAtleastRecord"))."'); return false;}";
			$input_edit = $myform->input('submit_edit', 'submit', __("edit"), array("js"=>"onclick=\"$onclick\""));
			if($this->_deletion)
				$input_delete = $myform->input('submit_delete', 'submit', __("delete"), array("js"=>"onclick=\"$onclick return confirmSubmit('".jsVar(__("ProcedeDeleteSelectedRecords"))."')\""));
			else $input_delete = '';
		}

		if($this->_export) {
			$onclick = "var checked = false;
				    var felements = $$('#atbl_form input[type=checkbox]');
				    for(var i=0;i<felements.length;i++) if(felements[i].checked) {checked = true;break;}
				    if(!checked) {alert('".jsVar(__("SelectAtleastRecord"))."'); return false;}";
			$input_export_selected = $myform->input('submit_export_selected', 'submit', __("exportSelected"), array("js"=>"onclick=\"$onclick \""));
			$input_export_all = $myform->input('submit_export_all', 'submit', __("exportAll"), array());
			$input_where_query = $myform->hidden('where_query', '');
		
		}
		else {
			$input_export_selected = null;
			$input_export_all = null;
			$input_where_query = '';	
		}

		$link_insert = $this->_insertion ? anchor("?insert", __("insertNewRecord")) : null;

		$this->_view->setTpl('admin_table');
		$this->_view->assign('table', $table);
		$this->_view->assign('link_insert', $link_insert);
		$this->_view->assign('formstart', $formstart);
		$this->_view->assign('formend', $formend);
		$this->_view->assign('input_edit', $input_edit);
		$this->_view->assign('input_delete', $input_delete);
		$this->_view->assign('input_where_query', $input_where_query);
		$this->_view->assign('input_export_selected', $input_export_selected);
		$this->_view->assign('input_export_all', $input_export_all);
		$this->_view->assign('psummary', $pag->summary());
		$this->_view->assign('pnavigation', $pag->navigation());

		return $this->_view->render();
	}

	/**
	 * Management of modification actions 
	 *
	 * Generation of insertion/modification form. Management of deletion or export actions.
	 * 
	 * @param array[string]mixed $opts 
	 * @access public
	 * @return string
	 */
	public function editFields($opts=null) {
		
		$this->_view->setTpl('flatpage_admin_form', array());
		$this->_view->assign('information', __("FlatpageAdminFormInformation"));
		$this->_view->assign('edit_fields', parent::editFields());

		return $this->_view->render();

	}
}

?>
