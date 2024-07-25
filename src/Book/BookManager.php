<?php

namespace App\Book;

use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;

class BookManager
{
    public function __construct(
        protected readonly BookRepository $repository,
        protected readonly int $limit,
    )
    {
    }

    public function getPaginated(Request $request): array
    {
        $page = $request->query->getInt('page', 1);
        $pageNums = ceil($this->repository->count() / $this->limit);
        $books = $this->repository->findBy([], [], $this->limit, ($page - 1) * $this->limit);

        return [
            'books' => $books,
            'pageNums' => $pageNums,
            'currentPage' => $page,
        ];
    }
}
