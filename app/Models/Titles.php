<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Titles extends Model
{
    use HasFactory;

    protected $table = 'titles';
    protected $primaryKey = ['emp_no', 'title', 'from_date'];

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'emp_no',
        'title',
        'from_date',
        'to_date',
    ];

    public function employee()
    {
        return $this->hasMany(Employee::class);
    }
}
