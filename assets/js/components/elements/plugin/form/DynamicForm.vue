<template>
  <div
    id="dynamicForm"
    class="mx-auto px-4 min-h-56"
  >
    <form
      @submit="submitForm($event)"
    >
      <div
        v-if="showSuccess === true"
        class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md fixed top-5 right-0"
        role="alert"
      >
        <div class="flex">
          <div class="py-1">
            <svg
              class="fill-current h-6 w-6 text-teal-500 mr-4"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
            ><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" /></svg>
          </div>
          <div>
            <p class="font-bold">
              {{ $t('SUCCESS') }}
            </p>
            <p class="text-sm">
              {{ $t(successText) }}
            </p>
          </div>
        </div>
      </div>
      <p
        v-if="showError === true"
        class="text-lg font-semibold mb-4 text-danger"
      >
        <span>
          {{ $t(errorText) }}
        </span>
      </p>
      <div
        v-for="(field, fieldIndex) of fields"
        :key="fieldIndex"
      >
        <div
          v-if="field.type !== 'row'"
          class="my-5"
        >
          <field
            :field-string="field.type"
            :field-config="field.fieldConfiguration"
            :field-placeholder="field.label"
            :field-identifier="field.identifier"
            :item-value="getFieldValue(field.identifier)"
            @update-value="setValueChange($event, field.identifier)"
          />
          <field-error
            v-if="showFieldErrors"
            :field-errors="getFieldErrors(field.identifier)"
          />
        </div>
        <div
          v-else
          class="grid gap-5 my-5"
          :class="getRowGridClass(field)"
        >
          <div
            v-for="(child, childIndex) of field.children"
            :key="childIndex"
          >
            <field
              :field-string="child.type"
              :field-config="child.fieldConfiguration"
              :field-placeholder="child.label"
              :field-identifier="child.identifier"
              :item-value="getFieldValue(child.identifier)"
              @update-value="setValueChange($event, child.identifier)"
            />
            <field-error
              v-if="showFieldErrors"
              :field-errors="getFieldErrors(child.identifier)"
            />
          </div>
        </div>
        <div
          class="my-5"
        >
          <field
            :field-string="'hidden'"
            :field-config="{}"
            :field-placeholder="'FAX'"
            @update-value="setValueChange($event, 'fax')"
          />
        </div>
      </div>
      <div class="text-center mt-6">
        <button
          class="outline-link outline-link-primary loading-spinner-outline-link"
          style="transition: all 0.15s ease 0s;"
        >
          <span v-if="isLoading === true">
            <svg
              role="status"
              class="inline w-4 h-4 text-primary animate-spin"
              viewBox="0 0 100 101"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                fill="#cd9144"
              />
              <path
                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                fill="#faf4ec"
              />
            </svg>
          </span>
          <span v-else>
            {{ $t(buttonText) }}
          </span>
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import { defineAsyncComponent } from 'vue';
import ApiService from '@SmugAdministration/js/services/api/api.service';
import ValidationService from '../../../../services/validation/validation.service';
const Field = defineAsyncComponent(() =>
  import("./additional/fields/Field.vue" /* webpackChunkName: "field" */)
);
const FieldError = defineAsyncComponent(() =>
  import("./additional/fields/error/FieldError.vue" /* webpackChunkName: "form-field-error" */)
);

export default {
  name: "DynamicForm",
  components: {
    Field,
    FieldError
  },
  inject: ['dataset'],
  data() {
    return {
      isLoading: false,
      showSuccess: false,
      showFieldErrors: false,
      showError: false,
      successText: '',
      errorText: '',
      fieldErrors: [],
      fields: [],
      buttonText: '',
      endpoint: '',
      form: {},
      formData: {}
    };
  },
  created() {
    const props = JSON.parse(this.dataset.props);
    this.fields = props.form.fields ?? [];
    for (let i = 0; i <= this.fields.length - 1; i++) {
      const children = this.fields[i].children ?? [];

      if (children.length > 0) {
        for (let j = 0; j <= this.fields[i].children.length - 1; j++) {
          this.formData[this.fields[i].children[j].identifier] = '';
        }
      } else {
        this.formData[this.fields[i].identifier] = '';
      }
    }
    this.form = props.form ?? {};
    this.buttonText = props.buttonText ?? 'SEND';
    this.successText = props.successText ?? 'SUCCESS_FORM_TEXT';
    this.endpoint = props.apiEndpoint ?? '';
  },
  methods: {
    getRowGridClass(field) {
      return 'grid-cols-' + field.children.length;
    },
    getFieldValue(identifier) {
      return this.formData[identifier];
    },
    getFieldErrors(identifier) {
      const fieldErrors = this.fieldErrors[identifier] ?? [];

      if (!fieldErrors || !fieldErrors.errors) {
        return [];
      }

      return fieldErrors.errors;
    },
    submitForm(event) {
      event.preventDefault();
      if (this.endpoint !== '') {
        this.fieldErrors = [];
        this.isLoading = true;
        this.showSuccess = false;
        this.showError = false;
        this.showFieldErrors = false;

        ValidationService.validate(this.formData, this.fields).then(validationResult => {
          if (validationResult.isValid === true) {
            validationResult.formData['form'] = {id: this.form.id};
            ApiService.post(this.endpoint, validationResult.formData, false).then(result => {
              this.isLoading = false;
              if (result.id) {
                for (const [key, value] of Object.entries(this.formData)) {
                  this.formData[key] = '';
                }
                this.showSuccess = true;
              } else {
                this.errorText = result.message;
                this.showError = true;
              }

              setTimeout(() => {
                this.showSuccess = false;
                this.showError = false;
              }, "5000");
            });
          } else {
            this.isLoading = false;
            this.showFieldErrors = true;
            this.fieldErrors = validationResult.errors;
          }
        });
      } else {
        this.errorText = 'NO_ENDPOINT_GIVEN_TEXT';
        this.showError = true;
      }
    },
    setValueChange(event, identifier) {
      this.formData[identifier] = event;
    }
  }
}
</script>
