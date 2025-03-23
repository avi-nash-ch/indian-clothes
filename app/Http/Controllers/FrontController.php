<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\About;
use App\Models\Contact;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Register;
use App\Models\ProductMapping;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
   public function index()
   {
    return redirect()->route('login');
   }

}
