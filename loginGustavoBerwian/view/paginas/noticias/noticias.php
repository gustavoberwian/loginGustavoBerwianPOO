<html>
<main>

<div class="panel-heading"><h1>Notícias</h1></div>
    <a href="<?php echo HOME_URI;?>noticia/criar" class="btn">ADD</a>

<?php
if(isset($noticias)){
    foreach($noticias AS $noticia){
    ?>
    <div class="panel panel-primary">
    <div class="panel-heading"><h2><?php echo $noticia->titulo ?></h2></div>
        <?php echo substr($noticia->descricao,0,180)."..." ?><a href="<?php echo HOME_URI."noticia/ver/".$noticia->id;?>">Ler mais</a>
        <div class='data'><span class="label label-primary"><?php echo $noticia->data ?></span><span class="label label-primary"><?php echo "Por:".$noticia->nome_usuario ?></span></div>

    </div>
    <?php
        echo("<a href='" . HOME_URI . "noticia/editar/" . $noticia->id . "'" . "><span class='glyphicon glyphicon-edit'></span></a><a href='" . HOME_URI . "noticia/excluir/" . $noticia->id . "'" . "><span class='glyphicon glyphicon-trash'></span></a>");
    }
}
?>
    

</main>
</html>