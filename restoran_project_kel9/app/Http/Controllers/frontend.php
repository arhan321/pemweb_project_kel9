<?php

namespace App\Http\Controllers;

use App\Models\Why;
use App\Models\Blog;
use App\Models\Home;
use App\Models\About;
use App\Models\Table;
use App\Models\Footer;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Datachef;
use App\Models\SosialMedium;
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

    public function reservasi(){
        // $Home = Home::all();
        return view ('layouts.reservasi');
    }

     public function abouts(){
        $whyus = Why::all();
        $About = About::all();
         return view ('frontend.about', compact('About','whyus'));
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
        $galery = Gallery::all();
        return view ('frontend.galery', compact('galery'));
    }
    
    public function chefs(){
        $chefs = Datachef::all();
        $icon = SosialMedium::all();
        return view ('frontend.chefs',compact('chefs','icon'));
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
