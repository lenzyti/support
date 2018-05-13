<?php

namespace Lenzy\Support\Domain\Database\Eloquent;

use Artesaos\Warehouse\CrudRepository;

abstract class Repository extends CrudRepository
{
    /**
     * Classe de modelo para repositório.
     *
     * @var string
     */
    protected $model;

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function newQuery()
    {
        return app()->make($this->model)->newQuery();
    }
}
