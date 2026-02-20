<footer class="mt-16 bg-gray-900 text-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid gap-8 md:grid-cols-3">
        <div>
            <h4 class="text-lg font-semibold mb-3">Contact Details</h4>
            <p>Phone: +94 77 821 5375</p>
            <p>Email: safe@boardingfinder.lk</p>
        </div>

        <div>
            <h4 class="text-lg font-semibold mb-3">Quick Actions</h4>
            <ul class="space-y-2">
                <li><a href="{{ route('register') }}" class="hover:text-indigo-300">Create Account</a></li>
                <li><a href="{{ route('owner.boardings.create') }}" class="hover:text-indigo-300">Post a Free Ad</a></li>
                <li><a href="{{ route('ads.index') }}" class="hover:text-indigo-300">View All Ads</a></li>
            </ul>
        </div>

        <div>
            <h4 class="text-lg font-semibold mb-3">Social Media</h4>
            <ul class="space-y-2">
                <li><a href="#" class="hover:text-indigo-300">Facebook</a></li>
                <li><a href="#" class="hover:text-indigo-300">Instagram</a></li>
                <li><a href="#" class="hover:text-indigo-300">TikTok</a></li>
                <li><a href="#" class="hover:text-indigo-300">LinkedIn</a></li>
            </ul>
        </div>
    </div>
</footer>
