<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    protected $fillable = ['question_id','option1','option2','option3','option4','correct'];

    public function question(){
        return $this->belongsTo(Question::class);
    }
}
