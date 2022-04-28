<?php

namespace Hlyun;

use Illuminate\Pagination\LengthAwarePaginator;

class Paginator extends LengthAwarePaginator
{

    public function toArray()
    {
        return [
            'current_page' => $this->currentPage(),
            'data' => $this->items->toArray(),
            // 'first_page_url' => $this->url(1),
             'from' => $this->firstItem() ?? 0,
            // 'last_page' => $this->lastPage(),
            // 'last_page_url' => $this->url($this->lastPage()),
            // 'next_page_url' => $this->nextPageUrl(),
            // 'path' => $this->path,
            'per_page' => $this->perPage() ,
            // 'prev_page_url' => $this->previousPageUrl(),
             'to' => $this->lastItem() ?? 0,
            'total' => $this->total(),
        ];
    }
}
