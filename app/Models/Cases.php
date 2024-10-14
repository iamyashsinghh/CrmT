<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cases extends Model
{
    use HasFactory;
    protected $table = 'cases';
    protected $guarded = [];


    public function tpa()
    {
        return $this->belongsTo(User::class, 'tpa');
    }

    public function user()
{
    return $this->belongsTo(User::class, 'created_by');
}

}
