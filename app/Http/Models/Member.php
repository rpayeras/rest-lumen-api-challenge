<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Member extends Model {

    protected $table = 'joysail_members';

    protected $fillable = [
        'firstname',
        'lastname',
        'phone',
        'email',
        'nationality',
        'card_id',
        'category_id',
        'external_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
