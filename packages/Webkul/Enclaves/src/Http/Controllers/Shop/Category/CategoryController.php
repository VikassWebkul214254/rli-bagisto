<?php

namespace Webkul\Enclaves\Http\Controllers\Shop\Category;

use Illuminate\Http\Resources\Json\JsonResource;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Enclaves\Http\Controllers\Controller;
use Webkul\Enclaves\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Default Status
     */
    protected const ENABLED = 1;

    /**
     * Default short
     */
    protected const SHORT = 'desc';

    /**
     * Default limit
     */
    protected const LIMIT = 10;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected CategoryRepository $categoryRepository,
    ) {
    }

    /**
     * Get all categories.
     */
    public function index(): JsonResource
    {
        /**
         * These are the default parameters. By default, only the enabled category
         * will be shown in the current locale.
         */
        $categories = $this->categoryRepository
                            ->whereNotNull('parent_id')
                            ->where('categories.communities_status', '!=', 0)
                            ->limit(request('limit') ?? self::LIMIT)
                            ->orderBy('categories.sort', request('sort') ?? self::SHORT)
                            ->get();

        return CategoryResource::collection($categories);
    }
}
