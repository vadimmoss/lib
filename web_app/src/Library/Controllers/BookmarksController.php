<?php


namespace Library\Controllers;


use Library\Exceptions\ForbiddenException;
use Library\Models\Books\Book;


class BookmarksController extends MainAbstractController
{

    public function view()
    {
        if (!$this->user){
            throw new ForbiddenException();
        }
        $books = Book::getBookmarks($this->user->getId());
        $user= $this->user;
        $this->view->renderPageHtml('bookmarks/view.php', [
            'books' => $books,
            'username' => $user,
        ]);

    }

}