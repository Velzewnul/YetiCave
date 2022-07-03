<form class="form form--add-lot container form--invalid" action="add.php" method="post"> <!-- form--invalid -->
<?php $classname = isset($errors) ? "form--invalid" : ""; ?>
    <h2>Добавление лота</h2>
    <div class="form__container-two">
        <div class="form__item form__item--invalid"> <!-- form__item--invalid -->
            <?php $classname = isset($errors['lot_title']) ? "form__item--invalid" : ""; ?>
            <label for="lot_title">Наименование <sup>*</sup></label>
            <input id="lot_title" type="text" name="lot_title" placeholder="Введите наименование лота">
            <span class="form__error">Введите наименование лота</span>
        </div>
        <div class="form__item">
            <?php $classname = isset($errors['category']) ? "form__item--invalid" : ""; ?>
            <label for="category">Категория <sup>*</sup></label>
            <select id="category" name="category">
                <?php foreach ($categories as $category): ?>
                <option><?= $category["character_code"]; ?></option>
                <?php endforeach; ?>
            </select>
            <span class="form__error">Выберите категорию</span>
        </div>
    </div>
    <div class="form__item form__item--wide">
        <?php $classname = isset($errors['lot_description']) ? "form__item--invalid" : ""; ?>
        <label for="lot_description">Описание <sup>*</sup></label>
        <textarea id="lot_description" name="lot_description" placeholder="Напишите описание лота"></textarea>
        <span class="form__error">Напишите описание лота</span>
    </div>
    <div class="form__item form__item--file">
        <?php $classname = isset($errors['lot_image']) ? "form__item--invalid" : ""; ?>
        <label>Изображение <sup>*</sup></label>
        <div class="form__input-file">
            <input class="visually-hidden" type="file" id="lot_image" value="" name="lot_image">
            <label for="lot_image">
                Добавить
            </label>
        </div>
    </div>
    <div class="form__container-three">
        <div class="form__item form__item--small">
            <?php $classname = isset($errors['start_price']) ? "form__item--invalid" : ""; ?>
            <label for="start_price">Начальная цена <sup>*</sup></label>
            <input id="start_price" type="text" name="start_price" placeholder="0">
            <span class="form__error">Введите начальную цену</span>
        </div>
        <div class="form__item form__item--small">
            <?php $classname = isset($errors['bet_step']) ? "form__item--invalid" : ""; ?>
            <label for="bet_step">Шаг ставки <sup>*</sup></label>
            <input id="bet_step" type="text" name="bet_step" placeholder="0">
            <span class="form__error">Введите шаг ставки</span>
        </div>
        <div class="form__item">
            <?php $classname = isset($errors['end_date']) ? "form__item--invalid" : ""; ?>
            <label for="end_date">Дата окончания торгов <sup>*</sup></label>
            <input class="form__input-date" id="end_date" type="text" name="end_date" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
            <span class="form__error">Введите дату завершения торгов</span>
        </div>
    </div>
    <?php if (isset($errors)): ?>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <ul>
        <?php foreach ($errors as $val): ?>
            <li><strong><?= $val; ?>:</strong></li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
    <button type="submit" class="button">Добавить лот</button>
</form>
