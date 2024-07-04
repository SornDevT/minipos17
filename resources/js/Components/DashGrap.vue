<template >
    <div class="row g-4 mb-4">
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>ລາຍຮັບ</span>
            <div class="d-flex align-items-end mt-2">
              <h5 class="mb-0 me-2">{{ formatPrice(data_income)  }} ກີບ</h5>
              <small class="text-success">(+29%)</small>
            </div>
            <p class="mb-0">Total Users</p>
          </div>
          <div class="avatar">
            <span class="avatar-initial rounded bg-label-primary">
              <i class="bx bx-user bx-sm"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>ລາຍຈ່າຍ</span>
            <div class="d-flex align-items-end mt-2">
              <h5 class="mb-0 me-2"> {{ formatPrice(data_expense)  }} ກີບ </h5>
              <small class="text-success">(+18%)</small>
            </div>
            <p class="mb-0">Last week analytics </p>
          </div>
          <div class="avatar">
            <span class="avatar-initial rounded bg-label-danger">
              <i class="bx bx-user-check bx-sm"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>ກຳໄລ</span>
            <div class="d-flex align-items-end mt-2">
              <h5 class="mb-0 me-2">{{ formatPrice(data_income-data_expense)  }} ກີບ</h5>
              <small class="text-danger">(-14%)</small>
            </div>
            <p class="mb-0">Last week analytics</p>
          </div>
          <div class="avatar">
            <span class="avatar-initial rounded bg-label-success">
              <i class="bx bx-group bx-sm"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>ຍອດໃນສະຕ໋ອກ</span>
            <div class="d-flex align-items-end mt-2">
              <h5 class="mb-0 me-2">{{ formatPrice(data_store)  }} </h5>
              <small class="text-success">(+42%)</small>
            </div>
            <p class="mb-0">Last week analytics</p>
          </div>
          <div class="avatar">
            <span class="avatar-initial rounded bg-label-warning">
              <i class="bx bx-user-voice bx-sm"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</template>
<script>
import { useStore } from "../Store/auth.js"
export default {
    setup(){
      const store = useStore();
      return { store }
    },
    data(){
        return{
            data_income:0,
            data_expense:0,
            data_store:0
        }
    },
    methods:{
        formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        GetData(){
            axios.get('api/report/dashgrap', { headers: { Authorization:"Bearer "+this.store.get_token }}).then((res)=>{

                this.data_income = res.data.income
                this.data_expense = res.data.expense
                this.data_store = res.data.store

            }).catch((error)=>{
                if(error.response.status == 401){
                this.store.remove_token()
                this.store.remove_user()

                localStorage.removeItem("web_token")
                localStorage.removeItem("web_user")

                this.$router.push("/login")
              }
            })
        }
    },
    created(){
        this.GetData()
    }
}
</script>
<style lang="">
    
</style>