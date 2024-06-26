<template lang="">
    <div class="card">
  <h5 class="card-header">ລາຍການ ສະຕ໋ອກສິນຄ້າ</h5>
  <div class="card-body">
    <!-- {{ShowForm}} -->
    <div v-if="ShowForm">
      {{FormStore}}
        <div class=" d-flex justify-content-end">
            <button type="button" class="btn btn-success me-2" :disabled="CheckForm" @click="SaveStore">ບັນທຶກ</button>
            <button type="button" class="btn btn-danger" @click="CancelStore" >ຍົກເລີກ</button>
        </div>
        <div class="row">
            <div class="col-md-4">
                Image
            </div>
            <div class="col-md-8">
          
          <label for="product-name" class="form-label fs-6">ຊື່ສິນຄ້າ:</label>
          <input type="text" class="form-control mb-2" v-model="FormStore.name" id="product-name" placeholder="..." >

          <label for="product-qty" class="form-label fs-6">ຈຳນວນ:</label>
          <input type="text" class="form-control mb-2" v-model="FormStore.qty" id="product-qty" placeholder="..." >
                
          <div class="row">
            <div class="col-md-6">
                
          <label for="price-buy" class="form-label fs-6">ລາຄາຊື້:</label>
          
          <div class="input-group">
            <input type="text" class="form-control" v-model="FormStore.price_buy" id="price-buy" placeholder="..." >
            <span class="input-group-text">ກີບ</span>
        </div>
            </div>
            <div class="col-md-6">
                
          <label for="price-sell" class="form-label fs-6">ລາຄາຂາຍ:</label>
          <div class="input-group">
            <input type="text" class="form-control" v-model="FormStore.price_sell" id="price-sell" placeholder="..." >
            <span class="input-group-text">ກີບ</span>
        </div>
            </div>
          </div>
    
            </div>
        </div>
    </div>

    <!-- <hr> -->

    <div class="table-responsive text-nowrap" v-if="!ShowForm">
        <div class=" d-flex justify-content-between mb-2">
            <div class=" d-flex ">
                <di class=" d-flex align-items-center me-2 cursor-pointer" @click="ChangeSort">
                    <i class='bx bx-sort-up fs-4' v-if="Sort=='asc'"></i>
                    <i class='bx bx-sort-down fs-4' v-if="Sort=='desc'"></i>
                </di>
                <select v-model="PerPage" class="form-select" @change="GetStore(1)" >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                </select>
            </div>
            <div class=" d-flex">
              <div class="input-group me-2">
                <input type="text" class="form-control " v-model="Search" @keyup.enter="GetStore(1)" placeholder="ຄົ້ນຫາ...">
                <!-- <span class="input-group-text">ກີບ</span> -->
                <button type="button" class="btn btn-primary px-2" @click="GetStore(1)" > <i class='bx bx-search-alt fs-5'></i> </button>
              </div>
                <button type="button" class="btn btn-info" @click="AddStore" >ເພີ່ມຂໍ້ມູນ</button>
            </div>
        </div>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>ຮູບ</th>
            <th>ຊື່ສິນຄ້າ</th>
            <th>ຈຳນວນ</th>
            <th>ລາຄາຊື້</th>
            
            <th>ຈັດການ</th>
          </tr>
        </thead>
        <tbody>
        
       
          <tr v-for="item in StoreData.data" :key="item.id">
            <td>{{item.id}}</td>
            <td>image</td>
            <td>{{ item.name }}</td>
            <td>{{ item.qty }}</td>
            <td>{{ item.price_buy }}</td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="javascript:void(0);" @click="EditStore(item.id)" ><i class="bx bx-edit-alt me-1"></i> ແກ້ໄຂ</a>
                  <a class="dropdown-item" href="javascript:void(0);" @click="DelStore(item.id)"><i class="bx bx-trash me-1"></i> ລຶບ</a>
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>

      <Pagination :pagination="StoreData" :offset="4" @paginate="GetStore($event)" />

    </div>
  </div>
</div>
</template>
<script>
import axios from 'axios';
import { useStore } from "../Store/auth"
export default {
    setup(){
      const store = useStore();
      return { store }
    },
    data() {
        return {
            Sort:'desc',
            PerPage: 5,
            ShowForm:false,
            StoreData:[],
            Search:'',
            FormStore:{
                name:'',
                image:'',
                qty:'',
                price_buy:'',
                price_sell:''
            },
            FormType: true,
            EditID:'',
        }
    },
    computed:{
        CheckForm(){
            if(this.FormStore.name == "" || this.FormStore.qty == "" || this.FormStore.price_buy == "" || this.FormStore.price_sell == ""){
                return true
            } else {
                return false
            }
        }
    },
    methods: {
      ChangeSort(){
          if(this.Sort == 'desc'){
            this.Sort = 'asc'
          } else {
            this.Sort = 'desc'
          }
          this.GetStore(1)
      },
        AddStore(){
            this.ShowForm = true
            this.FormType = true

            this.FormStore.name = ""
            this.FormStore.image = ""
            this.FormStore.qty = ""
            this.FormStore.price_buy = ""
            this.FormStore.price_sell = ""
        },
        CancelStore(){
            this.ShowForm = false
        },
        EditStore(id){
            this.EditID = id 
            this.FormType = false
            console.log(id)

            axios.get(`api/store/edit/${id}`,{ headers: { Authorization:"Bearer "+this.store.get_token }}).then((res)=>{

              this.FormStore = res.data
              this.ShowForm = true

            }).catch((error)=>{
              if(error.response.status == 401){
                this.store.remove_token()
                this.store.remove_user()

                localStorage.removeItem("web_token")
                localStorage.removeItem("web_user")

                this.$router.push("/login")
              }
            })

        },
        DelStore(id){
            axios.delete(`api/store/delete/${id}`,{ headers: { Authorization:"Bearer "+this.store.get_token }}).then((res)=>{
                if(res.data.success){
                  this.GetStore()
                }
            }).catch((error)=>{
              if(error.response.status == 401){
                this.store.remove_token()
                this.store.remove_user()

                localStorage.removeItem("web_token")
                localStorage.removeItem("web_user")

                this.$router.push("/login")
              }
            })
        },
        SaveStore(){

            if(this.FormType){
                // ເພີ່ມຂໍ້ມູນໃໝ່

                axios.post("api/store/add",this.FormStore, { headers: { Authorization:"Bearer "+this.store.get_token }}).then((res)=>{
                    if(res.data.success){
                      this.ShowForm = false
                      this.GetStore()
                    }
                }).catch((error)=>{
                    console.log(error)

                    if(error.response.status == 401){
                this.store.remove_token()
                this.store.remove_user()

                localStorage.removeItem("web_token")
                localStorage.removeItem("web_user")

                this.$router.push("/login")
              }
                })

            } else {
                // ອັບເດດຂໍ້ມູນ

                axios.post(`api/store/update/${this.EditID}`, this.FormStore,{ headers: { Authorization:"Bearer "+this.store.get_token } }).then((res)=>{
                    if(res.data.success){

                      this.ShowForm = false 
                      this.GetStore()

                    }


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
        GetStore(page){
            axios.get(`api/store?page=${page}&sort=${this.Sort}&perpage=${this.PerPage}&search=${this.Search}`, { headers: { Authorization:"Bearer "+this.store.get_token } }).then((res)=>{
              this.StoreData = res.data
            }).catch((error)=>{
              console.log(error.response.status)

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
    created() {
      this.GetStore()
    },
    watch:{
      Search(){
        if(this.Search == ""){
          this.GetStore(1)
        }
      }
    }
}
</script>
<style lang="">
    
</style>