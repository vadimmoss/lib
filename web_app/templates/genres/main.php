<?php include __DIR__ . '/../header.php'; ?>


<div id="catalog_container">
    <div id="catalog_window">
        <?php
        foreach ($classifications as $classification) {
            echo '<div class="genre_block"><a href="/genre/' . lcfirst($classification['genre']) . '">' . $classification['genre'] . '</a></div>';
        }
        ?>
    </div>
</div>
<div class="new-docs-container">
    <div class="block-name">Новинки:</div>
    <div class="row-block">
        <div id="new-prev-button-container" class="prev">
            <img src="/src/includes/icons/back.svg">
        </div>
        <div id="new-scroll-block" class="new-docs">
            <?php $i = 0;
            foreach ($new_books as $book): ?>
                <?php if ($i == 0): ?>
                    <div class="doc new-doc-1">
                        <div class="doc-image-block">
                            <a href="/books/<?= $book->getId() ?>"><img class="doc-image"
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
                            <a href="/books/<?= $book->getId() ?>"><img class="doc-image"
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
        <div class="next" id="new-next-button-container">
            <img src="/src/includes/icons/next-1.svg">
        </div>
    </div>
</div>
<div class="new-docs-container">
    <div class="block-name">For you:</div>
    <div class="row-block">
        <div id="for-you-prev-button-container" class="prev">
            <img src="/src/includes/icons/back.svg">
        </div>
        <div id="for-you-scroll-block" class="new-docs">
            <?php $i = 0;
            foreach ($recommendations as $book): ?>
                <?php if ($i == 0): ?>
                    <div class="doc new-doc-1">
                        <div class="doc-image-block">
                            <a href="/books/<?= $book->getId() ?>"><img class="doc-image"
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
                    </div>
                    <?php $i++; else: ?>
                    <div class="doc new-doc">
                        <div class="doc-image-block">
                            <a href="/books/<?= $book->getId() ?>"><img class="doc-image"
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
        <div id="for-you-next-button-container" class="next">
            <img src="/src/includes/icons/next-1.svg">
        </div>
    </div>
</div>
<div class="new-docs-container">
    <div class="block-name">Popular:</div>
    <div class="row-block">
        <div id="popular-prev-button-container" class="prev">
            <img src="/src/includes/icons/back.svg">
        </div>
        <div id="popular-scroll-block" class="new-docs">
            <?php $i = 0;
            foreach ($popular_books as $book): ?>
                <?php if ($i == 0): ?>
                    <div class="doc new-doc-1">
                        <div class="doc-image-block">
                            <a href="books/<?= $book->getId() ?>"><img class="doc-image"
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
                            <a href="books/<?= $book->getId() ?>"><img class="doc-image"
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
        <div id="popular-next-button-container" class="next">
            <img src="/src/includes/icons/next-1.svg">
        </div>
    </div>
</div>


<script src="/www/bookmarks.js"></script>

<script src="/www/slider.js"></script>

