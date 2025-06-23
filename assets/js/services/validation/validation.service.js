import TextService from '@SmugAdministration/js/services/text/text.service';

class ValidationService {
  validate(formData, fields) {
    return new Promise((resolve) => {
      let errors = [];
      let isValid = true;

      for (let i = 0; i <= Object.keys(fields).length - 1; i++) {
        const fieldData = this.validateField(fields[Object.keys(fields)[i]], formData, errors);

        formData = fieldData.formData;
        errors = fieldData.errors;
        if (isValid === true) {
          isValid = fieldData.isValid;
        }

        if (i === Object.keys(fields).length - 1) {
          resolve({
            isValid: isValid,
            formData: formData,
            errors: errors
          });
        }
      }


    });
  }
  validateField(field, formData, errors) {
    let isValid = true;
    if (field.children.length === 0) {
      errors[field.identifier] = {
        errors: []
      };
    } else {
      for (let j = 0; j <= field.children.length - 1; j++) {
        errors[field.children[j].identifier] = {
          errors: []
        };
      }
    }

    if (typeof formData[field.identifier] === 'undefined' && field.children.length === 0) {
      formData[field.identifier] = '';
    }

    if (field.required === true && formData[field.identifier] === '') {
      errors[field.identifier].errors.push({
        message: 'FIELD_IS_REQUIRED'
      });
      isValid = false;
    }

    for (const [key, value] of Object.entries(field.fieldConfiguration)) {
      if (key === 'pattern') {
        const pattern = new RegExp(value);
        pattern.max = 10;
        
        if (!pattern.test(formData[field.identifier])) {
          const accept = TextService.transformRegexToReadableExample(pattern);
          errors[field.identifier].errors.push({
            message: 'PATTERN_MISSMATCH',
            accept: accept
          });
          isValid = false;
        }   
      }
    }

    return {
      isValid: isValid,
      formData: formData,
      errors: errors
    }
  }
}
export default new ValidationService();