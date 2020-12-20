<?php include __DIR__ . '/../header.php';

?>
<style>
    .new-docs, .popular-docs {
        display: flex;
        flex-direction: row;
        width: 100%;
        overflow-x: hidden;
    }
</style>
<div class="doc-container">

    <div class="doc-author"><?= $book->getAuthors() ?></div>
    <div class="doc-name"><?= $book->getTitle() ?></div>
    <div class="doc-info">
        <div class="doc-left-block">
            <div class="doc-main-info">
                <div class="doc-image-big-block">
                    <img class="doc-image-big" src="<?= $book->getImageUrl() ?>">
                </div>
                <div class="info-table">
                    <table>
                        <tr>
                            <td>Автор:</td>
                            <td><?= $book->getAuthors() ?></td>
                        </tr>
                        <tr>
                            <td>Дата видавнитства:</td>
                            <td><?= $book->getOriginalPublicationYear() ?></td>
                        </tr>
                        <tr>
                            <td>Мова:</td>
                            <td><?= $book->getLanguageCode() ?></td>
                        </tr>
                    </table>
                    <div class="info-buttons">
                        <div class="doc-views">
                            <img class="views-image" src="/src/includes/icons/glasses.svg">
                            <?= $book->getBookViews() ?>
                        </div>
                        <div class="doc-rating">

                            <?php if (!empty($user)) {
                                for ($i = 1; $i <= $book->getBookRating(); $i++) {
                                    echo '<button class="rate-button" value="' . $i . '"><img class="star" src="/src/includes/icons/star-full.png"></button>';
                                }
                                for ($a = $i; $a <= 5; $a++) {
                                    echo '<button class="rate-button" value="' . $a . '"><img class="star" src="/src/includes/icons/star.svg"></button>';
                                }

                            } else {
                                for ($i = 1; $i <= $book->getBookRating(); $i++) {
                                    echo '<button disabled  class="rate-button" value="' . $i . '"><img class="star" src="/src/includes/icons/star-full.png"></button>';
                                }
                                for ($a = $i; $a <= 5; $a++) {
                                    echo '<button disabled class="rate-button" value="' . $a . '"><img class="star" src="/src/includes/icons/star.svg"></button>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="doc-description-info">
                <p>
                    <?= $book->getBookDescription($book->getId()) ?>
                </p>
            </div>
            <div class="doc-right-block">
                <div class="doc-themes-container">
                    <div class="block-name">Теми:</div>
                    <div class="doc-contest">
                        <ul class="genres_container gbook">
                            <?php
                            foreach ($genres as $genre) {
                                echo '<a href="/genre/' . $genre . '"><li class="genre">' . ucfirst($genre) . '</li></a>';
                            }

                            ?>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <div style="background-color: white; margin-bottom: 20px" class="new-docs-container">
        <div class="block-name" style="margin-bottom: 0; margin-left: 30px; margin-top: 20px">Similar:</div>
        <div class="row-block">
            <div class="prev prev-button-container">
                <img src="/src/includes/icons/back.svg">
            </div>
            <div id="scroll-block" class="new-docs"
            ">
            <?php $i = 0;
            foreach ($similar_books as $book): ?>
                <?php if ($i == 0): ?>
                    <div class="doc new-doc-1">
                        <div class="doc-image-block">
                            <a href="<?= $book->getId() ?>"><img class="doc-image"
                                                                 src="<?= $book->getImageUrl() ?>"></a>
                            <?php
                            if (!empty($user)) {
                                if ($book->isInBookmarks($user->getId(), $book->getId()) == 0) {
                                    echo '<img value="' . $book->getId() . '" class="like-image" src="/src/includes/icons/bookmark.png">';

                                } else {
                                    echo '<img value="' . $book->getId() . '" class="like-image" src="/src/includes/icons/tag-true.png">';
                                }
                            } else {
                                echo '<img value="' . $book->getId() . '" class="like-image" src="/src/includes/icons/bookmark.png">';
                            }
                            //                        ?>
                        </div>
                        <div class="doc-description">
                            <div>
                                <p class="doc-name-min"> <?= $book->getTitle() ?></p>
                                <p>
                                    <?php
                                    //$str = $document->getDocumentDescription();
                                    $str = "Google Executive Chairman and ex-CEO Eric Schmidt and former SVP of Products Jonathan Rosenberg came to Google over a decade ago as proven technology executives. At the time, the company was already well-known for doing things differently, reflecting the visionary--and frequently contrarian--principles of founders Larry Page and Sergey Brin. ";
                                    if (strlen($str) > 300) {
                                        $sum = strlen($str) - 200;
                                        $str = mb_substr($str, 0, $sum, 'UTF-8') . "...";
                                    }
                                    echo $str;
                                    ?>
                                </p>
                            </div>
                            <div class="doc-stat">
                                <div class="doc-views">
                                    <img class="views-image" src="/src/includes/icons/glasses.svg">
                                    <?= $book->getBookViews() ?>
                                </div>
                                <div class="doc-rating">
                                    <?php for ($i = 1; $i <= $book->getBookRating(); $i++) {
                                        echo '<img class="star" src="/src/includes/icons/star-full.png">';
                                    }
                                    for ($a = $i; $a <= 5; $a++) {
                                        echo '<img class="star" src="/src/includes/icons/star.svg">';
                                    }
                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php $i++; else: ?>
                    <div class="doc new-doc">
                        <div class="doc-image-block">
                            <a href="<?= $book->getId() ?>"><img class="doc-image"
                                                                 src="<?= $book->getImageUrl() ?>"></a>
                            <?php
                            if (!empty($user)) {
                                if ($book->isInBookmarks($user->getId(), $book->getId()) == 0) {
                                    echo '<img value="' . $book->getId() . '" class="like-image" src="/src/includes/icons/bookmark.png">';

                                } else {
                                    echo '<img value="' . $book->getId() . '" class="like-image" src="/src/includes/icons/tag-true.png">';
                                }
                            } else {
                                echo '<img value="' . $book->getId() . '" class="like-image" src="/src/includes/icons/bookmark.png">';
                            }
                            ?>

                        </div>
                    </div>
                <?php endif; ?>

            <? endforeach; ?>
        </div>
        <div class="next next-button-container" style="right: -50px;">
            <img src="/src/includes/icons/next-1.svg">
        </div>
    </div>
</div>
<script src="/www/rate.js"></script>
<script src="/www/bookmarks.js"></script>
<script src="/www/slider.js"></script>
<script>
    $('#copy').click(function (e) {
        var copyText = document.createElement('input');
        document.body.appendChild(copyText);
        copyText.value = window.location;
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        alert('Посилання на документ скопійовано!')
    })
</script>

