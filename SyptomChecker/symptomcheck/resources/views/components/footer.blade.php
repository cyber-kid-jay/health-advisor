<footer class="bg-white border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-4 flex flex-col sm:flex-row items-center justify-between text-sm text-gray-600">
            <div class="mb-2 sm:mb-0">&copy; {{ date('Y') }} {{ config('app.name', 'SymptomChecker') }}. All rights reserved.</div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('blog') }}" class="hover:underline">Blog</a>
                <a href="/privacy" class="hover:underline">Privacy</a>
                <a href="/terms" class="hover:underline">Terms</a>
            </div>
        </div>
    </div>
</footer>
