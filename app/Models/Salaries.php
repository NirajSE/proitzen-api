<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salaries extends Model
{
    use HasFactory;

    protected $table = 'salaries';
    protected $primaryKey = ['emp_no', 'from_date'];

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'emp_no',
        'salary',
        'from_date',
        'to_date',
    ];

    public function employee()
    {
        return $this->hasMany(Employee::class);
    }
}
