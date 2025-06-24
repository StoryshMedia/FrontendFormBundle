<template>
  <label class="block">
    <span class="block text-sm font-medium text-dark">{{ $t(fieldPlaceholder) }}</span>
    <select
      class="border-slate-200 mt-3 w-full placeholder-gray-500 contrast-more:border-slate-400 contrast-more:placeholder-slate-500"
      :value="fieldValue"
      @change="setContent($event)"
    >
      <option
        style="color: #D1D5DB; opacity:.7"
        value=""
      >
        {{ $t('PLEASE_CHOOSE') }}
      </option>
      <option
        v-for="(value, valueIndex) in fieldConfig.values"
        :key="valueIndex"
        :value="value.value"
      >
        <span>
          {{ $t(value.title) }}
        </span>
      </option>
    </select>
  </label>
</template>
  
<script>
  
export default {
  name: "Select",
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
    setContent(content) {
      this.$emit('updateValue', content.target.value);
    }
  }
}
</script>