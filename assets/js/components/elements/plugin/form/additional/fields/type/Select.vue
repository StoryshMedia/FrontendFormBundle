<template>
  <select
    class="w-full input rounded-3xl shadow-xl border-gray"
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