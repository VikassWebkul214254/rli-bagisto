<x-admin::layouts>
    <x-slot:title>
        @lang('blog::app.category.create.title')
    </x-slot:title>

    @pushOnce('styles')
        <style type="text/css">
            .v-tree-container>.v-tree-item:not(.has-children) {
                padding-left: 18px !important;
            }
        </style>
    @endPushOnce

    @php
        $currentLocale = core()->getRequestedLocale();
    @endphp
    
    <!-- Blog Edit Form -->
    <x-admin::form
        :action="route('admin.blog.category.store')"
        method="POST"
        enctype="multipart/form-data"
    >
        {!! view_render_event('admin.blog.categories.create.before') !!}

        <div class="flex items-center justify-between gap-[16px] max-sm:flex-wrap">
            <p class="text-[20px] font-bold text-gray-800 dark:text-white">
                @lang('blog::app.category.create.title')
            </p>

            <div class="flex items-center gap-x-[10px]">
                <!-- Cancel Button -->
                <a
                    href="{{ route('admin.blog.category.index') }}"
                    class="transparent-button hover:bg-gray-200 dark:text-white dark:hover:bg-gray-800"
                >
                    @lang('blog::app.category.create.back-btn')
                </a>

                <!-- Save Button -->
                <button
                    type="submit"
                    class="primary-button"
                >
                    @lang('blog::app.category.create.save-btn')
                </button>
            </div>
        </div>

        <!-- Full Panel -->
        <div class="mt-[14px] flex gap-[10px] max-xl:flex-wrap">
            <!-- Left Section -->
            <div class="flex flex-1 flex-col gap-[8px] max-xl:flex-auto">
                <!-- General -->
                <div class="box-shadow rounded-[4px] bg-white p-[16px] dark:bg-gray-900">
                    <p class="mb-[16px] text-[16px] font-semibold text-gray-800 dark:text-white">
                        @lang('blog::app.category.create.general')
                    </p>

                    <!-- Locales -->
                    <x-admin::form.control-group.control
                        type="hidden"
                        name="locale"
                        value="en"
                    >
                    </x-admin::form.control-group.control>

                    <!-- Name -->
                    <x-admin::form.control-group class="mb-2.5">
                        <x-admin::form.control-group.label class="required">
                            @lang('blog::app.category.create.name')
                        </x-admin::form.control-group.label>

                        <v-field
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            label="{{ trans('blog::app.category.create.name') }}"
                            rules="required"
                            v-slot="{ field }"
                        >
                            <input
                                type="text"
                                name="name"
                                id="name"
                                v-bind="field"
                                :class="[errors['{{ 'name' }}'] ? 'border border-red-600 hover:border-red-600' : '']"
                                class="flex min-h-[39px] w-full rounded-md border px-3 py-2 text-sm text-gray-600 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400"
                                placeholder="{{ trans('blog::app.category.create.name') }}"
                                v-slugify-target:slug="setValues"
                            >
                        </v-field>

                        <x-admin::form.control-group.error
                            control-name="name"
                        >
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                    <!-- Slug -->
                    <x-admin::form.control-group class="mb-2.5">
                        <x-admin::form.control-group.label class="required">
                            @lang('blog::app.category.create.slug')
                        </x-admin::form.control-group.label>

                        <v-field
                            type="text"
                            name="slug"
                            value="{{ old('slug') }}"
                            label="{{ trans('blog::app.category.create.slug') }}"
                            rules="required"
                            v-slot="{ field }"
                        >
                            <input
                                type="text"
                                name="slug"
                                id="slug"
                                v-bind="field"
                                :class="[errors['{{ 'slug' }}'] ? 'border border-red-600 hover:border-red-600' : '']"
                                class="flex min-h-[39px] w-full rounded-md border px-3 py-2 text-sm text-gray-600 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400"
                                placeholder="{{ trans('blog::app.category.create.slug') }}"
                                v-slugify-target:slug
                            >
                        </v-field>

                        <x-admin::form.control-group.error
                            control-name="slug"
                        >
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                </div>

                <!-- Description and images -->
                <div class="box-shadow rounded-[4px] bg-white p-[16px] dark:bg-gray-900">
                    <p class="mb-[16px] text-[16px] font-semibold text-gray-800 dark:text-white">
                        @lang('blog::app.category.create.description-and-images')
                    </p>

                    <!-- Description -->
                    <v-description>
                        <x-admin::form.control-group class="mb-2.5">
                            <x-admin::form.control-group.label class="required">
                                @lang('blog::app.category.create.description-and-images')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="textarea"
                                name="description"
                                id="description"
                                class="description"
                                rules="required"
                                :value="old('description')"
                                :label="trans('blog::app.category.create.description-and-images')"
                                :tinymce="true"
                                :prompt="core()->getConfigData('general.magic_ai.content_generation.category_description_prompt')"
                            >
                            </x-admin::form.control-group.control>

                            <x-admin::form.control-group.error
                                control-name="description"
                            >
                            </x-admin::form.control-group.error>
                        </x-admin::form.control-group>
                    </v-description>

                    <div class="flex gap-12">
                        <!-- Add Logo -->
                        <div class="mt-5 flex w-2/5 flex-col gap-2">
                            <p class="font-medium text-gray-800 dark:text-white">
                                @lang('blog::app.category.create.image')
                            </p>

                            <x-admin::media.images name="image" rules="required"></x-admin::media.images>

                            <x-admin::form.control-group.error control-name="image"></x-admin::form.control-group.error>
                        </div>
                    </div>
                </div>

                <!-- SEO Details -->
                <div class="box-shadow rounded-[4px] bg-white p-[16px] dark:bg-gray-900">
                    <p class="mb-[16px] text-[16px] font-semibold text-gray-800 dark:text-white">
                        @lang('blog::app.category.create.search-engine-optimization')
                    </p>

                    <!-- SEO Title & Description Blade Component -->
                    <v-seo-helper-custom></v-seo-helper-custom>

                    <div class="mt-8">
                        <!-- Meta Title -->
                        <x-admin::form.control-group class="mb-2.5">
                            <x-admin::form.control-group.label class="required">
                                @lang('blog::app.category.create.meta-title')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                name="meta_title"
                                id="meta_title"
                                rules="required"
                                :value="old('meta_title')"
                                :label="trans('blog::app.category.create.meta-title')"
                                :placeholder="trans('blog::app.category.create.meta-title')"
                            >
                            </x-admin::form.control-group.control>

                            <x-admin::form.control-group.error control-name="meta_title"></x-admin::form.control-group.error>
                        </x-admin::form.control-group>

                        <!-- Meta Keywords -->
                        <x-admin::form.control-group class="mb-2.5">
                            <x-admin::form.control-group.label class="required">
                                @lang('blog::app.category.create.meta-keywords')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                name="meta_keywords"
                                rules="required"
                                :value="old('meta_keywords')"
                                :label="trans('blog::app.category.create.meta-keywords')"
                                :placeholder="trans('blog::app.category.create.meta-keywords')"
                            >
                            </x-admin::form.control-group.control>
                            
                            <x-admin::form.control-group.error control-name="meta_keywords"></x-admin::form.control-group.error>
                        </x-admin::form.control-group>

                        <!-- Meta Description -->
                        <x-admin::form.control-group class="mb-2.5">
                            <x-admin::form.control-group.label class="required">
                                @lang('blog::app.category.create.meta-description')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="textarea"
                                name="meta_description"
                                id="meta_description"
                                rules="required"
                                :value="old('meta_description')"
                                :label="trans('blog::app.category.create.meta-description')"
                                :placeholder="trans('blog::app.category.create.meta-description')"
                            >
                            </x-admin::form.control-group.control>

                            <x-admin::form.control-group.error control-name="meta_description"></x-admin::form.control-group.error>
                        </x-admin::form.control-group>
                    </div>
                </div>
            </div>

            <!-- Right Section -->
            <div class="flex w-[360px] max-w-full flex-col gap-[8px]">

                <!-- Settings -->
                <x-admin::accordion>
                    <x-slot:header>
                        <p class="p-[10px] text-[16px] font-semibold text-gray-600 dark:text-gray-300">
                            @lang('blog::app.category.create.settings')
                        </p>
                    </x-slot:header>

                    <x-slot:content>
                        <!-- Status -->
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="font-medium text-gray-800 dark:text-white">
                                @lang('blog::app.category.create.status')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="switch"
                                name="status"
                                class="cursor-pointer"
                                value="1"
                                :label="trans('blog::app.category.create.status')"
                            >
                            </x-admin::form.control-group.control>
                        </x-admin::form.control-group>
                    </x-slot:content>
                </x-admin::accordion>

                <!-- Parent Category -->
                <x-admin::accordion>
                    <x-slot:header>
                        <p class="p-[10px] text-[16px] font-semibold text-gray-600 dark:text-gray-300">
                            @lang('blog::app.category.create.parent-category')
                        </p>
                    </x-slot:header>

                    <x-slot:content>
                        <!-- Status -->
                        <div class="flex flex-col gap-[12px]">
                            <x-admin::tree.view
                                input-type="radio"
                                name-field="parent_id"
                                value-field="key"
                                id-field="key"
                                model-value="json_encode($categories)"
                                :items="json_encode($categories)"
                                :fallback-locale="config('app.fallback_locale')"
                            >
                            </x-admin::tree.view>
                        </div>
                    </x-slot:content>
                </x-admin::accordion>

                {!! view_render_event('admin.blog.categories.create.after') !!}
            </div>
        </div>
    </x-admin::form>

