<?php

namespace App\Services;

use App\Models\Link;
use App\Repositories\LinkRepository;
use Carbon\Carbon;
use Hashids\Hashids;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class LinkService
{
    /**
     * @param string $originalUrl
     * @param ?Carbon $expireAt
     * @return Link
     */
    public function createLink(string $originalUrl, ?Carbon $expireAt): Link //todo y додати expired
    {
        $linkRepository = new LinkRepository();

        $link = $linkRepository->create($originalUrl, null, $expireAt);

        $linkRepository->updateToken($link->id, $this->cryptId($link->id));

        return $link;
    }

    /**
     * @param int $id
     * @return string
     */
    public function cryptId(int $id): string
    {
        $hashids = new Hashids();

        return $hashids->encode($id);
    }

    /**
     * @param string $token
     * @return ?int
     */
    public function decryptId(string $token): ?int
    {
        $hashids = new Hashids();

        return $hashids->decode($token)[0] ?? null;
    }

    public function getLinkByToken($token)
    {
        if (!$token) {
            throw new \Error('Empty link provided');//todo y
        } elseif (!$linkId = $this->decryptId($token)) {
            abort(404);
        }

        $link = Link::find($this->decryptId($token));

        if (!$link) {
            abort(404);
        }

        return $link;
    }

    //todo y перевірити модифікатори доступу
}
