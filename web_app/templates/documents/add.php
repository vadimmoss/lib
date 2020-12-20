<?php include __DIR__ . '/../header.php'; ?>
<!--    <h1>Добавление нового документа</h1>-->
<?php //if(!empty($error)): ?>
<!--    <div style="color: red;">--><?//= $error ?><!--</div>-->
<?php //endif; ?>
<!---->
<!--    <form name="uploadImageForm"  action="/documents/add" method="post">-->
<!--        <label for="name">Название документк</label><br>-->
<!--        <input type="text" name="name" id="name" value="--><?//= $_POST['name'] ?? '' ?><!--" size="50"><br>-->
<!--        <br>-->
<!--        <label for="date">Дата издания документа</label><br>-->
<!--        <input type="text" name="date" id="date" value="--><?//= $_POST['date'] ?? '' ?><!--" size="50"><br>-->
<!--        <br>-->
<!--        <label for="lang">Язык документа</label><br>-->
<!--        <input type="text" name="lang" id="lang" value="--><?//= $_POST['lang'] ?? '' ?><!--" size="50"><br>-->
<!--        <br>-->
<!--        <label for="description">Описание документа</label><br>-->
<!--        <textarea name="description" id="description" rows="10" cols="80">--><?//= $_POST['description'] ?? '' ?><!--</textarea><br>-->
<!--        <label for="image">Загрузите содержание документа</label><br>-->
<!--        <input type="file" name="image" id="image"><br>-->
<!--        <button type="button" id="submit-upload" value="Загрузить">Загрузить</button><br>-->
<!--        <br>-->
<!--        <label for="contests">Содержание</label><br>-->
<!--        <textarea name="contests" id="contests" rows="10" cols="80"></textarea><br>-->
<!--        <br>-->
<!--        <br>-->
<!---->
<!--        <input type="submit" value="Создать">-->
<!--    </form>-->




    <div class="block-name">Додати документ</div>
<?php if($error):?>
<div class="error-block"><?= $error ?></div>
<?php endif;?>
    <div class="add-document-form-container">
        <div class="column-container">
        <div class="filter-block">

            <div class="doc-left-block">
                <form name="uploadImageForm"  action="/documents/add" method="POST" enctype="multipart/form-data" class="add-document-form">
                    <div class="form-row">
                        <label for="name"> Назва документу:</label>
                        <div><input id="name" type="text" name="name"></div>
                    </div>
                    <div class="form-row">
                        <label for="author"> Автор:</label>
                        <div><input id="author" type="text" name="author"></div>
                    </div>
                    <div class="form-row">
                        <label for="publisher">Видавнитство:</label>
                        <div><input id="publisher" type="text" name="publisher"></div>
                    </div>
                    <div class="form-row">
                        <label for="date"> Рік видання:</label>
                        <div><input id="date" type="text" name="date"></div>
                    </div>
                    <div class="form-row">
                        <label for="lang"> Мова документу:</label>
                        <div>
                            <select id="lang" name="lang">
                                <option value="">Будь-яка</option>
                                <option value="ua">Українська</option>
                                <option value="rus">Російська</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="count-pages">Кількість сторінок:</label>
                        <div><input id="count-pages" type="text" name="count-pages"></div>
                    </div>
                    <div class="form-row">
                        <label for="description">Опис документа:</label>
                        <div><textarea id="description" name="description"></textarea></div>
                    </div>
                    <div class="form-row">
                        <label for="image"> Зміст:</label>
                        <div>
                            <input id="image" type="file" name="image">
                            <button type="button" id="submit-upload">Загрузить</button>
                        </div>
                    </div>
                    <div class="form-row">
                        <div><label for="contests"></label><textarea id="contests" name="contests"></textarea></div>
                    </div>
                    <div class="form-row">
                        <label class="label" for="image-doc">Обложка:
                            <span  class="add-file">Завантажити файл</span>
                            <input style="display: none" id="image-doc" type="file" name="cover-doc">
                        </label>
                    </div>
                    <div class="form-row">
                        <label class="label" for="doc">Документ:
                            <span  class="add-file">Завантажити файл</span>
                            <input style="display: none" id="doc" type="file" name="doc">
                        </label>
                    </div>
<!--                    <div><input class="btn-anim" type="submit" value="Додати"></div>-->

                    <div class="button-container"> <button type="submit" class="add-submit btn-anim">Додати</button></div>

            </div>
            <div class="doc-right-block">
                <div class="themes-filter-add">
                    <?php
                    function listThree($arr)
                    {

                        if ($arr['class_name'] !== null) {
                            echo '<ul class="ul " style="display: none">';
                            $id_theme = \Library\Models\Classifications\Classification::getIdThemeByClass($arr['id']);
                            if($id_theme == 0){
                                $id_theme = $arr['id'];
                            }
                            echo '<li><a class="class-name">' . $arr['class_name'] . '</a> <input name="classification['.$id_theme. ']" class="clchk" value="' .  $id_theme . '" type="checkbox"></li>';
                            if (isset($arr['children'])) {
                                if ($arr['children'] !== null) {
                                    foreach ($arr['children'] as $child) {
                                        listThree($child);
                                    };
                                }
                            };
                            echo '</ul>';
                        };
                    }
                    foreach ($classification::buildClassTree() as $class)
                    {

                        if($class['children'] !== null){
                            $id_theme = \Library\Models\Classifications\Classification::getIdThemeByClass($class['id']);
                            if($id_theme == 0){
                                $id_theme = $class['id'];
                            }
                            echo '<ul class="ul" > ' . '<li><a class="class-name">' .  $class['class_name'] . '</a><input name="classification[' .   $id_theme . ']" class="clchk" value="' .  $id_theme . '" type="checkbox"></li>';
                            foreach ($class['children'] as $child){
                                listThree($child);
                            };
                            echo '</ul>';
                        }
                    }

                    ?>
                </div>
            </div>
            </form>
        </div>

        </div>

    </div>
    <script src="/www/jsvascript.js"></script>
    <script>
        $('.class-name').click(function(event) {
            $(this).parent().parent("ul").children().find("ul").slideToggle('fast');
            // if($(this).children().children(".clchk").prop( "checked") === true){
            //     $(this).children().children(".clchk").prop( "checked", false );
            //     $(this).children().find(".clchk").prop( "checked", false );
            // } else {
            //     $(this).parents().find(".clchk").prop( "checked", false );
            //     $(this).parents().find(".ul").css('border-left', 'none');
            //     $(this).children().children(".clchk").prop( "checked", true );
            //     $(this).css('border-left', '3px solid black');
            //
            // }

            $(this).parent().parent("ul").children("ul>ul").slideToggle('fast');

            event.stopPropagation();
        });
        $('.clchk').click(function(event) {
            if($(this).prop("checked") === true) {
                $(this).parent().parent("ul").children().find(".clchk").prop("checked", true);
            }
            else {
                $(this).parent().parent("ul").children().find(".clchk").prop("checked", false);
            }
            event.stopPropagation();
        });
    </script>
<?php //include __DIR__ . '/../footer.php'; ?>