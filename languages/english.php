<?php
/**
 * Contains the string used for english localization.
 *
 * Append the following array items to the english.php language file inside the used theme folder (or the default one)<br />
 * <pre>ROOT/themes/default/languages/english.php</pre>
 *
 * @package jeff-flatpage
 * @version 1.21
 * @copyright 2011 Otto srl
 * @author abidibo <abidibo@gmail.com> 
 * @license http://www.opensource.org/licenses/mit-license.php MIT license
 */
$trnsls = array(
	"FlatpageAdminFormInformation"=>"<p>Images and videos may be placed inside the text using the following tags:</p>
		<ul>
			<li>{{image1 width=200 position=left lightbox=true}}</li>
			<li>{{image2 width=500}}</li>
			<li>{{video1 width=640 height=510}}</li>
		</ul>
		<p>The order of the attributes <b>must be</b> the following: width - height - position - lightbox.</p>
		<p>Video by default have the dimensions 480x390.</p>
		<p>The <i>lightbox</i> attribute allows to have the lightbox effect over images. The videos are always shown in an iframe inside the page.</p>
		<p>The <i>position</i> may assume the following values: left|right|block. If not specified the default <i>inline</i> behavior is considered.</p>
		<ul>
			<li>left: image floating on the left</li>
			<li>right: image floating on the right</li>
			<li>block: image like a block element, the following text stays on the following line.</li>
		</ul>
		<p>To have a public page (visible to all) do not select any group, otherwise the page access will be restricted only to the selected groups.</p>",
	"FlatpageNotExistsTitle"=>"Page not found",
	"FlatpageNotExistsText"=>"The page your're searching for doesn't exists! Maybe it has been removed or the url has changed.",
	"FlatpageForbiddenTitle"=>"Forbidden",
	"FlatpageForbiddenText"=>"The content your're trying to access is forbidden."	
);

?>
