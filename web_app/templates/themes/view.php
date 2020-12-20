<?php include __DIR__ . '/../header.php'; ?>


<?php
echo '<h2>Тема: ' . $theme->getTheme() . '</h2>';
foreach ($documents as $document): ?>
    <h2><a href="/documents/<?= $document->getId() ?>"><?= $document->getDocumentName() ?></a></h2>
    <p><?= $document->getDocumentDescription() ?></p>
    <p>Просмотры: <?= $document->getDocumentViews() ?>
        | Рейтинг: <?= $document->getDocumentRating() ?>
        | Скачивания: <?= $document->getDocumentDownloads() ?></p>
    <hr>
<?php endforeach; ?>

<?php include __DIR__ . '/../footer.php'; ?>