<html lang="en">
<head>
    <meta content="text/html" charset="UTF-8">
    <title>Головна сторінка</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" type="text/css" href="/www/main-styles.css">

    <script src="https://code.jsqlQuery.com/jsqlQuery-3.5.1.min.js"></script>
    <script src="/www/Catalog.js"></script>

</head>
<body>
<header>
    <ul class="header-left-menu">
        <li class="main-link"><a href="/">Library</a></li>
        <li><a id="catalog_button">Catalog</a></li>

        <?= !empty($user) ? '<li><a href="/user">My profile</a></li>' : '' ?>

    </ul>
    <div class="header-right-menu">
        <?= !empty($user) && $user->isUserAdmin() ? '
        <div class="menu-button" ><a href="/analytics"><img class="header-right-menu-image" src="/src/includes/icons/pie-chart.svg" alt=""></a></div>
        <div class="menu-button" ><a href="/documents/add"><img  class="header-right-menu-image" src="/src/includes/icons/new-book.png" alt="Додати документ"></a></div>
        ' : '' ?>
        <div class="menu-button"><a href="/search"><img class="header-right-menu-image"
                                                        src="/src/includes/icons/magnifying-glass.svg" alt=""></a></div>

        <?= !empty($user) ? '<div class="menu-button" ><a href="/bookmarks"><img class="header-right-menu-image" src="/src/includes/icons/bookmark.png" alt=""></a></div><div class="menu-button " ><a href="/user"><img class="header-right-menu-image" src="/src/includes/icons/avatar.svg" alt="">
            </a></div>' : '' ?>

        <div class="profile-name"><?= !empty($user) ? '' . $user->getNickname() . '' : '<a class="btn-anim top-link" href="http://libra/users/login">Увійти</a><a class="btn-anim top-link" href="http://libra/users/register">Зареєструватись</a>' ?></div>
        <?= !empty($user) ? '<div class="menu-button" ><a href="http://libra/users/logout" ><img class="header-right-menu-image" src="/src/includes/icons/logout.svg" alt=""></a></div>' : '' ?>

    </div>
</header>

