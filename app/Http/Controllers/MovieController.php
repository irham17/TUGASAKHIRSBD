<?php
    
namespace App\Http\Controllers;
    
use App\Models\Hero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class MovieController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:movie-list|movie-create|movie-edit|movie-delete', ['only' => ['index','show']]);
         $this->middleware('permission:movie-create', ['only' => ['create','store']]);
         $this->middleware('permission:movie-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:movie-delete', ['only' => ['destroy']]);
    }

    public function getMovies(){
        $movie = DB::table('movies')->where('deleted_at', null)->get();
        return view('movies.index')->with(['movies'=>$movie]);
    }

    public function index()
    {
        $keyword = Request()->keyword;
        // $heros = Hero::where('nama_hero','LIKE','%'.$keyword.'%')->paginate(5);
        $movies = DB::table('movies')->where('nama_movie', 'like', "%$keyword%")->get();
        return view('movies.index')->with(['movies' => $movies]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('movies.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'id_movie' => 'required',
            'nama_movie' => 'required',
            'id_genre' => 'required',
            'id_director' => 'required',
        ]);
    
        DB::insert('INSERT INTO movies(id_movie, nama_movie, id_genre, id_director) VALUES (:id_movie, :nama_movie, :id_genre, :id_director)',
        [
            'id_movie' => $request->id_movie,
            'nama_movie' => $request->nama_movie,
            'id_genre' => $request->id_genre,
            'id_director' => $request->id_director,
        ]
        );
    
        return redirect()->route('movies.index')
                        ->with('success','Movie created successfully.');
    }
    

    public function show($id)
    {
        $movie_table = DB::table('movies')->where('id_movie', $id)->get()->first();
        return view('movies.show')->with(['movie'=>$movie_table]);
    }
    
    
    public function edit($id)
    {
        $movie = DB::table('movies')->where('id_movie', $id)->first();
        // return ($movie);
        return view('movies.edit')->with(['movie'=>$movie]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_movie' => 'required',
            'nama_movie' => 'required',
            'id_genre' => 'required',
            'id_director' => 'required'
        ]);
        $data = [
            'id_movie' => $request->id_movie,
            'nama_movie' => $request->nama_movie,
            'id_genre' => $request->id_genre,
            'id_director' => $request->id_director,
        ];
        // $hero->update($request->all());
        DB::table('movies')->where('id_movie', $request->id_movie)->update($data);
    
        return redirect()->route('movies.index')
                        ->with('success','Movie updated successfully');
    }
    
    public function destroy($id)
    {
        $data=[
            'deleted_at' => Carbon::now(),
        ];
        DB::table('movies')->where('id_movie', $id)->update($data);
    
        return redirect()->route('movies.index')
                        ->with('success','Movie deleted successfully');
    }
    public function deletelist()
    {
        $deleted_table = DB::table('movies')->where('deleted_at','!=',null)->get();
        return view('movies.trash')->with(['movies'=>$deleted_table]);
        // return ($deleted_table);
    }
    public function restore($id)
    {
        DB::table('movies')->where('id_movie', $id)->update(["deleted_at" => null]);
        return redirect()->route('movies.index')
                        ->with('success','Movie Restored successfully');
    }
    public function deleteforce($id)
    {
        DB::table('movies')->where('id_movie', $id)->delete();
        return redirect()->route('movies.index')
                        ->with('success','Movie Deleted Permanently');
    }
}