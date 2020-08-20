<main>
    <form action="<?php echo HOME_URI;?>noticia/edicao" method="POST" >
        <fieldset>
            <legend>Editar Noticia</legend>
            <input type="hidden" name="id" value="<?php echo($id); ?>"/>
            <div class="row">
                <input type="text" name="titulo" placeholder="Titulo"/>
            </div>
            <div class="row">
                <textarea rows = '5' cols = '60' name="descricao" placeholder="Descrição"></textarea>
            </div>
            <div class="row">
                <input type="submit" name="editar" value="Editar" />
            </div>
        </fieldset>
    </form>
</main>