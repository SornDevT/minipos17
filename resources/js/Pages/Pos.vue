<template lang="">
    <div class="row">
        <div class="col-md-8">
            <div class=" card">
                <div class=" card-body">
                    <div class="input-group">
                <input type="text" class="form-control " v-model="Search" @keyup.enter="GetStore(1)" placeholder="ຄົ້ນຫາ...">
                <button type="button" class="btn btn-primary px-2"  > <i class='bx bx-search-alt fs-5'></i> </button>
              </div>
                </div>

            </div>

            <PerfectScrollbar class="mt-4 ">
                <div style="height:65vh">
                    <div class="row" >
                        <div v-for="list in StoreData.data" :key="list" class="col-md-3 mb-3">
                            <div class="card h-100 cursor-pointer" @click="AddProduct(list.id)" >
                                
                                <span v-for="i in ListOrder" :key="i.id">
                                    <span class="pos-num" v-if="list.id == i.id" > {{ i.order_qty }} </span>
                                </span>
                                <img :src="url + '/assets/img/' + list.image" v-if="list.image" class="pos-img card-img-top" >
                                <img :src="url + '/assets/img/no-img.png'" v-else class="pos-img card-img-top" >

                                <div class="card-body p-1 text-center">
                                    <h5 class="card-title"> {{ list.name }} </h5>
                                    <p class="card-text">
                                    {{ formatPrice(list.price_sell) }} ກີບ
                                    </p>
                                    
                                </div>
                                </div>
                        </div>
                    </div>
            </div>
        </PerfectScrollbar>

        </div>
        <div class="col-md-4">
            
            <div class="card">
                <div class="card-body p-0">
                    <div class="p-3">
 
                        <label  class="form-label fs-6">ຊື່ລູກຄ້າ:</label>
                        <input type="text" class="form-control mb-2" v-model="customer_name" placeholder="...." >
                        <label  class="form-label fs-6">ເບີໂທ:</label>
                        <input type="text" class="form-control" placeholder="...." v-model="customer_tel" >
   
                    </div>
                    <div class=" bg-info text-white p-2">
                        ລາຍການສັ່ງຊື້
                    </div>
                    <PerfectScrollbar>
                        <div style=" height:40vh">
                        <div class=" table-responsive text-wrap">
                            <table class=" table table-bordered">
                                <tbody>
                                    <tr v-for="list in ListOrder" :key="list.id">
                                        <td class="p-1 d-flex">
                                            <img src="assets/img/upload-img.jpg" class="list-img-pos">
                                            <div class="px-3 w-100">
                                                <span>{{list.name}}</span>
                                                <div class=" d-flex justify-content-end">{{ list.order_qty }} x {{ list.price_sell }}</div>
                                                <div class=" d-flex justify-content-between">
                                                    <span><i class='bx bxs-plus-circle cursor-pointer text-success' @click="AddProduct(list.id)" ></i> | <i class='bx bxs-minus-circle cursor-pointer text-warning' @click="RemoveProduct(list.id)"></i> | <i class='bx bxs-trash cursor-pointer text-danger' @click="DelProduct(list.id)"></i></span>
                                                    <span> {{ formatPrice(list.order_qty*list.price_sell) }} </span>
                                                </div>
                                            </div>
                                        </td>
                                        
                                    </tr>
                                </tbody>
                               
                            </table>
                            <div v-if="ListOrder.length<1" class=" d-flex justify-content-center align-items-center">
                                <h3 class=" text-muted mt-4">ບໍ່ມີລາຍການສັ່ງຊື້</h3>
                            </div>
                        </div>
                    </div>
                    </PerfectScrollbar>
                    <div class=" bg-info text-white p-2 d-flex justify-content-between">
                        <span>ລວມຍອດເງິນ:</span>
                        <span>{{ formatPrice(TotalAll) }} ກີບ</span>
                    </div>
                    <div class="p-2">
                        <button type="button" class="btn btn-success w-100" @click="Pay" :disabled="!TotalAll" > ຊຳລ່ະເງິນ </button>
                    </div>
                </div>
            </div>
        
        </div>
       
    </div>

    <div class="modal modal-top fade" id="dialog_pay" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
              <form class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalTopTitle">ຮັບເງິນນຳລູກຄ້າ</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                        <div class="col-md-6">
                            <div class=" d-flex justify-content-between">
                                <span>ລວມຍອດເງິນ:</span>
                                <span>{{ formatPrice(TotalAll) }} ກີບ</span>
                            </div>
                            <div class=" d-flex justify-content-between text-danger" v-if="(CashAmount-TotalAll)>0">
                                <span>ເງິນທອນ:</span>
                                <span>{{ formatPrice(CashAmount-TotalAll) }} ກີບ</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                    <cleave :options="options" class="form-control text-end" v-model="CashAmount" placeholder="..." />
                                    <span class="input-group-text">ກີບ</span>
                                </div>

                                <div class="row mt-2">
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100" @click="AddNum(500)" >500</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100"  @click="AddNum(1000)">1.000</button>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100"  @click="AddNum(2000)" >2.000</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100"  @click="AddNum(5000)">5.000</button>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100"  @click="AddNum(10000)">10.000</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100"  @click="AddNum(20000)" >20.000</button>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100"  @click="AddNum(50000)">50.000</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100"  @click="AddNum(100000)" >100.000</button>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                   
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-danger w-100"  @click="CashAmount=0" >Clear</button>
                                </div>
                            </div>
                        </div>
                  </div>
             
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="ComfirmPay" :disabled="CheckPrice" >ບັນທຶກ</button>
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ປິດ</button>
                  
                </div>
              </form>
            </div>
          </div>

