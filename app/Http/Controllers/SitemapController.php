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
        $sitemap = App::make("sitemap");
        $now = Carbon::now();
        $sitemap->add(URL::to('/'), $now, '1.0', 'daily');

        // $sitemap->add(
        //     route('top'),
        //     Carbon::now(),
        //     1.0,
        //     'weekly'
        // );

        // $sitemap->add(
        //     route('greeting'),
        //     Carbon::now(),
        //     1.0,
        //     'weekly'
        // );

        // $sitemap->add(
        //     route('access'),
        //     Carbon::now(),
        //     1.0,
        //     'weekly'
        // );

        // $sitemap->add(
        //     route('fee'),
        //     Carbon::now(),
        //     1.0,
        //     'weekly'
        // );

        // $sitemap->add(
        //     route('introduction'),
        //     Carbon::now(),
        //     1.0,
        //     'weekly'
        // );

        // $sitemap->add(
        //     route('reservationTop'),
        //     Carbon::now(),
        //     1.0,
        //     'weekly'
        // );

        // XML形式で出力
        return $sitemap->render('xml');
    }
}
