<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToCompany;

class Employee extends Model
{
    use HasFactory;
    use BelongsToCompany;


    protected $fillable = [
        'employee_id',
        'name',
        'email',
        'department',
        'date_of_joining',
        'status',
    ];

    protected $casts = [
        'date_of_joining' => 'date',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
