<template>
  <a-form layout="inline" :form="form" @submit="handleSubmit">
    <a-form-item label="email" :validate-status="emailError() ? 'error' : ''" :help="emailError() || ''">
      <a-input placeholder="user@genesis.com.mt"
        v-decorator="[
          'email',
          { 
            rules: [
            {
                type: 'email',
                message: 'The input is not valid email!',
            }, 
            { 
              required: true,
              message: 'Please enter your email!' 
            }
          ]},
        ]"
        >
        <a-icon slot="prefix" type="user" style="color:rgba(0,0,0,.25)" />
      </a-input>
    </a-form-item>
    <a-form-item :validate-status="passwordError() ? 'error' : ''" :help="passwordError() || ''">
      <a-input
        v-decorator="[
          'password',
          { rules: [{ required: true, message: 'Please input your Password!' }] },
        ]"
        type="password"
        placeholder="Password"
      >
        <a-icon slot="prefix" type="lock" style="color:rgba(0,0,0,.25)" />
      </a-input>
    </a-form-item>
    <a-form-item>
      <a-button type="primary" html-type="submit" :disabled="hasErrors(form.getFieldsError())">
        Log in
      </a-button>
    </a-form-item>
  </a-form>
</template>

<script>
import { mapState } from "vuex";
import { LOGIN } from "@/store/actions.type";

function hasErrors(fieldsError) {
  return Object.keys(fieldsError).some(field => fieldsError[field]);
}
export default {
  data() {
    return {
      hasErrors,
      form: this.$form.createForm(this, { name: 'horizontal_login' }),
    };
  },
  mounted() {
    this.$nextTick(() => {
      this.form.validateFields();
    });
  },
  computed: {
    ...mapState({
      errors: state => state.auth.errors
    })
  },
  methods: {
    emailError() {
      const { getFieldError, isFieldTouched } = this.form;
      return (isFieldTouched('email') && getFieldError('email'));
    },
    passwordError() {
      const { getFieldError, isFieldTouched } = this.form;
      return (isFieldTouched('password') && getFieldError('password')) || this.errors;
    },
    handleSubmit(e) {
      e.preventDefault();
      this.form.validateFields((err, values) => {
        if (!err) {
          this.$store
            .dispatch(LOGIN, { "username": values.email, "password": values.password })
            // .then(() => this.$router.push({ name: "home" }));
        }
      });
    },
  },
};
</script>
<style>
.login-box .ant-form-explain {
    font-size: xx-small;
}
</style>
