const rules = {
  required: value => !!value || 'Aquest camp es obligatori!',
  minLength: (value, length) => (value && value.length >= length) || `Aquest camp ha de tenir com a minim ${length} caracteres!`,
  maxLength: (value, length) => (value && value.length <= length) || `Aquest camp ha de tenir com a maxim ${length} caracteres!`,
  email: value => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value) || 'Aquest camp ha de ser un email valid!',
  phone: value => /^\(\d{2}\)\d{4,5}\-\d{4}$/.test(value) || 'Telefon inválido!',
  number: value => /^\d+$/.test(value) || 'Aquest camp ha de ser numeric!',
}

export default rules
