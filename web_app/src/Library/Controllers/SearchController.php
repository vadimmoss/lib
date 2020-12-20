<?php


namespace Library\Controllers;


use Library\Models\Books\Book;
use Library\Models\Classifications\Classification;


class SearchController extends MainAbstractController
{

    public function view(): void
    {
        $genres = Classification::getGenres();
        $this->view->renderPageHtml('search/view.php',
            ['genres' => $genres]
        );
    }
    public function search(): void
    {
        $result = Book::getBooksByFilter($_POST, '');
        $genres = Classification::getGenres();
        $this->view->renderPageHtml('search/results.php',
        ['books' => $result,
        'classification' => $genres]
        );
    }

}