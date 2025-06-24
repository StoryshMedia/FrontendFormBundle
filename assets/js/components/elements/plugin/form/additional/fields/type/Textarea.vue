<template>
  <label class="block">
    <span class="block text-sm font-medium text-dark">{{ $t(fieldPlaceholder) }}</span>
    <textarea
      :id="fieldIdentifier"
      type="text"
      :placeholder="$t(fieldPlaceholder)"
      class="border-slate-200 mt-3 w-full placeholder-gray-500 contrast-more:border-slate-400 contrast-more:placeholder-slate-500"
      :class="fieldConfig.classes ?? ''"
      :rows="fieldConfig.rows ?? 5"
      :value="getValue()"
      @change="setContent($event)"
    />
  </label>
</template>
  
<script>
import ValueService from '@SmugAdministration/js/services/value/value.service';
  
export default {
  name: "Textarea",
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
    }
  }
}
</script>