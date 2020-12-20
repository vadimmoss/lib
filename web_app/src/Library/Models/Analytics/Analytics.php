<?php

namespace Library\Models\Analytics;

use Library\Models\Views\View;
use Library\Models\Downloads\Download;
use Library\ServiceClasses\Database;

class Analytics
{
    public static function getViews(): array
    {
        return View::findAll();
    }

    public static function getDownloads(): array
    {

        return Download::findAll();
    }

    public static function getRates(): array
    {
        $db = Database::getConnection();
        $rates_stat = $db->sqlQueryNonClass('SELECT books.title, COUNT(*) as count_rates, AVG(rate) as average_rating FROM `rates`
                        JOIN books ON id_book = books.id
                        GROUP BY books.id');
        return $rates_stat;
    }

    public static function getDocsByRates(){
        $db = Database::getConnection();
        $sql = 'SELECT books.id, books.title, COUNT(*) as count_rates FROM `rates`
                JOIN books ON rates.id_book = books.id
                GROUP BY books.id
                ORDER BY count_rates DESC LIMIT 5';
        $result = $db->sqlQueryNonClass($sql);
        return $result;
    }

    public static function getDocsByViews(){
        $db = Database::getConnection();
        $sql = 'SELECT books.id, books.title, COUNT(*) as count_views FROM `views`
                JOIN books ON views.id_book = books.id
                GROUP BY books.id
                ORDER BY count_views DESC LIMIT 5';
        $result = $db->sqlQueryNonClass($sql);
        return $result;
    }

    public static function getViewsByDate(int $year = 2020)
    {
        $db = Database::getConnection();
        $sql = 'SELECT COUNT(*) as count_views, DATE(DATE_FORMAT(views.view_date,\'%Y-%m-%d\')) as view_dates FROM `views`
                JOIN books ON id_book = books.id
                GROUP BY view_dates
                ORDER BY view_dates';
        $result = $db->sqlQueryNonClass($sql);
        return $result;
    }

    public static function getRatesByDate()
    {
        $db = Database::getConnection();
        $sql = 'SELECT  COUNT(rates.id) as count_rates, DATE(DATE_FORMAT(rates.rate_date,\'%Y-%m-%d\')) as rates_dates FROM `rates`
                JOIN books ON id_book = books.id
                GROUP BY  rates_dates
                ORDER BY rates_dates';
        $result = $db->sqlQueryNonClass($sql);
        return $result;
    }

    public static function getCountViewsByRegion():array
    {
        $db = Database::getConnection();
        $sql = 'SELECT COUNT(*) as count_views, view_region FROM `views`
                JOIN books ON id_book = books.id
                GROUP BY view_region
                ORDER BY count_views';
        $result = $db->sqlQueryNonClass($sql);
        return $result;
    }

    public static function getCountViewsByAge():array
    {
        $db = Database::getConnection();
        $sql = 'SELECT COUNT(*) as count_users, age FROM `users` GROUP BY age ORDER BY count_users';
        $result = $db->sqlQueryNonClass($sql);
        return $result;
    }

    public static function getUserActivity($idUser):array{
        $db = Database::getConnection();
        $sql = 'SELECT COUNT(*) as count_views, DATE(DATE_FORMAT(views.view_date,\'%Y-%m-%d\')) as view_dates FROM `views`
                JOIN books ON id_book = books.id
              	JOIN users ON views.id_viewer = users.id
                WHERE users.id = '. $idUser .'
                GROUP BY view_dates
                ORDER BY view_dates';
        $result = $db->sqlQueryNonClass($sql);
        return $result;
    }



    public static function getUserViewsByDate(int $idUser)
    {
        $db = Database::getConnection();
        $sql = 'SELECT COUNT(*) as count_views, DATE(DATE_FORMAT(views.view_date,\'%Y-%m-%d\')) as view_dates FROM `views`
                JOIN books ON id_book = books.id
                JOIN users ON views.id_viewer = users.id
                WHERE users.id = '.$idUser.'
                GROUP BY view_dates
                ORDER BY view_dates';
        $result = $db->sqlQueryNonClass($sql);
        return $result;
    }

    public static function getUserRatesByDate(int $idUser)
    {
        $db = Database::getConnection();
        $sql = 'SELECT  COUNT(rates.id) as count_rates, DATE(DATE_FORMAT(rates.rate_date,\'%Y-%m-%d\')) as rates_dates FROM `rates`
                JOIN books ON id_book = books.id
                JOIN users ON rates.id_rater = users.id
                WHERE users.id = '.$idUser.'
                GROUP BY  rates_dates
                ORDER BY rates_dates';
        $result = $db->sqlQueryNonClass($sql);
        return $result;
    }





}

