<?php 

namespace App\Components\Pagination;

use Symfony\Component\Form\FormView;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('pagination/pagination')]
class PaginationComponent
{
    public FormView $form;
}
