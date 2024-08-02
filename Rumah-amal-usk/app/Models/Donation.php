<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'amount', 'payment_method', 'campaign_name', 'status', 'payment_id'];
}
