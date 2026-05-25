import {lenis} from "../../enter/animation.js";

const bodyAClass = "-modal";
const modalAClass = "-active";

let modals = document.querySelectorAll(".modal");
const openTriggers = document.querySelectorAll("[data-modal]");
const closeTriggers = document.querySelectorAll("[data-modal-close]");

function openModal(modal) {
  document.body.classList.add(bodyAClass);
  modal.classList.add(modalAClass);
}

function closeModal(modal = null) {
  if (!modal) {
    modals = document.querySelectorAll(".modal");
    modals.forEach(modal => modal.classList.remove(modalAClass));
  } else {
    modal.classList.remove(modalAClass);
  }
  document.body.classList.remove(bodyAClass);
}

modals.forEach(modal => {
  modal.querySelector("._body").addEventListener("click", e => {
    e.stopPropagation();
  });
});

openTriggers.forEach(trigger => {
  trigger.addEventListener("click", e => {
    e.preventDefault();
    openModal(document.querySelector(trigger.dataset.modal));
    lenis?.stop();
  });
});

closeTriggers.forEach(trigger => {
  trigger.addEventListener("click", e => {
    e.preventDefault();
    let el = trigger.dataset.modalClose;
    if (el) el = document.querySelector(el);
    if (el) closeModal(el);
    else closeModal();
    lenis?.start();
  });
});

function okAlert() {
  openModal(document.querySelector("#ok-modal"));
}

function errAlert() {
  openModal(document.querySelector("#err-modal"));
}

export {openModal, closeModal, bodyAClass, okAlert, errAlert};
