<v-blog-card
    {{ $attributes }}
    :blog="blog"
>
</v-blog-card>

@pushOnce('scripts')
    <script type="text/x-template" id="v-blog-card-template">
        <div class="relative grid max-w-[350px] gap-2.5 max-sm:grid-cols-1">
            <x-shop::media.images.lazy
                class="h-[290px] cursor-pointer rounded-[20px] bg-[#F5F5F5] transition-all duration-300 group-hover:scale-105"
                ::src="blog.base_image"
            ></x-shop::media.images.lazy>
    
            <p 
                class="font-popins text-[20px] font-bold" 
                v-text="blog.name"
            ></p>

            <button
                @click="redirectBlogPage(blog)"
                class="w-[150px] rounded-[20px] border-[3px] border-[#CC035C] px-[25px] py-[10px] font-semibold text-[#CC035C]">
                @lang('blog::app.shop.blog.read-more')
            </button>
        </div>
    </script>

    <script type="module">
        app.component('v-blog-card', {
            template: '#v-blog-card-template',

            props: ['mode', 'blog'],

            data() {
                return {
                    isCustomer: '{{ auth()->guard("customer")->check() }}',
                }
            },

            methods: {
                redirectBlogPage(blog) {
                    window.location.href = `{{ route('shop.article.view','') }}/` + blog.category.slug + '/' + blog.slug;
                },
            }
        });
    </script>
@endpushOnce