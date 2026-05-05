<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SEOToolsController extends Controller
{
    public function metaTagGenerator()
    {
        return view('tools.seo.meta-tag-generator');
    }

    public function robotsTxtGenerator()
    {
        return view('tools.seo.robots-txt-generator');
    }

    public function sitemapGenerator()
    {
        return view('tools.seo.sitemap-generator');
    }

    public function faqSchemaGenerator()
    {
        return view('tools.seo.faq-schema');
    }

    public function openGraphGenerator()
    {
        return view('tools.seo.og-generator');
    }
}
