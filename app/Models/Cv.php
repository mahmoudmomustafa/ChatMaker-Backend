<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'number', 'location', 'title', 'website', 'website2', 'summary', 'updated_at', 'created_at'
    ];
    public function user()
    {
        $this->belongsTo(User::class);
    }
}
