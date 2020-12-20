<?php

namespace Library\Controllers;

use Library\Models\Books\Book;
use Library\Models\Classifications\Classification;

class MainController extends MainAbstractController
{
    public function main(int $page = 0)
    {
        $pages = Book::getPages($page);
        $newBooks = Book::getNewBooks();
        $all_books = Book::getAllBooks($page);
        $popularBooks = Book::getPopularBooks();
        if(isset($this->user)){
            $recommendations = Book::getRecommendations($this->user->getId());
        }else{
            $recommendations = Book::getRecommendations(10);
        }
        $classifications = Classification::getGenres();
        $this->view->renderPageHtml('main/main.php', [
            'pages' => $pages,
            'current_page' => $page,
            'all_books' => $all_books,
            'popular_books' => $popularBooks,
            'recommendations' => $recommendations,
            'new_books' => $newBooks,
            'classifications' => $classifications,
        ]);
    }

}