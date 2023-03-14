<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';
    protected $primaryKey = 'emp_no';

    public $timestamps = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'gender',
        'hire_date',
    ];

    public function Titles()
    {
        return $this->hasMany(Titles::class,'emp_no');
    }

    public function Salaries()
    {
        return $this->hasMany(Salaries::class,'emp_no');
    }
}
