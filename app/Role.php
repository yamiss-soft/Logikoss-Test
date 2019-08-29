<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Role extends Model
{
    use Sortable;

    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Sortable columns.
     *
     * @var array
     */
    public $sortable = [
        'name',
    ];

    /**
     * Filtros generales
     *
     * @param $query
     * @param array $input
     * @return mixed
     */
    public function scopeFilter($query, array $input = [])
    {
        if (!empty($input['filter_search'])) {
            $search = $input['filter_search'];
            $query->orWhere('name', 'like', '%' . str_replace(' ', '%%', $search) . '%');
        }

        return $query;
    }
}
