<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Document extends Model {

    protected $table = 'joysail_documents';

    protected $fillable = [
        'name',
        'type',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
