<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Configuration;

class ConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $configurations = Configuration::get();
        return Inertia::render('Configuration/ConfigurationIndex',compact('configurations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Configuration $configuration,Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'details' => 'required',
            'image' => 'required|image',
            'fee' => 'required'
        ]);
        
        $save = Configuration::create($validate);
        if ($request->hasFile('image')) {
            $fileName = 'image'.time().'.'.$request->image->extension();
            $configuration->where('id',$save->id)->update(['image' => $fileName]);
            $request->file('image')->move(public_path('images/car-images'), $fileName);
        }

        return back()->with('success', 'Configuration added succesfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $validate = $request->validate([
            'id' => 'required',
            'name' => 'required',
            'details' => 'required',
            'image' => 'required|image',
            'fee' => 'required'
        ]);

        Configuration::where('id', $id)
        ->update($validate);

        // $update = Configuration::create($validate);
        if ($request->hasFile('image')) {
            $fileName = 'image'.time().'.'.$request->image->extension();
            Configuration::where('id', $id)
            ->update(['image' => $fileName]);
            $request->file('image')->move(public_path('images/car-images'), $fileName);
        }
        
        return back()->with('succes','Configuration updated successfully!');
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $configuration = Configuration::find($id);
        $configuration->delete();
        return back()->with('success','Config  deleted sucessfully!');
    }
}
