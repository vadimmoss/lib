<?php

namespace Library\Models\Bookmarks;

use Library\Models\ActiveRecordEngine;

class Bookmark extends ActiveRecordEngine
{
    protected $idBook;
    protected $idUser;

    /**
     * @param mixed $idUser
     */
    public function setIdUser($idUser): void
    {
        $this->idUser = $idUser;
    }

    /**
     * @param mixed $idDocument
     */
    public function setIdBook($idBook): void
    {
        $this->idBook = $idBook;
    }

    /**
     * @return mixed
     */
    public function getIdBook()
    {
        return $this->idBook;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }


    public function addBookMark($userId, $bookId): void
    {
        $this->setIdBook($bookId);
        $this->setIdUser($userId);
        $this->save();
    }


    protected static function getTable(): string
    {
        return 'bookmarks';
    }
}