<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class SitemapController extends Controller
{
    // sitemap-indexを出力する
    public function index()
    {
        return response()->view('sitemap')->header('Content-Type', 'text/xml');
    }
}
