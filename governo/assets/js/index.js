const btn_menu = document.querySelector(".btn-menu");
const side_bar = document.querySelector(".sidebar");

btn_menu.addEventListener("click", function () {
  side_bar.classList.toggle("expand");
  changebtn();
});

function changebtn() {
  if (side_bar.classList.contains("expand")) {
    btn_menu.classList.replace("bx-menu", "bx-menu-alt-right");
  } else {
    btn_menu.classList.replace("bx-menu-alt-right", "bx-menu");
  }
}

const btn_theme = document.querySelector(".theme-btn");
const theme_ball = document.querySelector(".theme-ball");

const localData = localStorage.getItem("theme");

if (localData == null) {
  localStorage.setItem("theme", "light");
}

if (localData == "dark") {
  document.body.classList.add("dark-mode");
  document.querySelector('.theme-ball').textContent = "dark_mode";
} else if (localData == "light") {
  document.body.classList.remove("dark-mode");
  document.querySelector('.theme-ball').textContent = "light_mode";
}

btn_theme.addEventListener("click", function () {
  document.body.classList.toggle("dark-mode");

  theme_ball.classList.toggle("dark");
  if (document.body.classList.contains("dark-mode")) {
    localStorage.setItem("theme", "dark");
    document.querySelector('.theme-ball').textContent = "dark_mode";
  } else {
    localStorage.setItem("theme", "light");
    document.querySelector('.theme-ball').textContent = "light_mode";
  }
});

// CALENDÁRIO

let calendar = document.querySelector('.calendar');

const month_names = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

isLeapYear = (year) => {
    return (year % 4 === 0 && year % 100 !== 0) || (year % 100 === 0 && year % 400 === 0);
}

getFebDays = (year) => {
    return isLeapYear(year) ? 29 : 28;
}

let selectedDay = null;
let currentDay = null;
let currentMonth = null;
let currentYear = null;

generateCalendar = (month, year) => {
    let calendar_days = calendar.querySelector('.calendar-days');
    let calendar_header_year = calendar.querySelector('#year');

    let days_of_month = [31, getFebDays(year), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

    calendar_days.innerHTML = '';

    let currDate = new Date();
    if (!month) month = currDate.getMonth();
    if (!year) year = currDate.getFullYear();

    currentDay = currDate.getDate();
    currentMonth = month;
    currentYear = year;

    let curr_month = `${month_names[month]}`;
    month_picker.innerHTML = curr_month;
    calendar_header_year.innerHTML = year;

    // get first day of month
    let first_day = new Date(year, month, 1);

    for (let i = 0; i <= days_of_month[month] + first_day.getDay() - 1; i++) {
        let day = document.createElement('div');
        if (i >= first_day.getDay()) {
            day.classList.add('calendar-day-hover');
            day.innerHTML = i - first_day.getDay() + 1;
            day.innerHTML += `<span></span><span></span><span></span><span></span>`;
            if (i - first_day.getDay() + 1 === currDate.getDate() && year === currDate.getFullYear() && month === currDate.getMonth()) {
              day.classList.add('curr-date');
              selectedDay = currDate.getDate();
          }
            day.addEventListener('click', () => {
                selectedDay = i - first_day.getDay() + 1;
                updatePresentDay();
                updateDiaSelecionado();
            });
        }
        calendar_days.appendChild(day);
    }

    updatePresentDay();
    updateDiaSelecionado();
};

let month_list = calendar.querySelector('.month-list');

month_names.forEach((e, index) => {
    let month = document.createElement('div');
    month.innerHTML = `<div data-month="${index}">${e}</div>`;
    month.querySelector('div').addEventListener('click', () => {
        month_list.classList.remove('show');
        curr_month.value = index;
        month_picker.innerHTML = e;
        generateCalendar(index, curr_year.value);
    });
    month_list.appendChild(month);
});

let month_picker = calendar.querySelector('#month-picker');

month_picker.addEventListener('click', () => {
    month_list.classList.add('show');
});

let currDate = new Date();

let curr_month = { value: currDate.getMonth() };
let curr_year = { value: currDate.getFullYear() };

generateCalendar(curr_month.value, curr_year.value);

document.querySelector('#prev-year').addEventListener('click', () => {
    --curr_year.value;
    generateCalendar(curr_month.value, curr_year.value);
});

document.querySelector('#next-year').addEventListener('click', () => {
    ++curr_year.value;
    generateCalendar(curr_month.value, curr_year.value);
});



function updatePresentDay() {
  const dateItems = document.querySelectorAll(".calendar-day-hover");
  dateItems.forEach(item => {
    item.classList.remove("selected");
    const day = parseInt(item.textContent);
    if (day === selectedDay && currentMonth === curr_month.value && currentYear === curr_year.value && !item.classList.contains("curr-date")) {
        item.classList.add("selected");
    }
  });
}

function formatNumberWithZero(number) {
  return number < 10 ? '0' + number : number.toString();
}

function updateDiaSelecionado() {
  const diaSelecionado = document.querySelector(".dia-selecionado");
  diaSelecionado.textContent = selectedDay + " de " + month_names[curr_month.value] + " de " + curr_year.value;

  const agendadosDiv = document.getElementById("agendadosDiv");
  
  const formattedMonth = formatNumberWithZero(curr_month.value + 1);
  const formattedDay = formatNumberWithZero(selectedDay);
  const selectedDate = curr_year.value + "-" + formattedMonth + "-" + formattedDay;

  const xhr = new XMLHttpRequest();
  xhr.open("GET", "./backend/code.php?selectedDate=" + selectedDate, true);
  xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
          agendadosDiv.innerHTML = xhr.responseText;
      }
  };
  xhr.send();
}


