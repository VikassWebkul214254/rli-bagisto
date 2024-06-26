<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('enclaves::app.shop.customers.account.inquiries.list.title')
    </x-slot>

    <!-- Breadcrumbs -->
    @section('breadcrumbs')
        <x-shop::breadcrumbs name="inquiries"></x-shop::breadcrumbs>
    @endSection

    <v-tickets></v-tickets>

    @pushOnce('scripts')
        <script type="text/x-template" id="v-tickets-template">
            <div>
                <div class="flex items-center justify-between">
                    <div class="">
                        <h2 class="text-[29px] font-medium">
                            @lang('enclaves::app.shop.customers.account.inquiries.list.title')

                            (<span v-text="count_of_tickets"></span>)
                        </h2>
                    </div>
                </div>

                <div class="items-center justify-between pt-10">
                    <span v-if="tickets" v-for="ticket in tickets">
                        <x-shop::accordion.custom-accordion 
                            :is-active=false 
                            class="border"
                        >
                            <x-slot:header>
                                <div class="flex w-full items-center justify-between">
                                    <div class="">
                                        <p>
                                            <span class="font-bold">
                                                @lang('enclaves::app.shop.customers.account.inquiries.concern')
                                            </span>

                                            <span v-text="ticket.reasons.name"></span>
                                        </p>
                                    </div>

                                    <div class="">
                                        <div 
                                            class="m-2 flex h-[30px] items-center rounded-full border bg-[#6CF0A9] p-4 text-[16px] text-[#2BBF1E]"
                                            v-if="ticket.status.name === 'Resolved'"
                                            v-text="ticket.status.name"
                                        >
                                        </div>

                                        <div 
                                            class="m-2 flex h-[30px] items-center rounded-full border bg-[#fac04f42] p-4 text-[16px] text-[#C3890F]"
                                            v-if="ticket.status.name === 'Pending'"
                                            v-text="ticket.status.name"
                                        >
                                        </div>

                                        <div 
                                            class="m-2 flex h-[30px] items-center rounded-full border bg-[#fa4f4f42] p-4 text-[16px] text-[#c30f0f]"
                                            v-if="ticket.status.name === 'Rejected'"
                                            v-text="ticket.status.name"
                                        >
                                        </div>
                                    </div>
                                </div>
                            </x-slot:header>

                            <x-slot:content>
                                <span v-html="ticket.comment"></span>

                                <div 
                                    v-if="ticket.files" 
                                    class="mt-8 flex gap-5">
                                    <div v-for="file in ticket.files" class="relative">
                                        <img
                                            :src="storagePath + file.path"
                                            :alt="file.name" 
                                            class="h-[200px] w-[200px] rounded-xl"
                                        />
                                        <a :href="storagePath + file.path" target="_blank" download>
                                            <div class="action-items">
                                                <p class="absolute left-[20px] top-[20px] inline-block rounded-lg bg-navyBlue p-[5px] text-[15px] text-white">
                                                    <span class="icon-download"></span>
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </x-slot:content>
                        </x-shop::accordion.custom-accordion>
                    </span>

                    <span 
                        class="flex flex-wrap gap-10" 
                        v-if="isLoading">
                        @for ($i = 0; $i < 4; $i++)
                            <div class="shimmer h-[95px] w-full rounded-lg"></div>
                        @endfor
                    </span>

                    <div class="flex justify-center">
                        <button
                            v-if="reaming"
                            class="rounded-[20px] bg-[#CC035C] px-[25px] py-[10px] text-white"
                            v-text="loadingText"
                            @click="loadMore"
                        >
                        </button>
                    </div>
                </div>
            </div>
        </script>

        <script type="module">
            app.component('v-tickets', {
                template: '#v-tickets-template',

                data() {
                    return {
                        limit: 0,
                        isLoading: true,
                        tickets: {},
                        loadingText: '',
                        count_of_tickets: 0,
                        reaming: 0,
                        storagePath: `{{ Storage::url("") }}`,
                    }
                },

                mounted() {
                    this.limit = 4;
                    
                    this.getTickets();
                },

                methods: {
                    loadMore() {
                        this.limit = this.limit + 4;

                        this.getTickets();
                    },

                    getTickets() {
                        this.isLoading = true;
                        this.loadingText = "Loading..";
                        
                        this.$axios.get("{{ route('enclaves.customers.account.inquiries.tickets') }}", {
                            params: {
                                limit: this.limit,
                            }
                        })
                        .then(response => {
                            this.tickets = response.data.tickets;

                            this.count_of_tickets = this.tickets.length;

                            this.reaming =  response.data.count - this.tickets.length;

                            this.loadingText = `@lang('enclaves::app.shop.customers.account.inquiries.load-more')` + ' (' +  this.reaming + ')';

                            this.isLoading = false;
                        })
                        .catch(error => {});
                    }
                }
            })
        </script>
    @endPushOnce
</x-shop::layouts.account>