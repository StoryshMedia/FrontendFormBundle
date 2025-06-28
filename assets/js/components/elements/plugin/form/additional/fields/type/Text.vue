<template>
  <label class="block">
    <span class="block text-sm font-medium text-dark">{{ $t(fieldPlaceholder) }}</span>
    <input
      :id="fieldIdentifier"
      type="text"
      class="border-slate-200 mt-3 w-full placeholder-gray-500 contrast-more:border-slate-400 contrast-more:placeholder-slate-500"
      :name="fieldIdentifier"
      :value="getValue()"
      :class="fieldConfig.classes ?? ''"
      :placeholder="$t(fieldPlaceholder)"
      @change="setContent($event)"
    >
  </label>
</template>
  
<script>
import ValueService from '@SmugAdministration/js/services/value/value.service';
  
export default {
  name: "Text",
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
    },
    fieldIdentifier:{
      type: String,
      required: false,
      default: ''
    }
  },
  methods: {
    getValue() {
      return ValueService.getValue(this.fieldValue, this.fieldConfig);
    },
    setContent(content) {
      this.$emit('updateValue', content.target.value);
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