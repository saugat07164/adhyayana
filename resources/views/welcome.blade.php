<!DOCTYPE html>
<html lang="en" class="dark">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Adhyayana</title>
  <link href="/css/output.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css ">
  <style>
    /* Custom CSS for a subtle animation on the hero content */
    @keyframes fadeInSlideUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animate-fade-in-slide-up {
      animation: fadeInSlideUp 0.8s ease-out forwards;
    }

    /* Gradient overlay for the hero image for better text contrast */
    .hero-gradient-overlay {
      background: linear-gradient(to bottom, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0.6) 100%);
    }

    .dark .hero-gradient-overlay {
        background: linear-gradient(to bottom, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0.7) 100%);
    }

    /* Pulsing effect for the call to action button */
    @keyframes pulse {
      0% {
        box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.7); /* blue-600 */
      }
      70% {
        box-shadow: 0 0 0 10px rgba(37, 99, 235, 0);
      }
      100% {
        box-shadow: 0 0 0 0 rgba(37, 99, 235, 0);
      }
    }

    .animate-pulse-light {
        animation: pulse 2s infinite;
    }

    .dark .animate-pulse-light {
         box-shadow: 0 0 0 0 rgba(96, 165, 250, 0.7); /* blue-400 */
    }
    .dark .animate-pulse-light {
        animation: pulse-dark 2s infinite;
    }

    @keyframes pulse-dark {
        0% {
        box-shadow: 0 0 0 0 rgba(96, 165, 250, 0.7); /* blue-400 */
      }
      70% {
        box-shadow: 0 0 0 10px rgba(96, 165, 250, 0);
      }
      100% {
        box-shadow: 0 0 0 0 rgba(96, 165, 250, 0);
      }
    }
  </style>
</head>

<body class="bg-white text-gray-800 dark:bg-gray-900 dark:text-gray-100 font-sans antialiased">
  <div class="fixed top-4 right-4 z-50">
   <button onclick="toggleDarkMode()"
  class="bg-blue-600 text-white dark:bg-blue-300 dark:text-black px-4 py-2 rounded-full shadow-lg flex items-center gap-2 transition-colors duration-300 hover:scale-105">
  <i id="darkModeIcon" class="fas fa-moon"></i>
</button>
  </div>

  <section
    class="relative py-24 md:py-32 flex items-center justify-center overflow-hidden min-h-screen-75 bg-cover bg-center"
    style="background-image: url('{{ asset('build/assets/images/top-hero.png') }}');">

    <div class="absolute inset-0 hero-gradient-overlay"></div>

    <div class="container mx-auto text-center px-6 relative z-10 animate-fade-in-slide-up">
      <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold mb-4 text-white drop-shadow-lg leading-tight">Master New Skills. <br class="md:hidden"> Learn Anytime.</h1>
      <p class="text-lg md:text-xl lg:text-2xl mb-8 text-blue-100 font-light max-w-2xl mx-auto">Your professional LMS with powerful features and elegant design.</p>
      <div class="flex flex-col sm:flex-row justify-center gap-4">
        <a href="/register"
          class="bg-blue-600 text-white px-8 py-4 rounded-full font-bold shadow-lg hover:bg-blue-700 transition duration-300 transform hover:scale-105 animate-pulse-light">Register Now</a>
        <a href="/login"
          class="bg-white text-blue-700 px-8 py-4 rounded-full font-bold shadow-lg hover:bg-gray-200 transition duration-300 transform hover:scale-105 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700">Login Here</a>
      </div>
    </div>
