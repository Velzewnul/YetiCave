<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $category): ?>
                <li class="nav__item">
                    <a href="pages/all-lots.html"><?= $category["category_name"]; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <?php $classname = isset($errors) ? "form--invalid" : ""; ?>
    <form class="form container <?= $classname; ?>" action="signup.php" method="post" autocomplete="off"
          enctype="multipart/form-data"> <!-- form
    --invalid -->
        <h2>Регистрация нового аккаунта</h2>
        <?php $classname = isset($errors['email']) ? "form__item--invalid" : ""; ?>
        <div class="form__item <?= $classname; ?>"> <!-- form__item--invalid -->
            <label for="email">E-mail <sup>*</sup></label>
            <input id="email" type="email" name="email" placeholder="Введите e-mail" value="<?= $user['email']; ?>">
            <span class="form__error"><?= $errors['email']; ?></span>
        </div>
        <?php $classname = isset($errors['password']) ? "form__item--invalid" : ""; ?>
        <div class="form__item <?= $classname; ?>">
            <label for="password">Пароль <sup>*</sup></label>
            <input id="password" type="password" name="password" placeholder="Введите пароль"
                   value="<?= $user['password']; ?>">
            <span class="form__error"><?= $errors['password']; ?></span>
        </div>
        <?php $classname = isset($errors['name']) ? "form__item--invalid" : ""; ?>
        <div class="form__item <?= $classname; ?>">
            <label for="name">Имя <sup>*</sup></label>
            <input id="name" type="text" name="name" placeholder="Введите имя" value="<?= $user['name']; ?>">
            <span class="form__error"><?= $errors['name']; ?></span>
        </div>
        <?php $classname = isset($errors['contact_info']) ? "form__item--invalid" : ""; ?>
        <div class="form__item <?= $classname; ?>">
            <label for="contact_info">Контактные данные <sup>*</sup></label>
            <textarea id="contact_info" name="contact_info"
                      placeholder="Напишите как с вами связаться"><?= $user['contact_info']; ?></textarea>
            <span class="form__error"><?= $errors['contact_info']; ?></span>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Зарегистрироваться</button>
        <a class="text-link" href="login.php">Уже есть аккаунт</a>
    </form>
</main>
