<template>
    <sui-container class="mt-3">
        <sui-segment clearing>
            <h2 is="sui-header" floated="left">
                Inventory
            </h2>

            <download-csv
                class   = "ui teal button right floated"
                :data   = "inventory"
                name    = "inventory.csv">

                Download CSV

            </download-csv>

            <router-link :to="{ path: '/create/' }" class="ui primary button right floated">
                Add Item
            </router-link>

            <sui-table celled striped>
                <sui-table-header>
                    <sui-table-row>
                        <sui-table-header-cell>Name</sui-table-header-cell>
                        <sui-table-header-cell>Stocks</sui-table-header-cell>
                        <sui-table-header-cell>Actions</sui-table-header-cell>
                    </sui-table-row>
                </sui-table-header>

                <sui-table-body>
                    <sui-table-row v-for="(item) in inventory" v-bind:key="item.id">
                        <sui-table-cell>{{ item.name }}</sui-table-cell>
                        <sui-table-cell>{{ item.stocks }}</sui-table-cell>
                        <sui-table-cell>
                            <sui-button @click.native="toggle(item)">Add Stocks</sui-button>
                            <sui-button positive @click.native="editItem(item)">Edit Item</sui-button>
                            <button class="ui red button" @click="deleteItem(item.id)"
                                    data-toggle="tooltip" title="Delete Item">Delete</button>
                        </sui-table-cell>
                    </sui-table-row>
                </sui-table-body>
            </sui-table>
        </sui-segment>

        <sui-modal v-model="open" clearing>
            <sui-modal-header>Add Stocks</sui-modal-header>

            <sui-modal-content>
                <sui-form @submit.prevent="updateItemStock(item.id)">
                    <sui-form-field>
                        <label>Item Name</label>
                        <input disabled v-model="item.name"/>
                    </sui-form-field>

                    <sui-form-field>
                        <label>Item Stocks</label>
                        <input v-model="data.stocks" type="number" name="stocks"/>
                    </sui-form-field>

                    <sui-button type="submit" class="positive" floated="right">Add Stock</sui-button>
                    <br><br>
                </sui-form>
            </sui-modal-content>
        </sui-modal>

        <sui-modal v-model="edit" clearing>
            <sui-modal-header>Edit {{ item.name }}</sui-modal-header>

            <sui-modal-content>
                <sui-form @submit.prevent="updateItem(item.id)">
                    <sui-form-field>
                        <label>Item Name</label>
                        <input v-model="data.name"/>
                    </sui-form-field>

                    <sui-button type="submit" class="positive" floated="right">Edit Item</sui-button>
                    <br><br>
                </sui-form>
            </sui-modal-content>
        </sui-modal>
    </sui-container>
</template>

<script>
    import axios from 'axios';

    export default {
        name: 'Index',
        data() {
            return {
                inventory: [],
                open: false,
                item: [],
                data: {
                    stocks: "",
                    name: ""
                },
                edit: false
            }
        },
        mounted() {
            this.getInventory()
        },
        methods: {
            toggle(item) {
                this.open = !this.open;

                this.item = item;
            },
            editItem(item) {
                this.edit = !this.edit;

                this.item = item;
                this.dt.name = item.name;
            },
            getInventory() {
                axios({
                    method: 'GET',
                    url: '/api/item/list'
                }).then(
                    result => {
                        this.inventory = result.data;
                    },
                    error => {
                        console.log(error);
                    }
                )
            },
            deleteItem(id) {
                if (confirm('Are you sure?')) {
                    fetch(`/item/${id}/delete`, {
                        method: 'POST',
                        headers: {
                            'content-type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            alert(data)
                            this.getInventory();
                        })
                        .catch(err => console.log(err));
                }
            },
            updateItemStock(itemId) {
                fetch(`/item/${itemId}/add_stocks`, {
                    method: 'POST',
                    body: JSON.stringify(this.data),
                    headers: {
                        'content-type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        alert(data);
                        this.getInventory();
                    })
                    .catch(err => console.log(err))
            },
            exportInventory() {
                axios.get('/items/export', {responseType: 'blob'})
                    .then((response) => {
                        const url = window.URL.createObjectURL(new Blob([response.data]));
                        const link = document.createElement('a');
                        link.href = url;
                        link.setAttribute('download', 'inventory.csv');
                        document.body.appendChild(link);
                        link.click();
                    })
            },
            updateItem(itemId) {
                fetch(`/item/${itemId}/update`, {
                    method: 'POST',
                    body: JSON.stringify(this.data),
                    headers: {
                        'content-type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        alert(data);
                        this.getInventory();
                    })
                    .catch(err => console.log(err))
            }
        }
    }
</script>
