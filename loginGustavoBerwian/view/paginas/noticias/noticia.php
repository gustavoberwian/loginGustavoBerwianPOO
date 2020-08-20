<html>
<main>
<div class="panel-heading"><h1>Notícias</h1></div>
<div class="panel panel-primary">

<div class="panel-heading"><h1><?php echo $noticia->titulo ?></h1></div>
    <?php echo $noticia->descricao?>

    <div class='data'>
        <span class="label label-primary"><?php echo $noticia->data ?></span>
        <span class="label label-primary"><?php echo "Por:".$noticia->nome_usuario ?></span>
    </div>

    </div>

    <div class="panel panel-primary">

        <div class="panel-heading">
            <h5 class="panel-title">Comentários</h5>
        </div>
        <?php
            include HOME_DIR."classes/Comentario.php";
            $comentario = new Comentario();
            $comentarios = $comentario->listarComentarios($noticia->id);
        ?>
        <div class="coments">
            <?php
                if($comentarios){
                    foreach($comentarios as $comentario){
            ?>
            <p class="nome-user"><?php echo($comentario->nome) ?></p>
            <p class="coment-user"><?php echo($comentario->comentario) ?></p>
                        <?php
                        if(isset($_SESSION['usuario'])) {
                            echo("<a href='" . HOME_URI . "comentario/excluir/" . $noticia->id . "/" . $comentario->id . "'"." ><span class='glyphicon glyphicon-trash'></span></a>");
                        }
                    }
                }
            ?>
        </div>

         <form class="form" action="<?php echo HOME_URI;?>comentario/salvar/<?php echo $noticia->id ?>"method="POST">
            <div class="form-group">
            <input name="comentario" type="text" class="form-control" placeholder="Adicione um comentário">
            <div class="input-form">
            <input name="enviar" type="submit" class="btn btn-primary btn-sm">
            </div>
            </div>      
            
        </form>

    </div>

    

</div>
    

</main>
</html>