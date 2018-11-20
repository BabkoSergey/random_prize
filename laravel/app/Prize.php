<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    public $table = "prizes";
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'user_id', 'type_id', 'value'
    ];
    
     /**
     * Many to one relationship with type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {                
        return $this->hasOne('App\Type','id', 'type_id');       
    }
    
    /**
     * Many to one relationship with type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {                
        return $this->hasOne('App\User','id', 'user_id');       
    }
}
