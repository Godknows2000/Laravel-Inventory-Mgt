<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'ordernote_number',
        'branch_id',
        'created_by',
        'note',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ordernote) {
            $ordernote->ordernote_number = date('Ymd') . '-' . str_pad(OrderNote::count() + 1, 4, '0', STR_PAD_LEFT);
        });
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    // Define the relationship to the User model
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
