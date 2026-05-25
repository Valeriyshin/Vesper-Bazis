<script>
export default {
  name: "Plan",
  props: {
    apartment: {
      type: Object,
      required: true
    },
  },
  computed: {
    plan() {
      const img = this.apartment.images?.find(image => image.typeCode === "1");
      if(!img) return null;
      return "https://bazis-online.kz/crmc/rest/prices/getImage?imageId=" + img.id;
    },
    blockNumber(){
      return this.apartment.blockName.split(" ")[1].trim()
    }
  },
};
</script>

<template>
  <li>
    <div class="_plan">
      <img v-if="plan" :src="plan" alt="">
    </div>
    <div class="_info">
      <div>№{{ apartment.number }}</div>
      <strong>Резиденция</strong>
      <div>{{ apartment.area }} м²</div>
      <strong>Площадь</strong>
      <div>{{ apartment.rooms }}</div>
      <strong>Комнат</strong>
      <div>{{ apartment.floor }}</div>
      <strong>Этаж</strong>
      <div>{{ blockNumber }}</div>
      <strong>Пятно</strong>
    </div>
  </li>
</template>

