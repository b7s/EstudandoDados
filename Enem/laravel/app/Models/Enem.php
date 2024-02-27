<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enem extends Model
{
    use HasFactory;

    protected $table = 'enem';

    protected $guarded = [];// Vazio para permiter preencher todas as colunas
}
