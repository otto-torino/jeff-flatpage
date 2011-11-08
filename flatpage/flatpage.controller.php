<?php

require_once('flatpage.php');
require_once('flatpageAdminTable.php');

class flatpageController extends controller {

	function __construct($registry) {

		parent::__construct($registry);

		$this->_cpath = dirname(__FILE__);
		$this->_mdl_name = "flatpage";

		// privileges
		$this->_class_privilege = $this->_mdl_name;
		$this->_admin_privilege = 1;
	}

	public function view() {
	
		$slug = cleanInput("get", "id", "string");

		$fp = flatpage::getFromSlug($this->_registry, $slug);

		// 404 not found
		if(is_null($fp)) return $this->page404();
		// 403 forbidden
		if($fp->groups && !access::hasGroup($this->_registry, explode(",", $fp->groups))) return $this->page403();

		$this->_fp = $fp;
		$text = preg_replace_callback("#{{(image[12]|video[12])\s*(width=(\d+))?\s*(height=(\d+))?\s*(position=(\w+))?\s*(lightbox=(true|false))?}}#", array($this, 'parseDescription'), $fp->text);
		$text .= "<script>";
		$text .= "(function() {
			$$('.lightbox').cerabox({
				group: true,
				titleFormat: '{number} / {total} - {title}'
			});
		})()";

		$text .= "</script>";

		$this->_view->setTpl('flatpage_view');
		$this->_view->assign('date', $this->_registry->dtime->view($fp->date, "date"));
		$this->_view->assign('title', htmlVar($fp->title));
		$this->_view->assign('subtitle', htmlVar($fp->subtitle));
		$this->_view->assign('abstract', htmlVar($fp->abstract));
		$this->_view->assign('text', htmlVar($text));

		return $this->_view->render();

	}

	public function manage() {
	
		access::check($this->_registry, $this->_class_privilege, $this->_admin_privilege, array("exitOnFailure"=>true));

		$s_fields = array(
			"image1"=>array(
				"type"=>"file",
				"label"=>"image 1",
				"path"=>ABS_UPLOAD.DS.'flatpage',
				"preview"=>true,
				"rel_path"=>REL_UPLOAD.'/flatpage',
				"extensions"=>array("jpg", "png", "gif")	    
			),
			"image2"=>array(
				"type"=>"file",
				"label"=>"image 2",
				"path"=>ABS_UPLOAD.DS.'flatpage',
				"preview"=>true,
				"rel_path"=>REL_UPLOAD.'/flatpage',
				"extensions"=>array("jpg", "png", "gif")	    
			),
			"groups"=>array(
				"type"=>"multicheck",
				"value_type"=>"int",
				"table"=>TBL_SYS_GROUPS,
				"field"=>"label",
				"where"=>"",
				"order"=>'id'
			)
		);

		$html_fields = array("abstract", "text");

		$at = new flatpageAdminTable($this->_registry, TBL_FLATPAGE, array("changelist_fields"=>array("date", "title", "groups"), "editor"=>true));
		$at->setSpecialFields($s_fields);
		$at->setHtmlFields($html_fields);

		$table = $at->manage();

		$this->_view->setTpl('manage_table');
		$this->_view->assign('title', __("ManageTable")." ".__("Flatpage"));
		$this->_view->assign('table', $table);

		return $this->_view->render();
	}

	private function parseDescription($matches) {

		if($matches[1]=='image1' || $matches[1]=='image2') {
			$width = (isset($matches[3]) && $matches[3]) ? "width=\"".$matches[3]."px\"" : "";
			$height = (isset($matches[5]) && $matches[5]) ? "height=\"".$matches[5]."px\"" : "";
			$class = (isset($matches[7]) && $matches[7]) ? "class=\"".$matches[7]."\"" : "";
			$lightbox = (isset($matches[9]) && $matches[9]=='true') ? true : false;

			$imgfile = $this->_fp->{$matches[1]};

			$img_tag = "<img src=\"".REL_UPLOAD."/flatpage/".$imgfile."\" alt=\"".$imgfile."\" $width $height $class />";

			if($lightbox) 
				return "<a href=\"".REL_UPLOAD."/flatpage/".$imgfile."\" class=\"lightbox\" />$img_tag</a>";
			else return $img_tag;
		}
		elseif($matches[1]=='video1' || $matches[1]=='video2') {

			$width = isset($matches[3]) ? $matches[3] : 480;
			$height = isset($matches[5]) ? $matches[5] : 390;
			$class = isset($matches[5]) ? "class=\"".$matches[5]."\"" : "";

			$code = $this->_fp->{$matches[1]};

			return "<iframe width=\"$width\" height=\"$height\" src=\"http://www.youtube.com/embed/".$code."\" frameborder=\"0\" allowfullscreen></iframe>";

		}
	}

	private function page404() {
	
		$this->_view->setTpl('flatpage_404');
		$this->_view->assign('title', __("FlatpageNotExistsTitle"));
		$this->_view->assign('text', __("FlatpageNotExistsText"));

		return $this->_view->render();

	}

	private function page403() {
	
		$this->_view->setTpl('flatpage_403');
		$this->_view->assign('title', __("FlatpageForbiddenTitle"));
		$this->_view->assign('text', __("FlatpageForbiddenText"));

		return $this->_view->render();

	}

}

?>
