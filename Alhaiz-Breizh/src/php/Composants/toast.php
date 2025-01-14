<?php

use Classes\Toast;

$toasts = Toast::getToasts();
?>

  <link rel="stylesheet" href="/ressources/css/toast.css">
  <div class="toast-overlay" id="toast-overlay"></div>
  <script src="/ressources/js/toast.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
        <?php foreach ($toasts as $toast): ?>
      showToast("<?= addslashes($toast['message']) ?>", "<?= $toast['type'] ?>", <?= $toast['duration'] ?>);
        <?php endforeach; ?>
    });
  </script>

<?php Toast::clearToasts(); ?>