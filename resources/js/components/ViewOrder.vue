<template>
<section class="content mt-5">

      <!-- Default box -->
      <div class="card">
        <div class="card-header text-white" style="background-color: #3d99f5;">
          <h3 class="card-title">{{ 'My Orders' }}</h3>

        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th style="width: 40%">
                          {{ 'Package Information'}}
                      </th>
                      <th style="width: 40%">
                          {{ 'Recever Information' }}
                      </th>
                      <th>
                          {{ 'Package Status' }}
                      </th>
                      <th style="width: 10%" class="text-center">
                          {{ 'Payment Status of Package' }}
                      </th>

                  </tr>
              </thead>
              <tbody>
                  <tr v-for="order in order.data" :key="order.id">

                      <td>
                          <a>
                             <b>Package's Name: </b> {{ order.package_name | upText}}
                          </a>
                          <br>
                           <a>
                              <b>Package's Type: </b> {{ order.type | upText }}
                          </a>
                          <br>
                           <a>
                             <b>Package's Weight(Kg): </b> {{ order.weight }}
                          </a>
                          <br>
                           <a>
                              <b>Package's Source: </b>{{ order.source | upText}}
                          </a>
                          <br>
                           <a>
                              <b>Package's Destination: </b> {{ order.destination | upText}}
                          </a>
                          <br>
                            <a>
                              <b>Time To Destination(Hrs): </b> {{ order.hrs }}
                          </a>
                          <br>
                           <a>
                             <b> Package's Price(Tsh): </b>{{ order.price }} Tsh.
                          </a>
                          <br>
                           <a>
                              <b>Total Weight of package: </b> {{ order.package_quantity }}
                          </a>
                          <br>
                          <small>
                              <b>Created At: </b> {{ order.created_at | myDate}}
                          </small>
                      </td>
                      <td>
                          <a>
                             <b>Sent to: </b> {{ order.recever_name | upText}}
                          </a>
                          <br>
                           <a>
                              <b>Phone: </b> {{ order.recever_phone }}
                          </a>
                          <br>
                           <a>
                             <b>Address: </b>{{ order.recever_address  | upText}}
                          </a>
                          <br>
                      </td>
                      <td class="project_progress">
                         <span class="badge badge-success"  :class="{ 'badge badge-primary':  PackageStatus(order.packagestatus) }">{{ order.packagestatus | upText }}</span>
                      </td>
                      <td class="project-state">
                          <span class="badge badge-success"  :class="{ 'badge badge-danger':  PaymentStatus(order.paymentstatus) }">{{ order.paymentstatus | upText }}</span>
                      </td>
                  </tr>
              </tbody>
          </table>
        </div>
        <!-- /.card-body -->
          <div class="card-footer">
                    <pagination :data="order" @pagination-change-page="getResults"></pagination>
        </div>
      </div>
      <!-- /.card -->

    </section>
</template>

<script>
import Vue from 'vue'
import {
    Form,
    HasError,
    AlertError
} from 'vform'

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

export default {
    data() {
        return {
            editmode: false,
            user: [],
            order: {},
            form: new Form({
                id: '',
                recever_name: '',
                recever_email:'',
                recever_phone:'',
                recever_address:'',
                packagestatus:'',
                paymentstatus:'',
                package_quantity:'',
                package_name:'',
                type:'',
                weight:'',
                source:'',
                destination:'',
                distance:'',
                hrs:'',
                price:'',
            })
        }
    },

    methods: {
                getResults(page = 1) {
			axios.get('api/user?page=' + page)
				.then(response => {
					this.order = response.data;
				});
		},

        loaduserOrder() {
            axios.get("api/getuserorder").then(({
                data
            }) => (this.order = data));
        },

        PaymentStatus(value){
            if(value==='unpaid'){
                return true;
            }

        },

         PackageStatus(value){
            if(value==='onprogress'){
                return true;
            }

        },


    },
    created() {
        this. loaduserOrder() ;
       // this.fillForm();

        this. loaduserOrder() ;
        Fire.$on('searching', () => {
             let query=this.$parent.search;
            axios.get('api/findOrder?q='+ query)
            .then((data)=>{
                this.order = data.data
            })
            .catch(()=>{

            });
        });
        Refresh.$on('RefreshResult', () => {
            this. loaduserOrder() ;
        });

        //setInterval(() => this.loadCompany(), 1000);
    }
}
</script>

