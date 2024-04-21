<?php

namespace App\Http\Controllers;

use App\Services\LinkService;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LinkController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @return View
     */
    public function index(): View
    {
        return view('link.index');
    }

    /**
     * @param Request $request
     * @return View
     */
    public function saveLink(Request $request): View
    {
        $request->validate([
            'original_url' => 'required|url',
            'expired_at' => 'nullable|string',
        ]);

        $originalUrl = $request->post('original_url');
        $expiredAt = $request->post('expired_at');
        $expiredAt = $expiredAt ? Carbon::parse($expiredAt) : null;

        $service = new LinkService();

        $link = $service->createLink($originalUrl, $expiredAt);

        return view('link.statistic', [
            'original_url' => $link->original_url,
            'short_url' =>  URL::to("/redirect-to/$link->token"),
            'expired_at' => $link->expire_at,
            'used_count' => $link->used_count ?? 0,
        ]);
    }

    /**
     * @param $token
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function redirectTo($token): RedirectResponse
    {
        $validator = Validator::make(['token' => $token], [
            'token' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $service = new LinkService();

        $link = $service->getLinkRedirect($token);

        $link->increment('used_count');
        $link->save();

        return Redirect::to($link->original_url);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function showStatistic(Request $request): View
    {
        $request->validate([
            'short_url' => 'required|url',
        ]);

        $service = new LinkService();

        $link = $service->getLinkByShortedUrl($request->short_url);

        if (!$link) {
            abort(404, 'This link was never existed');
        }

        return view('link.statistic', [
            'original_url' => $link->original_url,
            'short_url' =>  URL::to("/redirect-to/$link->token"),
            'expired_at' => $link->expire_at,
            'used_count' => $link->used_count ?? 0,
        ]);
    }
}
