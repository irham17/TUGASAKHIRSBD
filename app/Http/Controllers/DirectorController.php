<?php
    
namespace App\Http\Controllers;
    
use App\Models\Hero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DirectorController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:director-list|director-create|director-edit|director-delete', ['only' => ['index','show']]);
         $this->middleware('permission:director-create', ['only' => ['create','store']]);
         $this->middleware('permission:director-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:director-delete', ['only' => ['destroy']]);
    }

    public function getDirectors(){
        $director = DB::table('directors')->where('deleted_at', null)->get();
        return view('directors.index')->with(['directors'=>$director]);
    }

    public function index()
    {
        $keyword = Request()->keyword;
        // $heros = Hero::where('nama_hero','LIKE','%'.$keyword.'%')->paginate(5);
        $directors = DB::table('directors')->where('nama_director', 'like', "%$keyword%")->get();
        return view('directors.index')->with(['directors' => $directors]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('directors.create');
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
            'id_director' => 'required',
            'nama_director' => 'required',
        ]);
    
        DB::insert('INSERT INTO directors(id_director, nama_director) VALUES (:id_director, :nama_director)',
        [
            'id_director' => $request->id_director,
            'nama_director' => $request->nama_director,
        ]
        );
    
        return redirect()->route('directors.index')
                        ->with('success','Director created successfully.');
    }
    

    public function show($id)
    {
        $director_table = DB::table('directors')->where('id_director', $id)->get()->first();
        return view('directors.show')->with(['director'=>$director_table]);
    }
    
    
    public function edit($id)
    {
        $director = DB::table('directors')->where('id_director', $id)->first();
        // return ($director);
        return view('directors.edit')->with(['director'=>$director]);
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
            'id_director' => 'required',
            'nama_director' => 'required',
        ]);
        $data = [
            'id_director' => $request->id_director,
            'nama_director' => $request->nama_director,
        ];
        // $hero->update($request->all());
        DB::table('directors')->where('id_director', $request->id_director)->update($data);
    
        return redirect()->route('directors.index')
                        ->with('success','Director updated successfully');
    }
    
    public function destroy($id)
    {
        $data=[
            'deleted_at' => Carbon::now(),
        ];
        DB::table('directors')->where('id_director', $id)->update($data);
    
        return redirect()->route('directors.index')
                        ->with('success','Director deleted successfully');
    }
    public function deletelist()
    {
        $deleted_table = DB::table('directors')->where('deleted_at','!=',null)->get();
        return view('directors.trash')->with(['directors'=>$deleted_table]);
        // return ($deleted_table);
    }
    public function restore($id)
    {
        DB::table('directors')->where('id_director', $id)->update(["deleted_at" => null]);
        return redirect()->route('directors.index')
                        ->with('success','Director Restored successfully');
    }
    public function deleteforce($id)
    {
        DB::table('directors')->where('id_director', $id)->delete();
        return redirect()->route('directors.index')
                        ->with('success','Director Deleted Permanently');
    }
}