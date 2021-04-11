<?php

namespace App\Models;

class Model extends \Illuminate\Database\Eloquent\Model
{
    /**
     * @var int
     */
    public const LIST_DEFAULT_LIMIT = 10;

    /**
     * Sanitize the filter string from search value
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public static function getCleanFilter(\Illuminate\Http\Request $request): string
    {
        $filter = $request->get('filter', null);
        return filter_var(trim($filter));
    }
}
