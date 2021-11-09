<?php

namespace App\Models;

use App\Notifications\EntryNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Entry extends Model
{
    use Notifiable;

    public $timestamps = false;

    /**
     * table
     *
     * @var string
     */
    protected $table = 'tabla_sensor';

    /**
     * dates
     *
     * @var array
     */
    protected $dates = ['fecha_hora'];

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'temperatura',
        'tipo_alerta',
        'fecha_hora'
    ];


    /**
     * get email attribute for testing
     *
     * @return string
     */
    public function getEmailAttribute(): string
    {
        return 'guillermodanilo08@gmail.com';
    }
}
