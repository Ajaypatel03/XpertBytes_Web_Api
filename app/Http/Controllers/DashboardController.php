<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Client;
use App\Models\ContactUs;
use App\Models\Employ;
use App\Models\Quote;
use App\Models\Service;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(){

        $blogscount = Blog::count();
        $clientReviewscount = Client::count();
        $employscount = Employ::count();
        $contactUsCount = ContactUs::count();
        $quoteCount = Quote::count();
        $serviceCount = Service::count();
        return
        view('dashboard',compact('blogscount','clientReviewscount','employscount','contactUsCount','quoteCount','serviceCount'));
    }
}