<template lang="">
    <div class="row d-flex justify-content-center " >
        <div class="authentication-wrapper authentication-basic container-p-y col-md-4">
    <div class="authentication-inner">
      <!-- Register -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="index.html" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">


</span>
              <span class="app-brand-text demo text-body fw-bold">MiniPOS 17</span>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-2">ສະບາຍດີ! 👋</h4>
          <p class="mb-4">ກະລຸນາເຂົ້າສູ່ລະບົບ</p>
          {{ UserLogin }}
          
            <div class="mb-3">
              <label for="email" class="form-label fs-6">ອີເມວລ໌:</label>
              <input type="text" class="form-control" v-model="UserLogin.email" id="email" name="email-username" placeholder="..." autofocus="">
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label fs-6" for="password">ລະຫັດຜ່ານ:</label>
                
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" v-model="UserLogin.password" class="form-control" name="password" placeholder="············" aria-describedby="password">
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>

            <div class="alert alert-warning" v-if="text_error_email || text_error_password || text_error_login" role="alert">
                {{text_error_email}} {{text_error_password}} {{ text_error_login }}
            </div>
           
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" @click="Login" :disabled="CheckForm" >ເຂົ້າສູ່ລະບົບ</button>
            </div>
        

          <p class="text-center">
            <span>ບໍ່ມີ ບັນຊີຜູ້ໃຊ້?</span>
            <router-link to="/register" href="auth-register-basic.html">
              <span> ຄຼິກເພື່ອລົງທະບຽນ</span>
            </router-link>
          </p>
        </div>
      </div>
      <!-- /Register -->
    </div>
  </div>
    </div>
</template>
<script>
import axios from 'axios';
export default {
    data() {
      return {
        UserLogin:{
          email:'',
          password:''
        },
        text_error_email:'',
        text_error_password:'',
        text_error_login:''
      }
    },
    computed:{
      CheckForm(){

        const EmailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

         /// ກວດອີເມວລ໌
          if(this.UserLogin.email){
            if(EmailRegex.test(this.UserLogin.email)){
              this.text_error_email = ""
            } else {
              this.text_error_email = "ອີເມວລ໌ບໍ່ຖຶກຕ້ອງ"
            }
          } else {
            this.text_error_email = ""
          }

          // ກວດລະຫັດຜ່ານ
          if(this.UserLogin.password){
            if(this.UserLogin.password.length <= 3){
              this.text_error_password = "ລະຫັດຜ່ານຕ້ອງຫຼາຍກ່ວາ 3 ຕົວອັກສອນ"
            } else {
              this.text_error_password = ""
            }
          } else {
            this.text_error_password = ""
          }

          // ກວດຊອບຄວາມຜິດຜາດ ເພື່ອປິດປຸ່ມ login
          if(!EmailRegex.test(this.UserLogin.email) || this.UserLogin.password.length <= 3){
            return true
          } else {
            return false
          }
        }
    },
    methods:{
      Login(){
          if(this.UserLogin.email !="" && this.UserLogin.password !=""){
              axios.post("api/login",this.UserLogin).then((res)=>{

                if(res.data.success){
                  this.UserLogin.email = ""
                  this.UserLogin.password = ""
                  this.text_error_login = ""
                } else {
                  this.text_error_login = res.data.message
                }

              }).catch((error)=>{
                console.log(error)
              })
          } 
      }
    }
}
</script>
<style lang="">
    
</style>