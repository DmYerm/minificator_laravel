<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Services\LinkService;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class LinkController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index(Request $request) //todo y validate
    {
        return view('link.index'); //todo y rename
    }

//todo y annotation
    public function saveLink(Request $request) //todo y validate
    {
        $originalUrl = $request->post('original_url');
        $expiredAt = $request->post('expired_at');
        $expiredAt = Carbon::parse($expiredAt);

        $service = new LinkService();

        $link = $service->createLink($originalUrl, $expiredAt);

        return view('link.statistic', [
            'original_url' => $link->original_url,
            'short_url' =>  URL::to("/ride-to/$link->token"),
            'expired_at' => $link->expire_at,
            'used_count' => $link->used_count ?? 0,
        ]);
    }

    public function redirectTo($token) //todo y validate
    {
        $service = new LinkService();

        $link = $service->getLinkByToken($token);

        $link->increment('used_count');

        return Redirect::to($link->original_url);
    }

    public function showStatistic($token) //todo y validate
    {
        $service = new LinkService();

        $link = $service->getLinkByToken($token);

        $link->increment('used_count');

        return Redirect::to($link->original_url);
    }
}
