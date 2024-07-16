<?php

namespace App\Http\Controllers;

use App\Models\Why;
use App\Models\Home;
use App\Models\About;
use App\Models\Footer;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Signature;
use Illuminate\Http\Request;

class frontend extends Controller
{
    public function home(){
        $footer = Footer::all();
        $Home = Home::all();
        return view ('frontend.home', compact('Home','footer'));
    }

    public function reservasi(){
        // $Home = Home::all();
        return view ('layouts.reservasi');
    }

     public function abouts(){
        $footer = Footer::all();
        $whyus = Why::all();
        $About = About::all();
         return view ('frontend.about', compact('About','whyus','footer'));
     }
     
     public function menu(){
        $footer = Footer::all();
        $products = product::all();
        return view ('frontend.menu', compact('products','footer'));
    }

    public function signature() {
        $footer = Footer::all();
        $signatures = Signature::all();
        $categories = $signatures->pluck('category')->unique()->values()->all(); 
    
        return view('frontend.signature', compact('signatures', 'categories','footer'));
    }

    // public function testimonial(){
    //     $footer = Footer::all();
    //     $testimonial = Testimonial::all();
    //     return view ('frontend.testimonial', compact('footer','testimonial'));
    // }
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'nama'           => 'required|string|max:255',
    //         'email'          => 'required|email|max:255',
    //         'nomor_telfon'   => 'required|numeric',
    //         'pesan'          => 'required|string',
    //     ]);

    //     Testimonial::create([
    //         'nama'           => $request->nama,
    //         'email'          => $request->email,
    //         'nomor_telfon'   => $request->nomor_telfon,
    //         'pesan'          => $request->pesan,
    //     ]);
    //     return redirect()->back()->with('success', 'Testimonial berhasil ditambahkan!');
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Testimonial berhasil ditambahkan !!'
    //     ]);
    // }
    public function galery(){
        $footer = Footer::all();
        $galery = Gallery::all();
        return view ('frontend.galery', compact('galery','footer'));
    }

    // public function chefs(){
    //     $footer = Footer::all();
    //     $chefs = Datachef::all();
    //     return view ('frontend.chefs',compact('chefs','footer'));
    // }
    public function footer()
    {
        $footer = Footer::first();
        return view('layouts.inc.footers', compact('footer'));
    }

}
