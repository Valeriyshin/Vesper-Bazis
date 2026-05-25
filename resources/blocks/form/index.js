import axios from "axios";
import IMask from 'imask';
import {errAlert, okAlert} from "../modals/index.js";

let sending = false;

function getQueryParams() {
  const params = new URLSearchParams(window.location.search);
  const utmUrlParams = {};
  const utm = [
    "utm_source",
    "utm_medium",
    "utm_campaign",
    "utm_content",
    "utm_term",
  ];
  let p;
  utm.forEach(item => {
    // noinspection JSAssignmentUsedAsCondition
    if (p = params.get(item)) utmUrlParams[item] = p;
  });
  return utmUrlParams;
}

function normalizePhone(phone) {
  const digits = phone.replace(/\D/g, "");
  if (digits.length !== 11 || !digits.startsWith("7")) {
    return null;
  }
  const code = digits.slice(1, 4);
  const part1 = digits.slice(4, 7);
  const part2 = digits.slice(7, 9);
  const part3 = digits.slice(9, 11);
  return `+7 ${code} ${part1} ${part2} ${part3}`;
}

function send(form) {
  if (sending) return;
  let fd = new FormData(form);
  for (let pair of fd.entries()) {
    console.log(pair[0]+ ', ' + pair[1]);
  }
  const dataForm = {
    name: fd.get("name"),
    phone: normalizePhone(fd.get("phone")),
    utmUrlParams: getQueryParams()
  };
  sending = true;
  axios.post("/flat", dataForm)
    .then(() => {
      okAlert();
    })
    .catch(err => {
      console.log(err);
      errAlert();
    })
    .finally(() => {
      sending = false;
    });
}

const normalizePhoneMask = (value, noSlice=false) => {
  // console.log('normalizePhone');
  let digits = value.replace(/\D/g, '');
  // console.log(digits);
  if (digits.length <10) {
    // console.log('less than 10, return');
    return digits;
  }
  if (digits.startsWith('8')) {
    // console.log('replace first 8 to 7');
    digits = '7' + digits.slice(1);
  }
  // if (digits.startsWith('77')) {
  //   //console.log('replace first 77 to 7');
  //   digits = '7' + digits.slice(1);
  // }
  if (!noSlice) {
    // console.log('no noSlice');
    // console.log(digits.length);
    if (digits.length>=11) digits = digits.slice(2);
    else if (digits.length>=10) digits = digits.slice(1);
    if (digits[0]==='7') {
      // console.log('add 77');
      digits = '77' + digits;
    }
    // console.log('result:');
    // console.log(digits);
  }
  return digits;
};

document.querySelectorAll('.simple-form').forEach(form => {
  form.addEventListener('submit', (e) => {
    e.preventDefault();
    send(form);
  });

  const tel = form.querySelector('input[name="phone"]');

  // eslint-disable-next-line new-cap
  const mask = IMask(tel, {
    mask: '+{7} (700) 000-00-00',
    lazy: true,
    placeholderChar: ' ',
    prepare: (str) => normalizePhoneMask(str),
    overwrite: true,
  });

// Обрабатываем автозаполнение браузера
  tel.addEventListener('change', () => {
    const rawValue = tel.value;
    tel.value = normalizePhoneMask(rawValue, true); // Нормализация
    mask.updateValue(); // Обновляем маску, чтобы форматировалось
  });

  tel.addEventListener('input', () => {
    mask.updateValue();
  });
})
