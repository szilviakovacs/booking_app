<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingEvent extends Model
{
    use HasFactory;
    protected $fillable = ['oh_id', 'name', 'start_time', 'end_time'];
}
