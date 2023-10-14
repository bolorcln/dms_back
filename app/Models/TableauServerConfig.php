<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableauServerConfig extends Model
{
    use HasFactory;
    protected $fillable = [
        'server_url',
        'server_version',
        'site_name',
        'client_id',
        'client_secret',
        'client_exp_date',
        'access_name',
        'access_token',
        'pa_exp_date',
        'data_upload_connection_username',
        'data_upload_connection_password'
    ];
}
