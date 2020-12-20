<?php

namespace Library\Models\Classifications;

use Library\Models\ActiveRecordEngine;
use Library\ServiceClasses\Database;

class Classification extends ActiveRecordEngine
{
    protected $id;
    protected $bookId;
    protected $count;
    protected $genreId;

    /**
     * @return mixed
     */
    public function getBookId()
    {
        return $this->bookId;
    }

    public function getCountRates()
    {
        return $this->count;
    }

    /**
     * @return mixed
     */
    public function getGenreId()
    {
        return $this->genreId;
    }
    public static function getIdByGenre(string $genre):int
    {
        $db = Database::getConnection();
        $result = $db->sqlQueryNonClass('SELECT genre_id FROM genres WHERE genre = "'.$genre.'" ' );
        return $result[0]['genre_id'];
    }
    public static function getClassifications(int $book_id):array
    {
        $db = Database::getConnection();
        $result = $db->sqlQueryNonClass('SELECT * FROM books_genres WHERE book_id = '. $book_id . '  ' );
        $genres = array();
        foreach ($result as $genre)
        {
            $result = $db->sqlQueryNonClass('SELECT genre FROM genres WHERE genre_id = '. $genre['genre_id'] . '  ' );
            array_push($genres, $result[0]['genre']);
        }
        return $genres;
    }

    public static function getGenres()
    {
        $db = Database::getConnection();
        $result = $db->sqlQueryNonClass('SELECT * FROM genres' );
        foreach ($result as $key => $genre)
        {
            $result[$key]['genre'] = ucfirst($genre['genre']);
        }
        return $result;
    }

    public static function isGenreExist(string $genre)
    {
        $db = Database::getConnection();
        $result = $db->sqlQueryNonClass('SELECT * FROM genres WHERE genre = "'.$genre.'" ' );
        if(empty($result))
        {
            return false;
        } elseif (!empty($result))
        {
            return true;
        }
    }

    protected static function getTable(): string
    {
        return 'books_genres';
    }

}