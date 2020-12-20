<?php

namespace Library\Models\Downloads;

use Library\Models\ActiveRecordEngine;


class Download extends ActiveRecordEngine
{

    protected $idDocument;
    protected $idDownloader;
    protected $downloadDate;

    /**
     * @param mixed $idDocument
     */
    public function setIdDocument($idDocument): void
    {
        $this->idDocument = $idDocument;
    }

    /**
     * @param mixed $idDownloader
     */
    public function setIdDownloader($idDownloader): void
    {
        $this->idDownloader = $idDownloader;
    }


    /**
     * @param mixed $downloadDate
     */
    public function setDownloadDate($downloadDate): void
    {
        $this->downloadDate = $downloadDate;
    }

    /**
     * @return mixed
     */
    public function getDownloadDate()
    {
        return $this->downloadDate;
    }

    /**
     * @return mixed
     */
    public function getIdDocument()
    {
        return $this->idDocument;
    }

    /**
     * @return mixed
     */
    public function getIdDownloader()
    {
        return $this->idDownloader;
    }

    protected static function getTable(): string
    {
        return 'downloads';
    }
}