<?php

namespace App\Repositories;

use App\Models\Link;
use Illuminate\Support\Carbon;

class LinkRepository
{
    public function create($url, $token, $expireAt)
    {
        $linkModel = Link::query()
            ->where('original_url', $url)
            ->where('expire_at', '<=', Carbon::now())
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

    public function updateToken($linkId, $token)
    {
        return Link::where('id', $linkId)->update(['token' => $token]);
    }

    /**
     * @param string $originalUrl
     * @return ?Link
     */
    public function getLinkByOriginal(string $originalUrl): bool
    {
        return Link::where('original_url', $originalUrl)->first();
    }
}
