<!DOCTYPE html>
<html lang="en" class="dark">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Adhyayana</title>
  <link href="/css/output.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css ">
</head>

<body class="bg-white text-gray-800 dark:bg-gray-900 dark:text-gray-100 font-sans">
  <!-- Dark Mode Toggle -->
  <div class="fixed top-4 right-4 z-50">
   <button onclick="toggleDarkMode()"
  class="bg-blue-600 text-white dark:bg-blue-300 dark:text-black px-4 py-2 rounded shadow flex items-center gap-2">
  <i id="darkModeIcon" class="fas fa-moon"></i>
</button>
  </div>

  <section 
    class="relative py-24 overflow-hidden bg-gradient-to-b from-blue-100 via-blue-300 to-blue-500 dark:from-blue-900 dark:via-blue-700 dark:to-blue-600"
    style="background: url('{{ asset('build/assets/images/top-hero.png') }}') center/cover no-repeat;">
    
    <div class="container mx-auto text-center px-6 
                bg-white/40 dark:bg-black/10           backdrop-blur-sm p-8 rounded-xl">     <h1 class="text-4xl md:text-6xl font-bold mb-4">Master New Skills. Learn Anytime.</h1>
      <p class="text-lg md:text-xl mb-6">Your professional LMS with powerful features and elegant design.</p>
      <div class="flex justify-center gap-4">
        <a href="/register"
          class="bg-white dark:bg-gray-800 text-blue-600 dark:text-white px-6 py-3 rounded-full font-semibold shadow hover:bg-gray-100 dark:hover:bg-gray-700">Register</a>
        <a href="/login"
          class="bg-blue-700 dark:bg-blue-400 text-white px-6 py-3 rounded-full font-semibold shadow hover:bg-blue-800 dark:hover:bg-blue-500">Login</a>
      </div>
    </div>
</section>


  <!-- Search and Call to Action -->
  <section class="py-16 px-6">
    <div class="max-w-4xl mx-auto text-center">
      <h2 class="text-3xl font-bold mb-4">What would you like to learn today?</h2>
      <input type="text" placeholder="Search courses..."
        class="w-full max-w-lg px-6 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 dark:border-gray-600 dark:bg-gray-800 dark:text-white" />
    </div>
  </section>

  <!-- Course Tiles / Cards -->
  <section class="py-20 bg-blue-50 dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-6">
      <h2 class="text-3xl font-bold mb-8 text-center">Popular Courses</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-md overflow-hidden">
          <img src="https://via.placeholder.com/400x200" alt="Course Thumbnail" class="w-full">
          <div class="p-6">
            <h3 class="text-xl font-semibold mb-2">Introduction to Web Development</h3>
            <p class="text-sm mb-4">Learn HTML, CSS, and JavaScript from scratch. Perfect for beginners!</p>
            <a href="#" class="text-blue-600 dark:text-blue-300 font-medium">Learn More →</a>
          </div>
        </div>
        <!-- Duplicate the above div for more cards -->
      </div>
    </div>
  </section>

