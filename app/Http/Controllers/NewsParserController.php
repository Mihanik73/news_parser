<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\News;
use App\Entities\Parsers\NewsParser\{NewsParser, NewsXPathBlockParser};
use App\Entities\Parsers\UrlParsers\CurlUrlParser;

class NewsParserController extends Controller
{
    /**
     * Executes process of parsing news and passing data to the database
     *
     * @return void
     */
    public function index()
    {
        try {
            $url = 'https://www.rbc.ru/';

            $urlParser = new CurlUrlParser($url);
            $blockParser = new NewsXPathBlockParser($urlParser);

            $news_parser = new NewsParser($blockParser);
            $news = $news_parser->getNewsFromUrlContentBySelector("//div[@class='js-news-feed-list']/a[not(contains(@href, 'video_id'))]");

            if (!empty($news)) {
                $news = array_filter($news, function($item) {
                    return News::where('url', '=', $item['url'])->get()->isEmpty();
                });

                foreach ($news as $data) {
                    $newsPiece = new News($data);

                    $newsPiece->save();
                }

                dump(count($news) . ' news were parsed and saved to database.');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }

        exit;
    }

    /**
     * Shows all news from the database
     *
     * @return void
     */
    public function show()
    {
        $news = News::all();

        foreach ($news as $newsPiece) {
            dump($newsPiece->toArray());
        }
        exit;
    }
}
