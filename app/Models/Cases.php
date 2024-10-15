<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cases extends Model
{
    use HasFactory;
    protected $table = 'cases';
    protected $guarded = [];


   
    public function get_tpa()
    {
        return $this->belongsTo(User::class, 'tpa_allot_after_claim_no_received');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function get_assign_member()
{
    return $this->belongsTo(User::class, 'assign_member_id');
}

}
