<main>
<a href="<?php echo HOME_URI;?>usuario/criar" class="btn">ADD</a>
<table class="table">
<thead>
    <tr><td><b>#</b></td><td><b>Nome</b></td><td><b>Email</b></td><td><b>Editar</b></td><td><b>Deletar</b></td></tr>
    <?php
        if(isset($usuarios)){
            foreach ($usuarios as $usuario){
                echo("<tr><td>$usuario->id</td><td>$usuario->nome</td><td>$usuario->email</td><td><a href='".HOME_URI."usuario/editar/".$usuario->id."'"."><span class='glyphicon glyphicon-edit'></span></a></td><td><a href='".HOME_URI."usuario/deletar/".$usuario->id."'"."><span class='glyphicon glyphicon-trash'></span></a></td></tr>");
            }
        }
    ?>
</thead>
</table>
</main>

