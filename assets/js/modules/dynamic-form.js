import DynamicForm from '../components/elements/plugin/form/DynamicForm.vue';
import VueModule from '@core/js/modules/vue-module.js';

VueModule.observeAndMount({
  identifier: 'dynamic-form',
  component: DynamicForm,
  options: {useStore: true, provideDataset: true, identifier: 'dynamic-form'}
}).then(({ app, section }) => {
  console.log('Vue erfolgreich gemountet auf:', section);
}).catch(console.error);