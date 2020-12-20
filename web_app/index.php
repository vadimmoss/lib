<?php

// 1. Выполняеться spl_autoload_register(запуск функции loader при открытии страницы)
// $class - это название класса который еще не был добавлен(импортирован)
// 2. loader подключает класс
// 3. .htaccess отправляет GET-парамерт "route" $1 если файл или папка указаны в адресе не надены
// 4. Если $route не задан то он будет "" (это в случае перехода на главную страницу)
// 5. $laa_routes - это массив ключ->значение где ключ это регулярка для проверки адреса а значение это массив
// из именем контроллера и названием метода
// 6. Далее проходит проверка роута по регулярным выражениям заданым в routes.php
// 7. Если есть совпадения то создаеться экземпляр класса ктонтроллера и  запускаеться указаный метод(он указан в routes.php)
// $matches[0] - это полное совпадение по паттерну регулярного выражения
// $matches[1] - это аргументы к методу контроллера

function loader(string $class)
{
    $class = str_replace('/', '\\', $class);
    require_once __DIR__ . '\\src\\' . $class . '.php';
}

try {

    spl_autoload_register('loader'); // Запуск класса loader при открытии страницы
    $route = $_GET['route'] ?? '';

    $laa_routes = require __DIR__ . '/src/routes.php';
    $isRouteFound = false;
    foreach ($laa_routes as $pattern => $controller) {
        preg_match($pattern, $route, $matches);
        if (!empty($matches)) {
            $isRouteFound = true;
            break;
        }
    }

    if (!$isRouteFound) {
        throw new \Library\Exceptions\NotFoundException();
    }
    unset($matches[0]);

    $controller_name = $controller[0];
    $action = $controller[1];

    $controller = new $controller_name();
    $controller->$action(...$matches);
} catch (\Library\Exceptions\DatabaseException $e) {
    $view = new \Library\View\View(__DIR__ . '/templates/errors');
    $view->renderPageHtml('500.php', ['error' => $e->getMessage()], 500);
} catch (\Library\Exceptions\NotFoundException $e) {
    $view = new \Library\View\View(__DIR__ . '/templates/errors');
    $view->renderPageHtml('404.php', ['error' => $e->getMessage()], 404);
} catch (\Library\Exceptions\UnauthorizedException $e) {
    $view = new \Library\View\View(__DIR__ . '/templates/errors');
    $view->renderPageHtml('401.php', ['error' => $e->getMessage()], 401);
} catch (\Library\Exceptions\ForbiddenException $e) {
    $view = new \Library\View\View(__DIR__ . '/templates/errors');
    $view->renderPageHtml('403.php', ['error' => $e->getMessage()], 403);
}
