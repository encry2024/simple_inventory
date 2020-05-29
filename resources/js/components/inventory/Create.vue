<template>
    <sui-container class="mt-3">
        <sui-segment clearing>
            <sui-form @submit.prevent="addItem">
                <sui-form-field required>
                    <label>Item Name</label>
                    <input v-model="data.name" type="text" placeholder="Item Name" />
                </sui-form-field>

                <sui-form-field required>
                    <label>Item Stocks</label>
                    <input v-model="data.stocks" type="number" placeholder="Item Name" />
                </sui-form-field>

                <button type="submit" class="ui positive button right floated" >Add Item</button>
                <router-link to="/list" class="ui red button left floated">Back</router-link>
            </sui-form>
        </sui-segment>
    </sui-container>
</template>

<script>
    export default {
        data() {
            return {
                data: {}
            }
        },
        name: "Create",
        methods: {
            addItem() {
                fetch('/item/store', {
                    method: 'POST',
                    body: JSON.stringify(this.data),
                    headers: {
                        'content-type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        this.data = {}

                        alert("Item " + data.name + " was successfully added");
                    })
                    .catch(err => console.log(err))
            }
        }
    }
</script>
