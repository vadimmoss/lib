<?php

namespace Library\Controllers;

use Library\Exceptions\NotFoundException;
use Library\Models\Books\Book;
use Library\Models\Classifications\Classification;

class GenresController extends MainAbstractController
{
    public function view(string $genre)
    {
        if(Classification::isGenreExist($genre))
        {
            $genre_id = Classification::getIdByGenre($genre);
            $newBooks = Book::getNewBooks($genre_id);
            $popularBooks = Book::getPopularBooks($genre_id);
            $recommendations = Book::getRecommendations('10', $genre_id);
            if(empty($recommendations))
            {
                $recommendations = Book::getPopularBooks($genre_id);
                shuffle($recommendations);
            }
            $classifications = Classification::getGenres();
            $this->view->renderPageHtml('genres/main.php', [
                'popular_books' => $popularBooks,
                'recommendations' => $recommendations,
                'new_books' => $newBooks,
                'classifications' => $classifications,
                'genre' => $genre,
            ]);
        } else
        {
            throw new NotFoundException('Page not found!');
        }
    }
}