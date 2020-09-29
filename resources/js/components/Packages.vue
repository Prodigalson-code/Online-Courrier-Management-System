<template>
<div class="container">

    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-white" style="background-color: #3d99f5;">
                    <h3 class="card-title">{{ 'Make Order From The List' }}</h3>


                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>{{ 'Package Type' }}</th>
                                <th>{{ 'Package Weight in KG' }}</th>
                                <th>{{ 'From' }}</th>
                                <th>{{ 'To' }}</th>
                                <th>{{ 'Distance Covered in KM' }}</th>
                                <th>{{ 'Hrs Taken' }}</th>
                                 <th>{{ 'Price in Tsh' }}</th>
                                <th>{{ 'Action' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="items in items.data" :key="items.id">
                                <td>{{ items.type | upText }}</td>
                                <td>{{ items.weight }}</td>
                                <td>{{ items.source | upText }}</td>
                                <td>{{ items.destination | upText }}</td>
                                <td>{{ items.distance }}</td>
                                <td>{{ items.hrs }}</td>
                                <td>{{ items.price }}</td>

                                <td>

                                    <button type="button" class="btn btn-primary btn-sm" @click="orderModal(items);fillForm()">{{ 'Make Order' }}</button>

                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                  <div class="card-footer">
                    <pagination :data="items" @pagination-change-page="getResults"></pagination>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>

    <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 v-show="editmode" class="modal-title" id="addNewlLabel">{{ 'Order Package' }}</h5>
                </div>

                <form @submit.prevent="makeOrder() ">
                    <div class="modal-body">

                     <div class="card-header text-white" style="background-color: #3d99f5;">
                        <h3 class="card-title">{{ 'Sender Details' }}</h3>
                     </div>
                        <div class="form-group">
                        <label for="name">{{ 'Name' }}</label>
                            <input type="text" v-model="form.name" class="form-control" id="name" aria-describedby="nameHelp" placeholder="Name" :class="{ 'is-invalid': form.errors.has('name') }" disabled>
                            <has-error :form="form" field="name"></has-error>
                        </div>

                        <div class="form-group">
                        <label for="email">{{ 'Email' }}</label>
                            <input type="email" v-model="form.email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Email" :class="{ 'is-invalid': form.errors.has('email') }" disabled>
                            <has-error :form="form" field="email"></has-error>
                        </div>

                        <div class="form-group">
                        <label for="phone">{{ 'Phone' }}</label>
                            <input type="tel" v-model="form.phone" class="form-control" id="phone" aria-describedby="phoneHelp" placeholder="Phone number " :class="{ 'is-invalid': form.errors.has('phone') }" disabled>
                            <has-error :form="form" field="phone"></has-error>
                        </div>
                        <div class="form-group">
                                <label for="address">{{ 'Address' }}</label>
                                <textarea class="form-control" v-model="form.address" id="address" rows="3" :class="{ 'is-invalid': form.errors.has('address') }"></textarea>
                                <has-error :form="form" field="address"></has-error>
                         </div>

                         <div class="card-header text-white" style="background-color: #3d99f5;">
                            <h3 class="card-title">{{ 'Recever Details' }}</h3>
                         </div>

                              <div class="form-group">
                              <label for="name">{{ 'Name' }}</label>
                            <input type="text" v-model="form.recever_name" class="form-control" id="name" aria-describedby="nameHelp" placeholder="Name" :class="{ 'is-invalid': form.errors.has('recever_name') }">
                            <has-error :form="form" field="recever_name"></has-error>
                        </div>

                        <div class="form-group">
                        <label for="email">{{ 'Email' }}</label>
                            <input type="email" v-model="form.recever_email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Email" :class="{ 'is-invalid': form.errors.has('recever_email') }" >
                            <has-error :form="form" field="recever_email"></has-error>
                        </div>

                        <div class="form-group">
                        <label for="phone">{{ 'Phone' }}</label>
                            <input type="tel" v-model="form.recever_phone" class="form-control" id="phone" aria-describedby="phoneHelp" placeholder="Phone number " :class="{ 'is-invalid': form.errors.has('recever_phone') }" >
                            <has-error :form="form" field="recever_phone"></has-error>
                        </div>
                        <div class="form-group">
                                <label for="exampleFormControlTextarea1">{{ 'Address' }}</label>
                                <textarea class="form-control" v-model="form.recever_address" id="address" rows="3" :class="{ 'is-invalid': form.errors.has('recever_address') }"></textarea>
                                <has-error :form="form" field="recever_address"></has-error>
                         </div>

                         <div class="card-header text-white" style="background-color: #3d99f5;">
                            <h3 class="card-title">{{ 'Package Details' }}</h3>
                         </div>

                          <div class="form-group">
                             <label for="type">{{ 'Package Name' }}</label>
                            <input type="text" v-model="form.package_name" class="form-control" id="type" aria-describedby="typeHelp" placeholder="Name of your Parsel" :class="{ 'is-invalid': form.errors.has('package_name') }" >
                            <has-error :form="form" field="package_name"></has-error>
                             </div>

                              <div class="form-group">
                                <label for="amount">{{ 'Total Weight of Package' }}</label>
                                <input type="number" step="any" v-model="form.package_quantity" class="form-control" id="quantity" aria-describedby="distanceHelp" placeholder="How many parsel do you have " :class="{ 'is-invalid': form.errors.has('package_quantity') }" >
                                <has-error :form="form" field="package_quantity"></has-error>
                             </div>



                             <div class="form-group">
                             <label for="type">{{ 'Package Type' }}</label>
                            <input type="text" v-model="form.type" class="form-control" id="type" aria-describedby="typeHelp" placeholder="item type" :class="{ 'is-invalid': form.errors.has('type') }" disabled>
                            <has-error :form="form" field="type"></has-error>
                             </div>


                        <div class="form-group">
                        <label for="weight">{{ 'Weight in KG' }}</label>
                            <input type="number" step="any" v-model="form.weight" class="form-control" id="weight" aria-describedby="weightlHelp" placeholder="Item weight" :class="{ 'is-invalid': form.errors.has('weight') }" disabled>
                            <has-error :form="form" field="weight"></has-error>
                        </div>

                        <div class="form-group">
                            <label for="from">{{ 'From' }}</label>
                            <input type="text" v-model="form.source" class="form-control" id="source" aria-describedby="sourceHelp" placeholder="Source" :class="{ 'is-invalid': form.errors.has('source') }" disabled>
                            <has-error :form="form" field="source"></has-error>
                        </div>

                        <div class="form-group">
                        <label for="to">{{ 'To' }}</label>
                            <input type="text" step="any" v-model="form.destination" class="form-control" id="destination" aria-describedby="destinationHelp" placeholder="destination" :class="{ 'is-invalid': form.errors.has('destination') }" disabled>
                            <has-error :form="form" field="destination"></has-error>
                        </div>

                        <div class="form-group">
                        <label for="distance">{{ 'distance in KM' }}</label>
                            <input type="number" step="any" v-model="form.distance" class="form-control" id="distance" aria-describedby="distanceHelp" placeholder="Distance" :class="{ 'is-invalid': form.errors.has('distance') }" disabled>
                            <has-error :form="form" field="distance"></has-error>
                        </div>

                         <div class="form-group">
                        <label for="distance">{{ 'Time Taken To Destination' }}</label>
                            <input type="number" step="any" v-model="form.hrs" class="form-control" id="hrs" aria-describedby="distanceHelp" placeholder="hrs" :class="{ 'is-invalid': form.errors.has('hrs') }" disabled>
                            <has-error :form="form" field="hrs"></has-error>
                        </div>

                        <div class="form-group">
                        <label for="price">{{ 'Price in Tsh per KG' }}</label>
                            <input type="number" step="any"  v-model="form.price" class="form-control" id="price" aria-describedby="priceeHelp" placeholder="Price " :class="{ 'is-invalid': form.errors.has('price') }" disabled>
                            <has-error :form="form" field="price"></has-error>
                        </div>

                        <div class="card-header text-white" style="background-color: #3d99f5;">
                            <h3 class="card-title">{{ 'Payment Details' }}</h3>
                         </div>

                         <div class="form-group">
                         <label for="mobile">{{ 'Name Used In Mobile Transaction' }}</label>
                            <input type="text" v-model="form.senderPayment_name" class="form-control" id="name" aria-describedby="nameHelp" placeholder="Name" :class="{ 'is-invalid': form.errors.has('senderPayment_name') }">
                            <has-error :form="form" field="senderPayment_name"></has-error>
                        </div>
                        <div class="form-group">
                        <label for="name">{{ 'Phone Number used in Mobile Transaction' }}</label>
                            <input type="tel" v-model="form.senderPayment_phone" class="form-control" id="phone" aria-describedby="phoneHelp" placeholder="Phone number " :class="{ 'is-invalid': form.errors.has('senderPayment_phone') }">
                            <has-error :form="form" field="senderPayment_phone"></has-error>
                        </div>
                        <div class="form-group">

                            <select class="form-control " v-model="form.paymentmethod" id="type" placeholder="Choose Company Type" aria-describedby="typeHelp" :class="{ 'is-invalid': form.errors.has('paymentmethod') }">
                                 <option value="0" disabled>{{ 'Choose Payment Method' }}</option>
                                <option value="Tigo Pesa">{{ 'Tigo Pesa' }}</option>
                                <option value="M-pesa">{{ 'M-pesa' }}</option>
                                <option value="Airtel Money">{{ 'Airtel Money' }}</option>
                                <option value="Cash">{{ 'Cash' }}</option>

                            </select>
                            <has-error :form="form" field="paymentmethod"></has-error>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ 'Cancel' }}</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">{{ 'Send Order' }}</button>
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
            user: [],
            items: {},
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


            })
        }
    },

    methods: {

         getResults(page = 1) {
			axios.get('api/user?page=' + page)
				.then(response => {
					this.items = response.data;
				});
		},



        orderModal(items) {
            this.editmode = true;
            this.form.reset();
            $('#addNew').modal('show');

            this.form.fill(items);

            //this.form.fill(user);
        },
        newModal() {
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },



        loadItems() {
            axios.get("api/location").then(({
                data
            }) => (this.items = data));
        },

        fillForm(){
            this.form.name=this.user.name;
            this.form.email=this.user.email;
            this.form.phone=this.user.phone;
            this.form.user_id=this.user.id;

        },



          loadUser() {

             axios.get('/api/getuser')

              .then(function (response) {

                 this.user = response.data;

              }.bind(this));

        },
        makeOrder() {
            this.$Progress.start();
            this.form.post('api/parselinfo')
                .then(() => {

                    Refresh.$emit('RefreshResult');
                    $('#addNew').modal('hide');

                    toast.fire({
                        icon: 'success',
                        title: 'Order Sent successfully'
                    })

                    this.$Progress.finish();

                })
                .catch(() => {
                    this.$Progress.fail();

                        toast.fire({
                                    icon: 'warning',
                                    title: 'Something wrong....',
                                 });
                   // this.$Progress.fail();
                    //swal("Failed", "Something Went wrong.", "warning");
                })

        }

    },
    created() {
        this.loadUser();

        this.loadItems();
        Fire.$on('searching', () => {
             let query=this.$parent.search;
            axios.get('api/findOrder?q='+ query)
            .then((data)=>{
                this.items = data.data
            })
            .catch(()=>{

            });
        });
        Refresh.$on('RefreshResult', () => {
            this.loadItems();
        });

        //setInterval(() => this.loadCompany(), 1000);
    }
}
</script>
