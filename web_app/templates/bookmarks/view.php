<?php include __DIR__ . '/../header.php';
echo '<div class="block-name">Закладки:</div>';
echo '<div class="bookmarks-container">';
foreach ($books as $book): ?>


    <div class="result-doc">
        <div class="doc-image-block">

            <a href="documents/<?= $book->getId(); ?>"><img class="doc-image" src="<?= $book->getImageUrl() ?>"></a>

            <?php

            echo '<img value="' . $book->getId() . '" class="like-image" src="/src/includes/icons/tag-true.png">';

            ?>
        </div>
        <div class="doc-description">
            <div>
                <p class="doc-name-min"> <?= $book->getTitle() ?></p>
                <p>
                    <?= $book->getBookDescription() ?>
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


<?php endforeach; ?>
</div>
