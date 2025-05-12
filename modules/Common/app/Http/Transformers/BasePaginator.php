<?php

namespace Modules\Common\Http\Transformers;

use Illuminate\Pagination\LengthAwarePaginator;

class BasePaginator extends LengthAwarePaginator
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'currentPage'   => $this->currentPage,
            'perPage'       => $this->perPage,
            'lastPage'      => $this->lastPage,
            'total'         => $this->total,
        ];
    }
}
