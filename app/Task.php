<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model{
  protected $fillable = [
    'title',
    'description',
    'priority',
    'finished'
    // 'created_at',
    // 'updated_at'
  ];
}