<hr>
 <!-- Course Tiles / Cards -->
  <section class="py-20 bg-blue-50 dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-6">
      <h2 class="text-3xl font-bold mb-8 text-center">All Courses</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-md overflow-hidden">
          <img src="https://via.placeholder.com/400x200" alt="Course Thumbnail" class="w-full">
          <div class="p-6">
            <h3 class="text-xl font-semibold mb-2">Introduction to Web Development</h3>
            <p class="text-sm mb-4">Learn HTML, CSS, and JavaScript from scratch. Perfect for beginners!</p>
            <a href="#" class="text-blue-600 dark:text-blue-300 font-medium">Learn More →</a>
          </div>
        </div>
        <!-- Duplicate the above div for more cards -->
      </div>
    </div>
  </section>

  <!-- Parallax Banner -->
  <section class="h-96 bg-fixed bg-center bg-cover"
    style="background-image: url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b?fit=crop&w=1600&q=80');">
    <div class="h-full w-full flex items-center justify-center bg-blue-900/50 dark:bg-blue-900/70">
      <h2 class="text-white text-4xl font-bold">Learn from anywhere, anytime</h2>
    </div>
  </section>

  <!-- Testimonials Carousel (basic static version) -->
  <section class="py-20 bg-white dark:bg-gray-900">
    <div class="max-w-5xl mx-auto text-center px-6">
      <h2 class="text-3xl font-bold mb-8">What Our Learners Say</h2>
      <div class="space-y-8">
        <blockquote>
          <p class="italic">“This platform changed my life. I earned a lot of money from it.”</p>
          <footer class="mt-4 font-semibold">— Tikaraj Neupane</footer>
        </blockquote>
        <!-- Repeat for more testimonials -->
      </div>
    </div>
  </section>

  <section class="py-20 bg-blue-100 dark:bg-gray-800">
  <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-3 gap-12 text-center">
    <div>
      <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-4 text-blue-600 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" role="img" aria-hidden="true">
  <title>Certification Badge Icon</title>
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
  <path stroke-linecap="round" stroke-linejoin="round" d="M6 2h9l5 5v13a2 2 0 01-2 2H6a2 2 0 01-2-2V4a2 2 0 012-2z" />
  <path stroke-linecap="round" stroke-linejoin="round" d="M14 2v6h6" />
</svg>

      <h3 class="text-xl font-semibold">Certified Instructors</h3>
      <p class="mt-2">Get guidance from industry-leading professionals.</p>
    </div>
    <div>
      <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-4 text-blue-600 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
  <title>Learn Anywhere</title>
  <path stroke-linecap="round" stroke-linejoin="round" d="M3 6a1 1 0 011-1h16a1 1 0 011 1v10H3V6z" />
  <path stroke-linecap="round" stroke-linejoin="round" d="M2 16h20a1 1 0 01-1 1H3a1 1 0 01-1-1z" />
</svg>

      <h3 class="text-xl font-semibold">Flexible Learning</h3>
      <p class="mt-2">Learn at your own pace from any device.</p>
    </div>
    <div>
     <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-4 text-blue-600 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
  <title>Learn Anytime</title>
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
</svg>

      <h3 class="text-xl font-semibold">Lifetime Access</h3>
      <p class="mt-2">Revisit your courses whenever you need to refresh.</p>
    </div>
  </div>
</section>

 <!-- Call to Action -->
<section 
  class="py-20 text-white dark:text-gray-900 text-center relative overflow-hidden"
  style="background: url('{{ asset('build/assets/images/cta.png') }}') center/cover no-repeat;">
  
  <div class="absolute inset-0 bg-blue-700/80 dark:bg-blue-500/70"></div> <!-- Optional overlay for text contrast -->

  <div class="relative z-10">
    <h2 class="text-3xl font-bold mb-4">Ready to start your learning journey?</h2>
    <a href="/register"
      class="bg-white dark:bg-gray-900 text-blue-700 dark:text-white px-6 py-3 rounded-full shadow hover:bg-gray-100 dark:hover:bg-gray-700">
      Get Started
    </a>
  </div>
</section>

  <!-- Footer -->
  <footer class="py-10 bg-blue-900 dark:bg-gray-900 text-center text-white dark:text-gray-400">
    <p>&copy; {{ date('Y') }}Adhyayana. All rights reserved.</p>
  </footer>
<script>
  function toggleDarkMode() {
    document.documentElement.classList.toggle('dark');
    const icon = document.getElementById('darkModeIcon');
    if (document.documentElement.classList.contains('dark')) {
      icon.classList.remove('fa-moon');
      icon.classList.add('fa-sun');
    } else {
      icon.classList.remove('fa-sun');
      icon.classList.add('fa-moon');
    }
  }
</script>
</body>

</html>
