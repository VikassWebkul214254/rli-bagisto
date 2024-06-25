@inject ('reviewHelper', 'Webkul\Product\Helpers\Review')
@inject ('productViewHelper', 'Webkul\Product\Helpers\View')

@php
    $avgRatings = round($reviewHelper->getAverageRating($product));

    $percentageRatings = $reviewHelper->getPercentageRating($product);

    $customAttributeValues = $productViewHelper->getAdditionalData($product);

    $attributeData = collect($customAttributeValues)->filter(fn ($item) => ! empty($item['value']));
@endphp

<!-- SEO Meta Content -->
@push('meta')
    <meta name="description" content="{{ trim($product->meta_description) != "" ? $product->meta_description : \Illuminate\Support\Str::limit(strip_tags($product->description), 120, '') }}"/>

    <meta name="keywords" content="{{ $product->meta_keywords }}"/>

    @if (core()->getConfigData('catalog.rich_snippets.products.enable'))
        <script type="application/ld+json">
            {{ app('Webkul\Product\Helpers\SEO')->getProductJsonLd($product) }}
        </script>
    @endif

    <?php $productBaseImage = product_image()->getProductBaseImage($product); ?>

    <meta name="twitter:card" content="summary_large_image" />

    <meta name="twitter:title" content="{{ $product->name }}" />

    <meta name="twitter:description" content="{!! htmlspecialchars(trim(strip_tags($product->description))) !!}" />

    <meta name="twitter:image:alt" content="" />

    <meta name="twitter:image" content="{{ $productBaseImage['medium_image_url'] }}" />

    <meta property="og:type" content="og:product" />

    <meta property="og:title" content="{{ $product->name }}" />

    <meta property="og:image" content="{{ $productBaseImage['medium_image_url'] }}" />

    <meta property="og:description" content="{!! htmlspecialchars(trim(strip_tags($product->description))) !!}" />

    <meta property="og:url" content="{{ route('shop.product_or_category.index', $product->url_key) }}" />
@endPush

@push ('styles')
    <style>
        ul {
            padding-left: 40px;
            list-style: disc;
        }

        .product-price p {
            color: black !important;
        }
    </style>
@endpush
@pushOnce('scripts')
    <script>
		document.addEventListener("DOMContentLoaded", () => {
			let img = document.querySelectorAll('.et-slider img');
            
			let active = 1;

			let prev = 0;

			let next = 2;

			let changeImage = () => {
				img.forEach((ele, i) => {
					if (i === prev) {
						ele.className = 'prev'
					}
					else if (i === active) {
						ele.className = 'active'
					} else if (i === next) {
						ele.className = 'next'
					} else {
						ele.className = 'd-none'
					}
				})
			}
			changeImage();

			let sliderInterval = setInterval(() => {
				prev = active;
				active = next;
				if (active + 1 == img.length) {
					next = 0;
				} else {
					next = active + 1;
				}

				changeImage()
			}, 5000);
		});
	</script>
@endPushOnce

