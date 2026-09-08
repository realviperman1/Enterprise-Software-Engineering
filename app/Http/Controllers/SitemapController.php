<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        $tenant = app(\App\Models\Website::class);
        $tours = $tenant->tours;
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        
        // Home
        $xml .= '<url><loc>' . url('/') . '</loc><changefreq>daily</changefreq><priority>1.0</priority></url>';
        $xml .= '<url><loc>' . url('/about') . '</loc><changefreq>monthly</changefreq><priority>0.8</priority></url>';
        $xml .= '<url><loc>' . url('/contact') . '</loc><changefreq>monthly</changefreq><priority>0.8</priority></url>';
        
        // Tours
        foreach($tours as $tour) {
            $xml .= '<url><loc>' . url('/tour-' . $tour->id) . '</loc><changefreq>weekly</changefreq><priority>0.9</priority></url>';
        }
        
        $xml .= '</urlset>';
        
        return response($xml, 200)->header('Content-Type', 'text/xml');
    }}
