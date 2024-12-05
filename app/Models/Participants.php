<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participants extends Model
{
    protected $table = 'acr_partic_m';
    protected $guarded = ['id'];

    public function kk()
    {
        return $this->hasOne(ParticipantsFiles::class, 'file_id', 'bpjs_file_id');
    }

    public function ktp()
    {
        return $this->hasOne(ParticipantsFiles::class, 'file_id', 'passport_file_id');
    }

    public function pp()
    {
        return $this->hasOne(ParticipantsFiles::class, 'file_id', 'photo_file_id');
    }
}
