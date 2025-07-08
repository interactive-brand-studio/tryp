@extends('layouts.app')

@section('title', $page->seo_title ?? $page->title)

@if($page->seo_description)
    @section('meta_description', $page->seo_description)
@endif

@if($page->seo_image)
    @section('meta_image', $page->seo_image)
@endif

@section('content')
    <!-- Page Hero Section -->
    <section class="relative pt-24 pb-16 bg-gradient-to-br from-primary-50 to-indigo-100">
        <div class="absolute inset-0 bg-white/80"></div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <!-- Breadcrumb -->
                <nav class="mb-6">
                    <ol class="flex items-center justify-center space-x-2 text-sm text-gray-600">
                        <li><a href="{{ route('home') }}" class="hover:text-primary-600">Home</a></li>
                        <li><span class="text-gray-400">/</span></li>
                        <li><span class="text-gray-800">{{ $page->title }}</span></li>
                    </ol>
                </nav>

                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">{{ $page->title }}</h1>
                
                @if($page->excerpt)
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">{{ $page->excerpt }}</p>
                @endif
            </div>
        </div>

        <!-- Wave Divider -->
        <div class="absolute bottom-0 left-0 right-0 w-full">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" preserveAspectRatio="none"
                style="width: 100%; height: 60px; display: block;">
                <path fill="#ffffff" fill-opacity="1"
                    d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z">
                </path>
            </svg>
        </div>
    </section>

    <!-- Main Content Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Content Card -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="p-8 md:p-12">
                        <!-- Content -->
                        <div class="prose prose-lg max-w-none">
                            <div class="content-wrapper">
                                {!! $page->content !!}
                            </div>
                        </div>

                        <!-- Page Meta Information -->
                        @if($page->created_at)
                            <div class="mt-12 pt-8 border-t border-gray-200">
                                <div class="flex items-center justify-between text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Published: {{ $page->created_at->format('F j, Y') }}
                                    </div>
                                    @if($page->updated_at && $page->updated_at != $page->created_at)
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                            Last updated: {{ $page->updated_at->format('F j, Y') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Social Share Section -->
                <div class="mt-8 bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Share this page</h3>
                    <div class="flex space-x-4">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" 
                           target="_blank" 
                           class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            Facebook
                        </a>
                        
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($page->title) }}&url={{ urlencode(request()->fullUrl()) }}" 
                           target="_blank" 
                           class="flex items-center px-4 py-2 bg-blue-400 text-white rounded-lg hover:bg-blue-500 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                            Twitter
                        </a>
                        
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->fullUrl()) }}" 
                           target="_blank" 
                           class="flex items-center px-4 py-2 bg-blue-800 text-white rounded-lg hover:bg-blue-900 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                            LinkedIn
                        </a>
                        
                        <button onclick="copyToClipboard()" 
                                class="flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            Copy Link
                        </button>
                    </div>
                </div>

                <!-- Contact Section -->
                <div class="mt-8 bg-gradient-to-r from-primary-50 to-indigo-50 rounded-2xl shadow-lg p-8">
                    <div class="text-center">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Have Questions?</h3>
                        <p class="text-gray-600 mb-6 max-w-2xl mx-auto">
                            If you need more information about {{ $page->title }} or have any questions, feel free to reach out to our team.
                        </p>
                        <a href="{{ '/contact' }}" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-600 to-indigo-700 text-white font-semibold rounded-lg hover:from-primary-700 hover:to-indigo-800 transition-colors shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    /* Enhanced prose styling for content */
    .prose {
        color: #374151;
    }
    
    .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
        color: #1f2937;
        font-weight: 700;
        line-height: 1.25;
    }
    
    .prose h1 {
        font-size: 2.25rem;
        margin-top: 0;
        margin-bottom: 2rem;
    }
    
    .prose h2 {
        font-size: 1.875rem;
        margin-top: 3rem;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e5e7eb;
    }
    
    .prose h3 {
        font-size: 1.5rem;
        margin-top: 2.5rem;
        margin-bottom: 1rem;
    }
    
    .prose p {
        margin-bottom: 1.5rem;
        line-height: 1.75;
    }
    
    .prose ul, .prose ol {
        margin-bottom: 1.5rem;
        padding-left: 1.75rem;
    }
    
    .prose li {
        margin-bottom: 0.5rem;
    }
    
    .prose blockquote {
        border-left: 4px solid #3b82f6;
        background: #f8fafc;
        padding: 1rem 1.5rem;
        margin: 2rem 0;
        font-style: italic;
        border-radius: 0.5rem;
    }
    
    .prose img {
        border-radius: 0.75rem;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        margin: 2rem auto;
    }
    
    .prose a {
        color: #3b82f6;
        text-decoration: none;
        font-weight: 500;
    }
    
    .prose a:hover {
        color: #1d4ed8;
        text-decoration: underline;
    }
    
    .prose table {
        width: 100%;
        margin: 2rem 0;
        border-collapse: collapse;
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    .prose th, .prose td {
        padding: 0.75rem 1rem;
        border: 1px solid #e5e7eb;
    }
    
    .prose th {
        background: #f9fafb;
        font-weight: 600;
        color: #374151;
    }
    
    .prose code {
        background: #f1f5f9;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        color: #e11d48;
    }
    
    .prose pre {
        background: #1e293b;
        color: #e2e8f0;
        padding: 1.5rem;
        border-radius: 0.75rem;
        overflow-x: auto;
        margin: 2rem 0;
    }
</style>
@endpush

@push('scripts')
<script>
function copyToClipboard() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        // Create a temporary notification
        const notification = document.createElement('div');
        notification.textContent = 'Link copied to clipboard!';
        notification.className = 'fixed top-4 right-4 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg z-50 transition-opacity duration-300';
        document.body.appendChild(notification);
        
        // Remove notification after 3 seconds
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }).catch(function(err) {
        console.error('Could not copy text: ', err);
    });
}

// Smooth scrolling for anchor links
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth scrolling to all anchor links within the content
    const contentLinks = document.querySelectorAll('.content-wrapper a[href^="#"]');
    contentLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>
@endpush