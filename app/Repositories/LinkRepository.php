<?php

namespace App\Repositories;

use App\Models\Link;
use Illuminate\Support\Carbon;

class LinkRepository
{
    /**
     * @param $url
     * @param $token
     * @param $expireAt
     * @return Link
     */
    public function firstOrCreate($url, $token, $expireAt): Link
    {
        $linkModel = Link::query()
            ->where('original_url', $url)
            ->where(function ($query) use ($expireAt) {
                $query->where('expire_at', '<=', Carbon::now())
                    ->orWhereIsNull('expire_at');
            })
            ->first();

        if (!$linkModel) {
            $linkModel = new Link([
                'original_url' => $url,
                'token' => $token,
                'expire_at' => $expireAt,
            ]);

            $linkModel->save();
        }

        return $linkModel;
    }

    /**
     * @param Link $link
     * @param $token
     * @return Link
     */
    public function updateToken(Link $link, $token): Link
    {
        $link->update(['token' => $token]);

        return $link;
    }
}
