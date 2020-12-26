<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatedData extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protect inputs
    protected $fillable = ['title', 'company', 'description', 'start_date', 'end_date', 'updated_at', 'created_at'];

    //connect to dated section
    public function datedSection()
    {
        return $this->belongsTo(DatedSection::class);
    }
}
