<template>
  <div class="grid grid-cols-4">
    <div
      v-for="(value, valueIndex) of fieldConfig.values"
      :key="valueIndex"
      class="flex items-center cursor-pointer"
      @click="setContent(value.value)"
    >
      <input
        :id="'radio-value-' + value.value"
        type="radio"
        class="cursor-pointer"
        :name="value.value"
        :value="value.value"
        :checked="isChecked(value.value)"
      >
      <label :for="'radio-value-' + value.value"><span
        class="m-3 font-medium cursor-pointer"
      >{{ $t(value.value) }}</span></label>
    </div>
  </div>
</template>
  
<script>

export default {
  name: "Radio",
  props: {
    editAllowed:{
      type: Boolean,
      required: true
    },
    fieldValue:{
      type: String,
      required: false,
      default: ''
    },
    baseId:{
      type: String,
      required: false,
      default: null
    },
    fieldConfig:{
      type: Object,
      required: false,
      default: () => ({})
    },
    fieldPlaceholder:{
      type: String,
      required: false,
      default: 'TEXT_PLACEHOLDER'
    }
  },
  data() {
    return {
      formValue: ''
    };
  },
  methods: {
    setContent(value) {
      this.formValue = value;
      this.$emit('updateValue', this.formValue);
    },
    isChecked(value) {
      return this.formValue === value;
    }
  }
}
</script>