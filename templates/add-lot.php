<?php $classname = isset($errors) ? "form--invalid" : ""; ?>
<form class="form form--add-lot container form--invalid <?= $classname; ?>" action="add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
    <h2>Добавление лота</h2>
    <div class="form__container-two">
        <?php $classname = isset($errors['lot_title']) ? "form__item--invalid" : ""; ?>
        <div class="form__item form__item--invalid <?= $classname; ?>"> <!-- form__item--invalid -->

            <label for="lot_title">Наименование <sup>*</sup></label>
            <input id="lot_title" type="text" name="lot_title" placeholder="Введите наименование лота" value="<?= $lot['lot-name'] ;?>">
            <span class="form__error">Введите наименование лота</span>
        </div>
        <?php $classname = isset($errors['category']) ? "form__item--invalid" : ""; ?>
        <div class="form__item <?= $classname; ?>">
            <label for="category">Категория <sup>*</sup></label>
            <select id="category" name="category" placeholder="Выберите категорию">
                <?php foreach ($categories as $category): ?>
                <option value="<?= $category["id"]; ?>"><?= $category["category_name"]; ?></option>
                <?php endforeach; ?>
            </select>
            <span class="form__error"><?= $errors["category"]; ?></span>
        </div>
    </div>
    <?php $classname = isset($errors['lot_description']) ? "form__item--invalid" : ""; ?>
    <div class="form__item form__item--wide <?= $classname; ?>">
        <label for="lot_description">Описание <sup>*</sup></label>
        <textarea id="lot_description" name="lot_description" placeholder="Напишите описание лота"><?= $lot["lot_description"] ?></textarea>
        <span class="form__error">Напишите описание лота</span>
    </div>
    <?php $classname = isset($errors['lot_image']) ? "form__item--invalid" : ""; ?>
    <div class="form__item form__item--file <?= $classname; ?>">
        <label>Изображение <sup>*</sup></label>
        <div class="form__input-file">
            <input class="visually-hidden" type="file" id="lot_image" value="" name="lot_image">
            <label for="lot_image">
                Добавить
            </label>
        </div>
        <span class="form__error"><?= $errors["lot_image"]; ?></span>
    </div>
    <div class="form__container-three">
        <?php $classname = isset($errors['start_price']) ? "form__item--invalid" : ""; ?>
        <div class="form__item form__item--small <?= $classname; ?>">
            <label for="start_price">Начальная цена <sup>*</sup></label>
            <input id="start_price" type="text" name="start_price" placeholder="0" value="<?= $lot['start_price']; ?>">
            <span class="form__error"><?= $errors['start_price']; ?></span>
        </div>
        <?php $classname = isset($errors['bet_step']) ? "form__item--invalid" : ""; ?>
        <div class="form__item form__item--small <?= $classname; ?>">
            <label for="bet_step">Шаг ставки <sup>*</sup></label>
            <input id="bet_step" type="text" name="bet_step" placeholder="0" value="<?= $lot['bet_step']; ?>">
            <span class="form__error"><?= $errors['bet_step']; ?></span>
        </div>
        <?php $classname = isset($errors['end_date']) ? "form__item--invalid" : ""; ?>
        <div class="form__item <?= $classname; ?>">
            <label for="end_date">Дата окончания торгов <sup>*</sup></label>
            <input class="form__input-date" id="end_date" type="text" name="end_date" placeholder="Введите дату в формате ГГГГ-ММ-ДД"
            value="<?= $lot['end_date']; ?>">
            <span class="form__error"><?= $errors['bet_step']; ?></span>
        </div>
    </div>

    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Добавить лот</button>
</form>

