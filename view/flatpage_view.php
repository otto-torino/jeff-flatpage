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
