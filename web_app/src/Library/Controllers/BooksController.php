<?php


namespace Library\Controllers;

use Library\Exceptions\NotFoundException;
use Library\Models\Bookmarks\Bookmark;
use Library\Models\Classifications\Classification;
use Library\Models\Books\Book;


class BooksController extends MainAbstractController
{
    public function view(int $Id)
    {
        $book = Book::getById($Id);
        if ($book === null) {
            throw new NotFoundException();
        }

        if ($this->user) {
            $book->addBookView($this->user->getId());
        } else {
            $book->addBookView();
        }

        $similar_books = $book->getSimilarBooks();
        $genres = Classification::getClassifications($Id);
        $this->view->renderPageHtml('books/view.php', [
            'book' => $book,
            'similar_books' => $similar_books,
            'genres' => $genres,

        ]);
    }

    public function rate(int $bookId): void
    {
        $book = Book::getById($bookId);
        if (!$book->isUserRated($this->user->getId())) {
            $book->addDocumentRate($this->user->getId());
        }
        $this->view->renderPageHtml('books/view.php', [
            'book' => $book,
        ]);
    }

    public function bookmark(int $bookId): void
    {
        if ($this->user) {
            $bookmark = new Bookmark();
            $bookmark->addBookMark($this->user->getId(), $bookId);
        }
        $document = Book::getById($bookId);
        $this->view->renderPageHtml('books/view.php', [
            'document' => $document,
        ]);
    }
}