<?php

namespace Library\Controllers;

use Library\Models\Classifications\Classification;

class ClassificationsController extends MainAbstractController
{
    public function view(): void
    {
        $this->view->renderPageHtml('classifications/view.php',
            ['classification' => Classification::class]
        );
    }
}