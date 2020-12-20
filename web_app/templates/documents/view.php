<?php include __DIR__ . '/../header.php';

?>

<div class="doc-container">

    <div class="doc-author"><?= $document->getDocumentAuthor() ?></div>
    <div class="doc-name"><?= $document->getDocumentName() ?></div>
    <div class="doc-info">
        <div class="doc-left-block">
            <div class="doc-main-info">
                <div class="doc-image-big-block">
                    <img class="doc-image-big" src="/<?= $document->getCover() ?>">
                    <?php
                    if(!empty($user)){
                    if($document->isInBookmarks($user->getId(), $document->getId()) == 0){
                        echo '<img value="'.$document->getId().'" class="like-image" src="/src/includes/icons/bookmark.png">';

                    }
                    else{
                        echo '<img value="'.$document->getId().'" class="like-image" src="/src/includes/icons/tag-true.png">';
                    }}else{
                        echo '<img value="' . $document->getId() . '" class="like-image" src="/src/includes/icons/bookmark.png">';
                    }
                    ?>
                </div>
                <div class="info-table">
                    <table>
                        <tr>
                            <td>Автор:</td>
                            <td><?= $document->getDocumentAuthor() ?></td>
                        </tr>
                        <tr>
                            <td>Видавнитство:</td>
                            <td><?= $document->getDocumentPublisher() ?></td>
                        </tr>
                        <tr>
                            <td>Дата видавнитства:</td>
                            <td><?= $document->getDocumentPublicationDate()?></td>
                        </tr>
                        <tr>
                            <td>Мова:</td>
                            <td><?= $document->getDocumentLang()?></td>
                        </tr>
                        <tr>
                            <td>Кількість сторінок:</td>
                            <td><?= $document->getDocumentCountPages() ?></td>
                        </tr>
                    </table>
                    <div class="info-buttons">
                        <div class="doc-views">
                            <img class="views-image" src="/src/includes/icons/glasses.svg">
                            <?= $document->getDocumentViews() ?>
                        </div>
                        <div class="doc-rating">

                        <?php if(!empty($user)){
                            for( $i = 1; $i <= $document->getDocumentRating(); $i++){
                            echo '<button class="rate-button" value="'.$i.'"><img class="star" src="/src/includes/icons/star-full.png"></button>';
                        }
                        for( $a = $i; $a <= 5; $a++){
                            echo '<button class="rate-button" value="'.$a.'"><img class="star" src="/src/includes/icons/star.svg"></button>';
                        }

                        }else{
                            for( $i = 1; $i <= $document->getDocumentRating(); $i++){
                                echo '<button disabled  class="rate-button" value="'.$i.'"><img class="star" src="/src/includes/icons/star-full.png"></button>';
                            }
                            for( $a = $i; $a <= 5; $a++){
                                echo '<button disabled class="rate-button" value="'.$a.'"><img class="star" src="/src/includes/icons/star.svg"></button>';
                            }
                        }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="doc-description-info">
                <p>
                    <?= $document->getDocumentDescription() ?>
                </p>
            </div>
            <div class="doc-bottom-buttons">
                <div>
                    <div><a href="<?= $document->getId() ?>/download"><img class="btn-img" src="/src/includes/icons/download.svg">Завантажити</a></div>
                </div>
                <div>
                    <?= !empty($user) && $user->isUserAdmin() ? '
        <div><a class="edit-btn" href="' . $document->getId()  . '/edit"><img class="btn-img" src="/src/includes/icons/edit.svg">Редагувати</a></div>
        ' : '' ?>


                    <div><a id="copy"><img class="btn-img" src="/src/includes/icons/next.svg">Поділитися</a></div>
                </div>

            </div>
        </div>
        <div class="doc-right-block">
            <div class="doc-themes-container">
                <div class="block-name">Теми:</div>
                <div class="doc-contest">

                    <?php
                        foreach ($themes as $theme){
                        echo '<a class="contest-item" href="/themes/'.$theme->getId().'" >'.$theme->getTheme().'</a></br>';
                        } ?>

<!--                    <a class="contest-item">Економіка. Економічні науки</a>-->
<!--                    <a class="contest-item">Економіка загалом</a>-->
<!--                    <a class="contest-item">Економічна наука. Основні економічні концепції, теорія.-->
<!--                        Вартість. Капітал. Фонди</a>-->
<!--                    <a class="contest-item">Динаміка економіки. Економічний розвиток-->
<!--                        В тому числі: Нове формування капіталу.-->
<!--                        Інвестиції. Економічний розвиток</a>-->
<!--                    <a class="contest-item">Регіональна економіка. Територіальна економіка.-->
<!--                        Економіка землі. Економіка житла</a>-->
                </div>
            </div>
            <div class="doc-contests-container">
                <div class="block-name">Зміст:</div>
                <div>
                    <div class="contest">
<?= $document->getDocumentContests();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/www/rate.js"></script>
<script src="/www/bookmarks.js"></script>
<script>
    $('#copy').click(function(e) {
        var copyText = document.createElement('input');
        document.body.appendChild(copyText);
        copyText.value = window.location;
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        alert('Посилання на документ скопійовано!')
    })
</script>
<!---->
<!--<h1>--><?//= $document->getDocumentName() ?><!--</h1>-->
<!--<p>--><?//= $document->getDocumentDescription() ?><!--</p>-->
<!--<p>Автор: --><?//= $document->getDocumentAuthorId()->getNickname() ?><!--</p>-->
<!--<p><pre style="font: 17px 'Times New Roman'">Содержание: --><?//= $document->getDocumentContests();?><!--</pre></p>-->
<!---->
<!--    --><?//= !empty($user) ? !$document->isUserRated($user->getId())? '<p><label> Оцените документ
//        <select id="rate" name="rate">
//            <option value="1">1</option>
//            <option value="2">2</option>
//            <option value="3">3</option>
//            <option value="4">4</option>
//            <option value="5">5</option>
//        </select>
//    </label>
//    <button id="rate_btn" type="button">Оценить</button></p>' :  '<button disabled id="rate_btn" type="button">Вы уже оценили</button></p>': ''?>
<!--<p>--><?php
//    foreach ($themes as $theme){
//    echo '<a href="/themes/'.$theme->getId().'" >'.$theme->getTheme().'</a></br>';
//    } ?><!--</p>-->
<!--<p><a href="--><?//=$document->getId()?><!--/download">Скачать</a></p>-->
<?//= !empty($user) ?  $user->isUserAdmin() ? '
//<p><a href="'.$document->getId().'/edit">Редактировать</a></p>
//<p><a href="'.$document->getId().'/delete">Удалить</a></p>
//<script src="/www/rate.js"></script>
//' : '' : '' ?>




<?php //include __DIR__ . '/../footer.php'; ?>
