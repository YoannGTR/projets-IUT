// Define an array to store events
let events = [];
let dateDebut;
let dateFin;
let datesIn = [];

let months = [
  'Janvier',
  'Fevrier',
  'Mars',
  'Avril',
  'Mai',
  'Juin',
  'Juillet',
  'Aout',
  'Septembre',
  'Octobre',
  'Novembre',
  'Decembre',
];
let days = ['L', 'Ma', 'Me', 'J', 'V', 'S', 'D'];

// Function to generate a range of years for the year select input
function generate_year_range(start, end) {
  let years = '';
  for (let year = start; year <= end; year++) {
    years += "<option value='" + year + "'>" + year + '</option>';
  }
  return years;
}

// Function to generate a range of month for the month select input
function generate_month_range(start) {
  let monthsOptions = '';
  for (let month = start; month < 12; month++) {
    monthsOptions += "<option value='" + month + "'>" + months[month] + '</option>';
  }
  return monthsOptions;
}

// Initialize date-related variables
today = new Date();
currentMonth = today.getMonth();
currentYear = today.getFullYear();
selectYear = document.getElementById('year');
selectMonth = document.getElementById('month');

createYear = generate_year_range(today.getFullYear(), today.getFullYear() + 10);

document.getElementById('year').innerHTML = createYear;

createMonth = generate_month_range(today.getMonth());

document.getElementById('month').innerHTML = createMonth;

let calendar = document.getElementById('calendar');

$dataHead = '<tr>';
for (dhead in days) {
  $dataHead += "<th data-days='" + days[dhead] + "'>" + days[dhead] + '</th>';
}
$dataHead += '</tr>';

document.getElementById('thead-month').innerHTML = $dataHead;

monthAndYear = document.getElementById('monthAndYear');
showCalendar(currentMonth, currentYear);

// Function to navigate to the next month
function next() {
  if (new Date(currentYear, currentMonth, 1) <= today) {
    document.getElementById('previous').style.backgroundColor = 'var(--pink)';
    document.getElementById('previous').style.color = '#fff';
  }
  currentYear = currentMonth === 11 ? currentYear + 1 : currentYear;
  currentMonth = (currentMonth + 1) % 12;
  if (currentYear !== today.getFullYear()) {
    createMonth = generate_month_range(0);

    document.getElementById('month').innerHTML = createMonth;
  }
  showCalendar(currentMonth, currentYear);
}

// Function to navigate to the previous month
function previous() {
  if (!(new Date(currentYear, currentMonth, 1) <= today)) {
    currentYear = currentMonth === 0 ? currentYear - 1 : currentYear;
    currentMonth = currentMonth === 0 ? 11 : currentMonth - 1;
    if (currentYear === today.getFullYear()) {
      createMonth = generate_month_range(today.getMonth());

      document.getElementById('month').innerHTML = createMonth;
    }
    showCalendar(currentMonth, currentYear);
    if (new Date(currentYear, currentMonth, 1) <= today) {
      document.getElementById('previous').style.backgroundColor =
        'var(--background-color)';
      document.getElementById('previous').style.color = 'var(--pink)';
    }
  }
}

// Function to jump to a specific month and year
function jump() {
  if (new Date(currentYear, currentMonth, 1) <= today) {
    document.getElementById('previous').style.backgroundColor = 'var(--pink)';
    document.getElementById('previous').style.color = '#fff';
  }
  currentYear = parseInt(selectYear.value);
  currentMonth = parseInt(selectMonth.value);
  if (currentYear === today.getFullYear()) {
    createMonth = generate_month_range(today.getMonth());

    document.getElementById('month').innerHTML = createMonth;
  } else {
    createMonth = generate_month_range(0);

    document.getElementById('month').innerHTML = createMonth;
  }
  showCalendar(currentMonth, currentYear);
  if (new Date(currentYear, currentMonth, 1) <= today) {
    document.getElementById('previous').style.backgroundColor =
      'var(--background-color)';
    document.getElementById('previous').style.color = 'var(--pink)';
  }
}

