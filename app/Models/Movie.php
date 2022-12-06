<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
  
class Movie extends Model
{
    use HasFactory,SoftDeletes;
  
    /**
     * The attributes that are mass assignable.
     *  
     * @var array
     */
    protected $fillable = [
        'id_movie', 'nama_movie','id_genre','id_director'
    ];
    protected $primaryKey = 'id_movie';
    protected $keyType = 'bigInteger';
    public $incrementing = false;
}