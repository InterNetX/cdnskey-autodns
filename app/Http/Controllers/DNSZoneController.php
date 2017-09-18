<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DNSServer;
use App\DNSZone;

class DNSZoneController extends Controller
{
    /**
     * This controller requires authentication
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = DNSZone::orderBy('name')->paginate(5);
        return view('zoneCRUD.index',compact('items'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
	$servers = DNSServer::all();
        return view('zoneCRUD.create', compact('servers'));
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'dns_server_id' => 'required',
        ]);

        DNSZone::create($request->all());
        return redirect()->route('zoneCRUD.index')
                        ->with('success','DNS server created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = DNSZone::find($id);
        return view('zoneCRUD.show',compact('item'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = DNSZone::find($id);
	$servers = DNSServer::all();
        return view('zoneCRUD.edit',compact('item'),compact('servers'));
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
        $this->validate($request, [
            'name' => 'required',
            'dns_server_id' => 'required',
        ]);

        DNSZone::find($id)->update($request->all());
        return redirect()->route('zoneCRUD.index')
                        ->with('success','DNS server updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DNSZone::find($id)->delete();
        return redirect()->route('serverCRUD.index')
                        ->with('success','DNS server deleted successfully');

    }
}
