const icons = {
  'success': 'success.png',
  'danger': 'error.png',
  'warning': 'warning.png',
  'info': 'info.png'
};

const showToast = (message = "", toastType = "info", duration) => {
  if (!Object.keys(icons).includes(toastType)) toastType = "info";

  let box = document.createElement("div");
  box.classList.add("toast", `toast-${toastType}`);
  let contentWrapper = document.createElement("div");
  contentWrapper.classList.add("toast-content-wrapper");

  let icon = document.createElement("img");
  icon.classList.add("toast-icon");
  icon.src = `/ressources/assets/${icons[toastType]}`;

  let toastMessage = document.createElement("div");
  toastMessage.classList.add("toast-message");
  toastMessage.innerText = message;

  let progress = document.createElement("div");
  progress.classList.add("toast-progress");
  progress.style.animationDuration = `${duration / 1000}s`;

  contentWrapper.appendChild(icon);
  contentWrapper.appendChild(toastMessage);
  contentWrapper.appendChild(progress);
  box.appendChild(contentWrapper);

  let toastAlready = document.body.querySelector(".toast");
  if (toastAlready) toastAlready.remove();

  document.body.appendChild(box);
  setTimeout(() => {
    box.remove();
  }, duration);
};