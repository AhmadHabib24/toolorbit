<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ConversionController;
use App\Http\Controllers\DevToolsController;
use App\Http\Controllers\ImageToolsController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\SEOToolsController;
use App\Http\Controllers\TechnicalSEOController;
use App\Http\Controllers\TextToolsController;
use App\Http\Controllers\YouTubeToolsController;
use App\Models\Tool;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $tools = Tool::where('is_active', true)->get()->map(function ($tool) {
        return [
            'title' => $tool->title,
            'category' => $tool->category,
            'desc' => $tool->description,
            'href' => $tool->route_name && Route::has($tool->route_name) ? route($tool->route_name, [], false) : '/' . $tool->slug,
            'icon' => $tool->icon
        ];
    });
    return view('welcome', compact('tools'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Locale
Route::get('/lang/{lang}', [LocaleController::class, 'setLocale'])->name('lang.switch');

// SEOToolsController
Route::get('/meta-tag-generator', [SEOToolsController::class, 'metaTagGenerator'])->name('tools.meta-tag-generator');
Route::get('/robots-txt-generator', [SEOToolsController::class, 'robotsTxtGenerator'])->name('tools.robots-txt-generator');
Route::get('/sitemap-generator', [SEOToolsController::class, 'sitemapGenerator'])->name('tools.sitemap-generator');
Route::get('/faq-schema-generator', [SEOToolsController::class, 'faqSchemaGenerator'])->name('tools.faq-schema-generator');
Route::get('/open-graph-generator', [SEOToolsController::class, 'openGraphGenerator'])->name('tools.open-graph-generator');

// PDFController
Route::get('/text-to-pdf', [PDFController::class, 'textToPdf'])->name('tools.text-to-pdf');
Route::post('/pdf/text-to-pdf', [PDFController::class, 'processTextToPdf']);
Route::get('/image-to-pdf', [PDFController::class, 'imageToPdf'])->name('tools.image-to-pdf');
Route::post('/pdf/image-to-pdf', [PDFController::class, 'processImageToPdf']);
Route::get('/pdf-to-base64', [PDFController::class, 'pdfToBase64'])->name('tools.pdf-to-base64');
Route::post('/pdf/pdf-to-base64', [PDFController::class, 'processPdfToBase64']);

// AuditController
Route::get('/seo-checker', [AuditController::class, 'seoChecker'])->name('tools.seo-checker');
Route::post('/audit/seo-checker', [AuditController::class, 'processSeoChecker']);
Route::get('/color-palette-generator', [AuditController::class, 'colorPalette'])->name('tools.color-palette-generator');
Route::get('/url-encoder-decoder', [AuditController::class, 'urlEncoder'])->name('tools.url-encoder-decoder');
Route::post('/audit/url-encoder-decoder', [AuditController::class, 'processUrlEncoder']);

// ImageToolsController
Route::get('/image-to-base64', [ImageToolsController::class, 'imageToBase64'])->name('tools.image-to-base64');
Route::post('/image/image-to-base64', [ImageToolsController::class, 'processImageToBase64']);
Route::get('/website-screenshot', [ImageToolsController::class, 'screenshotGenerator'])->name('tools.screenshot-generator');
Route::get('/placeholder-generator', [ImageToolsController::class, 'placeholderGenerator'])->name('tools.placeholder-generator');

// ConversionController
Route::get('/rgb-to-hex', [ConversionController::class, 'rgbHex'])->name('tools.rgb-to-hex');
Route::get('/binary-converter', [ConversionController::class, 'binaryConverter'])->name('tools.binary-converter');
Route::get('/json-to-csv', [ConversionController::class, 'jsonCsv'])->name('tools.json-to-csv');
Route::post('/conversion/json-to-csv', [ConversionController::class, 'processJsonCsv']);
Route::get('/qr-code-generator', [ConversionController::class, 'qrCode'])->name('tools.qr-code-generator');
Route::get('/favicon-generator', [ConversionController::class, 'faviconGenerator'])->name('tools.favicon-generator');

// ChatController
Route::prefix('ai')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('ai.chat');
    Route::post('/chat', [ChatController::class, 'process']);
});

