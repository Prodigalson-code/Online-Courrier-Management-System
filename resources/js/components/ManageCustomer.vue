<template>

    <div class="container">


        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{ 'Customers' }}</h3>

                <div class="card-tools">
                    <button class="btn btn-success" @click="newModal">{{'Add New Customer'}}
                    <i class="fas fa-user-plus fa-fw"></i>
                    </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>{{ 'SNO.' }}</th>
                      <th>{{ 'User Name' }}</th>
                      <th>{{ 'Email' }}</th>
                      <th>{{ 'Phone' }}</th>
                      <th>{{ 'User type' }}</th>
                      <th>{{ 'Registered At' }}</th>
                       <th>{{ 'Action' }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="Customer in Customer" :key="Customer.id">
                      <td>{{ Customer.id }}</td>
                      <td>{{ Customer.name }}</td>
                      <td>{{ Customer.email }}</td>
                      <td>{{ Customer.phone }}</td>
                      <td>{{ Customer.type | upText}}</td>
                      <td>{{ Customer.created_at | myDate }}</td>

                      <td>
                            <a href="#" @click="editModal(Customer)">
                                 <i class="fas fa-edit" style="display:inline-block;margin-right:1em;color:blue"></i>
                            </a>

                            <a href="#" @click="deleteUser(Customer.id)">
                                 <i class="fas fa-trash" style="color:red" ></i>
                            </a>
                      </td>
                    </tr>

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>






<div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 v-show="!editmode" class="modal-title" id="addNewlLabel">{{ 'New Customer ' }}</h5>
         <h5 v-show="editmode" class="modal-title" id="addNewlLabel">{{ 'Edit Customer' }}</h5>
      </div>

      <form @submit.prevent="editmode ? updateCustomer() : createCustomer()">
      <div class="modal-body">
        <div class="form-group">
            <input type="text" v-model="form.name" class="form-control" id="name" aria-describedby="nameHelp" placeholder="Name" :class="{ 'is-invalid': form.errors.has('name') }">
             <has-error :form="form" field="name"></has-error>
        </div>

        <div class="form-group">
            <input type="email" v-model="form.email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Email" :class="{ 'is-invalid': form.errors.has('email') }">
            <has-error :form="form" field="email"></has-error>
        </div>

         <div class="form-group">
            <input type="tel" v-model="form.phone" class="form-control" id="phone" aria-describedby="phoneHelp" placeholder="Phone number " :class="{ 'is-invalid': form.errors.has('phone') }">
            <has-error :form="form" field="phone"></has-error>
        </div>

    <div class="form-group">

        <select class="form-control " v-model="form.type" id="type" placeholder="Choose Company Type"  aria-describedby="typeHelp"  :class="{ 'is-invalid': form.errors.has('type') }">
        <option value="customer">{{ 'Customer' }}</option>


        </select>
    </div>

    <div class="form-group">
            <input type="password" v-model="form.password" class="form-control" id="password" aria-describedby="passwordHelp" placeholder="Password" :class="{ 'is-invalid': form.errors.has('password') }">
            <has-error :form="form" field="password"></has-error>
        </div>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ 'Close' }}</button>
        <button v-show="!editmode" type="submit" class="btn btn-primary">{{ 'Add Customer' }}</button>
        <button v-show="editmode" type="submit"  class="btn btn-success">{{ 'Update Customer' }}</button>
      </div>
</form>
    </div>
  </div>
</div>





      </div>

</template>
<script>

import Vue from 'vue'
import { Form, HasError, AlertError } from 'vform'

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)


    export default {
        data() {
            return {
                editmode: false,
                Customer: {},
                form: new Form({
                    id : '',
                    name : '',
                    email: '',
                    phone : '',
                    type : '',
                   password : ''

            })
            }
        },

        methods: {

            updateCustomer(){
                this.$Progress.start();
                this.form.put('api/user/'+this.form.id)
                .then(()=>{

                        $('#addNew').modal('hide');
                         Refresh.$emit('RefreshResult');
                         /*  swal.fire(
                                   'Updated!',
                                    'Customer has been Updated.',
                                    'success'
                                 ); */
                                  toast.fire({
                                        icon: 'success',
                                        title: 'Customer Updated successfully'
                                    })

                        this.progress.finish();

                })
                .catch(()=>{
                    //this.$Progress.fail();
                    swal("Failed","Something Went wrong.","warning");

                });
            },

            editModal(Customer){
                this.editmode =true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(Customer);
            },
             newModal(){
                 this.editmode =false;
                this.form.reset();
                $('#addNew').modal('show');
            },



            deleteUser(id){

                swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            //send request to server
                            if (result.value) {
                                    this.form.delete('api/user/'+id)
                                    .then(()=>{

                                            swal.fire(
                                            'Deleted!',
                                            'Customer has been deleted.',
                                            'success'
                                            )

                                        Refresh.$emit('RefreshResult');
                                    })
                                    .catch(()=>{
                                        swal("Failed","Something Went wrong.","warning");
                                    });
                            }


                })

            },

            loadCustomer(){
                axios.get("api/customer").then(({data})=>(this.Customer = data.data));
            },
            createCustomer(){
                this.$Progress.start();
                this.form.post('api/user')
                .then(()=>{

                    Refresh.$emit('RefreshResult');
                $('#addNew').modal('hide');

                toast.fire({
                            icon: 'success',
                            title: 'Customer created successfully'
                          })


                this.$Progress.finish();

                })
                .catch(()=>{
                     swal("Failed","Something Went wrong.","warning");
                })



            }

        },
        created() {
            this.loadCustomer();
            Refresh.$on('RefreshResult',() => {
                this.loadCustomer();
            });
            //setInterval(() => this.loadCompany(), 1000);
        }
    }
</script>
