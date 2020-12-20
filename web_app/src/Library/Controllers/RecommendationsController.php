<?php

namespace Library\Controllers;

use Library\Exceptions\ForbiddenException;
use Library\Models\Books\Book;

class RecommendationsController extends MainAbstractController
{
    public function view()
    {
        if (!$this->user){
            throw new ForbiddenException();
        }
        $recommendations = Book::getRecommendations($this->user->getId());
        $this->view->renderPageHtml('recommendations/view.php', [
            'recommendations' => $recommendations,
        ]);

    }
}