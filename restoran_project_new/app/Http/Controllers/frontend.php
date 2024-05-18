<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Home;
use App\Models\Table;
use App\Models\Footer;
use App\Models\Product;
use Illuminate\Http\Request;

class frontend extends Controller
{

    // public function getdb() {
    //     $footer = Footer::all();
    //     $blog = Blog::with(['media'])->get();
    //     return view ('frontend.index', compact('footer','blog'));
    // }
    // public function home(){
    //     // $blog = Blog::all();
    //     return view ('frontend.home', compact('blog'));
    // }
    public function home(){
        $Home = Home::all();
        return view ('frontend.home', compact('Home'));
    }

     public function abouts(){
        //  $blog = Blog::all();
         return view ('frontend.about');
     }
     
     public function menu(){
        $products = product::all();
        return view ('frontend.menu', compact('products'));
    }

    public function signature(){
        // $blog = Blog::all();
        return view ('frontend.signature');
    }

    public function testimonial(){
        return view ('frontend.testimonial');
    }
    
    public function galery(){
        return view ('frontend.galery');
    }
    
    public function chefs(){
        return view ('frontend.chefs');
    }


    // public function footer() {
    //     $footer = Footer::all();
    //     return view ('frontend.index', compact('footer'));
    // }

    // public function product () {
    //     $products = Product::all();
    //     return view ('frontend.index', compact('products'));
    // };
}
