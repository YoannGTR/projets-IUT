function formatDate(e) {
  const input = e.target;
  const inputValue = input.value.replace(/\D/g, ''); // Remove non-numeric characters
  input.value = formatDateString(inputValue);
}

function formatDateString(inputValue) {
  let formattedDate = '';
  if (inputValue.length > 0) {
    formattedDate += inputValue.substring(0, 2);
    if (inputValue.length > 2) {
      formattedDate += '/' + inputValue.substring(2, 4);
    }
    if (inputValue.length > 4) {
      formattedDate += '/' + inputValue.substring(4, 8);
    }
  }
  return formattedDate;
}

function validateDate(dateString) {
  const datePattern = /^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/(19|20)\d\d$/;
  if (!datePattern.test(dateString)) return false;

  const parts = dateString.split('/');
  const day = parseInt(parts[0], 10);
  const month = parseInt(parts[1], 10);
  const year = parseInt(parts[2], 10);

  const date = new Date(year, month - 1, day);
  return date.getFullYear() === year && date.getMonth() === month - 1 && date.getDate() === day;
}

function parseDate(dateString) {
  const parts = dateString.split('/');
  return new Date(parts[2], parts[1] - 1, parts[0]);
}

document.addEventListener('DOMContentLoaded', () => {
  const debut = document.getElementById('debut');
  const fin = document.getElementById('fin');
  const close = document.getElementById('close');
  const section = document.getElementById('popup-hide-bc');
  const popup = document.getElementById('popup');
  const add = document.getElementById('add');
  const selectAllCheckbox = document.getElementById('selectAll');
  const table = document.getElementById('table');
  const form = document.getElementById('logementForm');
  const errorDate = document.getElementById('error-date');
  const errorSelect = document.getElementById('error-select');

  function validateForm(event) {
    const checkboxes = document.querySelectorAll('input[type="checkbox"][name="selected[]"]');
    const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

    if (!anyChecked) {
      errorSelect.style.display = 'block';
      event.preventDefault();
      return;
    }

    const debut = document.getElementById('debut');
    const fin = document.getElementById('fin');

    const debutDate = parseDate(debut.value);
    const finDate = parseDate(fin.value);

    if (debutDate >= finDate) {
      errorDate.style.display = 'block';
      event.preventDefault();
    }
  }

  debut.addEventListener('input', formatDate);
  fin.addEventListener('input', formatDate);

  close.addEventListener('click', () => {
    section.style.display = 'none';
    popup.style.display = 'none';
  });

  add.addEventListener('click', () => {
    section.style.display = 'block';
    popup.style.display = 'block';
  });

  table.querySelectorAll('input[type="checkbox"][name="selected[]"]').forEach((checkbox) => {
    checkbox.addEventListener('change', () => {
      const anyChecked = Array.from(table.querySelectorAll('input[type="checkbox"][name="selected[]"]')).some(checkbox => checkbox.checked);
      if (anyChecked) {
        errorSelect.style.display = 'none';
      }
    });
  });

  debut.addEventListener('input', () => errorDate.style.display = 'none');
  fin.addEventListener('input', () => errorDate.style.display = 'none');


  selectAllCheckbox.addEventListener('change', (e) => {
    const checkboxes = table.querySelectorAll('input[type="checkbox"][name="selected[]"]');
    checkboxes.forEach((checkbox) => {
      if(e.target.checked) {
        errorSelect.style.display = 'none';
      }
      checkbox.checked = e.target.checked;
    });
  });

  form.addEventListener('submit', validateForm);
});
