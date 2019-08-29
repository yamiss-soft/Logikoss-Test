<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Post extends Model
{
    use Sortable;

    protected $table = 'posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','content','image','slug',
    ];

    /**
     * Sortable columns.
     *
     * @var array
     */
    public $sortable = [
        'title','content'
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
            $query->orWhere('title', 'like', '%' . str_replace(' ', '%%', $search) . '%');
            $query->orWhere('content', 'like', '%' . str_replace(' ', '%%', $search) . '%');
        }

        return $query;
    }
}
