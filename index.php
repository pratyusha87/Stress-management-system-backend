<?php
// Include header
include 'components/header.php';

// Include navbar
include 'components/navbar.php';
?>

<!-- Main Content -->
<main class="container mx-auto px-4 pt-20">
    <?php
    include 'components/sections/landing.php';
    include 'components/sections/login.php';
    include 'components/sections/about.php';
    include 'components/sections/breathing.php';
    include 'components/sections/meditation.php';
    include 'components/sections/music.php';
    include 'components/sections/drawing.php';
    include 'components/sections/photos.php';
    include 'components/sections/feedback.php';
    include 'components/sections/contact.php';
    ?>
</main>

<script src="https://cdn.tailwindcss.com"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const circle = document.getElementById('boxBreathingCircle');
  const startBtn = document.getElementById('startBoxBreathing');
  const stopBtn = document.getElementById('stopBoxBreathing');
  let interval = null;
  let phase = 0;
  const phases = [
    { text: 'Inhale', scale: 1.2 },
    { text: 'Hold', scale: 1 },
    { text: 'Exhale', scale: 0.8 },
    { text: 'Hold', scale: 1 }
  ];

  function updateCircle() {
    const current = phases[phase % 4];
    circle.textContent = current.text;
    circle.style.transform = `scale(${current.scale})`;
    phase++;
  }

  if (startBtn && stopBtn && circle) {
    startBtn.onclick = function() {
      startBtn.classList.add('hidden');
      stopBtn.classList.remove('hidden');
      phase = 0;
      updateCircle();
      interval = setInterval(updateCircle, 4000);
    };

    stopBtn.onclick = function() {
      clearInterval(interval);
      circle.textContent = 'Ready';
      circle.style.transform = 'scale(1)';
      startBtn.classList.remove('hidden');
      stopBtn.classList.add('hidden');
    };
  }
});

// Only keep the last post in memory (or localStorage if you want persistence)
let lastPost = null;

// Remove any code that loads/saves an array of posts

function postEmotion() {
    const emotionText = document.getElementById('emotionInput').value;
    const photoInput = document.getElementById('photoInput');
    const file = photoInput.files[0];

    if (!emotionText && !file) {
        showNotification('Please share your emotion or add a photo');
        return;
    }

    const post = {
        text: emotionText,
        image: null,
        timestamp: new Date().toLocaleString()
    };

    // Always clear the posts grid before adding the new post
    const postsGrid = document.getElementById('postsGrid');
    postsGrid.innerHTML = '';

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            post.image = e.target.result;
            addPostToGrid(post);
            clearInputs();
        };
        reader.readAsDataURL(file);
    } else {
        addPostToGrid(post);
        clearInputs();
    }
}

function addPostToGrid(post) {
    const postsGrid = document.getElementById('postsGrid');
    const postElement = document.createElement('div');
    postElement.className = 'post-card bg-white dark:bg-gray-800 rounded-xl shadow-xl p-4';
    postElement.innerHTML = `
        <div class="mb-4">
            <p class="text-gray-700 dark:text-gray-300">${post.text}</p>
            ${post.image ? `<img src="${post.image}" alt="Post image" class="post-image rounded-lg mt-2">` : ''}
        </div>
        <div class="flex justify-end">
            <span class="text-sm text-gray-500">${post.timestamp}</span>
        </div>
    `;
    postsGrid.appendChild(postElement);
}

function clearInputs() {
    document.getElementById('emotionInput').value = '';
    document.getElementById('photoInput').value = '';
}
</script>

<?php
// Include footer
include 'components/footer.php';
?> 