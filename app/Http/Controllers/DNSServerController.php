<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DNSServer;

class DNSServerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = DNSServer::orderBy('name')->paginate(5);
        return view('serverCRUD.index',compact('items'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('serverCRUD.create');
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
            'ip' => 'required',
        ]);

        DNSServer::create($request->all());
        return redirect()->route('serverCRUD.index')
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
        $item = DNSServer::find($id);
        return view('serverCRUD.show',compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = DNSServer::find($id);
        return view('serverCRUD.edit',compact('item'));
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
            'ip' => 'required',
        ]);

        DNSServer::find($id)->update($request->all());
        return redirect()->route('serverCRUD.index')
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
        DNSServer::find($id)->delete();
        return redirect()->route('serverCRUD.index')
                        ->with('success','DNS server deleted successfully');

    }
}
