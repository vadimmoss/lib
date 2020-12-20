<?php

namespace Library\Models\Recommendations;

use Library\Models\ActiveRecordEngine;
use Library\ServiceClasses\Database;

class Recommendation extends ActiveRecordEngine
{
    protected $userId;
    protected $book;

    /**
     * @return mixed
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }


    public static function getBookIdsByTitles($Books, $genre_id = null):array
    {
        $db = Database::getConnection();
        $booksTitles = explode ('; ', $Books);
        $result = array();
        if (is_null($genre_id))
        {
            foreach ($booksTitles as $title)
            {
                $sqlQuery = $db->sqlQueryNonClass("SELECT books.id, books.authors, books.original_publication_year, 
                                                books.title, books.language_code, books.image_url, 
                                                books.book_views, books.book_rating 
                                                FROM books 
                                                WHERE title = '$title' ");
                array_push($result, $sqlQuery[0]['id']);
            }

        }else
        {
            foreach ($booksTitles as $title) {
                $sqlQuery = $db->sqlQueryNonClass("SELECT books.id, books.authors, books.original_publication_year, 
                                                books.title, books.language_code, books.image_url, 
                                                books.book_views, books.book_rating 
                                                FROM books 
                                                JOIN `books_genres` ON books.id = book_id
                                            
                                                WHERE  genre_id = '$genre_id' AND title = '$title' ");
                if(!is_null( $sqlQuery[0]['id']))
                {
                    array_push($result, $sqlQuery[0]['id']);
                }
            }
        }

        return $result;
    }


    protected static function getTable(): string
    {
        return 'recommendations';
    }
}