// Function to display the calendar
function showCalendar(month, year) {
  console.log('Generating calendar for:', month, year);

  let firstDay = new Date(year, month, 1).getDay() - 1;
  let tbl = document.getElementById('calendar-body');
  tbl.innerHTML = '';
  monthAndYear.innerHTML = months[month] + ' ' + year;
  selectYear.value = year;
  selectMonth.value = month;
  let date = 1;

  // Convert planningData dates to Date objects for easy comparison, normalize to local time
  if (typeof planningData === 'undefined') {
    planningData = [];
  }

  let unavailableDates = planningData.map(item => {
    let date = new Date(item.unavailability_date);
    return new Date(date.getFullYear(), date.getMonth(), date.getDate());
  });
  console.log('Unavailable dates:', unavailableDates);

  for (let i = 0; i < 6; i++) {
    let row = document.createElement('tr');
    for (let j = 0; j < 7; j++) {
      if (i === 0 && j < firstDay) {
        let cell = document.createElement('td');
        let cellText = document.createTextNode('');
        cell.appendChild(cellText);
        row.appendChild(cell);
      } else if (date > daysInMonth(month, year)) {
        break;
      } else {
        let cell = document.createElement('td');
        cell.setAttribute('data-date', date);
        cell.setAttribute('data-month', month + 1);
        cell.setAttribute('data-year', year);
        cell.setAttribute('data-month_name', months[month]);
        cell.innerHTML = '<span>' + date + '</span>';

        let currentDate = new Date(year, month, date);
        console.log('Checking date:', currentDate);

        if (new Date(year, month, date + 1) < today) {
          cell.className = 'date-before';
        } else if (unavailableDates.some(d => d.getTime() === currentDate.getTime())) {
          console.log('Date is unavailable:', currentDate);
          cell.className = 'date-unavailable'; // Add a class for unavailable dates
        } else {
          cell.className = 'date-picker';
          cell.addEventListener('click', selectionerJour);
        }
        if (
          date === today.getDate() &&
          year === today.getFullYear() &&
          month === today.getMonth()
        ) {
          cell.classList.add('today');
        }

        if (
          dateDebut !== undefined &&
          date === dateDebut.getDate() &&
          year === dateDebut.getFullYear() &&
          month === dateDebut.getMonth()
        ) {
          cell.classList.add('selected');
        }

        if (
          dateDebut !== undefined &&
          dateFin !== undefined &&
          dateDebut < dateFin &&
          date === dateFin.getDate() &&
          year === dateFin.getFullYear() &&
          month === dateFin.getMonth()
        ) {
          cell.classList.add('selected');
          cell.classList.add('end');
        }
        datesIn.forEach((dateIn) => {
          if (
            date === dateIn.getDate() &&
            year === dateIn.getFullYear() &&
            month === dateIn.getMonth()
          ) {
            cell.classList.add('selectedIn');
          }
        });
        row.appendChild(cell);
        date++;
      }
    }
    tbl.appendChild(row);
  }
}

// Add CSS for the unavailable dates
const style = document.createElement('style');
style.innerHTML = `
  .date-unavailable {
    background-color: #808080;
    border: 1px solid black;
    pointer-events: all;
    opacity: 0.5;
    cursor: not-allowed;
    color: black;
  }
`;
document.head.appendChild(style);


// Function to get the number of days in a month
function daysInMonth(iMonth, iYear) {
  return 32 - new Date(iYear, iMonth, 32).getDate();
}

// Call the showCalendar function initially to display the calendar
showCalendar(currentMonth, currentYear);

// Select a day in the calendar
function selectionerJour(e) {
  document.getElementsByClassName('table-calendar')[0].style.border = 'none';
  document.getElementById('CalendarVide').style.display = 'none';
  if (selectDaySelected(this)) return;
  if (selectDatDeb(this)) return;
  if (selectDatFin(this)) return;
}

// Deselect a day in the calendar
function selectDaySelected(elem) {
  if(dateDebut !== undefined || dateFin !== undefined) {
    if (
      dateDebut !== undefined &&
      dateFin === undefined &&
      parseInt(elem.getAttribute('data-date')) == dateDebut.getDate() &&
      parseInt(elem.getAttribute('data-year')) == dateDebut.getFullYear() &&
      parseInt(elem.getAttribute('data-month')) - 1 == dateDebut.getMonth()
    ) {
      dateDebut = undefined;
      dateFin = undefined;
      datesIn = [];
      showCalendar(currentMonth, currentYear);
      document.getElementById('formDateDeb').value = '';
      document.getElementById('formDateFin').value = '';
      return true;
    }
  }

  return false;
}

// Select a date debut
function selectDatDeb(elem) {
  if (dateDebut === undefined || dateFin !== undefined) {
    dateDebut = new Date(
      elem.getAttribute('data-year'),
      elem.getAttribute('data-month') - 1,
      elem.getAttribute('data-date')
    );

    dateFin = undefined;
    datesIn = [];
    showCalendar(currentMonth, currentYear);
    document.getElementById('formDateDeb').value = dateDebut.getFullYear() + "-" + (dateDebut.getMonth() + 1).toString().padStart(2, "0") + "-" + dateDebut.getDate();
    document.getElementById('formDateFin').value = '';
    return true;
  }
  return false;
}

// Select a date fin
function selectDatFin(elem) {
  if (dateDebut !== undefined && dateFin === undefined) {
    let proposedEndDate = new Date(
      elem.getAttribute('data-year'),
      elem.getAttribute('data-month') - 1,
      elem.getAttribute('data-date')
    );
    if (dateDebut < proposedEndDate) {
      // Vérifier s'il existe des dates indisponibles entre la date de début et la date de fin
      let isUnavailable = planningData.some(item => {
        let unavailableDate = new Date(item.unavailability_date);
        return unavailableDate > dateDebut && unavailableDate < proposedEndDate;
      });

      if (isUnavailable) {
        alert('Il existe une date indisponible entre la date de début et la date de fin.');
        // Réinitialiser la sélection
        dateDebut = undefined;
        dateFin = undefined;
        datesIn = [];
        showCalendar(currentMonth, currentYear);
        document.getElementById('formDateDeb').value = '';
        document.getElementById('formDateFin').value = '';
        return false;
      }

      dateFin = proposedEndDate;
      setSelectedInDates();
      showCalendar(currentMonth, currentYear);
      document.getElementById('formDateFin').value = dateFin.getFullYear() + "-" + (dateFin.getMonth() + 1).toString().padStart(2, "0") + "-" + dateFin.getDate();
    } else {
      dateFin = undefined;
    }
    return true;
  }
  return false;
}

function setSelectedInDates() {
  datesIn = [];
  let dateIn = new Date(dateDebut);
  dateIn.setDate(dateIn.getDate() + 1);

  while (dateIn < dateFin) {
    datesIn.push(new Date(dateIn));
    dateIn.setDate(dateIn.getDate() + 1);
  }
}
