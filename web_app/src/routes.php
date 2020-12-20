<?php

return [
    '~^genre/(\w+)$~' => [\Library\Controllers\GenresController::class, 'view'],
    '~^books/(\d+)$~' => [\Library\Controllers\BooksController::class, 'view'],
    '~^themes/(\d+)$~' => [\Library\Controllers\ThemesController::class, 'view'],
    '~^analytics$~' => [\Library\Controllers\AnalyticsController::class, 'view'],
    '~^search/search~' => [\Library\Controllers\SearchController::class, 'search'],
    '~^search~' => [\Library\Controllers\SearchController::class, 'view'],
    '~^bookmarks~' => [\Library\Controllers\BookmarksController::class, 'view'],
    '~^recommendations~' => [\Library\Controllers\RecommendationsController::class, 'view'],
    '~^classifications$~' => [\Library\Controllers\ClassificationsController::class, 'view'],
    '~^analytics/rates$~' => [\Library\Controllers\AnalyticsController::class, 'rates'],
    '~^analytics/topViews~' => [\Library\Controllers\AnalyticsController::class, 'topViews'],
    '~^analytics/viewsByDate~' => [\Library\Controllers\AnalyticsController::class, 'viewsByDate'],
    '~^analytics/ratesByDate~' => [\Library\Controllers\AnalyticsController::class, 'ratesByDate'],
    '~^analytics/viewsByRegion~' => [\Library\Controllers\AnalyticsController::class, 'viewsByRegion'],
    '~^analytics/usersByAge~' => [\Library\Controllers\AnalyticsController::class, 'usersByAge'],
    '~^analytics/getUserActivity~' => [\Library\Controllers\AnalyticsController::class, 'getUserActivity'],
    '~^analytics/getUserViews~' => [\Library\Controllers\AnalyticsController::class, 'getUserViews'],
    '~^analytics/getUserRates~' => [\Library\Controllers\AnalyticsController::class, 'getUserRates'],
    '~^books/(\d+)/rate~' => [\Library\Controllers\BooksController::class, 'rate'],
    '~^books/(\d+)/bookmark~' => [\Library\Controllers\BooksController::class, 'bookmark'],
    '~^users/register$~' => [\Library\Controllers\UsersController::class, 'signUp'],
    '~^users/login~' => [\Library\Controllers\UsersController::class, 'login'],
    '~^users/logout~' => [\Library\Controllers\UsersController::class, 'logOut'],
    '~^user$~' => [\Library\Controllers\UsersController::class, 'view'],
    '~^users/(\d+)/activate/(.+)$~' => [\Library\Controllers\UsersController::class, 'activate'],
    '~^$~' => [\Library\Controllers\MainController::class, 'main'],
    '~^page/(\d+)$~' => [\Library\Controllers\MainController::class, 'main'],
];