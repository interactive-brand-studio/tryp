@extends('layouts.admin')

@section('title', 'Create Page')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Create Page</h1>
            <a href="{{ route('admin.pages.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <form method="POST" action="{{ route('admin.pages.store') }}" class="p-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div class="col-span-2">
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug <span
                                class="text-red-500">*</span></label>
                        <div class="flex">
                            <input type="text" name="slug" id="slug" value="{{ old('slug') }}" required
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <button type="button" id="generateSlug"
                                class="ml-2 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Generate
                            </button>
                        </div>
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Content -->
                    <div class="col-span-2">
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                        <textarea name="content" id="content" rows="15"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('content') }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- SEO Title -->
                    <div class="col-span-2">
                        <label for="seo_title" class="block text-sm font-medium text-gray-700 mb-1">SEO Title</label>
                        <input type="text" name="seo_title" id="seo_title" value="{{ old('seo_title') }}"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        @error('seo_title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- SEO Description -->
                    <div class="col-span-2">
                        <label for="seo_description" class="block text-sm font-medium text-gray-700 mb-1">SEO
                            Description</label>
                        <textarea name="seo_description" id="seo_description" rows="3"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('seo_description') }}</textarea>
                        @error('seo_description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- SEO Image -->
                    <div class="col-span-2">
                        <label for="seo_image" class="block text-sm font-medium text-gray-700 mb-1">SEO Image URL</label>
                        <input type="url" name="seo_image" id="seo_image" value="{{ old('seo_image') }}"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        @error('seo_image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Create Page
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
    <script>
        let editorInstance;

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize CKEditor
            ClassicEditor
                .create(document.querySelector('#content'))
                .then(editor => {
                    editorInstance = editor;
                })
                .catch(error => {
                    console.error('CKEditor Error:', error);
                });

            // Handle form submission to sync CKEditor content
            const form = document.querySelector('form');
            form.addEventListener('submit', function(event) {
                if (editorInstance) {
                    editorInstance.updateSourceElement();
                }
            });

            // Slug generation script
            const titleInput = document.getElementById('title');
            const slugInput = document.getElementById('slug');
            const generateSlugButton = document.getElementById('generateSlug');

            generateSlugButton.addEventListener('click', function() {
                if (titleInput.value) {
                    slugInput.value = titleInput.value
                        .toLowerCase()
                        .replace(/[^\w\s-]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/--+/g, '-')
                        .trim();
                }
            });
        });
    </script>
@endpush
