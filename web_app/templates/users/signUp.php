<?php include __DIR__ . '/../header.php'; ?>
<div class="form-container-register">

    <h1>Регистрация</h1>
    <?php if (!empty($error)): ?>
        <div style="background-color: red;padding: 5px;margin: 15px"><?= $error ?></div>
    <?php endif; ?>
    <form action="/users/register" method="post" class="register-form">
        <div class="form-row">
            <label for="nickname">Ваш нікнейм</label>
            <div><input type="text" id="nickname" name="nickname" value="<?= $_POST['nickname'] ?? '' ?>"></div>
        </div>
        <div class="form-row">
            <label for="age">Ваш вік</label>
            <div><input id="age" type="number" name="age" value="<?= $_POST['age'] ?? '' ?>"></div>
        </div>
        <div class="form-row">
            <label for="email">Email</label>
            <div><input id="email" type="text" name="email" value="<?= $_POST['email'] ?? '' ?>"></div>
        </div>
        <div class="form-row">
            <label for="password">Пароль </label>
            <div><input id="password" type="password" name="password" value="<?= $_POST['password'] ?? '' ?>"></div>
        </div>
        <div class="register-btn-container"><input class="btn-anim register-btn" type="submit" value="Зареєструватися">
        </div>

    </form>
</div>