@pushOnce('scripts')
    <!-- SEO Vue Component Template -->
    <script type="text/x-template" id="v-seo-helper-custom-template">
        <div class="mb-[30px] flex flex-col gap-[3px]">
            <p 
                class="text-[#161B9D] dark:text-white"
                v-text="metaTitle"
            >
            </p>

            <p 
                class="text-[#161B9D] dark:text-white"
                style="display: none;"
                v-text="metaSlug"
            >
            </p>

            <!-- SEO Meta Title -->
            <p 
                class="text-[#135F29]"
                v-text="'{{ URL::to('/') }}/blog/' + (metaSlug ? metaSlug.toLowerCase().replace(/\s+/g, '-') : '')"
            >
            </p>

            <!-- SEP Meta Description -->
            <p 
                class="text-gray-600 dark:text-gray-300"
                v-text="metaDescription"
            >
            </p>
        </div>
    </script>

    <script type="module">
        app.component('v-seo-helper-custom', {
            template: '#v-seo-helper-custom-template',

            data() {
                return {
                    metaTitle: this.$parent.getValues()['meta_title'],

                    metaDescription: this.$parent.getValues()['meta_description'],

                    metaSlug: this.$parent.getValues()['slug'],
                }
            },

            mounted() {
                let self = this;

                self.metaTitle = document.getElementById('meta_title').value;

                self.metaDescription = document.getElementById('meta_description').value;

                self.metaSlug = document.getElementById('slug').value;

                document.getElementById('meta_title').addEventListener('input', function(e) {
                    self.metaTitle = e.target.value;
                });

                document.getElementById('meta_description').addEventListener('input', function(e) {
                    self.metaDescription = e.target.value;
                });

                document.getElementById('name').addEventListener('input', function(e) {
                    setTimeout(function(){
                        var slug = document.getElementById('slug').value;
                        self.metaSlug = ( slug != '' && slug != null && slug != undefined ) ? slug : '';
                    }, 1000);
                });

                document.getElementById('slug').addEventListener('input', function(e) {
                    var slug = e.target.value;
                    self.metaSlug = ( slug != '' && slug != null && slug != undefined ) ? slug : '';
                });
            },
        });
    </script>
@endPushOnce
</x-admin::layouts>