function formatarInput(input) {
  // Remove qualquer formatação existente (como R$) e espaços em branco
  var valor = input.value.replace(/\D/g, '');

  // Adiciona a formatação desejada (R$) e separador de milhar (.)
  valor = 'R$ ' + valor.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');

  // Define o valor formatado no campo de entrada
  input.value = valor;
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

const addEventBtn = document.querySelector(".add-event"),

      addEventWrapper = document.querySelector(".add-event-wrapper");

//function to add event
addEventBtn.addEventListener("click", () => {
  addEventWrapper.classList.toggle("active");
});

// addEventCloseBtn.addEventListener("click", () => {
//   addEventWrapper.classList.remove("active");
// });

document.addEventListener("click", (e) => {
  if (e.target !== addEventBtn && !addEventWrapper.contains(e.target)) {
    addEventWrapper.classList.remove("active");
  }
});


/*=============== MODAL ===============*/

const modal = document.getElementById('modal');
const modalCloses = document.querySelectorAll('.habilidade__modal-close');
const fornecedorSelect = document.getElementById('fornecedorSelect');

// Função para exibir o modal
function exibirModal() {
    modal.classList.add('active-modal');
}

// Função para fechar o modal
function fecharModal() {
    modal.classList.remove('active-modal');
}

// Ouvinte de mudança no elemento select
fornecedorSelect.addEventListener('change', function() {
    // Verificar se a opção selecionada é "add"
    if (fornecedorSelect.value === 'add') {
        exibirModal();
    } else {
        fecharModal();
    }
});

// Anexar ouvintes de eventos aos botões de fechar o modal
modalCloses.forEach(function(modalClose) {
    modalClose.addEventListener('click', fecharModal);
});

/////////////////////////////////////////////////////////////////////////////////

function toggleOptions() {
  var customSelect = document.querySelector('.custom-select');
  customSelect.classList.toggle('open');
}

function toggleOptionsEspecie() {
  var customSelect = document.querySelector('.custom-select_especie');
  customSelect.classList.toggle('open');
}

function toggleOptionsMedicamentos() {
  var customSelect = document.querySelector('.custom-select_medicamentos');
  customSelect.classList.toggle('open');
}