</section>



  <section class="py-16 px-6 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-900">
    <div class="max-w-4xl mx-auto text-center">
      <h2 class="text-3xl md:text-4xl font-bold mb-6 text-gray-900 dark:text-white">What would you like to learn today?</h2>
      <div class="relative max-w-lg mx-auto">
        <input type="text" placeholder="Search for courses, topics, or skills..."
          class="w-full px-6 py-3 pr-12 rounded-full border border-blue-300 focus:outline-none focus:ring-4 focus:ring-blue-400/50 dark:border-gray-600 dark:bg-gray-700 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-300 text-lg shadow-inner" />
        <i class="fas fa-search absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-300"></i>
      </div>
    </div>
  </section>



  <section class="py-20 bg-gray-100 dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-6">
      <h2 class="text-3xl md:text-4xl font-bold mb-12 text-center text-gray-900 dark:text-white">Popular Courses</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300 border border-gray-200 dark:border-gray-700">
          <img src="https://via.placeholder.com/400x200/4F46E5/FFFFFF?text=Web+Dev" alt="Course Thumbnail" class="w-full h-48 object-cover">
          <div class="p-6">
            <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Introduction to Web Development</h3>
            <p class="text-sm mb-4 text-gray-600 dark:text-gray-300">Learn HTML, CSS, and JavaScript from scratch. Perfect for beginners!</p>
            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                <span><i class="fas fa-star text-yellow-400"></i> 4.9 (1,200)</span>
                <span><i class="fas fa-clock"></i> 10 Hours</span>
            </div>
            <a href="#" class="inline-flex items-center text-blue-600 dark:text-blue-400 font-medium hover:underline">
                Learn More
                <i class="fas fa-arrow-right ml-2 text-sm"></i>
            </a>
          </div>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300 border border-gray-200 dark:border-gray-700">
          <img src="https://via.placeholder.com/400x200/10B981/FFFFFF?text=Data+Science" alt="Course Thumbnail" class="w-full h-48 object-cover">
          <div class="p-6">
            <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Data Science Fundamentals</h3>
            <p class="text-sm mb-4 text-gray-600 dark:text-gray-300">Dive into data analysis, machine learning, and Python.</p>
            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                <span><i class="fas fa-star text-yellow-400"></i> 4.7 (950)</span>
                <span><i class="fas fa-clock"></i> 15 Hours</span>
            </div>
            <a href="#" class="inline-flex items-center text-blue-600 dark:text-blue-400 font-medium hover:underline">
                Learn More
                <i class="fas fa-arrow-right ml-2 text-sm"></i>
            </a>
          </div>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300 border border-gray-200 dark:border-gray-700">
          <img src="https://via.placeholder.com/400x200/F59E0B/FFFFFF?text=UI/UX+Design" alt="Course Thumbnail" class="w-full h-48 object-cover">
          <div class="p-6">
            <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">UI/UX Design Principles</h3>
            <p class="text-sm mb-4 text-gray-600 dark:text-gray-300">Craft intuitive and beautiful user interfaces.</p>
            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                <span><i class="fas fa-star text-yellow-400"></i> 4.8 (1,100)</span>
                <span><i class="fas fa-clock"></i> 12 Hours</span>
            </div>
            <a href="#" class="inline-flex items-center text-blue-600 dark:text-blue-400 font-medium hover:underline">
                Learn More
                <i class="fas fa-arrow-right ml-2 text-sm"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>



 <section class="py-20 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-6">
      <h2 class="text-3xl md:text-4xl font-bold mb-12 text-center text-gray-900 dark:text-white">All Courses</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="bg-gray-50 dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300 border border-gray-200 dark:border-gray-700">
          <img src="https://via.placeholder.com/400x200/EF4444/FFFFFF?text=Marketing" alt="Course Thumbnail" class="w-full h-48 object-cover">
          <div class="p-6">
            <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Digital Marketing Strategy</h3>
            <p class="text-sm mb-4 text-gray-600 dark:text-gray-300">Master SEO, social media, and content marketing.</p>
            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                <span><i class="fas fa-star text-yellow-400"></i> 4.6 (800)</span>
                <span><i class="fas fa-clock"></i> 8 Hours</span>
            </div>
            <a href="#" class="inline-flex items-center text-blue-600 dark:text-blue-400 font-medium hover:underline">
                Learn More
                <i class="fas fa-arrow-right ml-2 text-sm"></i>
            </a>
          </div>
        </div>
        <div class="bg-gray-50 dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300 border border-gray-200 dark:border-gray-700">
          <img src="https://via.placeholder.com/400x200/3B82F6/FFFFFF?text=Cloud+Computing" alt="Course Thumbnail" class="w-full h-48 object-cover">
          <div class="p-6">
            <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Cloud Computing Essentials</h3>
            <p class="text-sm mb-4 text-gray-600 dark:text-gray-300">An introduction to cloud platforms like AWS and Azure.</p>
            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                <span><i class="fas fa-star text-yellow-400"></i> 4.5 (650)</span>
                <span><i class="fas fa-clock"></i> 9 Hours</span>
            </div>
            <a href="#" class="inline-flex items-center text-blue-600 dark:text-blue-400 font-medium hover:underline">
                Learn More
                <i class="fas fa-arrow-right ml-2 text-sm"></i>
            </a>
          </div>
        </div>
        <div class="bg-gray-50 dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300 border border-gray-200 dark:border-gray-700">
          <img src="https://via.placeholder.com/400x200/06B6D4/FFFFFF?text=Cybersecurity" alt="Course Thumbnail" class="w-full h-48 object-cover">
          <div class="p-6">
            <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Cybersecurity Basics</h3>
            <p class="text-sm mb-4 text-gray-600 dark:text-gray-300">Understand the fundamentals of protecting digital assets.</p>
            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                <span><i class="fas fa-star text-yellow-400"></i> 4.9 (1,050)</span>
                <span><i class="fas fa-clock"></i> 11 Hours</span>
            </div>
            <a href="#" class="inline-flex items-center text-blue-600 dark:text-blue-400 font-medium hover:underline">
                Learn More
                <i class="fas fa-arrow-right ml-2 text-sm"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>



  <section class="h-96 bg-fixed bg-center bg-cover relative"
    style="background-image: url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b?fit=crop&w=1600&q=80');">
    <div class="absolute inset-0 bg-blue-900/60 dark:bg-blue-900/80 flex items-center justify-center">
      <h2 class="text-white text-4xl md:text-5xl font-extrabold text-center drop-shadow-md px-4">Learn from anywhere, anytime</h2>
    </div>
  </section>



  <section class="py-20 bg-gray-100 dark:bg-gray-900">
    <div class="max-w-5xl mx-auto text-center px-6">
      <h2 class="text-3xl md:text-4xl font-bold mb-12 text-gray-900 dark:text-white">What Our Learners Say</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <blockquote class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg border-t-4 border-blue-500 dark:border-blue-400">
          <p class="italic text-lg text-gray-700 dark:text-gray-200 mb-4">“This platform changed my life. The courses are high-quality and the instructors are incredibly supportive.”</p>
          <footer class="mt-4 font-semibold text-gray-800 dark:text-gray-100">— Tikaraj Neupane, Web Developer</footer>
        </blockquote>
        <blockquote class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg border-t-4 border-purple-500 dark:border-purple-400">
          <p class="italic text-lg text-gray-700 dark:text-gray-200 mb-4">“I've gained so many valuable skills here. The flexible learning approach truly fits my busy schedule.”</p>
          <footer class="mt-4 font-semibold text-gray-800 dark:text-gray-100">— Anjali Sharma, Data Analyst</footer>
        </blockquote>
      </div>
       <button class="mt-12 bg-blue-600 text-white px-8 py-3 rounded-full font-semibold shadow-lg hover:bg-blue-700 transition duration-300">Read More Testimonials</button>
    </div>
  </section>


