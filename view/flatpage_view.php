<?php
/**
 * Template displayed when the requested content is found
 *
 * The template defined variables are:<br />
 * - <b>title</b>: the page title<br />
 * - <b>date</b>: the page date<br />
 * - <b>subtitle</b>: the page subtitle<br />
 * - <b>abstract</b>: the page abstract<br />
 * - <b>text</b>: the page text<br />
 * 
 * @package jeff-flatpage
 * @version 1.21
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
