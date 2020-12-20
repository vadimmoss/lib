<?php include __DIR__ . '/../header.php'; ?>

<?php if (!empty($error)): ?>
    <div style="background-color: red;padding: 5px;margin: 15px"><?= $error ?></div>
<?php endif; ?>
<div class="form-container-login">
    <h1>Вхід</h1>
    <form action="/users/login" method="post" class="login-form">
        <div class="form-row">
            <label for="email">Email</label>
            <div><input id="email" type="text" name="email" value="<?= $_POST['email'] ?? '' ?>"></div>
        </div>
        <div class="form-row">
            <label for="password">Пароль </label>
            <div><input id="password" type="password" name="password" value="<?= $_POST['password'] ?? '' ?>"></div>
        </div>
        <div class="butt-container"><input class="btn-anim" type="submit" value="Увійти"></div>

    </form>
</div>
</div>
