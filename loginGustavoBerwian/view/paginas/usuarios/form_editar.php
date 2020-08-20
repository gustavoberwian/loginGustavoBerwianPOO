<main>
    <form action="<?php echo HOME_URI;?>usuario/realizaEdicao" method="POST">
        <fieldset>
            <legend>Editar usuário</legend>
            <input type="hidden" name="id" value="<?php echo($id); ?>"/>
            <div class="row">
                <input type="text" name="nome" placeholder="Nome do usuário"/>
            </div>
            <div class="row">
                <input type="email" name="email" placeholder="Email"/>
            </div>
            <div class="row">
                <input type="password" name="senha" placeholder="Senha"/>
            </div>
            <div class="row">
                <input type="submit" name="editar" value="Editar" />
            </div>
        </fieldset>
    </form>
</main>