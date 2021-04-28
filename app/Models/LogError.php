<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogError extends Model
{
    protected $table = 'log_error';
    protected $primaryKey = 'id';
    protected $fillable = [
        "error",
        "class",
        "function"
    ];

    public static function saveLog($error, $class, $function){

        Self::create([
            "error" => $error,
            "class" => $class,
            "function" => $function
        ]);

    }
}
