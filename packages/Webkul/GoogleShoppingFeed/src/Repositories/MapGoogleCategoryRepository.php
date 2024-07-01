<?php

namespace Webkul\GoogleShoppingFeed\Repositories;

use Webkul\Core\Eloquent\Repository;

class MapGoogleCategoryRepository extends Repository
{
    /**
     * Specify Model class name.
     *
     * @return mixed
     */
    public function model()
    {
        return 'Webkul\GoogleShoppingFeed\Contracts\MapGoogleCategory';
    }
}