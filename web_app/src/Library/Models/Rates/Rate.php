<?php

namespace Library\Models\Rates;

use Library\Models\ActiveRecordEngine;
use Library\ServiceClasses\Database;

class Rate extends ActiveRecordEngine
{

    public $idBook;
    protected $idRater;
    public $rateDate;
    public $rate;


    public function setIdBook($idBook): void
    {
        $this->idBook = $idBook;
    }

    /**
     * @param mixed $idRater
     */
    public function setIdRater($idRater): void
    {
        $this->idRater = $idRater;
    }

    /**
     * @param mixed $rate
     */
    public function setRate($rate): void
    {
        $this->rate = $rate;
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
    public function getRateDate()
    {
        return $this->rateDate;
    }

    /**
     * @return mixed
     */
    public function getIdRater()
    {
        return $this->idRater;
    }

    /**
     * @return mixed
     */
    public function getRate()
    {
        return $this->rate;
    }

    public static function isRatedBefore(int $val1, int $val2, string $col1, string $col2): bool
    {
        return Rate::isValueExist($val1, $val2, $col1, $col2);
    }

    public function getRatingByBook(int $bookId):int
    {
        $db = Database::getConnection();
        $entities = $db->simplesqlQuery(
            'SELECT AVG(rate) as rating FROM `rates` WHERE id_book=:id_book;',
            [':id_book' => $bookId]
        );
        return $entities;
    }

    protected static function getTable(): string
    {
        return 'rates';
    }



}