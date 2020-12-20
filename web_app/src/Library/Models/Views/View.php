<?php

namespace Library\Models\Views;

use Library\Models\ActiveRecordEngine;


class View extends ActiveRecordEngine
{
    protected $idBook;
    protected $idViewer;
    protected $viewDate;
    protected $viewRegion;

    /**
     * @return mixed
     */
    public function getViewRegion()
    {
        return $this->viewRegion;
    }

    /**
     * @param mixed $viewRegion
     */
    public function setViewRegion($viewRegion): void
    {
        $this->viewRegion = $viewRegion;
    }

    protected static function getTable(): string
    {
        return 'views';
    }

    /**
     * @return mixed
     */
    public function getIdBook()
    {
        return $this->idBook;
    }


    public function setIdBook($idBook): void
    {
        $this->idBook = $idBook;
    }

    /**
     * @return mixed
     */
    public function getIdViewer()
    {
        return $this->idViewer;
    }

    /**
     * @param mixed $idViewer
     */
    public function setIdViewer($idViewer): void
    {
        $this->idViewer = $idViewer;
    }

    /**
     * @return mixed
     */
    public function getViewDate()
    {
        return $this->viewDate;
    }


}