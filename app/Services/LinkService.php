<?php

namespace App\Services;

use App\Models\Link;
use App\Repositories\LinkRepository;
use Carbon\Carbon;
use Hashids\Hashids;
use Illuminate\Support\Facades\URL;

class LinkService
{
    /**
     * @param string $originalUrl
     * @param ?Carbon $expireAt
     * @return Link
     */
    public function createLink(string $originalUrl, ?Carbon $expireAt): Link
    {
        $linkRepository = new LinkRepository();

        $link = $linkRepository->firstOrCreate($originalUrl, null, $expireAt);

        return $linkRepository->updateToken($link, $this->cryptId($link->id));
    }

    /**
     * @param string $token
     * @return Link|null
     */
    public function getLinkRedirect(string $token): ?Link
    {
        $link = $this->getLinkByToken($token);

        if (!$link || ($link->expire_at && $link->expire_at < now())) {
            abort(404, 'Wrong or expired link');
        }

        return $link;
    }

    /**
     * @param string $token
     * @return Link|null
     */
    public function getLinkByShortedUrl(string $token): ?Link
    {
        $token = str_replace(URL::to('/redirect-to/'), '', $token);

        $count = 1;

        $token = str_replace('/', '', $token, $count);

        return $this->getLinkByToken($token);
    }

    /**
     * @param string $token
     * @return Link|null
     */
    private function getLinkByToken(string $token): ?Link
    {
        if (!$token) {
            throw new \Error('Empty link provided');
        } elseif (!$linkId = $this->decryptId($token)) {
            abort(404, 'Wrong shorted url');
        }

        $link = Link::find($linkId);

        return $link;
    }

    /**
     * @param int $id
     * @return string
     */
    private function cryptId(int $id): string
    {
        $hashids = new Hashids();

        return $hashids->encode($id);
    }

    /**
     * @param string $token
     * @return ?int
     */
    private function decryptId(string $token): ?int
    {
        $hashids = new Hashids();

        return $hashids->decode($token)[0] ?? null;
    }
}
