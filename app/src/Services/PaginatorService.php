<?php

namespace App\Services;

use Doctrine\ORM\Tools\Pagination\Paginator;

class PaginatorService
{
    /**
     * list all pages from paginator
     *
     * @param Paginator $paginator
     * @return int[] $pages
     */
    public function getPageCount(Paginator $paginator): int
    {
        $pageCount = count($paginator) / $paginator->getQuery()->getMaxResults();

        return (int) ceil($pageCount);
    }
}