</template>
<script>
import axios from "axios";
import { useStore } from "../Store/auth"
export default {
    setup(){
      const store = useStore();
      return { store }
    },
    data() {
        
        return {
            customer_name:'',
            customer_tel:'',
            url: window.location.origin,
            Sort:'desc',
            PerPage: 20,
            StoreData:[],
            Search:'',
            ListOrder:[],
            CashAmount:0,
            options: {
                  numeral: true,
                  numeralPositiveOnly: true,
                  noImmediatePrefix: true,
                  rawValueTrimPrefix: true,
                  numeralIntegerScale: 10,
                  numeralDecimalScale: 2,
                  numeralDecimalMark: '.',
                  delimiter: ','
                }
        }
    },
    computed:{
        CheckPrice(){
            if(this.CashAmount>=this.TotalAll){
                return false
            } else {
                return true
            }
        },
        TotalAll(){
            let val = this.ListOrder.reduce((num, item)=> parseInt(num) + (parseInt(item.order_qty) * parseInt(item.price_sell)),0)
            return val
        }
    },
    methods: {
        async openLink(link){
            const response = await fetch(`${link}`,{ headers:{ Authorization: 'Bearer '+ this.store.get_token}});
            const html = await response.text();
            const blob = new Blob([html],{ type: "text/html"});
            const blobUrl = URL.createObjectURL(blob);
            window.open(blobUrl, "_blank");
        },
        AddNum(num){
            this.CashAmount = parseInt(this.CashAmount?this.CashAmount:0) + parseInt(num) // 100 + 200 = 300
        },
        formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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
        },
        Pay(){
                $("#dialog_pay").modal("show")
        },
        AddProduct(id){

            let item = this.StoreData.data.find((i)=>i.id == id)
            let old_item = this.ListOrder.find((i)=>i.id == id)

            if(item.qty>0){

                if(old_item) {

                       if(item.qty - old_item.order_qty>0){
                        old_item.order_qty++
                       } else {
                        this.$swal({
                                title:"ບໍ່ສາມາດຂາຍສິນຄ້າໄດ້!",
                                text: "ສິນຄ້າດັ່ງກ່າວໄດ້ໝົດແລ້ວ",
                                showConfirmButton: false,
                                icon:"error",
                                timer:3500
                            });
                       }
                        
                
                }else{
                // add data to listorder
                this.ListOrder.push({
                    id: item.id,
                    image: item.image,
                    name: item.name,
                    order_qty: 1,
                    price_sell: item.price_sell
                })
            }
                

            } else {

                this.$swal({
                                title:"ບໍ່ສາມາດຂາຍສິນຄ້າໄດ້!",
                                text: "ສິນຄ້າດັ່ງກ່າວໄດ້ໝົດແລ້ວ",
                                showConfirmButton: false,
                                icon:"error",
                                timer:3500
                            });
            }

            
        },
        RemoveProduct(id){
            // console.log(id)
            let item = this.ListOrder.find((i)=>i.id==id)
            if(item){
                item.order_qty--
                if(item.order_qty < 1){
                    this.ListOrder.splice(this.ListOrder.map((i)=>i.id).indexOf(id),1)
                }
            }
        },
        DelProduct(id){

            this.$swal({
            title: "ທ່ານແນ່ໃຈບໍ່?",
            text: "ທີ່ຈະລຶບຂໍ້ມູນນີ້!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "ຍຶນຍັນ",
            cancelButtonText:  "ຍົກເລີກ"
          }).then((result) => {
            if (result.isConfirmed) {

                this.ListOrder.splice(this.ListOrder.map((i)=>i.id).indexOf(id),1)
            }
          })

        },
        ComfirmPay(){
                axios.post("api/transection/add",{
                    customer_name: this.customer_name,
                    customer_tel: this.customer_tel,
                    listorder: this.ListOrder
                },{ headers: { Authorization:"Bearer "+this.store.get_token }}).then((res)=>{

                    if(res.data.success){

                        this.customer_name = ''
                        this.customer_tel = ''
                        this.ListOrder = []
                        this.CashAmount = 0

                        $("#dialog_pay").modal("hide")

                        // window.open(window.location.origin+"/api/bills/print/"+res.data.bill_id)
                        this.openLink(window.location.origin+"/api/bills/print/"+res.data.bill_id)

                        this.$swal({
                                position:'top-end',
                                toast:true,
                                title: res.data.message,
                                showConfirmButton: false,
                                icon:"success",
                                timer:2500
                            });


                    } else {
                        this.$swal({
                                title: res.data.message,
                                showConfirmButton: false,
                                icon:"error",
                                timer:3500
                            });
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
    created() {
        this.GetStore(1)
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
<style >
    .pos-img{
        height: 110px;
        object-fit: cover;
        object-position: center;
        width: 100%;
    }

    .pos-num{
        position: absolute;
    background-color: red;
    color: white;
    padding: 5px;
    font-weight: bold;
    border-radius: 5px 0px 5px 0px;
    }

    .list-img-pos{
        width: 70px;
    height: 70px;
    object-fit: cover;
    object-position: center;
    border-radius: 5px;
    border: 1px solid #ddd9d9;
    }
</style>