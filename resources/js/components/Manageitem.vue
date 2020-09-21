<template>
<div class="container">

    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ 'Item Details' }}</h3>

                    <div class="card-tools">
                        <button class="btn btn-success" @click="newModal">{{'Add New Item'}}
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
                                <th>{{ 'Package type ' }}</th>
                                <th>{{ 'Weight' }}</th>
                                <th>{{ 'Source' }}</th>
                                 <th>{{ 'Destination' }}</th>
                                  <th>{{ 'Distance' }}</th>
                                   <th>{{ 'Hrs' }}</th>
                                    <th>{{ 'Cost' }}</th>

                                <th>{{ 'Action' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in item.data" :key="item.id">
                                <td>{{ item.id }}</td>
                                <td>{{item.type | upText }}</td>
                                <td>{{ item.weight }}</td>
                                <td>{{ item.source }}</td>
                                <td>{{ item.destination }}</td>
                                <td>{{ item.distance}}</td>
                                <td>{{ item.hrs }}</td>
                                <td>{{ item.price }}</td>

                                <td>
                                    <a href="#" @click="editModal(item)">
                                        <i class="fas fa-edit" style="display:inline-block;margin-right:1em;color:blue"></i>
                                    </a>

                                    <a href="#" @click="deleteItem(item.id)">
                                        <i class="fas fa-trash" style="color:red"></i>
                                    </a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                 <div class="card-footer">
                    <pagination :data="item" @pagination-change-page="getResults"></pagination>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>

    <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 v-show="!editmode" class="modal-title" id="addNewlLabel">{{ 'New Item ' }}</h5>
                    <h5 v-show="editmode" class="modal-title" id="addNewlLabel">{{ 'Edit Item' }}</h5>
                </div>

                <form @submit.prevent="editmode ? updateItem() : createItem()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="amount">{{ 'Type' }}</label>
                            <input type="text" v-model="form.type" class="form-control" id="type" aria-describedby="typeHelp" placeholder="item type" :class="{ 'is-invalid': form.errors.has('type') }">
                            <has-error :form="form" field="type"></has-error>
                        </div>

                        <div class="form-group">
                            <label for="amount">{{ 'Weight' }}</label>
                            <input type="number" step="any" v-model="form.weight" class="form-control" id="weight" aria-describedby="weightlHelp" placeholder="Item weight" :class="{ 'is-invalid': form.errors.has('weight') }">
                            <has-error :form="form" field="weight"></has-error>
                        </div>

                        <div class="form-group">
                            <label for="amount">{{ 'Price' }}</label>
                            <input type="number" step="any" v-model="form.price" class="form-control" id="price" aria-describedby="priceeHelp" placeholder="Price " :class="{ 'is-invalid': form.errors.has('price') }">
                            <has-error :form="form" field="price"></has-error>
                        </div>

                         <div class="form-group">
                            <label for="amount">{{ 'Source' }}</label>
                            <input type="text" v-model="form.source" class="form-control" id="source" aria-describedby="typeHelp" placeholder="source" :class="{ 'is-invalid': form.errors.has('source') }">
                            <has-error :form="form" field="source"></has-error>
                        </div>
                         <div class="form-group">
                            <label for="amount">{{ 'Destination' }}</label>
                            <input type="text" v-model="form.destination" class="form-control" id="type" aria-describedby="typeHelp" placeholder="destination" :class="{ 'is-invalid': form.errors.has('destination') }">
                            <has-error :form="form" field="type"></has-error>
                        </div>

                        <div class="form-group">
                            <label for="amount">{{ 'Distance' }}</label>
                            <input type="number" step="any" v-model="form.distance" class="form-control" id="distance" aria-describedby="priceeHelp" placeholder="distance " :class="{ 'is-invalid': form.errors.has('distance') }">
                            <has-error :form="form" field="distance"></has-error>
                        </div>
                        <div class="form-group">
                        <label for="amount">{{ 'Hrs' }}</label>
                            <input type="number" step="any" v-model="form.hrs" class="form-control" id="hrs" aria-describedby="priceeHelp" placeholder="hrs " :class="{ 'is-invalid': form.errors.has('hrs') }">
                            <has-error :form="form" field="hrs"></has-error>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ 'Close' }}</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">{{ 'Add Item' }}</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">{{ 'Update Item' }}</button>
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
            item: {},
            form: new Form({
                id: '',
                weight: '',
                price: '',
                type: '',
                source: '',
                destination: '',
                distance: '',
                    hrs: '',

            })
        }
    },

    methods: {

         getResults(page = 1) {
			axios.get('api/user?page=' + page)
				.then(response => {
					this.item = response.data;
				});
		},

        updateItem() {
            this.$Progress.start();
            this.form.put('api/location/' + this.form.id)
                .then(() => {

                    $('#addNew').modal('hide');
                    Refresh.$emit('RefreshResult');
                    swal.fire(
                        'Updated!',
                        'Item has been Updated.',
                        'success'
                    );

                    this.progress.finish();

                })
                .catch(() => {
                    this.$Progress.fail();
                         toast.fire({
                                    icon: 'warning',
                                    title: 'Something wrong....',
                                 });
                    //swal("Failed", "Something Went wrong.", "warning");
                });
        },

        editModal(item) {
            this.editmode = true;
            this.form.reset();
            $('#addNew').modal('show');
            this.form.fill(item);
        },
        newModal() {
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },

        deleteItem(id) {

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
                    this.form.delete('api/location/' + id)
                        .then(() => {

                            swal.fire(
                                'Deleted!',
                                'Item has been deleted.',
                                'success'
                            )

                            Refresh.$emit('RefreshResult');
                        })
                        .catch(() => {
                            this.$Progress.fail();

                        toast.fire({
                                    icon: 'warning',
                                    title: 'Something wrong....',
                                 });
                            //swal("Failed", "Something Went wrong.", "warning");
                        });
                }

            })

        },

        loadItem() {
            axios.get("api/location").then(({
                data
            }) => (this.item = data));
        },
        createItem() {
            this.$Progress.start();
            this.form.post('api/location')
                .then(() => {

                    Refresh.$emit('RefreshResult');
                    $('#addNew').modal('hide');

                    toast.fire({
                        icon: 'success',
                        title: 'Item created successfully'
                    })

                    this.$Progress.finish();

                })
                .catch(() => {
                    swal("Failed", "Something Went wrong.", "warning");
                })

        }

    },
    created() {
        this.loadItem();
        Fire.$on('searching', () => {
             let query=this.$parent.search;
            axios.get('api/findLocation?q='+ query)
            .then((data)=>{
                this.item = data.data
            })
            .catch(()=>{

            });
        });
        Refresh.$on('RefreshResult', () => {
            this.loadItem();
        });
        //setInterval(() => this.loadCompany(), 1000);
    }
}
</script>