// TextToolsController
Route::prefix('text')->group(function () {
    Route::get('/word-counter', [TextToolsController::class, 'wordCounter'])->name('tools.word-counter');
    Route::post('/word-counter', [TextToolsController::class, 'processWordCounter']);
    Route::get('/case-converter', [TextToolsController::class, 'caseConverter'])->name('tools.case-converter');
    Route::post('/case-converter', [TextToolsController::class, 'processCaseConverter']);
    Route::get('/remove-emojis', [TextToolsController::class, 'removeEmojis'])->name('tools.remove-emojis');
    Route::post('/remove-emojis', [TextToolsController::class, 'processRemoveEmojis']);
    Route::get('/lorem-ipsum', [TextToolsController::class, 'loremIpsum'])->name('tools.lorem-ipsum');
});

// YouTubeToolsController
Route::prefix('youtube')->group(function () {
    Route::get('/thumbnail-downloader', [YouTubeToolsController::class, 'thumbnailDownloader'])->name('tools.thumbnail-downloader');
    Route::post('/thumbnail-downloader', [YouTubeToolsController::class, 'processThumbnail']);
    Route::get('/tag-extractor', [YouTubeToolsController::class, 'tagExtractor'])->name('tools.tag-extractor');
    Route::post('/tag-extractor', [YouTubeToolsController::class, 'processTagExtractor']);
});

// DevToolsController
Route::prefix('dev')->group(function () {
    Route::get('/json-formatter', [DevToolsController::class, 'jsonFormatter'])->name('tools.json-formatter');
    Route::post('/json-formatter', [DevToolsController::class, 'processJsonFormatter']);
    Route::get('/html-entities', [DevToolsController::class, 'htmlEntities'])->name('tools.html-entities');
    Route::post('/html-entities', [DevToolsController::class, 'processHtmlEntities']);
    Route::get('/js-minifier', [DevToolsController::class, 'jsMinifier'])->name('tools.js-minifier');
    Route::post('/js-minifier', [DevToolsController::class, 'processJsMinifier']);
});
Route::get('/json-formatter', [DevToolsController::class, 'jsonFormatter']);
Route::get('/html-entities', [DevToolsController::class, 'htmlEntities']);
Route::get('/js-minifier', [DevToolsController::class, 'jsMinifier']);

// TechnicalSEOController
Route::get('/ssl-checker', [TechnicalSEOController::class, 'sslChecker'])->name('tools.ssl-checker');
Route::post('/technical-seo/ssl-checker', [TechnicalSEOController::class, 'processSslChecker']);
Route::get('/header-checker', [TechnicalSEOController::class, 'headerChecker'])->name('tools.header-checker');
Route::post('/technical-seo/header-checker', [TechnicalSEOController::class, 'processHeaderChecker']);
Route::get('/redirect-checker', [TechnicalSEOController::class, 'redirectChecker'])->name('tools.redirect-checker');
Route::post('/technical-seo/redirect-checker', [TechnicalSEOController::class, 'processRedirectChecker']);

// AnalysisController
Route::get('/my-ip', [AnalysisController::class, 'myIP'])->name('tools.my-ip');
Route::get('/domain-to-ip', [AnalysisController::class, 'domainToIP'])->name('tools.domain-to-ip');
Route::post('/analysis/domain-to-ip', [AnalysisController::class, 'processDomainToIP']);
Route::get('/whois-lookup', [AnalysisController::class, 'whoisLookup'])->name('tools.whois-lookup');
Route::post('/analysis/whois-lookup', [AnalysisController::class, 'processWhois']);
Route::get('/domain-age', [AnalysisController::class, 'domainAge'])->name('tools.domain-age');
Route::post('/analysis/domain-age-checker', [AnalysisController::class, 'processDomainAge']);
Route::get('/ip-geolocation', [AnalysisController::class, 'ipGeolocation'])->name('tools.ip-geolocation');
Route::post('/analysis/ip-geolocation', [AnalysisController::class, 'processIpGeolocation']);

// SecurityController
Route::get('/password-generator', [SecurityController::class, 'passwordGenerator'])->name('tools.password-generator');
Route::get('/md5-generator', [SecurityController::class, 'md5Generator'])->name('tools.md5-generator');
Route::post('/security/md5-generator', [SecurityController::class, 'processMd5']);
Route::get('/base64-encoder-decoder', [SecurityController::class, 'base64Encoder'])->name('tools.base64-encoder-decoder');
Route::post('/security/base64-encoder-decoder', [SecurityController::class, 'processBase64']);
