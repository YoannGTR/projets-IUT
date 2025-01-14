window.addEventListener('DOMContentLoaded', function () {
  document.querySelector('.main-menu').addEventListener('mouseover', function() {
    document.querySelector('.placeholder-hover').classList.add('show-menu');
  });

  document.querySelector('.main-menu').addEventListener('mouseout', function() {
    document.querySelector('.placeholder-hover').classList.remove('show-menu');
  });
});