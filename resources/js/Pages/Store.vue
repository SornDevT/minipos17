<template lang="">
    <div class="card">
  <h5 class="card-header">ລາຍການ ສະຕ໋ອກສິນຄ້າ</h5>
  <div class="card-body">
    <!-- {{ShowForm}} -->
    <div v-if="ShowForm">
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
                <di class=" d-flex align-items-center me-2">
                    <i class='bx bx-sort-up fs-4'></i>
                </di>
                <select class="form-select">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                </select>
            </div>
            <div class=" d-flex">
                <input type="text" class="form-control me-2"  placeholder="ຄົ້ນຫາ...">
                <button type="button" class="btn btn-primary" @click="AddStore" >ເພີ່ມຂໍ້ມູນ</button>
            </div>
        </div>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>ຮູບ</th>
            <th>ຊື່ສິນຄ້າ</th>
            <th>ລາຄາຊື້</th>
            <th>ຈຳນວນ</th>
            <th>ຈັດການ</th>
          </tr>
        </thead>
        <tbody>
        
       
          <tr>
            <td>00</td>
            <td>01</td>
            <td>02</td>
            <td>03</td>
            <td>04</td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                  <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
</template>
<script>
import axios from 'axios';
export default {
    data() {
        return {
            ShowForm:false,
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
        AddStore(){
            this.ShowForm = true
            this.FormType = true
        },
        CancelStore(){
            this.ShowForm = false
        },
        EditStore(id){
            this.EditID = id 
            this.FormType = false

        },
        SaveStore(){

            if(this.FormType){
                // ເພີ່ມຂໍ້ມູນໃໝ່

                axios.post("api/store/add",this.FormStore).then((res)=>{
                    if(res.data.success){
                        
                    }
                }).catch((error)=>{
                    console.log(error)
                })

            } else {
                // ອັບເດດຂໍ້ມູນ

            }

        }
    },
}
</script>
<style lang="">
    
</style>