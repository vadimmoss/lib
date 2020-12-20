<?php

namespace Library\Models\Books;

use Library\Exceptions\NotFoundException;
use Library\Models\ActiveRecordEngine;
use Library\Models\Rates\Rate;
use Library\Models\Recommendations\Recommendation;
use Library\Models\Views\View;
use Library\ServiceClasses\Database;

class Book extends ActiveRecordEngine
{

    protected $authors;
    protected $originalPublicationYear;
    protected $title;
    protected $languageCode;
    protected $imageUrl;
    protected $bookViews;
    protected $bookRating;

    /**
     * @return mixed
     */
    public function getBookRating()
    {
        return $this->bookRating;
    }


    /**
     * @return mixed
     */
    public function getBookViews()
    {
        return $this->bookViews;
    }

    /**
     * @return mixed
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * @return mixed
     */
    public function getOriginalPublicationYear()
    {
        return $this->originalPublicationYear;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getLanguageCode()
    {
        return $this->languageCode;
    }

    /**
     * @return mixed
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @param mixed $bookViews
     */
    public function setBookViews($bookViews): void
    {
        $this->bookViews = $bookViews;
    }

    public static function getPages($current_page): array
    {
        $count_pages = Book::getCountPages();
        $pages = range(0, $count_pages);
        if ($current_page < 5) {
            $pages = array_slice($pages, $current_page, 11);
        } else {
            $pages = array_slice($pages, $current_page - 5, 11);
        }

        return $pages;
    }

    public static function getCountPages(): int
    {
        $db = Database::getConnection();
        $count = $db->simplesqlQuery('SELECT COUNT(*) FROM books');
        return round($count / 150);
    }

    public static function setAverageRates()
    {
        $db = Database::getConnection();
        $result = $db->sqlQueryNonClass('SELECT id FROM books');
        foreach ($result as $id) {
            $avg = $db->sqlQueryNonClass('SELECT round(AVG(rate)),id_book  FROM rates WHERE id_book = "' . $id['id'] . '" ');
            if ($avg[0]["round(AVG(rate))"] != null) {
                echo var_dump($avg[0]["id_book"] . ' ---------- ' . $avg[0]["round(AVG(rate))"]) . '</br>';
                $db->sqlQueryNonClass('UPDATE `books` SET `book_rating`= ' . $avg[0]["round(AVG(rate))"] . ' WHERE id = "' . $id['id'] . '" ');
                echo 'UPDATE `books` SET `book_rating`= ' . $avg[0]["round(AVG(rate))"] . ' WHERE id = "' . $id['id'] . '" ';
            }

        }
    }

    public static function getAllBooks(int $page = 0, int $genre_id = null)
    {
        $db = Database::getConnection();
        $count = Book::getCountPages();
        $offset = $count * $page;
        if (is_null($genre_id)) {
            $sql = "SELECT * FROM `books` WHERE `image_url` NOT LIKE '%nophoto%' AND `original_publication_year` NOT LIKE '%No Data%' LIMIT 150 OFFSET " . $offset . " ";
        } else {
            $sql = "SELECT books.id, books.authors, books.original_publication_year, books.title, books.language_code, books.image_url, books.book_views, books.book_rating FROM `books` 
                    JOIN `books_genres` ON books.id = book_id
                    WHERE genre_id = '" . $genre_id . "' AND `image_url` NOT LIKE '%nophoto%' AND `original_publication_year` NOT LIKE '%No Data%'  ORDER BY original_publication_year DESC LIMIT 20";
        }
        $result = $db->sqlQuery($sql,
            [],
            Book::class);
        return $result;
    }

    public static function getNewBooks(string $genre_id = null): array
    {
        $db = Database::getConnection();
        if (is_null($genre_id)) {
            $sql = "SELECT * FROM `books` WHERE `image_url` NOT LIKE '%nophoto%' AND `original_publication_year` NOT LIKE '%No Data%'  ORDER BY original_publication_year DESC LIMIT 20";

        } else {
            $sql = "SELECT books.id, books.authors, books.original_publication_year, books.title, books.language_code, books.image_url, books.book_views, books.book_rating FROM `books` 
                    JOIN `books_genres` ON books.id = book_id
                    WHERE genre_id = '" . $genre_id . "' AND `image_url` NOT LIKE '%nophoto%' AND `original_publication_year` NOT LIKE '%No Data%'  ORDER BY original_publication_year DESC LIMIT 20";
        }
        $result = $db->sqlQuery($sql,
            [],
            Book::class);
        return $result;
    }

    public static function getRecommendations(int $userId = null, $genre_id = null)
    {
        $db = Database::getConnection();
        $result = $db->sqlQueryNonClass('SELECT * FROM recommendations WHERE user_id = ' . $userId . '  '); // change in the future
        if (is_null($genre_id)) {
            $result = Recommendation::getBookIdsByTitles(substr($result[0]['book'], 1, -1));
        } else {
            $result = Recommendation::getBookIdsByTitles(substr($result[0]['book'], 1, -1), $genre_id);
        }
        $result = array_filter($result, function ($v) {
            return !is_null($v) && $v !== '';
        });
        $books_array = array();
        foreach ($result as $book_id) {
            array_push($books_array, Book::getById($book_id));
        }
        return $books_array;
    }

    public static function getBookById(int $id)
    {
        $db = Database::getConnection();
        $entities = $db->sqlQuery(
            'SELECT * FROM `' . static::getTable() . '` WHERE id=:id;',
            [':id' => $id],
            static::class
        );
        return $entities ? $entities[0] : null;
    }

    public function addBookView(int $userId = null): void
    {
        $view = new View();
        $view->setIdBook($this->getId());
        $view->setIdViewer($userId);
        $view->setViewRegion($this->getLocation());

        $this->setBookViews($view->getCount($this->id));
        $view->save();
        $this->save();
    }

    /**
     * @param mixed $bookRating
     */
    public function setBookRating($bookRating): void
    {
        $this->bookRating = $bookRating;
    }

    public function addDocumentRate(int $userId = null): void
    {
        $rate = new Rate();
        $rate->setIdBook($this->getId());
        $rate->setIdRater($userId);
        $rate->setRate($_POST['rate']);
        $rate->save();
        $this->setBookRating($rate->getRatingByBook($this->getId())); // среднее
        $this->save();
    }

    public function isUserRated(int $userId = null): bool
    {
        $bookId = $this->getId();
        return Rate::isRatedBefore($userId, $bookId, 'id_rater', 'id_book');
    }

    public function getLocation()
    {
        $remote = @$_SERVER['REMOTE_ADDR'];
        $details = json_decode(file_get_contents("http://ipinfo.io/46.219.229.15/json"));
        return $details->city;
    }

    public static function getPopularBooks(string $genre_id = null): array
    {
        $db = Database::getConnection();
        if (is_null($genre_id)) {
            $sql = "SELECT * FROM `books` ORDER BY book_views DESC LIMIT 10";

        } else {
            $sql = "SELECT books.id, books.authors, books.original_publication_year, books.title, books.language_code, books.image_url, books.book_views, books.book_rating FROM `books` 
                    INNER JOIN `books_genres` ON books.id = book_id
                    WHERE genre_id = '" . $genre_id . "' ORDER BY book_views DESC LIMIT 10";
        }
        $result = $db->sqlQuery($sql,
            [],
            Book::class);
        return $result;
    }

    public function isInBookmarks($idUser, $bookId): bool
    {
        $db = Database::getConnection();
        $result = $db->simplesqlQuery('SELECT * FROM `bookmarks` WHERE id_book = ' . $bookId . ' and id_user = ' . $idUser . ' ');
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public static function getBookmarks($usrId): array
    {
        $db = Database::getConnection();
        return $db->sqlQuery("SELECT * FROM `bookmarks`
                                JOIN books ON bookmarks.id_book = books.id
                                WHERE bookmarks.id_user =  '.$usrId.'", [], Book::class);
    }

    public static function getBookDescription($bookId): string
    {
        $db = Database::getConnection();
        $result = $db->sqlQueryNonClass('SELECT description FROM descriptions WHERE id_book = ' . $bookId . '  ');
        $result = utf8_decode($result[0]['description']);
        if (empty($result[0])) {
            $result = "A man will do almost anything for ninety million dollars. So will its rightful owners. They found him in a small town in Brazil. He had a new name, Danilo Silva, and his appearance had been changed by plastic surgery. The search had taken four years. They'd chased him around the world, always just missing him. It had cost their clients $3.5 million. But so far none of them had complained. The man they were about to kidnap had not always been called Danilo Silva. Before he had had another life, a life which ended in a car crash in February 1992. His gravestone lay in a cemetery in Biloxi, Mississippi. His name before his death was Patrick S. Lanigan. He had been a partner at an up-and-coming law firm. He had a pretty wife, a young daughter, and a bright future. Six weeks after his death, $90 million disappeared from the law firm. ";
        }

        return $result;
    }

    protected static function getTable(): string
    {
        return 'books';
    }

    public function getSimilarBooks()
    {
        $db = Database::getConnection();
        $result = $db->sqlQueryNonClass('SELECT * FROM similar_books WHERE book_id = ' . $this->getId() . '  '); // change in the future
        $result = Recommendation::getBookIdsByTitles($result[0]['books']);
        $result = array_filter($result, function ($v) {
            return !is_null($v) && $v !== '';
        });
        $books_array = array();
        foreach ($result as $book_id) {
            array_push($books_array, Book::getById($book_id));
        }
        return $books_array;
    }


    public static function getBooksByFilter($post, $order_by): array
    {
        $str = '';
        $sql_names = '';
        $docs_array = array();
        $class_filter_sql = '';
        $class_filter_sql_join = '';
        if ($post['genre_id']) {
            $class_filter_sql_join .= 'INNER JOIN `books_genres` ON books.id = book_id ';
        }
        if ($post['genre_id']) {
            $str .= ' ( ';
            foreach ($post['genre_id'] as $genre_id) {
                $str .= ' genre_id = ' . $genre_id . ' OR';
            }
            $str = substr($str, 0, -3);
            $str .= ' ) ';
            $str .= ' AND ';

            unset($post['genre_id']);
        }

        if ($post['order_by']) {
            if ($post['order_by'] === 'date') {
                $sql_order_by = ' ORDER BY document_add_date DESC';
            }
            if ($post['order_by'] === 'rate') {
                $sql_order_by = ' ORDER BY document_rating DESC';
            }
            if ($post['order_by'] === 'view') {
                $sql_order_by = ' ORDER BY document_views DESC';
            }
            if ($post['order_by'] === 'down') {
                $sql_order_by = ' ORDER BY document_downloads DESC';
            }
            unset($post['order_by']);
        }
        if ($post['contest_for_filter']) {
            $sql_contest_for_filter = ' contest_for_filter LIKE \'%' . $post['contest_for_filter'] . '%\' AND';
            unset($post['contest_for_filter']);
        }
        if ($post['year_start'] or $post['year_end']) {
            if (!$post['year_start']) {
                $sql_dates = 'original_publication_year BETWEEN \'1998\' AND ' . $post['year_end'] . ' AND ';
                unset($post['year_end']);
            } elseif (!$post['year_end']) {
                $sql_dates = 'original_publication_year BETWEEN ' . $post['year_start'] . ' AND 2020' . ' AND ';
                unset($post['year_start']);
            } elseif ($post['year_start'] and $post['year_end']) {
                $sql_dates = 'original_publication_year BETWEEN ' . $post['year_start'] . ' AND ' . $post['year_end'] . ' AND ';
                unset($post['year_end']);
                unset($post['year_start']);
            }
        }
        if ($post['title']) {
            $sql_names .= ' title LIKE \'%' . $post['title'] . '%\' AND';
            unset($post['title']);
        }
        if ($post['authors']) {
            $sql_names .= ' authors LIKE \'%' . $post['authors'] . '%\' AND';
            unset($post['authors']);
        }
        if ($post['document_lang']) {
            $sql_names .= ' language_code LIKE \'%' . $post['document_lang'] . '%\' AND';
            unset($post['document_lang']);
        }
        foreach ($post as $item => $value) {
            if ($item != null) {
                if ($value) {
                    $str .= ' ' . $item . ' = \'' . $value . '\' AND ';
                }
            }
        }

        $str .= $sql_dates;
        $str .= $sql_names;
        $str .= $sql_contest_for_filter;

        $str .= $class_filter_sql;
        $str = substr($str, 0, -4);

        $str .= $sql_order_by;
        $db = Database::getConnection();
        if ($str !== '') {
            $docs = $db->sqlQueryNonClass('SELECT books.id, books.authors, books.original_publication_year, books.title, books.language_code, books.image_url, books.book_views, books.book_rating FROM books   ' . $class_filter_sql_join . ' WHERE ' . $str . ' GROUP BY id LIMIT 50');
        } else {
            $docs = $db->sqlQueryNonClass('SELECT books.id, books.authors, books.original_publication_year, books.title, books.language_code, books.image_url, books.book_views, books.book_rating FROM books  ' . $class_filter_sql_join . ' ' . $str . ' GROUP BY id LIMIT 50');
        }

        if ($docs !== null) {
            foreach ($docs as $doc) {
                $document = Book::getById($doc['id']);
                array_push($docs_array, $document);
            }
        } else {
            throw new NotFoundException('Не найдено ни одного документа');
        }

        return $docs_array;
    }


}

