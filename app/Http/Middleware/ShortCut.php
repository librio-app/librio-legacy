<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use App\Service\ShortCutService;

class ShortCut
{
    public const SHORT_CUT_HEADER = 'X-Short-Cut-Url';

    /**
     * @var ShortCutService
     */
    private $shortCutService;

    /**
     * ShortCut constructor.
     * @param ShortCutService $shortCutService
     */
    public function __construct(ShortCutService $shortCutService)
    {
        $this->shortCutService = $shortCutService;
    }

    /**
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        $shortcut = $request->get('barcode', '');
        if (empty($shortcut)) {
            $shortcut = $request->get('search', '');
        }

        /** @var Request $response */
        $response = $next($request);
        $url = $this->shortCutService->getShortCutRedirect($shortcut, $request->toArray());
        if ($url !== null) {
            // add redirect header
            $response->header(self::SHORT_CUT_HEADER, $url);
        }

        return $response;
    }
}
