<template>
  <div class="grid grid-cols-4">
    <div
      v-for="(value, valueIndex) of fieldConfig.values"
      :key="valueIndex"
      class="flex items-center cursor-pointer"
      @click="setContent(value.value)"
    >
      <input
        :id="'check-value-' + value.value"
        class="border-gray cursor-pointer"
        type="checkbox"
        :checked="isChecked(value.value)"
        :model="value.value"
      >
      <label
        class="checkbox-label cursor-pointer"
        :class="{ active: isChecked(value.value) }"
        :for="'check-value-' + value.value"
      >
        <span
          class="m-3 font-medium"
        >{{ $t(value.value) }}</span>
      </label>
    </div>
  </div>
</template>
  
<script>
import ArrayService from '@SmugAdministration/js/services/array/array.service';

export default {
  name: "Checkbox",
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
      selectValues: []
    };
  },
  methods: {
    setContent(value) {
      const position = ArrayService.getIndexInArray(this.selectValues, value);

      if (position < 0) {
        this.selectValues.push(value);
      } else {
        this.selectValues.splice(position, 1);
      }
      this.$emit('updateValue', this.selectValues.toString());
    },
    isChecked(value) {
      return (ArrayService.getIndexInArray(this.selectValues, value) >= 0);
    }
  }
}
</script>