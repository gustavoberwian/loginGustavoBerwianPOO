<main>
    <form action="<?php echo HOME_URI;?>usuario/atualizar" method="POST">
        <fieldset>
            <legend>Atualize sua senha</legend>
            <input type="hidden" name="id" value="<?php echo($id); ?>"/>
            <div class="row">
                <input type="password" name="senha" placeholder="Nova senha"/>
            </div>
            <div class="row">
                <input type="password" name="confirmaSenha" placeholder="Confirme nova senha"/>
            </div>
            <div class="row">
                <input type="submit" name="editar" value="Editar" />
            </div>
        </fieldset>
    </form>

</main>