<template lang="">
    <div class="row">
        <div class="col-md-8">
            <div class=" card">
                <div class=" card-body">
                    <div class="input-group">
                <input type="text" class="form-control " placeholder="ຄົ້ນຫາ...">
                <button type="button" class="btn btn-primary px-2"  > <i class='bx bx-search-alt fs-5'></i> </button>
              </div>
                </div>

            </div>

            <PerfectScrollbar class="mt-4 ">
                <div style="height:65vh">
                    <div class="row" >
                        <div v-for="list in StoreData.data" :key="list" class="col-md-3 mb-3">
                            <div class="card h-100">
                                <span class="pos-num">10</span>
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
                        <input type="text" class="form-control mb-2" placeholder="...." >
                        <label  class="form-label fs-6">ເບີໂທ:</label>
                        <input type="text" class="form-control" placeholder="...." >
   
                    </div>
                    <div class=" bg-info text-white p-2">
                        ລາຍການສັ່ງຊື້
                    </div>
                    <PerfectScrollbar>
                        <div style=" height:40vh">
                        <div class=" table-responsive text-wrap">
                            <table class=" table table-bordered">
                                <tbody>
                                    <tr v-for="list in 10">
                                        <td class="p-1 d-flex">
                                            <img src="assets/img/upload-img.jpg" class="list-img-pos">
                                            <div class="px-3 w-100">
                                                <span>ຊື່ສິນຄ້າ jgidfosjgif jfdios</span>
                                                <div class=" d-flex justify-content-end">10 x 20,000</div>
                                                <div class=" d-flex justify-content-between">
                                                    <span><i class='bx bxs-plus-circle'></i> | <i class='bx bxs-minus-circle'></i> | <i class='bx bxs-trash'></i></span>
                                                    <span>200,000</span>
                                                </div>
                                            </div>
                                        </td>
                                        
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </PerfectScrollbar>
                    <div class=" bg-info text-white p-2 d-flex justify-content-between">
                        <span>ລວມຍອດເງິນ:</span>
                        <span>10,000 ກີບ</span>
                    </div>
                    <div class="p-2">
                        <button type="button" class="btn btn-success w-100" > ຊຳລ່ະເງິນ </button>
                    </div>
                </div>
            </div>
        
        </div>
       
    </div>
</template>
<script>
import { useStore } from "../Store/auth"
export default {
    setup(){
      const store = useStore();
      return { store }
    },
    data() {
        
        return {
            url: window.location.origin,
            Sort:'desc',
            PerPage: 20,
            StoreData:[],
            Search:'',
        }
    },
    methods: {
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
        }
    },
    created() {
        this.GetStore(1)
    },
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