<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneralPaymentData extends Model
{
    protected $table = 'general_payment_data';

    protected $dispatchesEvents = [
        'saving' => UserSaved::class,
        'updating' => UserDeleted::class,
    ];
}
