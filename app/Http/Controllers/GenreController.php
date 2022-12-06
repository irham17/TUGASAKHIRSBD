<?php
    
namespace App\Http\Controllers;
    
use App\Models\Hero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class GenreController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:genre-list|genre-create|genre-edit|genre-delete', ['only' => ['index','show']]);
         $this->middleware('permission:genre-create', ['only' => ['create','store']]);
         $this->middleware('permission:genre-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:genre-delete', ['only' => ['destroy']]);
    }

    public function getGenres(){
        $genre = DB::table('genres')->where('deleted_at', null)->get();
        return view('genres.index')->with(['genres'=>$genre]);
    }

    public function index()
    {
        $keyword = Request()->keyword;
        // $heros = Hero::where('nama_hero','LIKE','%'.$keyword.'%')->paginate(5);
        $genres = DB::table('genres')->where('nama_genre', 'like', "%$keyword%")->get();
        return view('genres.index')->with(['genres' => $genres]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('genres.create');
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
            'id_genre' => 'required',
            'nama_genre' => 'required',
        ]);
    
        DB::insert('INSERT INTO genres(id_genre, nama_genre) VALUES (:id_genre, :nama_genre)',
        [
            'id_genre' => $request->id_genre,
            'nama_genre' => $request->nama_genre,
        ]
        );
    
        return redirect()->route('genres.index')
                        ->with('success','Genre created successfully.');
    }
    

    public function show($id)
    {
        $genre_table = DB::table('genres')->where('id_genre', $id)->get()->first();
        return view('genres.show')->with(['genre'=>$genre_table]);
    }
    
    
    public function edit($id)
    {
        $genre = DB::table('genres')->where('id_genre', $id)->first();
        // return ($genre);
        return view('genres.edit')->with(['genre'=>$genre]);
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
            'id_genre' => 'required',
            'nama_genre' => 'required',
        ]);
        $data = [
            'id_genre' => $request->id_genre,
            'nama_genre' => $request->nama_genre,
        ];
        // $hero->update($request->all());
        DB::table('genres')->where('id_genre', $request->id_genre)->update($data);
    
        return redirect()->route('genres.index')
                        ->with('success','Genre updated successfully');
    }
    
    public function destroy($id)
    {
        $data=[
            'deleted_at' => Carbon::now(),
        ];
        DB::table('genres')->where('id_genre', $id)->update($data);
    
        return redirect()->route('genres.index')
                        ->with('success','Genre deleted successfully');
    }
    public function deletelist()
    {
        $deleted_table = DB::table('genres')->where('deleted_at','!=',null)->get();
        return view('genres.trash')->with(['genres'=>$deleted_table]);
        // return ($deleted_table);
    }
    public function restore($id)
    {
        DB::table('genres')->where('id_genre', $id)->update(["deleted_at" => null]);
        return redirect()->route('genres.index')
                        ->with('success','Genre Restored successfully');
    }
    public function deleteforce($id)
    {
        DB::table('genres')->where('id_genre', $id)->delete();
        return redirect()->route('genres.index')
                        ->with('success','Genre Deleted Permanently');
    }
}