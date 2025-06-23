<template>
  <select
    class="form-select text-dark"
    :model="getFieldValue()"
    :disabled="isDisabled()"
    @change="setContent($event)"
  >
    <option value="">
      {{ $t('PLEASE_CHOOSE') }}
    </option>
    <option
      v-for="(form, formIndex) in formItems"
      :key="formIndex"
      :value="form.id"
      :selected="isSelected(form.id)"
    >
      <span>
        {{ $t(form.title) }}
      </span>
    </option>
  </select>
</template>
  
<script>
import ApiService from '@SmugAdministration/js/services/api/api.service';
import ValueService from '@SmugAdministration/js/services/value/value.service';
  
export default {
  name: "FormSelect",
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
      formItems: [],
      isLoading: false
    }
  },
  mounted() {
    this.getData();
  },
  methods: {
    getFieldValue() {
      return ValueService.getValue(this.fieldValue, this.fieldConfig);
    },
    setContent(content) {
      this.$emit('updateValue', content.target.value);
    },
    isSelected(value) {
      if (typeof this.fieldValue === 'string') {
        return value === this.fieldValue;
      }
  
      return value === this.getFieldValue();
    },
    getData() {
      this.isLoading = true;
      ApiService.get('/be/api/smug/frontendForm/form').then(result => {
        this.isLoading = false;
        this.formItems = result;
      });
    },
    isDisabled() {
      if (this.isLoading === true) {
        return true;
      }
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