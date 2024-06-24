@if ($product->processing_fee)
        <p class="processing_fee_text font-roboto text-[25px] font-normal leading-[25px] text-[#8B8B8B] max-sm:text-[18px]">
            @lang('enclaves::app.shop.product.processing')
        </p>

        <p class="processing_fee text-6xl font-bold text-[#C38400] max-sm:text-4xl">
            {{ core()->formatPrice($product->processing_fee) }}
        </p>
@else
    <p class="processing_fee_text font-roboto text-[25px] font-normal leading-[25px] text-[#8B8B8B] max-sm:text-[18px]" style="display:none;">
        @lang('enclaves::app.shop.product.processing')
    </p>

    <p class="processing_fee text-6xl font-bold text-[#C38400] max-sm:text-4xl"></p>
@endif