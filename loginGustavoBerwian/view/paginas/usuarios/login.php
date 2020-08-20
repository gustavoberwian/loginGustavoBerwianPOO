<main>
    <form action="<?php echo HOME_URI;?>usuario/autenticar" method="POST">
        <fieldset>
            <legend>Login de usuário</legend>
            <input type="hidden" name="id" />
            <div class="row">
                <input type="email" name="email" placeholder="Email"/>
            </div>
            <div class="row">
                <input type="password" name="senha" placeholder="Senha"/>
            </div>
            <div class="row">
                <input type="submit" name="login" value="Entrar" />
            </div>
        </fieldset>
    </form>

</main>