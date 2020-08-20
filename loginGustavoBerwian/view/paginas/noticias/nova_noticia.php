<main>
    <form action="<?php echo HOME_URI;?>noticia/salvar" method="POST" >
        <fieldset>
            <legend>Nova Noticia</legend>
            <input type="hidden" name="id" value="<?php echo($_SESSION['usuario']['id']); ?>"/>
            <div class="row">
                <input type="text" name="titulo" placeholder="Titulo"/>
            </div>
            <div class="row">
                <textarea rows = '5' cols = '60' name="descricao" placeholder="Descrição"></textarea>
            </div>
            <div class="row">
                <input type="submit" name="publicar" value="Publicar" />
            </div>
        </fieldset>
    </form>
</main>
