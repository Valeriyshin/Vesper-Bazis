<script>
import {IMaskComponent} from "vue-imask";
import axios from "axios";
import {errAlert, okAlert} from "../modals/index.js";

export default {
  name: "Modal",
  components: {
    "imask-input": IMaskComponent
  },
  props: {
    plan: {
      type: Object,
      required: true
    },
  },
  data() {
    return {
      name: null,
      phone: null,
      valid: {
        name: true,
        phone: true,
        total: false
      },
      utmUrlParams: {},
      sending: false,
    };
  },
  computed: {
    big() {
      return "https://bazis-online.kz/crmc/rest/prices/getImage?imageId=" + this.plan.images[0]?.id;
    },
    flat() {
      return "https://bazis-online.kz/crmc/rest/prices/getImage?imageId=" + this.plan.images[1]?.id;
    },
    block() {
      return "https://bazis-online.kz/crmc/rest/prices/getImage?imageId=" + this.plan.images[2]?.id;
    },
    dlLink() {
      return "https://bazis-online.kz/crmc/rest/prices/getImage?imageId=" + this.plan.images[3]?.id;
    },
    wzLink() {
      const text = `Ваша ${this.plan.rooms}-комнатная резиденция ${this.plan.area}м² в Vesper\n`
        + "https://bazis-online.kz/crmc/rest/prices/getImage?imageId=" + this.plan.images[3]?.id;
      return "https://api.whatsapp.com/send?text=" + encodeURIComponent(text);
    },
    tgLink() {
      const text = `Ваша ${this.plan.rooms}-комнатная резиденция ${this.plan.area}м² в Vesper`;
      return "https://t.me/share/url?url="
        + encodeURIComponent("https://bazis-online.kz/crmc/rest/prices/getImage?imageId=" + this.plan.images[3]?.id)
        + "&text="
        + encodeURIComponent(text);
    },
    blockNumber(){
      return this.plan.blockName.split(" ")[1].trim()
    }
  },
  watch: {
    phone() {
      this.validate();
    }
  },
  methods: {
    getQueryParams() {
      const params = new URLSearchParams(window.location.search);
      this.utmUrlParams = {};
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
        if (p = params.get(item)) this.utmUrlParams[item] = p;
      });
    },
    normalizePhone(phone) {
      const digits = phone.replace(/\D/g, "");
      if (digits.length !== 11 || !digits.startsWith("7")) {
        return null;
      }
      const code = digits.slice(1, 4);
      const part1 = digits.slice(4, 7);
      const part2 = digits.slice(7, 9);
      const part3 = digits.slice(9, 11);
      return `+7 ${code} ${part1} ${part2} ${part3}`;
    },
    sendData() {
      if (this.sending) return;
      this.getQueryParams();
      const dataForm = {
        name: this.name,
        phone: this.normalizePhone(this.phone),
        utmUrlParams: this.utmUrlParams
      };
      const token = document.querySelector("meta[name=\"csrf-token\"]")?.getAttribute("content");
      if (token) {
        axios.defaults.headers.common["X-CSRF-TOKEN"] = token;
      }
      axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
      this.sending = true;
      axios.post("/flat", dataForm)
        .then(okAlert)
        .catch(err=>{
          console.log(err);
          errAlert();
        })
        .finally(() => {
          this.sending = false;
        });
    },
    formatWithDots(n) {
      if (!n) return "0";
      return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },
    lead() {
      this.validate();
      if (!this.valid.total) return;
      this.sendData();
    },
    validate() {
      this.valid.name = !!this.name?.length;
      this.valid.total = this.valid.name;
      if (!this.phone?.length) {
        this.valid.phone = true;
        this.valid.total = false;
      } else {
        this.valid.phone = /^\+7 \(7\d{2}\) \d{3}-\d{2}-\d{2}$/.test(this.phone);
        this.valid.total &= this.valid.phone;
      }
    },
    close(){
      this.$emit('close');
    }
  },
};
</script>

<template>
  <div ref="modal" class="modal -active" id="plan-modal" @click="close">
    <div class="_body" @click.stop  @wheel.stop @touchmove.stop>
      <button class="_close close-modal" @click="close"></button>
      <h1>Residence {{ plan.apartmentCode }}</h1>
      <div class="_split">
        <div class="_preview">
          <div class="main">
            <img :src="big"
                 alt="">
          </div>
          <div class="sub">
            <img :src="flat"
                 alt="">
          </div>
          <div class="sub">
            <img :src="block"
                 alt="">
          </div>
        </div>
        <div class="_info">
          <table>
            <tbody>
            <tr>
              <th>Площадь</th>
              <td>{{ plan.area }} м²</td>
            </tr>
            <tr>
              <th>Floor</th>
              <td>{{ plan.floor }}</td>
            </tr>
            <tr>
              <th>Резиденция №</th>
              <td>{{ plan.apartmentCode }}</td>
            </tr>
            <tr>
              <th>Пятно</th>
              <td>{{ blockNumber }}</td>
            </tr>
            <tr>
              <th>Цена</th>
              <td>{{ formatWithDots(plan.totalPrice) }} тг</td>
            </tr>
            </tbody>
          </table>
          <div class="btns">
            <a :href="dlLink" target="_blank">скачать</a>
            <button>отправить на почту</button>
          </div>
          <div class="share">
            <label>Поделиться</label>
            <a :href="wzLink" target="_blank" title="отправить в WhatsApp" class="wa"></a>
            <a :href="tgLink" target="_blank" title="отправить в Telegram" class="tg"></a>
          </div>
          <form action="#" @submit.prevent="lead">
            <h3>получите персональное предложение</h3>
            <h4>Оставьте заявку для индивидуальной консультации</h4>
            <p class="-dt">
              Нажимая на кнопку «заказать звонок» вы принимаете
              <a href="https://sales.bazis.kz/privacy-policy" target="_blank">условия</a>
              обработки персональных данных
            </p>
            <input
              :class="{i:!valid.name}"
              @input="validate" name="name" type="text" placeholder="Имя" v-model="name" required />
            <imask-input
              :class="{i:!valid.phone}"
              v-model:masked="phone"
              mask="+{7} (700) 000-00-00"
              placeholder="+7 ("
              name="phone"
              pattern="\+7 \(7\d{2}\) \d{3}-\d{2}-\d{2}"
              required
            />
            <button type="submit" :disabled="!valid.total">
              Заказать звонок
            </button>
            <p class="-mob">
              Нажимая на кнопку «заказать звонок» вы принимаете
              <a href="https://sales.bazis.kz/privacy-policy" target="_blank">условия</a>
              обработки персональных данных
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
