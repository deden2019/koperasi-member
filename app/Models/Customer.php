<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash; // Import facade Hash

class Customer extends Model
{
    protected $table = 'm_customer';

    protected $primaryKey = 'customer_id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $guarded = [];

    /**
     * Mutator untuk otomatis mengenkripsi PIN ke bcrypt setiap kali disimpan
     */
    public function setPinAttribute($value)
    {
        // Mengecek apakah value sudah dalam bentuk hash atau belum (mencegah double hash)
        if (!empty($value) && Hash::needsRehash($value)) {
            $this->attributes['pin'] = Hash::make($value);
        } else {
            $this->attributes['pin'] = $value;
        }
    }
}