<?php
    
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JoinController extends Controller
{
    public function index()
    {
        $joins = DB::table('movies')
            ->join('genres', 'movies.id_genre', '=', 'genres.id_genre')
            ->join('directors', 'movies.id_director', '=', 'directors.id_director')
            ->select('movies.nama_movie as nama_movie', 'genres.nama_genre as nama_genre','directors.nama_director as nama_director')
            ->paginate(6);
            return view('totals.index',compact('joins'))
                ->with('i', (request()->input('page', 1) - 1) * 6);
    }
}