<x-shop::layouts.account>
    {{-- Page Title --}}
    <x-slot:title>
        @lang('shop::app.customers.account.reviews.title')
    </x-slot>

    {{-- Breadcrumbs --}}
    @section('breadcrumbs')
        <x-shop::breadcrumbs name="reviews"></x-shop::breadcrumbs>
    @endSection

    <!-- Reviews Vue Component -->
    <v-product-reviews>
        <!-- Reviews Shimmer Effect -->
        <x-shop::shimmer.customers.account.reviews :count="4"></x-shop::shimmer.customers.account.reviews>
    </v-product-reviews>

    @pushOnce('scripts')
        <script type="text/x-template" id="v-product-reviews-template">
            <div>
                <!-- Reviews Shimmer Effect -->
                <template v-if="isLoading">
                    <x-shop::shimmer.customers.account.reviews :count="4"></x-shop::shimmer.customers.account.reviews>
                </template>

                {!! view_render_event('bagisto.shop.customers.account.reviews.list.before', ['reviews' => $reviews]) !!}

                <!-- Reviews Information -->
                <template v-else>
                    <div class="flex-auto">
                        <div class="max-md:max-w-full">
                            <h2 class="text-[26px] font-medium">
                                @lang('shop::app.customers.account.reviews.title')
                            </h2>
                
                            @if (! $reviews->isEmpty())
                                {{-- Review Information --}}
                                <div class="max-1060:grid-cols-[1fr] mt-[60px] grid gap-[20px]">
                                    @foreach($reviews as $review)
                                        <a
                                            href="{{ route('shop.product_or_category.index', $review->product->url_key) }}"
                                            id="{{ $review->product_id }}"
                                        >
                                            <div class="flex gap-[20px] rounded-[12px] border border-[#e5e5e5] p-[25px] max-lg:flex-wrap">
                                                <x-shop::media.images.lazy
                                                    class="h-[146px] max-h-[146px] w-[128px] min-w-[128px] max-w-[128px] rounded-[12px]" 
                                                    src="{{ $review->product->base_image_url ?? bagisto_asset('images/small-product-placeholder.webp') }}"
                                                    alt="Review Image"                   
                                                >
                                                </x-shop::media.images.lazy>
                
                                                <div class="w-full">
                                                    <div class="flex justify-between">
                                                        <p class="text-[20px] font-medium max-lg:text-[16px]">
                                                            {{ $review->title}}
                                                        </p>
                
                                                        <div class="flex items-center gap-[10px]">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <span class="icon-star-fill text-[24px] {{ $review->rating >= $i ? 'text-[#ffb600]' : 'text-[#6E6E6E]' }}"></span>
                                                            @endfor
                                                        </div>
                                                    </div>
                
                                                    <p class="mt-[10px] text-[14px] font-medium max-lg:text-[12px]">
                                                        {{ $review->created_at }}
                                                    </p>
                
                                                    <p class="mt-[20px] text-[16px] text-[#6E6E6E] max-lg:text-[12px]">
                                                        {{ $review->comment }}
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                {{-- Review Empty Page --}}
                                <div class="m-auto grid h-[476px] w-[100%] place-content-center items-center justify-items-center text-center">
                                    <img class="" src="{{ bagisto_asset('images/review.png') }}" alt="" title="">
                
                                    <p class="text-[20px]">
                                        @lang('shop::app.customers.account.reviews.empty-review')
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </template>

                {!! view_render_event('bagisto.shop.customers.account.reviews.list.after', ['reviews' => $reviews]) !!}

            </div>
        </script>

        <script type="module">
            app.component("v-product-reviews", {
                template: '#v-product-reviews-template',

                data() {
                    return {
                        isLoading: true,
                    };
                },

                mounted() {
                    this.get();
                },

                methods: {
                    get() {
                        this.$axios.get("{{ route('shop.customers.account.reviews.index') }}")
                            .then(response => {
                                this.isLoading = false;
                            })
                            .catch(error => {});
                    },
                },
            });
        </script>
    @endpushOnce
</x-shop::layouts.account>
