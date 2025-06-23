<template>
  <div>
    <p
      v-for="(error, errorIndex) in fieldErrors"
      :key="errorIndex"
      class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1"
    >
      {{ $t(error.message) }} <span
        v-if="error.accept"
        class="pl-3"
      >{{ error.accept }}</span>
    </p>
  </div>
</template>
  
<script>
export default {
  name: "FieldError",
  props: {
    fieldErrors:{
      type: Object,
      required: false,
      default: () => ({})
    }
  }
}
</script>