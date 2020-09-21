<template>
<div class="container">

    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-white" style="background-color: #3d99f5;">
                    <h3 class="card-title">{{ 'Manage Orders' }}</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>{{ 'Sender Name' }}</th>
                                <th>{{ 'Sender Email' }}</th>
                                <th>{{ 'Sender Phone' }}</th>
                                <th>{{ 'Sender Address' }}</th>
                                <th>{{ 'Recever Name' }}</th>
                                <th>{{ 'Recever Email' }}</th>
                                 <th>{{ 'Recever Phone' }}</th>
                                <th>{{ 'Recever Address' }}</th>
                                <th>{{ 'Parsel Name' }}</th>
                                <th>{{ 'Parsel Type' }}</th>
                                <th>{{ 'Number Of Parsels' }}</th>
                                <th>{{ 'Parsel Weight' }}</th>
                                <th>{{ 'Parsel From' }}</th>
                                <th>{{ 'Parsel To' }}</th>
                                <th>{{ 'Distance Covered' }}</th>
                                <th>{{ 'Hrs Taken' }}</th>
                                 <th>{{ 'Price' }}</th>
                                <th>{{ 'Transaction Name' }}</th>
                                <th>{{ 'Transaction Phone' }}</th>
                                 <th>{{ 'Payment Method Used' }}</th>
                                <th>{{ 'Package Status' }}</th>
                                <th>{{ 'Payment Status' }}</th>
                                <th>{{ 'Action' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="order in order.data" :key="order.id">
                                <td>{{ order.name | upText }}</td>
                                <td>{{ order.email }}</td>
                                <td>{{ order.phone  }}</td>
                                <td>{{ order.address | upText }}</td>
                                <td>{{ order.recever_name | upText }}</td>
                                <td>{{ order.recever_email }}</td>
                                <td>{{ order.recever_phone}}</td>
                                <td>{{ order.recever_address| upText }}</td>
                                <td>{{ order.package_name| upText }}</td>
                                <td>{{ order.type | upText }}</td>
                                <td>{{ order.package_quantity }}</td>
                                <td>{{ order.weight }}</td>
                                <td>{{ order.source | upText }}</td>
                                <td>{{ order.destination | upText }}</td>
                                <td>{{ order.distance  }}</td>
                                <td>{{ order.hrs }}</td>
                                <td>{{ order.price  }}</td>
                                <td>{{ order.senderPayment_name | upText }}</td>
                                <td>{{ order.senderPayment_phone }}</td>
                                <td>{{ order.paymentmethod | upText }}</td>
                                <td>
                                    <span class="badge badge-success"  :class="{ 'badge badge-secondary':  PackageStatus(order.packagestatus) }">{{ order.packagestatus | upText }}</span>
                                </td>
                                 <td>
                                    <span class="badge badge-success"  :class="{ 'badge badge-danger':  PaymentStatus(order.paymentstatus) }">{{ order.paymentstatus | upText }}</span>
                                 </td>

                                <td>

                                     <button type="button" class="btn btn-primary btn-sm" @click="editModal(order)">{{ 'Manage Order' }}</button>


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
        </div>
    </div>

    <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 v-show="editmode" class="modal-title" id="addNewlLabel">{{ 'Confirm Status' }}</h5>
                </div>

                <form @submit.prevent="updateStatus()">
                    <div class="modal-body">


                        <div class="form-group">
                             <label for="managepackage">{{ 'Change Status Of Package on Transportation ' }}</label>
                            <select class="form-control " v-model="form.packagestatus" id="type" placeholder="Package Status" aria-describedby="typeHelp" :class="{ 'is-invalid': form.errors.has('packagestatus') }">
                                <option value="Onprogress">{{ 'Onprogress' }}</option>
                                <option value="Delivered">{{ 'Delivered' }}</option>

                            </select>
                        </div>

                        <div class="form-group">
                                 <label for="managepayment">{{ 'Change Status of Package on Payment ' }}</label>
                            <select class="form-control " v-model="form.paymentstatus" id="type" placeholder="Payment Status" aria-describedby="typeHelp" :class="{ 'is-invalid': form.errors.has('paymentstatus') }">
                                <option value="unpaid">{{ 'unpaid' }}</option>
                                <option value="paid">{{ 'paid' }}</option>


                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ 'Close' }}</button>

                        <button v-show="editmode" type="submit" class="btn btn-success">{{ 'Update Status' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
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
            order: {},
            form: new Form({
               id: '',
                user_id:'',
                name: '',
                email: '',
                phone: '',
                address: '',
                recever_name: '',
                recever_email:'',
                recever_phone:'',
                recever_address:'',
                package_quantity:'',
                package_name:'',
                type:'',
                weight:'',
                hrs:'',
                source:'',
                destination:'',
                distance:'',
                price:'',
                senderPayment_name:'',
                senderPayment_phone:'',
                paymentmethod:'',
                packagestatus: '',
                paymentstatus: '',

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

          PaymentStatus(value){
            if(value==='unpaid'){
                return true;
            }

        },

         PackageStatus(value){
            if(value==='Onprogress'){
                return true;
            }

        },

        updateStatus() {
            this.$Progress.start();
            this.form.put('api/parselinfo/' + this.form.id)
                .then(() => {

                    $('#addNew').modal('hide');
                    Refresh.$emit('RefreshResult');
                    swal.fire(
                        'Updated!',
                        'Status has been Updated.',
                        'success'
                    );

                    this.progress.finish();

                })
                .catch(() => {
                    //this.$Progress.fail();
                    this.$Progress.fail();

                        toast.fire({
                                    icon: 'warning',
                                    title: 'Something wrong....',
                                 });
                    //swal("Failed", "Something Went wrong.", "warning");
                });
        },

        editModal(order) {
            this.editmode = true;
            this.form.reset();
            $('#addNew').modal('show');
            this.form.fill(order);
        },
        newModal() {
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },



        loadOrders() {
            axios.get("api/parselinfo").then(({
                data
            }) => (this.order = data));
        },


    },
    created() {
        this.loadOrders();
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
            this.loadOrders();
        });
        //setInterval(() => this.loadCompany(), 1000);
    }
}
</script>
