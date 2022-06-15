<template>

  <div class="row">

    <!-- Brand Box -->
    <div class="col-sm-6 brand" style="z-index:10">

      <img style=" width: 100%;" src="img/banner log in 2.jpg">
    </div>
    <!-- Form Box -->
    <div class="col-sm-6 form">

      <!-- Login Form -->
      <div class="login form-peice">
        <form @submit.prevent="attemptLogin">

          <div class="form-group">
            <label for="loginemail">Email Adderss</label>
            <input v-model="login.email" type="email" name="email" id="loginemail" required>
          </div>

          <div class="form-group">
            <label for="loginPassword">Password</label>
            <input v-model="login.password" type="password" name="password" id="loginPassword" required>
          </div>

          <div class="CTA">
            <input type="submit" value="Login">
            <a href="#" class="switch">I'm New</a>
          </div>
        </form>
      </div><!-- End Login Form -->

      <!-- Signup Form -->
      <div class="signup form-peice switched">
        <form @submit.prevent="attemptRegister">

          <div class="dropdown">
            <select v-model="register.type" class="btn btn-secondary dropdown-toggle" name="type" aria-label="Default select example">
              <option selected value="user">Register as Student</option>
              <option value="adviser">Register as Teacher</option>
            </select>
          </div>

          <div class="form-group">
            <label for="name">Full Name</label>
            <input v-model="register.name" type="text" name="name" id="name" class="name">
            <span class="error"></span>
          </div>
          <div class="form-group">
            <label for="email">Email Adderss</label>
            <input v-model="register.emailAddress" type="email" name="emailAdress" id="email" class="email">
            <span class="error"></span>
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <input v-model="register.password" type="password" name="password" id="password" class="pass">
            <span class="error"></span>
          </div>

          <div class="form-group">
            <label for="password">Confirm Password</label>
            <input v-model="register.password_confirmation" type="password" name="password" id="password" class="pass">
            <span class="error"></span>
          </div>

          <div class="CTA">
            <input type="submit" value="Signup Now" id="submit">
            <a href="#" class="switch">I have an account</a>
          </div>
        </form>
      </div><!-- End Signup Form -->
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      login: {
        email: "",
        password: "",
      },
      register: {
        type: "user",
        name: "",
        emailAddress: "",
        password: "",
        password_confirmation: "",
      },
    };
  },
  methods: {
    async attemptRegister() {
      if (this.register.password.length == 0) {
        return this.$Swal.fire(
          "Warning",
          "Please specify a password",
          "warning"
        );
      }
      if (
        this.register.password_confirmation != this.register.password &&
        this.register.password.length > 0
      ) {
        return this.$Swal.fire("Warning", "Password not match", "warning");
      }
      try {
        let data = await axios.post("/register", this.register);
        if (!data.data.success) {
          this.$Swal.fire("Warning", data.data.message, "warning");
          return;
        }
        location.href = "/";
      } catch (e) {
        console.log(e);
      }
    },
    async attemptLogin() {
      try {
        let data = await axios.post("/login", this.login);
        if (!data.data.success) {
          this.$Swal.fire("Warning", data.data.message, "warning");
          return;
        }
        location.href = "/";
      } catch (e) {
        console.log(e);
      }
    },
  },
};
</script>

<style>
</style>