<section class="py-20 bg-blue-50 dark:bg-gray-800">
  <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-3 gap-12 text-center">
    <div>
      <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto mb-6 text-blue-600 dark:text-blue-300 animate-bounce-slow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" role="img" aria-hidden="true">
  <title>Certification Badge Icon</title>
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
  <path stroke-linecap="round" stroke-linejoin="round" d="M6 2h9l5 5v13a2 2 0 01-2 2H6a2 2 0 01-2-2V4a2 2 0 012-2z" />
  <path stroke-linecap="round" stroke-linejoin="round" d="M14 2v6h6" />
</svg>

      <h3 class="text-2xl font-bold mb-2 text-gray-900 dark:text-white">Certified Instructors</h3>
      <p class="mt-2 text-gray-700 dark:text-gray-300">Get guidance from industry-leading professionals dedicated to your success.</p>
    </div>
    <div>
      <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto mb-6 text-blue-600 dark:text-blue-300 animate-bounce-slow animation-delay-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
  <title>Learn Anywhere</title>
  <path stroke-linecap="round" stroke-linejoin="round" d="M3 6a1 1 0 011-1h16a1 1 0 011 1v10H3V6z" />
  <path stroke-linecap="round" stroke-linejoin="round" d="M2 16h20a1 1 0 01-1 1H3a1 1 0 01-1-1z" />
</svg>

      <h3 class="text-2xl font-bold mb-2 text-gray-900 dark:text-white">Flexible Learning</h3>
      <p class="mt-2 text-gray-700 dark:text-gray-300">Learn at your own pace, on your schedule, from any device, anywhere in the world.</p>
    </div>
    <div>
     <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto mb-6 text-blue-600 dark:text-blue-300 animate-bounce-slow animation-delay-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
  <title>Learn Anytime</title>
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
</svg>

      <h3 class="text-2xl font-bold mb-2 text-gray-900 dark:text-white">Lifetime Access</h3>
      <p class="mt-2 text-gray-700 dark:text-gray-300">Enroll once and revisit your courses whenever you need to refresh your knowledge.</p>
    </div>
  </div>
</section>


 <section
  class="py-20 text-white dark:text-gray-900 text-center relative overflow-hidden"
  style="background: url('{{ asset('build/assets/images/cta.png') }}') center/cover no-repeat;">

  <div class="absolute inset-0 bg-blue-800/85 dark:bg-blue-600/75"></div>

  <div class="relative z-10">
    <h2 class="text-3xl md:text-5xl font-extrabold mb-8 drop-shadow-lg">Ready to accelerate your learning journey?</h2>
    <a href="/register"
      class="bg-white dark:bg-gray-900 text-blue-700 dark:text-white px-10 py-4 rounded-full shadow-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300 transform hover:scale-105 font-bold text-lg">
      Get Started Today!
    </a>
  </div>
</section>


  <footer class="py-10 bg-blue-950 dark:bg-gray-950 text-center text-white dark:text-gray-400 text-sm">
    <div class="container mx-auto px-6">
        <p class="mb-2">&copy; {{ date('Y') }} Adhyayana. All rights reserved.</p>
        <nav class="space-x-4">
            <a href="#" class="hover:text-blue-300 transition duration-300">Privacy Policy</a>
            <a href="#" class="hover:text-blue-300 transition duration-300">Terms of Service</a>
            <a href="{{ route('contactmessages.create') }}" class="hover:text-blue-300 transition duration-300">Contact Us</a>
        </nav>
    </div>
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