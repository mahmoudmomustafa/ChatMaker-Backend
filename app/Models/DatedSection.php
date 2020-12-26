<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatedSection extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['heading', 'updated_at', 'created_at'];
    //connect to user
    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }
    // 
    public function data()
    {
        return $this->hasMany(DatedData::class);
    }
}
