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

            </a>
          </div>
          <!-- /Logo -->
          <p class="mb-4">ລົງທະບຽນ ບັນຊີໃໝ່</p>

          
          <div class="mb-3"> 
              <label for="user_name" class="form-label fs-6">ຊື່ຜູ້ໃຊ້:</label>
              <input type="text" class="form-control" id="user_name" v-model="user_name" name="email-username" placeholder="..." >
            </div>

            <div class="mb-3">
              <label for="email" class="form-label fs-6">ອີເມວລ໌:</label>
              <input type="text" class="form-control" id="email" v-model="user_email" name="email-username" placeholder="..." >
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label fs-6" for="password">ລະຫັດຜ່ານ:</label>
                
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" v-model="user_password" name="password" placeholder="············" aria-describedby="password">
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>

            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label fs-6" for="password">ຍືນຍັນ ລະຫັດຜ່ານ:</label>
                
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" v-model="user_password2" class="form-control" name="password" placeholder="············" aria-describedby="password">
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
            <div class="alert alert-warning" v-if="text_error" role="alert">
                {{text_error}}
            </div>
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" @click="Register" >ລົງທະບຽນ</button>
            </div>
        

          <p class="text-center">
            <span>ມີບັນຊີແລ້ວ!</span>
            <router-link to="/login" href="auth-register-basic.html">
              <span> ເຂົ້າສູ່ລະບົບ</span>
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
            user_name:'',
            user_email:'',
            user_password:'',
            user_password2:'',
            text_error:''
        }
        
    },
    methods: {
        Register(){
                if(this.user_name == "" || this.user_email == "" || this.user_password == "" ){
                    this.text_error = "ກະລຸນາປ້ອນຂໍ້ມູນໃກ້ຄົບຖ້ວນ"
                } else {
                    if(this.user_password == this.user_password2){
                        // ຖ້າສຳເລັດທຸເງື່ອນໄຂ
                        this.text_error = ""

                        axios.post('api/register',{
                            user_name: this.user_name,
                            user_email :this.user_email,
                            password: this.user_password
                        }).then((res)=>{

                            console.log(res)

                            if(res.data.success){

                                this.user_name = ""
                                this.user_email = ""
                                this.user_password = ""
                                this.user_password2 = ""
                                // ໄປໜ້າ login
                                this.$router.push("/login")
                            } else {
                                this.text_error = res.data.message
                            }

                        }).catch((error)=>{
                            console.log(error)
                        })


                    } else {
                        this.text_error = "ລະຫັດຜ່ານບໍ່ກົດກັນ ກະລຸນາກວດຄືນ!"
                    }
                }
        }
    },

}
</script>
<style lang="">
    
</style>