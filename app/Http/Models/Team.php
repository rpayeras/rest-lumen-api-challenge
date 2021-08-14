<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Team extends Model {
    protected $table = 'joysail_teams';

    protected $fillable = [
        'name',
        'brand',
        'model',
        'loa',
        'draft',
        'beam',
        'sail_number',
        'date_arrival',
        'date_departure',
        'class',
        'car_plate_number',
        'container_size',
        'external_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
