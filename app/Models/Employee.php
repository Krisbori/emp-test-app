<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Employee extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = ['employee_id', 'surname','name', 'patronymic', 'position', 'recruitment_date', 'salary'];
    protected $dates = ['recruitment_date'];
    
    public function getRecruitmentDateAttribute($value){
        return Carbon::parse($value)->format('Y-m-d');
    }
    
    public function Childrens(){
        return $this->HasMany(Employee::class);
    }
}
