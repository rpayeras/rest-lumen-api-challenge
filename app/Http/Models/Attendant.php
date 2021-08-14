<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Attendant extends Model {
    protected $table = 'joysail_attendants';

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'position',
        'media',
        'media_category',
        'media_department',
        'type_id',
        'external_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
