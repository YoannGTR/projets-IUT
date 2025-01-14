let isInstalled = window.matchMedia('(display-mode: standalone)').matches;
let hasHomeIndicator = false;

window.onload = function () {
  console.log('script.js loaded');

  if (isInstalled) {
    document.body.style.webkitUserSelect = 'none';
    document.body.style.userSelect = 'none';
    document.body.style.webkitTapHighlightColor = 'transparent';
    document.body.style.webkitTouchCallout = 'none';
  }
};

document.addEventListener('DOMContentLoaded', function () {
  const links = document.querySelectorAll('.redirect');

  links.forEach((link) => {
    link.addEventListener('click', function (event) {
      displayLoader();
    });
  });


});

function waitForCSSRendering(callback) {
  let retries = 10;

  function checkCSS() {
    const value = getComputedStyle(document.documentElement).getPropertyValue(
      '--sab',
    );
    if (value !== '0px' || retries <= 0) {
      callback();
    } else {
      retries--;
      requestAnimationFrame(checkCSS);
    }
  }

  checkCSS();
}

window.addEventListener('load', function () {
  waitForCSSRendering(function () {
    let homeIndicatorValue = getComputedStyle(
      document.documentElement,
    ).getPropertyValue('--sab');
    let hasHomeIndicator =
      homeIndicatorValue !== '0.0px' &&
      homeIndicatorValue !== '0px' &&
      homeIndicatorValue;

    if (hasHomeIndicator && isInstalled) {
      document.getElementById('footer-spacer').style.height = '0.9rem';
      document.getElementsByTagName('footer')[0].style.height = '4.9rem';
    }
  });
});

function displayLoader() {
  document.getElementById('loader').style.display = 'flex';
}


