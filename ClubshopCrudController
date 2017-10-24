<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use App\Http\Controllers\Session;
use App\Clubshops;
use App\Manage;

class ClubshopCrudController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

               $data = DB::table('clubshops')->paginate(20);
        
               return view('pages.manage')->with('data', $data);
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id = $request->input('id');
        $clubshop_id = $request->input('clubshop_id');
        $clubshop = $request->input('clubshop');
        $status = $request->input('status');
        $opened = $request->input('opened');
        $url = $request->input('url');
        $sage = $request->input('sage');

        DB::table('clubshops')->insert(['clubshop_id' => $clubshop_id, 'clubshop' => $clubshop, 'status' => $status, 'opened' => $opened,'sage' => $sage, 'url' => $url]);

        return redirect('/admin/manage')->with('message', 'Clubshop edit successfull!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {

        $id = $request->input('id') ? $request->input('id') : false;
        $clubshop_id = $request->input('clubshop_id');
        $clubshop = $request->input('clubshop');
        $tax = $request->input('tax');
        $status = $request->input('status');
        $opened = $request->input('opened');
        $url = $request->input('url');
        $sage = $request->input('sage');

        DB::table('clubshops')->where('id', $id)->update(['clubshop_id' => $clubshop_id, 'clubshop' => $clubshop, 'status' => $status, 'opened' => $opened,'sage' => $sage, 'tax' => $tax,'url' => $url]);

       
        return redirect()->back()->with('message', 'Clubshop edit successfull!');
      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      
    }

    /* CLOSE THE CLUBSHOP */
    public function open(Request $request, $id){
        $time = $date = date("d-m-Y | h:i:s A");
        DB::table('clubshops')->where('id', $id)->update(['status' => 'Open', 'opened' => $time]);

            
            $note = "This store was opened on ".$time;
            $created_by = "Admin";
            DB::table('notes')->insert(['clubshop_id' => $id,'note' => $note,'created_by' => $created_by,'created_at' => $time]);

        return redirect()->back()->with('message', 'Clubshop edit successfull!');
    } # END


  /* CLOSE THE CLUBSHOP */  
    public function close(Request $request, $id){
        
        DB::table('clubshops')->where('id', $id)->update(['status' => 'Closed']);

            $time = $date = date("d-m-Y | h:i:s A");
            $note = "This store was closed on ".$time;
            $created_by ="Admin";
            DB::table('notes')->insert(['clubshop_id' => $id,'note' => $note,'created_by' => $created_by,'created_at' => $time]);

        return redirect()->back()->with('message', 'Clubshop edit successfull!');
                
    }
}
