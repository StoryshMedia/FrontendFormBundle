<template>
  <input
    type="number"
    :placeholder="$t(fieldPlaceholder)"
    class="w-full input rounded-3xl shadow-xl border-gray"
    :value="getValue()"
    :min="getMin()"
    :max="getMax()"
    :class="fieldConfig.classes ?? ''"
    @change="setContent($event)"
  >
</template>
  
<script>
import ValueService from '@SmugAdministration/js/services/value/value.service';
  
export default {
  name: "Numeric",
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
  methods: {
    getValue() {
      return ValueService.getValue(this.fieldValue, this.fieldConfig);
    },
    setContent(content) {
      this.$emit('updateValue', content.target.value);
    },
    getMin() {
      return this.fieldConfig.min ?? 0;
    },
    getMax() {
      return this.fieldConfig.max ?? '';
    },
    isDisabled() {
      if (this.editAllowed === false) {
        return true;
      }
      if (this.fieldConfig.disabled && this.fieldConfig.disabled === true) {
        return true;
      }
    }
  }
}
</script>