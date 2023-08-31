<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentManagement extends Model
{
    use HasFactory;

    protected $table = 'document_management';

    protected $fillable = [
        'title',
        'content',
        'signing',
    ];
}
