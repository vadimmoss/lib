<?php

namespace Library\Controllers;

use Library\Exceptions\ForbiddenException;
use Library\Models\Analytics\Analytics;
use Library\Models\Books\Book;

class AnalyticsController extends MainAbstractController
{
    public function view(): void
    {
        if (!$this->user->isUserAdmin()){
            throw new ForbiddenException();
        }
        $views = Analytics::getViews();
        $downloads = Analytics::getDownloads();
        $rates = Analytics::getRates();
        $documents = Book::findAll();
        $this->view->renderPageHtml('analytics/view.php', [
            'books' => $documents,
            'views' => $views,
            'downloads' => $downloads,
            'rates' => $rates,
        ]);

    }

    public function rates(){
        if (!$this->user->isUserAdmin()){
            throw new ForbiddenException();
        }

        echo json_encode(Analytics::getDocsByRates());
    }
    public function topViews(){
        if (!$this->user->isUserAdmin()){
            throw new ForbiddenException();
        }
        echo json_encode(Analytics::getDocsByViews());
    }
    public function viewsByDate(){
        if (!$this->user->isUserAdmin()){
            throw new ForbiddenException();
        }
        echo json_encode(Analytics::getViewsByDate());
    }

    public function ratesByDate(){
        if (!$this->user->isUserAdmin()){
            throw new ForbiddenException();
        }
        echo json_encode(Analytics::getRatesByDate());
    }

    public function viewsByRegion(){
        if (!$this->user->isUserAdmin()){
            throw new ForbiddenException();
        }
        echo json_encode(Analytics::getCountViewsByRegion());
    }
    //getCountViewsByAge
    public function usersByAge(){
        if (!$this->user->isUserAdmin()){
            throw new ForbiddenException();
        }
        echo json_encode(Analytics::getCountViewsByAge());
    }
    public function getUserActivity(){

        if (!$this->user){
            throw new ForbiddenException();
        }
        echo json_encode(Analytics::getUserActivity($this->user->getId()));
    }

    public function getUserViews(){

        if (!$this->user){
            throw new ForbiddenException();
        }
        echo json_encode(Analytics::getUserViewsByDate($this->user->getId()));
    }
    public function getUserRates(){

        if (!$this->user){
            throw new ForbiddenException();
        }
        echo json_encode(Analytics::getUserRatesByDate($this->user->getId()));
    }
}