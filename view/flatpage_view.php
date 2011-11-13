<?php
/**
 * Template displayed when the requested content is found
 *
 * The template defined variables are:<br/>
 * <ul>
 * <li><b>title</b>: the page title</li>
 * <li><b>date</b>: the page date</li>
 * <li><b>subtitle</b>: the page subtitle</li>
 * <li><b>abstract</b>: the page abstract</li>
 * <li><b>text</b>: the page text</li>
 * </ul>
 * 
 * @package jeff-flatpage
 * @version 1.0
 * @copyright 2011 Otto srl
 * @author abidibo <abidibo@gmail.com> 
 * @license http://www.opensource.org/licenses/mit-license.php MIT license
 */
?>
<section>
<h1><?= $title ?></h1>
<? if($date): ?>
<h4><?= $date ?></h4>
<? endif ?>
<? if(isset($subtitle)): ?>
<h3><?= $subtitle ?></h3>
<? endif ?>
<? if($abstract): ?>
<div class="abstract"><?= $abstract ?></div>
<? endif ?>
<div>
<?= $text ?>
</div>
</section>
