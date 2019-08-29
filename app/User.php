<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Kyslik\ColumnSortable\Sortable;

class User extends Authenticatable
{
    use Notifiable;
    use Sortable;

    protected $table = 'users';

    const PATH_AVATARS = 'images/users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','username','avatar','status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Sortable columns.
     *
     * @var array
     */
    public $sortable = [
        'name',
        'email',
        'email_verified_at',
        'status'
    ];

    /**
     * @return string
     */
    public function pathAvatar()
    {
        return '/app-images/' . self::PATH_AVATARS . '/' . $this->avatar;
    }

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
            $query->orWhere('email', 'like', '%' . str_replace(' ', '%%', $search) . '%');
            $query->orWhere('username', 'like', '%' . str_replace(' ', '%%', $search) . '%');
        }

        return $query;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class,'user_role');
    }
}
