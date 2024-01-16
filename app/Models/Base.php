<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    protected $limit = 0;

    public function __construct(array $attributes = [])
    {


        $this->bootIfNotBooted();

        $this->initializeTraits();

        $this->syncOriginal();

        $this->fill($attributes);

        $this->limit = config('setting.limit');
    }



}
