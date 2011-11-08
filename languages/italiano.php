<?php
// append the following array items to the italiano.php language file inside the the used theme folder
$trnsls = array(
	"FlatpageAdminFormInformation"=>"<p>Le immagini ed il video possono essere inseriti all'interno del testo nella posizione voluta utilizzando i seguenti tag:</p>
		<ul>
			<li>{{image1 width=200 position=left lightbox=true}}</li>
			<li>{{image width=500}}</li>
			<li>{{video1 width=640 height=510}}</li>
		</ul>
		<p>L'ordine degli attributi <b>deve essere necessariamente</b> width - height - position - lightbox.</p>
		<p>I video di default hanno dimensioni 480x390.</p>
		<p>L'attributo <i>lightbox</i> indica se aprire l'immagine con effetto lightbox, i video vengono sempre mostrati nella pagina all'interno di un iframe.</p>
		<p>L'attributo <i>position</i> può essere: left|right|block. Se non viene specificato si intende il comportamento di default (inline)</p>
		<ul>
			<li>left: immagine flottante sulla sinistra</li>
			<li>right: immagine flottante sulla destra</li>
			<li>block: immagine tipo blocco, il testo successivo va a capo</li>
		</ul>
		<p>Per rendere una pagina pubblica non selezionare alcun gruppo, per restringerne l'accesso solamente a certi gruppi selezionare quelli desiderati.</p>",
	"FlatpageNotExistsTitle"=>"Pagina non trovata",
	"FlatpageNotExistsText"=>"La pagina che stai cercando non esiste! Potrebbe essere stata rimossa oppure aver cambiato url.",
	"FlatpageForbiddenTitle"=>"Accesso negato",
	"FlatpageForbiddenText"=>"L'accesso ai contenuti richiesti è proibito."	
);

?>
