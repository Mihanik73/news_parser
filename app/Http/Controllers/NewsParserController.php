<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\News;
use App\Entities\Parsers\NewsParser\{NewsParser, NewsXPathBlockParser};
use App\Entities\Parsers\UrlParsers\CurlUrlParser;

class NewsParserController extends Controller
{
    public function index()
    {
        try {
            $url = 'https://www.rbc.ru/';

            $urlParser = new CurlUrlParser($url);
            $blockParser = new NewsXPathBlockParser($urlParser);

            $news_parser = new NewsParser($blockParser);
            $news = $news_parser->getNewsFromUrlContent("//div[@class='js-news-feed-list']/a[not(contains(@href, 'video_id'))]");

            if (!empty($news)) {
                $news = array_filter($news, function($item) {
                    return News::where('url', '=', $item['url'])->get()->isEmpty();
                });

                foreach ($news as $data) {
                    $newsPiece = new News($data);

                    $newsPiece->save();
                }
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function show()
    {
        $news = News::all();

        dd($news);
    }
}
