<?php include __DIR__ . '/../header.php';
echo '<div class="block-name">Made for ' . $user->getNickname() . ':</div>';
echo '<div class="bookmarks-container">';
var_dump($recommendations);

$readlists = array_chunk($recommendations, 4);
$playlistNumber = 1;
echo '</br>' . var_dump($readlists) . '</br>';
foreach ($readlists as $titles) {
    echo $playlistNumber . '</br>';
    foreach ($titles as $title) {
        echo $title . '</br>';
    }
    $playlistNumber = $playlistNumber++;
}
foreach ($documents as $document): ?>


    <div class="result-doc">
        <div class="doc-image-block">

            <a href="documents/<?= $document->getId(); ?>"><img class="doc-image"
                                                                src="/<?= $document->getCover() ?>"></a>

            <?php

            echo '<img value="' . $document->getId() . '" class="like-image" src="/src/includes/icons/tag-true.png">';

            ?>
        </div>
        <div class="doc-description">
            <div>
                <p class="doc-name-min"> <?= $document->getDocumentName() ?></p>
                <p>
                    <?= $document->getDocumentDescription() ?>
                </p>
            </div>
            <div class="doc-stat">
                <div class="doc-views">
                    <img class="views-image" src="/src/includes/icons/glasses.svg">
                    <?= $document->getDocumentViews() ?>
                </div>
                <div class="doc-rating">
                    <?php for ($i = 1; $i <= $document->getDocumentRating(); $i++) {
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