<!-- Page Layout -->
<x-shop::layouts>
    <div class="container px-[60px] max-lg:px-[15px]">
        <!-- Page Title -->
        <x-slot:title>
            {{ trim($product->meta_title) != "" ? $product->meta_title : $product->name }}
        </x-slot>

        {!! view_render_event('bagisto.shop.products.view.before', ['product' => $product]) !!}

        <!-- Breadcrumbs -->
        <x-shop::breadcrumbs name="product" :entity="$product"></x-shop::breadcrumbs>

        <!-- Product Information Vue Component -->
        <v-product ref="details" :product-id="{{ $product->id }}">
            <x-shop::shimmer.products.view/>
        </v-product>

        {!! view_render_event('bagisto.shop.products.view.after', ['product' => $product]) !!}

        @pushOnce('scripts')
            <script type="text/x-template" id="v-product-template">
                <div>
                    <x-shop::form
                        v-slot="{ meta, errors, handleSubmit }"
                        as="div"
                        >
                        <form
                            ref="formData"
                            @submit="handleSubmit($event, addToCart)"
                            >
                            <input 
                                type="hidden" 
                                name="product_id" 
                                value="{{ $product->id }}"
                            >

                            <input
                                type="hidden"
                                name="is_buy_now"
                                v-model="is_buy_now"
                            >
                            
                            <input 
                                type="hidden" 
                                name="quantity" 
                                :value="qty"
                            >

                            <div class="mt-12 flex gap-2 max-lg:mt-0 max-lg:gap-y-6 max-md:flex-wrap lg:gap-[54px]">
                                <div class="min-w-[50%] max-md:w-full">
                                    <!-- Gallery Blade Inclusion -->
                                    @include('shop::products.view.gallery')

                                    <!-- Product Price -->
                                    <div class="product-price mb-[18px] mt-[34px] flex flex-col gap-1.5 px-4 sm:px-0">
                                        <p class="font-roboto font-normal text-[20xp] text-black sm:text-[30px] sm:leading-[30px]">
                                            {!! $product->getTypeInstance()->getPriceHtml() !!}
                                        </p>
                                        
                                        <h5 class="font-roboto text-[12px] font-normal text-[#8B8B8B] sm:text-[20px] sm:leading-[30px]">
                                            @lang('enclaves::app.shop.product.contract-price')
                                        </h5>
                                    </div>

                                    <hr class="mb-6 mt-6 h-px border-t border-[#D9D9D9]" />

                                    <!-- Product Name -->
                                    {!! view_render_event('bagisto.shop.products.name.before', ['product' => $product]) !!}
                                        <h1 class="text-[40px] font-bold leading-[48px] tracking-tighter max-sm:text-[20px] max-sm:leading-[24px]">
                                            {{ $product->name }}
                                        </h1>
                                    {!! view_render_event('bagisto.shop.products.name.after', ['product' => $product]) !!}

                                    <!-- Product description -->
                                    {!! view_render_event('bagisto.shop.products.description.before', ['product' => $product]) !!}
                                        <p class="mt-[26px] text-xl max-lg:text-[12px] max-md:leading-6" v-html="product.description"></p>
                                    {!! view_render_event('bagisto.shop.products.description.after', ['product' => $product]) !!}
                                </div>

                                <div class="relative top-12 -mt-12 flex hidden h-fit w-full max-w-[781px] flex-col rounded-3xl px-10 py-12 shadow-[0px_4px_40px_0px_rgba(220,_228,_240,_1)] max-sm:p-6 md:flex">
                                    <!-- Price -->
                                    <div class="flex gap-x-4 gap-y-5">
                                        <div class="flex flex-col gap-4 pt-0.5">
                                            <p class="font-roboto text-[25px] font-normal leading-[25px] text-[#8B8B8B] max-sm:text-[18px]">
                                                @lang('enclaves::app.shop.product.contract-price')
                                            </p>

                                            <p class="product-price font-roboto text-xl font-normal text-black max-sm:text-lg">
                                                {!! $product->getTypeInstance()->getPriceHtml() !!}
                                            </p>
                                        </div>

                                        <!-- reservation fee -->
                                        <div class="flex flex-col gap-3">
                                            {!! view_render_event('bagisto.shop.products.price.before', ['product' => $product]) !!}

                                            {!! view_render_event('bagisto.shop.products.price.after', ['product' => $product]) !!}
                                        </div>
                                    </div>

                                    <hr class="mb-6 mt-10 h-px border-t border-[#D9D9D9]" />

                                    <!-- Short Description -->
                                    <div v-if="product.short_description">
                                        {!! view_render_event('bagisto.shop.products.short_description.before', ['product' => $product]) !!}

                                        <p 
                                            class="max-lg:text-small mt-6 text-base text-[#6E6E6E] max-lg:mt-4" 
                                            v-html="product.short_description"
                                        ></p>

                                        {!! view_render_event('bagisto.shop.products.short_description.after', ['product' => $product]) !!}
                                    </div>

                                    <hr class="mb-6 mt-10 h-px border-t border-[#D9D9D9]" />

                                    <!-- Product Option -->
                                    <div class="flex flex-col">
                                        @include('shop::products.view.types.configurable')
                                    </div>

                                    <hr class="mb-11 mt-16 h-px border-t border-[#D9D9D9]" />

                                    <!-- button -->
                                    <div class="flex items-center gap-4">
                                        <a 
                                            class="mx-auto block h-full w-full rounded-full bg-[#FFFBF1] py-7 py-8 text-center text-base font-normal tracking-tighter text-[#C38400] underline underline-offset-2 md:text-2xl"
                                            href="#"
                                        >
                                            View Financing Scheme
                                        </a>

                                        <!-- Add To Cart Button -->
                                        {!! view_render_event('bagisto.shop.products.view.add_to_cart.before', ['product' => $product]) !!}
                                        
                                        @if ($product->getTypeInstance()->showQuantityBox())
                                            <button
                                                type="submit"
                                                class="mx-auto ml-[0px] mt-[30px] block w-full rounded-[18px] bg-[linear-gradient(268.1deg,_#CC035C_7.47%,_#FCB115_98.92%)] px-[43px] py-[16px] text-center text-[16px] font-medium text-white"
                                                {{ ! $product->isSaleable(1) ? 'disabled' : '' }}
                                            >
                                                @lang('shop::app.products.view.add-to-cart')
                                            </button>
                                        @endif
                                        
                                        {!! view_render_event('bagisto.shop.products.view.add_to_cart.after', ['product' => $product]) !!}
                                        
                                        <!-- Buy Now Button -->
                                        {!! $product->button_text != '0' && $product->button_text ? $product->button_information : '' !!}

                                        {!! view_render_event('bagisto.shop.products.view.buy_now.before', ['product' => $product]) !!}
                                            <button
                                                v-if="isAdding"
                                                class="mx-auto flex w-full items-center gap-2 divide-x rounded-full bg-[linear-gradient(268.1deg,_#CC035C_7.47%,_#FCB115_98.92%)] text-center text-base font-normal text-[#C38400] md:text-2xl"
                                                style="color: {{ $product->button_color_text }}; background-color: {{ $product->button_background_color }}; border: {{ $product->button_border_color != '0' && $product->button_border_color ? '3px solid ' . $product->button_border_color: '' }}"
                                                disabled
                                                >
                                                <span 
                                                    class="flex flex-col gap-1 whitespace-nowrap py-[18px] pl-[32px] text-left text-lg font-normal tracking-tighter text-white">
                                                    <span>
                                                        {{ core()->formatPrice($product->processing_fee) }}
                                                    </span>
                                                    <span>
                                                        @lang('enclaves::app.shop.product.processing')
                                                    </span>
                                                </span>

                                                <span 
                                                    class="whitespace-nowrap py-[18px] pl-2 pr-[22px] tracking-tighter text-white underline underline-offset-2"
                                                    >
                                                    @lang($product->button_text != '0' && $product->button_text ? $product->button_text : 'enclaves::app.shop.product.reserve-now')
                                                </span>
                                            </button>

                                            <button
                                                v-else
                                                @click="is_buy_now=1; is_kyc_process=1;"
                                                class="mx-auto flex w-full items-center gap-2 divide-x rounded-full bg-[linear-gradient(268.1deg,_#CC035C_7.47%,_#FCB115_98.92%)] text-center text-base font-normal text-[#C38400] md:text-2xl"
                                                style="color: {{ $product->button_color_text }}; background-color: {{ $product->button_background_color }}; border: {{ $product->button_border_color != '0' && $product->button_border_color ? '3px solid ' . $product->button_border_color: '' }}"
                                                {{ ! $product->isSaleable(1) ? 'disabled' : '' }}
                                                >
                                                <span 
                                                    class="flex flex-col gap-1 whitespace-nowrap py-[18px] pl-[32px] text-left text-lg font-normal tracking-tighter text-white">
                                                    <span>
                                                        {{ core()->formatPrice($product->processing_fee) }}
                                                    </span>
                                                    <span>
                                                        @lang('enclaves::app.shop.product.processing')
                                                    </span>
                                                </span>

                                                <span 
                                                    class="whitespace-nowrap py-[18px] pl-2 pr-[22px] tracking-tighter text-white underline underline-offset-2"
                                                    >
                                                    @lang($product->button_text != '0' && $product->button_text ? $product->button_text : 'enclaves::app.shop.product.reserve-now')
                                                </span>
                                            </button>
                                        {!! view_render_event('bagisto.shop.products.view.buy_now.after', ['product' => $product]) !!}
                                    </div>
                                </div>
                            </div>
                        </form>
                    </x-shop::form>
                </div>
            </script>

            <script type="module">
                app.component('v-product', {
                    template: '#v-product-template',

                    props: ['productId'],

                    data() {
                        return {
                            isWishlist: Boolean("{{ (boolean) auth()->guard()->user()?->wishlist_items->where('channel_id', core()->getCurrentChannel()->id)->where('product_id', $product->id)->count() }}"),

                            isCustomer: "{{ auth()->guard('customer')->check() }}",

                            is_buy_now: 0,

                            is_kyc_process: 0,
                            
                            qty: 1,

                            product: @json($product),

                            isAdding: 0,
                        }
                    },

                    methods: {
                        addToCart(params) {
                                this.isAdding = 1;
                                
                                let formData = new FormData(this.$refs.formData);

                                this.$axios.post('{{ route("shop.api.checkout.cart.store") }}', formData, {
                                        headers: {
                                            'Content-Type': 'multipart/form-data'
                                        }
                                    })
                                    .then(response => {
                                        this.isAdding = 0;

                                        if (response.data.message) {
                                            this.$emitter.emit('update-mini-cart', response.data.data);

                                            this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                                            
                                            if (response.data.redirect && ! this.is_kyc_process) {
                                                window.location.href = response.data.redirect;
                                            } else {
                                                window.location.href = response.data.ekyc_redirect;
                                            }
                                        } else {
                                            this.$emitter.emit('add-flash', { type: 'warning', message: response.data.data.message });
                                        }
                                    })
                                    .catch(error => {});
                        },

                        addToWishlist() {
                            if (this.isCustomer) {
                                this.$axios.post("{{ route('shop.api.customers.account.wishlist.store') }}", {
                                    product_id: "{{ $product->id }}"
                                })
                                .then(response => {
                                    this.isWishlist = ! this.isWishlist;

                                    this.$emitter.emit('add-flash', { type: 'success', message: response.data.data.message });
                                })
                                .catch(error => {});
                            } else {
                                window.location.href = "{{ route('shop.customer.session.index')}}";
                            }
                        },

                        addToCompare(productId) {
                            /**
                            * This will handle for customers.
                            */
                            if (this.isCustomer) {
                                this.$axios.post('{{ route("shop.api.compare.store") }}', {
                                        'product_id': productId
                                    })
                                    .then(response => {
                                        this.$emitter.emit('add-flash', { type: 'success', message: response.data.data.message });
                                    })
                                    .catch(error => {
                                        if ([400, 422].includes(error.response.status)) {
                                            this.$emitter.emit('add-flash', { type: 'warning', message: error.response.data.data.message });

                                            return;
                                        }

                                        this.$emitter.emit('add-flash', { type: 'error', message: error.response.data.message});
                                    });

                                return;
                            }

                            /**
                            * This will handle for guests.
                            */
                            let existingItems = this.getStorageValue(this.getCompareItemsStorageKey()) ?? [];

                            if (existingItems.length) {
                                if (! existingItems.includes(productId)) {
                                    existingItems.push(productId);

                                    this.setStorageValue(this.getCompareItemsStorageKey(), existingItems);

                                    this.$emitter.emit('add-flash', { type: 'success', message: "@lang('shop::app.products.view.add-to-compare')" });
                                } else {
                                    this.$emitter.emit('add-flash', { type: 'warning', message: "@lang('shop::app.products.view.already-in-compare')" });
                                }
                            } else {
                                this.setStorageValue(this.getCompareItemsStorageKey(), [productId]);

                                this.$emitter.emit('add-flash', { type: 'success', message: "@lang('shop::app.products.view.add-to-compare')" });
                            }
                        },

                        getCompareItemsStorageKey() {
                            return 'compare_items';
                        },

                        setStorageValue(key, value) {
                            localStorage.setItem(key, JSON.stringify(value));
                        },

                        getStorageValue(key) {
                            let value = localStorage.getItem(key);

                            if (value) {
                                value = JSON.parse(value);
                            }

                            return value;
                        },
                    },
                });
            </script>
        @endPushOnce
    </div>
</x-shop::layouts>