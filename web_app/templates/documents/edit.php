<?php
include __DIR__ . '/../header.php';
?>
    <div class="block-name">Редагування документу</div>
<?php if(!empty($error)): ?>
    <div style="color: red;"><?= $error ?></div>
<?php endif; ?>
    <form class="edit-form" action="/documents/<?= $document->getId() ?>/edit" method="post">
<!--        <label for="name">Название докумета</label><br>-->
<!--        <input type="text" name="name" id="name" value="--><?//= $_POST['name'] ?? $document->getDocumentName() ?><!--" size="50"><br>-->
<!--        <br>-->
<!--        <label for="date">Дата поубликации докумета</label><br>-->
<!--        <input type="text" name="date" id="date" value="--><?//= $_POST['date'] ?? $document->getDocumentPublicationDate() ?><!--" size="50"><br>-->
<!--        <br>-->
<!--        <label for="lang">Язык докумета</label><br>-->
<!--        <input type="text" name="lang" id="lang" value="--><?//= $_POST['lang'] ?? $document->getDocumentLang() ?><!--" size="50"><br>-->
<!--        <br>-->
<!--        <label for="text">Описание документа</label><br>-->
<!--        <textarea name="text" id="text" rows="10" cols="80">--><?//= $_POST['text'] ?? $document->getDocumentDescription() ?><!--</textarea><br>-->
<!--        <label for="contests">Содержание документа</label><br>-->
<!--        <textarea name="contests" id="contests" rows="10" cols="80">--><?//= $_POST['contests'] ?? $document->getDocumentContests() ?><!--</textarea><br>-->
<!--        <br>-->
<!--        <input type="submit" value="Обновить">-->
        <div class="form-row">
            <label for="name"> Назва документу:</label>
            <div><input id="name" type="text" value="<?= $_POST['name'] ?? $document->getDocumentName() ?>" name="name"></div>
        </div>
        <div class="form-row">
            <label for="author"> Автор:</label>
            <div><input id="author" value="<?= $_POST['author'] ?? $document->getDocumentAuthor() ?>" type="text" name="author"></div>
        </div>
        <div class="form-row">
            <label for="publisher">Видавнитство:</label>
            <div><input id="publisher" value="<?= $_POST['publisher'] ?? $document->getDocumentPublisher() ?>" type="text" name="publisher"></div>
        </div>
        <div class="form-row">
            <label for="date"> Рік видання:</label>
            <div><input id="date" value="<?= $_POST['date'] ?? $document->getDocumentPublicationDate() ?>" type="text" name="date"></div>
        </div>
        <div class="form-row">
            <label for="lang"> Мова документу:</label>
            <div>
                <select id="lang" name="lang">
                    <option value="">Будь-яка</option>
                    <option selected value="ua">Українська</option>
                    <option value="rus">Російська</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <label for="count-pages">Кількість сторінок:</label>
            <div><input id="count-pages" value="<?= $_POST['count-pages'] ?? $document->getDocumentCountPages() ?>" type="text" name="count-pages"></div>
        </div>
        <div class="form-row">
            <label for="description">Опис документа:</label>
            <div><textarea id="description"  name="description"><?= $_POST['description'] ?? $document->getDocumentDescription() ?></textarea></div>
        </div>
        <div class="form-row">
            <label for="contests"></label>
            <div><textarea id="contests" name="contests"><?= $_POST['contests'] ?? $document->getDocumentContests() ?></textarea></div>
        </div>
        <div class="edit-form-bottom"> <input class="btn-anim" type="submit" value="Зберегти"></div>

    </form>
<?php //include __DIR__ . '/../footer.php'; ?>