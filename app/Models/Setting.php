<?php

namespace App\Models;

use App\Traits\CleanHtml;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use CleanHtml;

    protected $fillable = ['name'];
}
