<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = ['full_path'];
    protected $visible = ['id','full_path','path_name','file_name'];

    public function getFullPathAttribute()
    {
        return url("")."/".$this->path_name;
    }

    // public function getFileNameAttribute()
    // {
    //     return basename($this->path_name);
    // }

    public function fileable()
    {
        return $this->morphTo();
    }
}
